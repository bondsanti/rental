<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRentalRequest;
use App\Models\Customer;
use App\Models\Lease_auto_code;
use App\Models\Lease_code;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Project;
use App\Models\Quarantee;
use App\Models\Rental;
use App\Models\Rental_Room_Images;
use App\Models\Role_user;
use App\Models\Room;
use App\Models\Room_Images;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    public function index()
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = DB::connection('mysql_report')
            ->table('project')
            ->where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();

        $status = DB::connection('mysql_report')->table('rental_room')
            ->select(DB::raw('
            CASE
                WHEN COALESCE(Status_room, "") = "" THEN "ห้องใหม่"
                WHEN Status_room = "จอง" THEN "จอง"
                WHEN Status_room = "พร้อมอยู่" THEN "พร้อมอยู่"
                WHEN Status_room IN ("รอคลีน", "รอตรวจ", "รอเฟอร์", "ไม่พร้อมอยู่") THEN "ไม่พร้อมอยู่"
                WHEN Status_room IN ("สวัสดิการ", "ห้องออฟฟิต", "เช่าอยู่", "อยู่แล้ว") THEN "อยู่แล้ว"
            END AS name
        '))
            ->whereRaw('IFNULL(status_room, "") NOT IN (?, ?)', ['', 'คืนห้อง'])
            ->groupBy('name')
            ->orderBy('name', 'ASC')
            ->get();

        return view('rental.index', compact(
            'dataLoginUser',
            'isRole',
            'projects',
            'status'
        ));
    }

    public function search(Request $request)
    {
        
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();

        $status = Room::select(DB::raw('
            CASE 
                WHEN COALESCE(Status_room, "") = "" THEN "ห้องใหม่"
                WHEN Status_room = "จอง" THEN "จอง"
                WHEN Status_room = "พร้อมอยู่" THEN "พร้อมอยู่"
                WHEN Status_room IN ("รอคลีน", "รอตรวจ", "รอเฟอร์", "ไม่พร้อมอยู่") THEN "ไม่พร้อมอยู่"
                WHEN Status_room IN ("สวัสดิการ", "ห้องออฟฟิต", "เช่าอยู่", "อยู่แล้ว") THEN "อยู่แล้ว"
            END AS name
        '))
            ->whereRaw('IFNULL(status_room, "") NOT IN (?,?)', ['', 'คืนห้อง'])
            ->groupBy('name')
            ->orderBy('name', 'ASC')
            ->get();

        $rents = Room::select(
            'projects.Project_Name',
            'rooms.id',
            'rooms.pid',
            'rooms.Create_Date',
            'rooms.HomeNo',
            'rooms.RoomNo',
            'rooms.RoomType',
            'rooms.rental_status',
            'rooms.Size',
            'rooms.Owner',
            'rooms.Status_Room',
            'rooms.Phone',
            'rooms.price',
            'rooms.Trans_Status',
            'rooms.contract_owner',
            'rooms.Owner',
            'rooms.Guarantee_Startdate',
            'rooms.Guarantee_Enddate',
            'rooms.date_firstrend',
            'rooms.date_endrend',
            'customers.id as cid',
            'customers.Contract_Status',
            'customers.Contract_Startdate',
            'customers.Contract_Enddate',
            'customers.Cus_Name'

        )
            ->from('rooms as rooms')
            ->join('projects', 'rooms.pid', '=', 'projects.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            // ->when($today, function (Builder $query, string $today) {
            //     $query->where('rooms.Create_Date','<=', $today);
            // })
            // ->whereNotIn('rooms.Status_Room', ['คืนห้อง'])
            ->whereRaw('ifnull(rooms.status_room, "") <> ?', ['คืนห้อง'])
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            });


        
        if ($request->pid != 'all') {
            $rents->where('rooms.pid', $request->pid);
        }

        if ($request->Owner) {
            $rents->where('rooms.Owner', 'LIKE', '%' . $request->Owner . '%');
        }

        if ($request->RoomNo) {
            $rents->where('rooms.RoomNo', 'LIKE', '%' . $request->RoomNo . '%');
        }

        if ($request->HomeNo) {
            $rents->where('rooms.HomeNo', 'LIKE', '%' . $request->HomeNo . '%');
        }

        if ($request->Cusmoter) {
            $rents->where('customers.Cus_Name', 'LIKE', '%' . $request->Cusmoter . '%');
        }

        if ($request->typerent != 'all') {
            $rents->where('rooms.rental_status', $request->typerent);
        }

        if ($request->status != 'all') {
            if ($request->status == "ไม่พร้อมอยู่") {
                $rents->whereIn('rooms.Status_Room', ['ไม่พร้อมอยู่', 'รอคลีน', 'รอตรวจ', 'รอเฟอร์']);
            } elseif ($request->status == "อยู่แล้ว") {
                $rents->whereIn('rooms.Status_Room', ['สวัสดิการ', 'ห้องออฟฟิต', 'เช่าอยู่', 'อยู่แล้ว']);
            } else {
                $rents->where('rooms.Status_Room', $request->status);
            }
        }

        // if (!$request->dateselect && $request->startdate  && $request->enddate) {
        //     $rents->whereBetween('rooms.Create_Date', [$request->startdate, $request->enddate]);
        // }

        if ($request->dateselect && $request->startdate) {
            if ($request->dateselect == "transfer_date") {
                if ($request->enddate != null) {
                    $rents->whereBetween('rooms.Transfer_Date', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('rooms.Transfer_Date', [$request->startdate, $request->startdate]);
                }
            } elseif ($request->dateselect == "Guarantee_Startdate") {
                if ($request->enddate != null) {
                    $rents->whereBetween('rooms.Guarantee_Startdate', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('rooms.Guarantee_Startdate', [$request->startdate, $request->startdate]);
                }
            } elseif ($request->dateselect == "Guarantee_Enddate") {
                if ($request->enddate != null) {
                    $rents->whereBetween('rooms.Guarantee_Enddate', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('rooms.Guarantee_Enddate', [$request->startdate, $request->startdate]);
                }
            } elseif ($request->dateselect == "Contract_Startdate") {
                if ($request->enddate != null) {
                    $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->startdate]);
                }
            }elseif ($request->dateselect == "Cancle_Date") {
                if ($request->enddate != null) {
                    $rents->whereBetween('customers.Cancle_Date', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('customers.Cancle_Date', [$request->startdate, $request->startdate]);
                }
            }else{
                $rents->whereBetween('rooms.Create_Date', [$request->startdate, $request->enddate]);
            }
        }
        // elseif ($request->startdate  && $request->enddate) {
        //     $rents->whereBetween('rooms.Create_Date', [$request->startdate, $request->enddate]);
        // }

        $rentsCount = $rents->count();

        $rents = $rents
            ->orderBy('Project_Name', 'asc')
            ->get();
            // ->toSql();

        // dd($rents);

        $formInputs = $request->all();

        return view('rental.search', compact(
            'rents',
            'dataLoginUser',
            'isRole',
            'projects',
            'status',
            'formInputs',
            'rentsCount'
        ));
    }

    public function detail($id)
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();

        // $rental_room = Rental::where('id', $id)->first();

        $rents = Room::select(
            'projects.Project_Name',
            'rooms.id',
            'rooms.pid',
            'rooms.numberhome',
            'rooms.HomeNo',
            'rooms.RoomNo',
            'rooms.RoomType',
            'rooms.Location',
            'rooms.Size',
            'rooms.Building',
            'rooms.Floor',
            'rooms.Electric_Contract',
            'rooms.owner_soi',
            'rooms.owner_road',
            'rooms.owner_district',
            'rooms.owner_khet',
            'rooms.owner_province',
            'rooms.Owner',
            'rooms.cardowner',
            'rooms.Phone',
            'rooms.price',
            'rooms.Transfer_Date',
            'rooms.date_firstrend',
            'rooms.date_endrend',
            // 'rooms.Guarantee_Startdate',
            // 'rooms.Guarantee_Enddate',
            'rooms.rental_status',
            'rooms.Status_Room',
            // 'rooms.Other',
            // 'rooms.contract_cus',
            'rooms.contract_owner',
            // 'rooms.price_insurance',
            'customers.Cus_Name',
            'customers.Phone as cusPhone',
            'customers.IDCard',
            'customers.contract_cus',
            'customers.Price',
            'customers.Contract_Status',
            'customers.Contract_Startdate',
            'customers.Contract_Enddate',
            'customers.Cancle_Date'

        )
            ->join('projects', 'projects.pid', '=', 'rooms.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })

            ->where('rooms.id', $id)
            ->first();

        // $projects = Project::orderBy('name', 'asc')->where('active', 1)->get();
        // dd($rents);
        // return view('rental.detail', compact('dataLoginUser', 'rents'));
        return response()->json($rents, 200);
    }

    public function edit($id)
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();

        $images = Room_Images::where('rid', $id)
            ->orderBy('id', 'asc')
            ->get();

        // dd($images);
        // $rental_room = Rental::where('id', $id)->first();
        $rents = Room::select(
            'projects.*',
            // 'projects.pid as pids',
            'rooms.*',
            'rooms.id as room_id',
            'rooms.pid as project_id',
            'rooms.Phone as owner_phone',
            'customers.id as customer_id',
            'customers.*'
        )
            ->join('projects', 'projects.pid', '=', 'rooms.pid')
            // ->join('rooms', 'rooms.pid', '=', 'projects.pid')
            // ->join('customers', 'rooms.pid', '=', 'customers.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
            OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            ->where('rooms.id', $id)
            // ->where('rental_customer.rid',$id)
            // ->where('project.pid',$rental_room->pid)
            ->get();

        foreach ($rents as $item) {
            $ref_cus_id = $item->customer_id;
        }
        // $ref_cus_id = $ref_cus_id ?? NULL;

        // dd($rents);

        $lease_auto_code = Lease_auto_code::where('ref_cus_id', $ref_cus_id)
            ->first();

        // dd($lease_auto_code);

        return view('rental.edit', compact('dataLoginUser', 'rents', 'projects', 'lease_auto_code','images'));
    }

    public function update(UpdateRentalRequest $request)
    {
        // $reNewContract = Customer::where('rid', $request->room_id)->orderBy('id','desc')->first();
        // dd($payment);
        $request->validated();
       
        // dd($request->room_id);
        $rental_room = Room::where('id', $request->room_id)->first();
        // อัปโหลดไฟล์บัตรประชาชน
        if ($request->hasFile('filUploadPersonID')) {
            $file = $request->file('filUploadPersonID');
            $extension = $file->getClientOriginalExtension();
            $filename = 'Idcard' . $rental_room->id . '_' . $request->project_id . '_' . $request->RoomNo . '.' . $extension;
            $file->move('uploads/image_id/', $filename);
            $rental_room->file_id_path = $filename;
        }
        // อัปโหลดไฟล์สัญญา
        if ($request->hasFile('filUploadContract')) {
            // dd($request->file('filUploadPersonID'));
            $file = $request->file('filUploadContract');
            $extension = $file->getClientOriginalExtension();
            $filename = 'Idrent' . $rental_room->id . '_' . $request->project_id . '_' . $request->RoomNo . '.' . $extension;
            $file->move('uploads/image_id/', $filename);
            $rental_room->file_rent = $filename;
        }
        // รูปภาพปก
        if ($request->hasFile('filUploadMain')) {
            $URL = request()->getHttpHost();
            $file = $request->file('filUploadMain');
            $extension = $file->getClientOriginalExtension();
            $filename = 'main_' . $rental_room->id . '_' . $request->project_id . '_' . $request->RoomNo . '.' . $extension;
            $file->move('uploads/images_room/', $filename);
            $rental_room->image = $URL . '/uploads/images_room/' . $filename;
        }

        if (!$request->show_price) {
            $rental_room->public = 0;
        }

        // dd($request->project_id);
        // dd($rental_room);
        $rental_room->pid = $request->project_id ?? NULL;
        // $rental_room->numebrhome = $request->room_address ?? NULL;
        $rental_room->numberhome = $request->numberhome ?? NULL;
        $rental_room->HomeNo = $request->HomeNo ?? NULL;
        $rental_room->Owner = $request->onwername ?? NULL;
        $rental_room->cardowner = $request->cardowner ?? NULL;
        $rental_room->owner_soi = $request->owner_soi ?? NULL;
        $rental_room->owner_road = $request->owner_road ?? NULL;
        $rental_room->owner_district = $request->owner_district ?? NULL;
        $rental_room->owner_khet = $request->owner_khet ?? NULL;
        $rental_room->owner_province = $request->owner_province ?? NULL;
        $rental_room->Phone = $request->ownerphone ?? NULL;
        $rental_room->Transfer_Date = $request->transfer_date ?? NULL;
        $rental_room->RoomNo = $request->RoomNo ?? NULL;
        $rental_room->RoomType = $request->room_type ?? NULL;
        $rental_room->Size = $request->room_size ?? NULL;
        $rental_room->Location = $request->Location ?? NULL;
        $rental_room->Building = $request->Building ?? NULL;
        $rental_room->Floor = $request->Floor ?? NULL;
        $rental_room->Key_front = $request->room_key_front ?? NULL;
        $rental_room->Key_bed = $request->room_key_bed ?? NULL;
        $rental_room->Key_balcony = $request->room_key_balcony ?? NULL;
        $rental_room->Key_mailbox = $request->room_key_mailbox ?? NULL;
        $rental_room->KeyCard = $request->room_card ?? NULL;
        $rental_room->KeyCard_P = $request->room_card_p ?? NULL;
        $rental_room->KeyCard_B = $request->room_card_b ?? NULL;
        $rental_room->KeyCard_C = $request->room_card_c ?? NULL;
        $rental_room->Guarantee_Startdate = $request->gauranteestart ?? NULL;
        $rental_room->Guarantee_Enddate = $request->gauranteeend ?? NULL;
        $rental_room->date_firstrend = $request->date_firstrend ?? NULL;
        $rental_room->date_endrend = $request->date_endrend ?? NULL;
        $rental_room->Guarantee_Amount = $request->gauranteeamount ?? NULL;
        $rental_room->Status_Room = $request->Status_Room ?? NULL;
        $rental_room->date_firstget = $request->date_firstget ?? NULL;
        $rental_room->date_print_contract_manual = $request->date_print_contract_manual ?? NULL;
        $rental_room->Electric_Contract = $request->Electric_Contract ?? NULL;
        $rental_room->Meter_Code = $request->Meter_Code ?? NULL;
        $rental_room->rental_status = $request->rental_status ?? NULL;
        $rental_room->price = $request->room_price ?? NULL;
        $rental_room->Bed = $request->room_Bed ?? NULL;
        $rental_room->Beding = $request->room_Curtain ?? NULL;
        $rental_room->Bedroom_Curtain = $request->room_Bedroom_Curtain ?? NULL;
        $rental_room->Livingroom_Curtain = $request->Livingroom_Curtain ?? NULL;
        $rental_room->Wardrobe = $request->room_Wardrobe ?? NULL;
        $rental_room->Sofa = $request->room_Sofa ?? NULL;
        $rental_room->TV_Table = $request->room_TV_Table ?? NULL;
        $rental_room->Center_Table = $request->room_Center_Table ?? NULL;
        $rental_room->Dining_Table = $request->room_Dining_Table ?? NULL;
        $rental_room->Chair = $request->room_Chair ?? NULL;
        $rental_room->Bedroom_Air = $request->Bedroom_Air ?? NULL;
        $rental_room->Livingroom_Air = $request->Livingroom_Air ?? NULL;
        $rental_room->Water_Heater = $request->room_Water_Heater ?? NULL;
        $rental_room->TV = $request->room_TV ?? NULL;
        $rental_room->Refrigerator = $request->room_Refrigerator ?? NULL;
        $rental_room->microwave = $request->room_microwave ?? NULL;
        $rental_room->wash_machine = $request->room_wash_machine ?? NULL;
        $rental_room->Other = $request->Other ?? NULL;
        $rental_room->save();

        // รูปภาพห้อง
        if ($request->hasFile('filUpload')) {
            $URL = request()->getHttpHost();
            $allowedfileExtension = ['jpg', 'png'];
            $files = $request->file('filUpload');
            $isImage = NULL;
            $isImage = Room_Images::where('rid', $request->room_id)->where('img_category', 'เช่าอยู่')->first();
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $file->getClientOriginalName();
                    $file->move('uploads/images_room', $filename);
                    $img_room[$key] =  $URL . '/uploads/images_room/' . $request->room_id . '_' . $request->project_id . '_' . $request->RoomNo . '_' . $key . '.' . $extension;
                    // Room_Images::updateOrCreate(
                    //     ['img_path' => $img_room, 'img_category' => 'เช่าอยู่'],
                    //     ['rid' =>  $request->room_id, 'img_category' => 'เช่าอยู่']
                    // );
                    if($isImage){
                        // $isImage->rid = $request->room_id;
                        $isImage->img_path = $img_room[$key];
                        $isImage->img_category = 'เช่าอยู่';
                        $isImage->save();
                    }else{
                        $image = new Room_Images();
                        $image->rid = $request->room_id;
                        $image->img_path = $img_room[$key];
                        $image->img_category = 'เช่าอยู่';
                        $image->save();
                    }
                }
                // else {
                //     echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg </div>';
                // }
            }
        }

        $rental_customer = Customer::where('rid', $request->room_id)->where('id', $request->customer_id)->first();
        // dd($rental_customer);
        if ($rental_customer) {
            // dd($rental_customer);
            // หนังสือสัญญา
            if ($request->hasFile('file_contract_path')) {
                $file = $request->file('file_contract_path');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $file->move('uploads/image_custrent/', $filename);
                $rental_customer->file_contract_path = 'uploads/image_custrent/' . $filename;
            }
            // ใบเสร็จจาก express
            if ($request->hasFile('fileUploadExpress')) {
                $file = $request->file('fileUploadExpress');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                // $file->move('uploads/fileexpress/', $filename);
                // $rental_customer->file_contract_path = 'uploads/fileexpress/' . $filename;
            }
            // ไฟล์บัตรประชาชนลูกค้า
            if ($request->hasFile('file_id_path_cus')) {
                $file = $request->file('file_id_path_cus');
                $extension = $file->getClientOriginalExtension();
                // $filename = $file->getClientOriginalName();
                $filename = $request->customer_id . '_' . $request->project_id . '_' . $request->RoomNo . '.' . $extension;
                $file->move('uploads/image_custrent/', $filename);
                $rental_customer->file_id_path_cus = 'uploads/image_custrent/' . $filename;
            }

            

            // if ($request->hasFile('filUpload')) {
            //     $allowedMimeTypes = ['image/jpeg', 'image/png'];
                
            //     foreach ($request->file('filUpload') as $key => $file) {
            //         if ($file->isValid() && in_array($file->getMimeType(), $allowedMimeTypes)) {
            //             $fileName = $file->hashName();
            //             $filePath = $file->storeAs('uploads/images_room', $fileName);
            //             $imgRoomUrl = Storage::url($filePath);
                        
            //             dump($key);
            //             // Perform database operations inside a transaction
            //             DB::transaction(function () use ($imgRoomUrl, $request) {
            //                 Room_Images::updateOrCreate(
            //                     ['rid' =>  $request->room_id, 'img_category' => 'เช่าอยู่'],
            //                     ['img_path' => $imgRoomUrl, 'img_category' => 'เช่าอยู่']
                                
            //                 );
            //             });
            //         }
            //     }
            // }

           

            if ($request->Contract_Status == 'ต่อสัญญา') {
                // 1. update customer
                $reNewContract = Customer::where('rid', $request->room_id)->orderBy('id','desc')->first();
                $reNewContract->Cancel_Date = date('Y-m-d');
                $reNewContract->Contract_Status = $request->Contract_Status ?? NULL;
                $reNewContract->save();

                // 2. insert new customer new contract
                $newContract = new Customer();
                $newContract->Create_Date = date('Y-m-d');
                $newContract->pid = $request->project_id;
                $newContract->rid = $request->room_id;
                $newContract->Cus_Name = $request->Cus_Name ?? NULL;
                $newContract->IDCard = $request->IDCard ?? NULL;
                $newContract->RoomNo = $request->RoomNo ?? NULL;
                $newContract->Building = $request->Building ?? NULL;
                $newContract->Floor = $request->Floor ?? NULL;
                $newContract->Size = $request->Size ?? NULL;
                $newContract->price_insurance = $request->price_insurance ?? 0;
                $newContract->home_address = $request->cus_homeAddress ?? NULL;
                $newContract->cust_soi = $request->cust_soi ?? NULL;
                $newContract->cust_road = $request->cust_road ?? NULL;
                $newContract->tumbon = $request->cus_tumbon ?? NULL;
                $newContract->province = $request->cus_province ?? NULL;
                $newContract->id_post = $request->cus_idPost ?? NULL;
                $newContract->Phone = $request->cus_phone ?? NULL;
                $newContract->Price = $request->Price ?? NULL;
                $newContract->Contract = $request->Contract_Renew ?? NULL;
                $newContract->Day = $request->Day_Renew ?? 0;
                $newContract->start_paid_date = $request->start_paid_date_Renew ?? NULL;
                $newContract->Contract_Startdate = $request->Contract_Startdate_Renew ?? NULL;
                $newContract->Contract_Enddate = $request->Contract_Enddate_Renew ?? NULL;
                $newContract->Contract_Status = 'เช่าอยู่';
                $newContract->Contract_Reason = $request->Contract_Reason ?? NULL;
                $newContract->date_print_contract_cus_manual = $request->date_print_contract_manual ?? NULL;
                $newContract->cust_remark = $request->cust_remark;
                $newContract->save();

                // 3. insert new payment
                if($request->Contract_Renew == 1){
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Price1 = $request->Price;
                }elseif ($request->Contract_Renew == 2) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                }elseif ($request->Contract_Renew == 3) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                }elseif ($request->Contract_Renew == 4) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                    $Price4 = $request->Price;
                }elseif ($request->Contract_Renew == 5) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                    $Price4 = $request->Price;
                    $Price5 = $request->Price;
                }elseif ($request->Contract_Renew == 6) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                    $Price4 = $request->Price;
                    $Price5 = $request->Price;
                    $Price6 = $request->Price;
                }elseif ($request->Contract_Renew == 7) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                    $Price4 = $request->Price;
                    $Price5 = $request->Price;
                    $Price6 = $request->Price;
                    $Price7 = $request->Price;
                }elseif ($request->Contract_Renew == 8) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                    $Price4 = $request->Price;
                    $Price5 = $request->Price;
                    $Price6 = $request->Price;
                    $Price7 = $request->Price;
                    $Price8 = $request->Price;
                }elseif ($request->Contract_Renew == 9) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due9_Date = Carbon::parse($Due8_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                    $Price4 = $request->Price;
                    $Price5 = $request->Price;
                    $Price6 = $request->Price;
                    $Price7 = $request->Price;
                    $Price8 = $request->Price;
                    $Price9 = $request->Price;
                }elseif ($request->Contract_Renew == 10) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due9_Date = Carbon::parse($Due8_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due10_Date = Carbon::parse($Due9_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                    $Price4 = $request->Price;
                    $Price5 = $request->Price;
                    $Price6 = $request->Price;
                    $Price7 = $request->Price;
                    $Price8 = $request->Price;
                    $Price9 = $request->Price;
                    $Price10 = $request->Price;
                }elseif ($request->Contract_Renew == 11) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due9_Date = Carbon::parse($Due8_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due10_Date = Carbon::parse($Due9_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due11_Date = Carbon::parse($Due10_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                    $Price4 = $request->Price;
                    $Price5 = $request->Price;
                    $Price6 = $request->Price;
                    $Price7 = $request->Price;
                    $Price8 = $request->Price;
                    $Price9 = $request->Price;
                    $Price10 = $request->Price;
                    $Price11 = $request->Price;
                }elseif ($request->Contract_Renew == 12) {
                    $Due1_Date = $request->Contract_Startdate_Renew;
                    $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due9_Date = Carbon::parse($Due8_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due10_Date = Carbon::parse($Due9_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due11_Date = Carbon::parse($Due10_Date)->addMonth()->startOfMonth()->toDateString();
                    $Due12_Date = Carbon::parse($Due11_Date)->addMonth()->startOfMonth()->toDateString();
                    $Price1 = $request->Price;
                    $Price2 = $request->Price;
                    $Price3 = $request->Price;
                    $Price4 = $request->Price;
                    $Price5 = $request->Price;
                    $Price6 = $request->Price;
                    $Price7 = $request->Price;
                    $Price8 = $request->Price;
                    $Price9 = $request->Price;
                    $Price10 = $request->Price;
                    $Price11 = $request->Price;
                    $Price12 = $request->Price;
                }
                $paymentNew = new Payment();
                $paymentNew->cid = $request->customer_id;
                $paymentNew->rid = $request->room_id;
                $paymentNew->Due1_Date = $Due1_Date ?? NULL;
                $paymentNew->Due2_Date = $Due2_Date ?? NULL;
                $paymentNew->Due3_Date = $Due3_Date ?? NULL;
                $paymentNew->Due4_Date = $Due4_Date ?? NULL;
                $paymentNew->Due5_Date = $Due5_Date ?? NULL;
                $paymentNew->Due6_Date = $Due6_Date ?? NULL;
                $paymentNew->Due7_Date = $Due7_Date ?? NULL;
                $paymentNew->Due8_Date = $Due8_Date ?? NULL;
                $paymentNew->Due9_Date = $Due9_Date ?? NULL;
                $paymentNew->Due10_Date = $Due10_Date ?? NULL;
                $paymentNew->Due11_Date = $Due11_Date ?? NULL;
                $paymentNew->Due12_Date = $Due12_Date ?? NULL;
                $paymentNew->Due1_Amount = $Price1 ?? NULL;
                $paymentNew->Due2_Amount = $Price2 ?? NULL;
                $paymentNew->Due3_Amount = $Price3 ?? NULL;
                $paymentNew->Due4_Amount = $Price4 ?? NULL;
                $paymentNew->Due5_Amount = $Price5 ?? NULL;
                $paymentNew->Due6_Amount = $Price6 ?? NULL;
                $paymentNew->Due7_Amount = $Price7 ?? NULL;
                $paymentNew->Due8_Amount = $Price8 ?? NULL;
                $paymentNew->Due9_Amount = $Price9 ?? NULL;
                $paymentNew->Due10_Amount = $Price10 ?? NULL;
                $paymentNew->Due11_Amount = $Price11 ?? NULL;
                $paymentNew->Due12_Amount = $Price12 ?? NULL;
                $paymentNew->save();

            }elseif($request->Contract_Status == 'ออก'){
                $rental_customer->Cus_Name = $request->Cus_Name ?? NULL;
                $rental_customer->IDCard = $request->IDCard ?? NULL;
                $rental_customer->RoomNo = $request->RoomNo ?? NULL;
                $rental_customer->code_contract_old = $request->code_contract_old ?? NULL;
                $rental_customer->price_insurance = $request->price_insurance ?? 0;
                $rental_customer->home_address = $request->cus_homeAddress ?? NULL;
                $rental_customer->cust_soi = $request->cust_soi ?? NULL;
                $rental_customer->cust_road = $request->cust_road ?? NULL;
                $rental_customer->tumbon = $request->cus_tumbon ?? NULL;
                $rental_customer->province = $request->cus_province ?? NULL;
                $rental_customer->id_post = $request->cus_idPost ?? NULL;
                $rental_customer->Phone = $request->cus_phone ?? NULL;
                $rental_customer->Price = $request->Price ?? NULL;
                $rental_customer->Day = $request->Day ?? 0;
                $rental_customer->Cancle_Date = $request->Cancle_Date ?? NULL;
                $rental_customer->Contract_Status = $request->Contract_Status ?? NULL;
                $rental_customer->Contract_Reason = $request->Contract_Reason ?? NULL;
                $rental_customer->date_print_contract_cus_manual = $request->date_print_contract_manual ?? NULL;
                $rental_customer->cust_remark = $request->cust_remark;
                $rental_customer->save();

                // insert report inout
                if (date('m') == '01') {
                    # code...
                }elseif (date('m') == '02') {
                    # code...
                }elseif (date('m') == '03') {
                    # code...
                }elseif (date('m') == '04') {
                    # code...
                }elseif (date('m') == '05') {
                    # code...
                }elseif (date('m') == '06') {
                    # code...
                }elseif (date('m') == '07') {
                    # code...
                }elseif (date('m') == '08') {
                    # code...
                }elseif (date('m') == '09') {
                    # code...
                }elseif (date('m') == '10') {
                    # code...
                }elseif (date('m') == '11') {
                    # code...
                }elseif (date('m') == '12') {
                    # code...
                }
            }else{
                $rental_customer->Cus_Name = $request->Cus_Name ?? NULL;
                $rental_customer->IDCard = $request->IDCard ?? NULL;
                $rental_customer->RoomNo = $request->RoomNo ?? NULL;
                $rental_customer->code_contract_old = $request->code_contract_old ?? NULL;
                $rental_customer->price_insurance = $request->price_insurance ?? 0;
                $rental_customer->home_address = $request->cus_homeAddress ?? NULL;
                $rental_customer->cust_soi = $request->cust_soi ?? NULL;
                $rental_customer->cust_road = $request->cust_road ?? NULL;
                $rental_customer->tumbon = $request->cus_tumbon ?? NULL;
                $rental_customer->province = $request->cus_province ?? NULL;
                $rental_customer->id_post = $request->cus_idPost ?? NULL;
                $rental_customer->Phone = $request->cus_phone ?? NULL;
                $rental_customer->Price = $request->Price ?? NULL;
                $rental_customer->Day = $request->Day ?? 0;
                $rental_customer->Contract_Status = $request->Contract_Status ?? NULL;
                $rental_customer->Contract_Reason = $request->Contract_Reason ?? NULL;
                $rental_customer->date_print_contract_cus_manual = $request->date_print_contract_manual ?? NULL;
                $rental_customer->cust_remark = $request->cust_remark;
                $rental_customer->save();
            }
            
        } else {
            $customer = new Customer();
            $customer->rid = $request->room_id ?? NULL;
            $customer->pid = $request->project_id ?? NULL;
            $customer->Create_Date = now();
            $customer->RoomNo = $request->RoomNo ?? NULL;
            $customer->Cus_Name = $request->Cus_Name ?? NULL;
            $customer->IDCard = $request->IDCard ?? NULL;
            $customer->code_contract_old = $request->code_contract_old ?? NULL;
            $customer->price_insurance = $request->price_insurance ?? NULL;
            $customer->home_address = $request->cus_homeAddress ?? NULL;
            $customer->cust_soi = $request->cust_soi ?? NULL;
            $customer->cust_road = $request->cust_road ?? NULL;
            $customer->tumbon = $request->cus_tumbon ?? NULL;
            $customer->province = $request->cus_province ?? NULL;
            $customer->id_post = $request->cus_idPost ?? NULL;
            $customer->Phone = $request->cus_phone ?? NULL;
            $customer->Price = $request->Price ?? NULL;
            $customer->Contract = $request->Contract ?? NULL;
            $customer->Day = $request->Day ?? 0;
            $customer->start_paid_date = $request->start_paid_date ?? NULL;
            $customer->Contract_Status = $request->Contract_Status ?? NULL;
            $customer->Contract_Reason = $request->Contract_Reason ?? NULL;
            $customer->date_print_contract_cus_manual = $request->date_print_contract_manual ?? NULL;
            $customer->cust_remark = $request->cust_remark ?? NULL;
            // dd($customer);
            
            $customer->save();
            // dd($rental_customer);
        }

        // update table lease_auto_code
        $lease_auto_code = Lease_auto_code::where('ref_cus_id', $request->customer_id)->first();
        if($lease_auto_code){
            $lease_auto_code->print_contract_manual = $request->date_print_contract_manual ?? NULL;
            $lease_auto_code->price_insurance = $request->price_insurance ?? NULL;
        }
        
        if($request->Contract == 1){
            $Due1_Date = $request->Contract_Startdate;
            $Price1 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
        }elseif ($request->Contract == 2) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 3) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 4) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;
            $Price4 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due4_Date = Carbon::parse($Owner_Due3_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 5) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;
            $Price4 = $request->Price;
            $Price5 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due4_Date = Carbon::parse($Owner_Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due5_Date = Carbon::parse($Owner_Due4_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 6) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;
            $Price4 = $request->Price;
            $Price5 = $request->Price;
            $Price6 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due4_Date = Carbon::parse($Owner_Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due5_Date = Carbon::parse($Owner_Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due6_Date = Carbon::parse($Owner_Due5_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 7) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;
            $Price4 = $request->Price;
            $Price5 = $request->Price;
            $Price6 = $request->Price;
            $Price7 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due4_Date = Carbon::parse($Owner_Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due5_Date = Carbon::parse($Owner_Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due6_Date = Carbon::parse($Owner_Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due7_Date = Carbon::parse($Owner_Due6_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 8) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;
            $Price4 = $request->Price;
            $Price5 = $request->Price;
            $Price6 = $request->Price;
            $Price7 = $request->Price;
            $Price8 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due4_Date = Carbon::parse($Owner_Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due5_Date = Carbon::parse($Owner_Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due6_Date = Carbon::parse($Owner_Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due7_Date = Carbon::parse($Owner_Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due8_Date = Carbon::parse($Owner_Due7_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 9) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
            $Due9_Date = Carbon::parse($Due8_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;
            $Price4 = $request->Price;
            $Price5 = $request->Price;
            $Price6 = $request->Price;
            $Price7 = $request->Price;
            $Price8 = $request->Price;
            $Price9 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due4_Date = Carbon::parse($Owner_Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due5_Date = Carbon::parse($Owner_Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due6_Date = Carbon::parse($Owner_Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due7_Date = Carbon::parse($Owner_Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due8_Date = Carbon::parse($Owner_Due7_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due9_Date = Carbon::parse($Owner_Due8_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 10) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
            $Due9_Date = Carbon::parse($Due8_Date)->addMonth()->startOfMonth()->toDateString();
            $Due10_Date = Carbon::parse($Due9_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;
            $Price4 = $request->Price;
            $Price5 = $request->Price;
            $Price6 = $request->Price;
            $Price7 = $request->Price;
            $Price8 = $request->Price;
            $Price9 = $request->Price;
            $Price10 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due4_Date = Carbon::parse($Owner_Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due5_Date = Carbon::parse($Owner_Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due6_Date = Carbon::parse($Owner_Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due7_Date = Carbon::parse($Owner_Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due8_Date = Carbon::parse($Owner_Due7_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due9_Date = Carbon::parse($Owner_Due8_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due10_Date = Carbon::parse($Owner_Due9_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 11) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
            $Due9_Date = Carbon::parse($Due8_Date)->addMonth()->startOfMonth()->toDateString();
            $Due10_Date = Carbon::parse($Due9_Date)->addMonth()->startOfMonth()->toDateString();
            $Due11_Date = Carbon::parse($Due10_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;
            $Price4 = $request->Price;
            $Price5 = $request->Price;
            $Price6 = $request->Price;
            $Price7 = $request->Price;
            $Price8 = $request->Price;
            $Price9 = $request->Price;
            $Price10 = $request->Price;
            $Price11 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due4_Date = Carbon::parse($Owner_Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due5_Date = Carbon::parse($Owner_Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due6_Date = Carbon::parse($Owner_Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due7_Date = Carbon::parse($Owner_Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due8_Date = Carbon::parse($Owner_Due7_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due9_Date = Carbon::parse($Owner_Due8_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due10_Date = Carbon::parse($Owner_Due9_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due11_Date = Carbon::parse($Owner_Due10_Date)->addMonth()->startOfMonth()->toDateString();
        }elseif ($request->Contract == 12) {
            $Due1_Date = $request->Contract_Startdate;
            $Due2_Date = Carbon::parse($Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Due3_Date = Carbon::parse($Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Due4_Date = Carbon::parse($Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Due5_Date = Carbon::parse($Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Due6_Date = Carbon::parse($Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Due7_Date = Carbon::parse($Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Due8_Date = Carbon::parse($Due7_Date)->addMonth()->startOfMonth()->toDateString();
            $Due9_Date = Carbon::parse($Due8_Date)->addMonth()->startOfMonth()->toDateString();
            $Due10_Date = Carbon::parse($Due9_Date)->addMonth()->startOfMonth()->toDateString();
            $Due11_Date = Carbon::parse($Due10_Date)->addMonth()->startOfMonth()->toDateString();
            $Due12_Date = Carbon::parse($Due11_Date)->addMonth()->startOfMonth()->toDateString();
            $Price1 = $request->Price;
            $Price2 = $request->Price;
            $Price3 = $request->Price;
            $Price4 = $request->Price;
            $Price5 = $request->Price;
            $Price6 = $request->Price;
            $Price7 = $request->Price;
            $Price8 = $request->Price;
            $Price9 = $request->Price;
            $Price10 = $request->Price;
            $Price11 = $request->Price;
            $Price12 = $request->Price;

            $Owner_Due1_Date = $request->gauranteestart;
            $Owner_Due2_Date = Carbon::parse($Owner_Due1_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due3_Date = Carbon::parse($Owner_Due2_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due4_Date = Carbon::parse($Owner_Due3_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due5_Date = Carbon::parse($Owner_Due4_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due6_Date = Carbon::parse($Owner_Due5_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due7_Date = Carbon::parse($Owner_Due6_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due8_Date = Carbon::parse($Owner_Due7_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due9_Date = Carbon::parse($Owner_Due8_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due10_Date = Carbon::parse($Owner_Due9_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due11_Date = Carbon::parse($Owner_Due10_Date)->addMonth()->startOfMonth()->toDateString();
            $Owner_Due12_Date = Carbon::parse($Owner_Due11_Date)->addMonth()->startOfMonth()->toDateString();
        }

        // insert date to table rental_payment
        $payment = Payment::where('rid', $request->room_id)
            ->where('cid', $request->customer_id)
            ->count();
        if(!$payment){
            // $Contract_Startdates = $request->start_paid_date;
            // $Contract_StartdateNew = date("Y-m-d", strtotime("-1 day", strtotime($Contract_Startdates)));

            $paymentNew = new Payment();
            $paymentNew->cid = $request->customer_id;
            $paymentNew->rid = $request->room_id;
            $paymentNew->Due1_Date = $Due1_Date ?? NULL;
            $paymentNew->Due2_Date = $Due2_Date ?? NULL;
            $paymentNew->Due3_Date = $Due3_Date ?? NULL;
            $paymentNew->Due4_Date = $Due4_Date ?? NULL;
            $paymentNew->Due5_Date = $Due5_Date ?? NULL;
            $paymentNew->Due6_Date = $Due6_Date ?? NULL;
            $paymentNew->Due7_Date = $Due7_Date ?? NULL;
            $paymentNew->Due8_Date = $Due8_Date ?? NULL;
            $paymentNew->Due9_Date = $Due9_Date ?? NULL;
            $paymentNew->Due10_Date = $Due10_Date ?? NULL;
            $paymentNew->Due11_Date = $Due11_Date ?? NULL;
            $paymentNew->Due12_Date = $Due12_Date ?? NULL;
            $paymentNew->Due1_Amount = $Price1 ?? NULL;
            $paymentNew->Due2_Amount = $Price2 ?? NULL;
            $paymentNew->Due3_Amount = $Price3 ?? NULL;
            $paymentNew->Due4_Amount = $Price4 ?? NULL;
            $paymentNew->Due5_Amount = $Price5 ?? NULL;
            $paymentNew->Due6_Amount = $Price6 ?? NULL;
            $paymentNew->Due7_Amount = $Price7 ?? NULL;
            $paymentNew->Due8_Amount = $Price8 ?? NULL;
            $paymentNew->Due9_Amount = $Price9 ?? NULL;
            $paymentNew->Due10_Amount = $Price10 ?? NULL;
            $paymentNew->Due11_Amount = $Price11 ?? NULL;
            $paymentNew->Due12_Amount = $Price12 ?? NULL;
            $paymentNew->Owner_Due1_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due2_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due3_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due4_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due5_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due6_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due7_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due8_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due9_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due10_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due11_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due12_Amount = $request->gauranteeamount ?? NULL;
            $paymentNew->Owner_Due1_Date = $Owner_Due1_Date ?? NULL;
            $paymentNew->Owner_Due2_Date = $Owner_Due2_Date ?? NULL;
            $paymentNew->Owner_Due3_Date = $Owner_Due3_Date ?? NULL;
            $paymentNew->Owner_Due4_Date = $Owner_Due4_Date ?? NULL;
            $paymentNew->Owner_Due5_Date = $Owner_Due5_Date ?? NULL;
            $paymentNew->Owner_Due6_Date = $Owner_Due6_Date ?? NULL;
            $paymentNew->Owner_Due7_Date = $Owner_Due7_Date ?? NULL;
            $paymentNew->Owner_Due8_Date = $Owner_Due8_Date ?? NULL;
            $paymentNew->Owner_Due9_Date = $Owner_Due9_Date ?? NULL;
            $paymentNew->Owner_Due10_Date = $Owner_Due10_Date ?? NULL;
            $paymentNew->Owner_Due11_Date = $Owner_Due11_Date ?? NULL;
            $paymentNew->Owner_Due12_Date = $Owner_Due12_Date ?? NULL;

            $paymentNew->save();

        }else{

        }
        // insert and update quarantee

        // update product and rooms

        // insert log


        Alert::success('Success', 'อัพเดทข้อมูลสำเร็จ!');
        return redirect(route('rental'));
    }

    public function print(Request $request)
    {
        $strNowdate = date("Y-m-d H:i:s");
        $Y = date("Y") + 543;
        $Y = substr($Y, 2, 2);
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        //เช็คเลขที่สัญญา ใน rooms
        $check_room = Room::select('contract_cus', 'contract_owner', 'id')->where('id', $request->room_id)->first();
        //เช็คเลขที่สัญญา ใน customers
        $check_customer = Customer::select('id', 'contract_owner', 'contract_cus', 'Contract_Startdate', 'date_print_contract_cus_manual')->where('id', $request->customer_id)->first();

        $Contract_Startdate = substr($check_customer->date_print_contract_cus_manual, 0, 4);
        $YearTH = ((int)$Contract_Startdate) + 543;
        $StrYear = substr($YearTH, 2, 2);
        $getCode = Lease_code::where('pid', $request->project_id)->first();
        // DB::raw('(SELECT * FROM customers WHERE Contract_Status
        // $genCode = Lease_auto_code::select(DB::raw('RIGHT(code_contract_owner,3) + 1 as newcode'))->where('code_contract_owner', 'LIKE', '%'.$getCode->lease_agr_code-$StrYear.'%')->where('code_contract_cus', 'LIKE', '%'.$getCode->sub_lease_code-$StrYear.'%')->orderBy('id', 'desc')->take(1)->toSql();
        //     $genCode =  DB::table('lease_auto_code')
        //     ->selectRaw('RIGHT(code_contract_owner, 3) + 1 as newcode')
        //     ->where('code_contract_owner', 'LIKE', "%$getCode->lease_agr_code-$StrYear%")
        //     ->where('code_contract_cus', 'LIKE', "%$getCode->sub_lease_code-$StrYear%")
        //     ->orderBy('id', 'DESC')
        //     ->limit(1)
        //     ->first();
        // dd($genCode->newcode);
        if (!empty($check_room->contract_owner) && !empty($check_customer->contract_cus)) {
            $auto_code = Lease_auto_code::where('ref_rental_room_id', $request->room_id)->first();
            $auto_code->print_contract_owner = $strNowdate;
            $auto_code->save();
        } else {
            $getCode = Lease_code::where('pid', $request->project_id)->first();
            // dd($getCode);
            // DB::raw('(SELECT * FROM customers WHERE Contract_Status
            // $genCode = Lease_auto_code::select(DB::raw('RIGHT(code_contract_owner,3) + 1 as newcode'))->where('code_contract_owner', 'LIKE', '%'.$getCode->lease_agr_code-$StrYear.'%')->where('code_contract_cus', 'LIKE', '%'.$getCode->sub_lease_code-$StrYear.'%')->orderBy('id', 'desc')->take(1)->toSql();
            // $genCode = DB::table('Lease_auto_code')->select(DB::raw('RIGHT(code_contract_owner,3) + 1 as newcode'))->where('code_contract_owner', 'LIKE', '%'.$getCode->lease_agr_code-$StrYear.'%')->where('code_contract_cus', 'LIKE', '%'.$getCode->sub_lease_code-$StrYear.'%')->orderBy('id', 'desc')->take(1)->toSql();
            $genCode =  DB::table('lease_auto_code')
                ->selectRaw('RIGHT(code_contract_owner, 3) + 1 as newcode')
                ->where('code_contract_owner', 'LIKE', "%$getCode->lease_agr_code-$StrYear%")
                ->where('code_contract_cus', 'LIKE', "%$getCode->sub_lease_code-$StrYear%")
                ->orderBy('id', 'DESC')
                ->limit(1)
                // ->pluck('newcode')
                ->first();
            // dd($genCode);
            if (!$genCode) {
                $codeID0 = $getCode->lease_agr_code . "-" . $StrYear . "-" . "001";
                $codeID1 = $getCode->sub_lease_code . "-" . $StrYear . "-" . "001";
                $codeID2 = $getCode->insurance_code . "-" . $StrYear . "-" . "001";
                $codeID3 = $getCode->agent_contract_code . "-" . $StrYear . "-" . "001";
            } else {
                $codeID0 = $getCode->lease_agr_code . "-" . $StrYear . "-" . sprintf("%03d", $genCode->newcode);
                $codeID1 = $getCode->sub_lease_code . "-" . $StrYear . "-" . sprintf("%03d", $genCode->newcode);
                $codeID2 = $getCode->insurance_code . "-" . $StrYear . "-" . sprintf("%03d", $genCode->newcode);
                $codeID3 = $getCode->agent_contract_code . "-" . $StrYear . "-" . sprintf("%03d", $genCode->newcode);
            }

            $lease_auto_code = new Lease_auto_code();
            $lease_auto_code->ref_lease_code_id = $getCode->ref_lease_code_id ?? NULL;
            $lease_auto_code->ref_rental_room_id = $getCode->ref_rental_room_id ?? NULL;
            $lease_auto_code->ref_cus_id = $getCode->ref_cus_id ?? NULL;
            $lease_auto_code->code_contract_owner = $codeID0 ?? NULL;
            $lease_auto_code->code_contract_cus = $codeID1 ?? NULL;
            $lease_auto_code->code_contract_insurance = $codeID2 ?? NULL;
            $lease_auto_code->code_contract_agent = $codeID3 ?? NULL;
            $lease_auto_code->create_at = $strNowdate ?? NULL;
            $lease_auto_code->print_contract_owner = NULL;
            $lease_auto_code->print_contract_cus = NULL;
            $lease_auto_code->print_contract_insurance = $strNowdate ?? NULL;
            $lease_auto_code->print_contract_agent = NULL;
            $lease_auto_code->print_contract_manual = NULL;
            $lease_auto_code->price_insurance = NULL;
            $lease_auto_code->save();

            $room = Room::where('id', $request->room_id)->first();
            $room->contract_cus = $codeID1;
            $room->contract_owner = $codeID0;
            $room->save();

            $customer = Customer::where('id', $request->customer_id)->first();
            $customer->contract_owner = $codeID0;
            $customer->contract_cus = $codeID1;
            $customer->save();

            $customer = Customer::where('id', $request->customer_id)->first();
            $customer->contract_owner = $codeID0;
            $customer->contract_cus = $codeID1;
            $customer->save();
        }
        // dd($request->phayarn1);

        $phayarn1 = $request->phayarn1 ?? '';
        $phayarn2 = $request->phayarn2 ?? '';

        $getCode = Lease_code::where('pid', $request->project_id)->first();

        $rents = Room::select(
            'projects.Project_Name',
            'projects.Project_NameTH',
            'projects.address_full',
            'lease_auto_code.code_contract_agent',
            'lease_auto_code.code_contract_owner',
            'lease_auto_code.code_contract_cus',
            'lease_auto_code.code_contract_insurance',
            'lease_auto_code.print_contract_manual',
            'lease_auto_code.price_insurance',
            'rooms.id',
            'rooms.pid',
            'rooms.HomeNo',
            'rooms.RoomNo',
            'rooms.RoomType',
            'rooms.Location',
            'rooms.Size',
            'rooms.Building',
            'rooms.Floor',
            'rooms.Owner',
            'rooms.Transfer_Date',
            'rooms.Guarantee_Enddate',
            'rooms.cardowner',
            'rooms.owner_district',
            'rooms.owner_khet',
            'rooms.owner_road',
            'rooms.owner_soi',
            'rooms.owner_province',
            'rooms.numberhome',
            'rooms.date_firstget',
            'rooms.price',
            'rooms.Key_front',
            'rooms.Key_bed',
            'rooms.Key_mailbox',
            'rooms.KeyCard',
            'rooms.KeyCard_P',
            'rooms.KeyCard_B',
            'rooms.KeyCard_C',
            'rooms.Bed',
            'rooms.Beding',
            'rooms.Bedroom_Curtain',
            'rooms.Livingroom_Curtain',
            'rooms.Wardrobe',
            'rooms.Sofa',
            'rooms.TV_Table',
            'rooms.Dining_Table',
            'rooms.Center_Table',
            'rooms.Chair',
            'rooms.Bedroom_Air',
            'rooms.Livingroom_Air',
            'rooms.Water_Heater',
            'rooms.TV',
            'rooms.Refrigerator',
            'rooms.microwave',
            'rooms.wash_machine',
            'rooms.Other',
            'customers.id',
            'customers.Cus_Name',
            'customers.IDCard',
            'customers.home_address',
            'customers.cust_soi',
            'customers.cust_road',
            'customers.tumbon',
            'customers.aumper',
            'customers.province',
            'customers.Contract',
            'customers.Day',
            'customers.RoomNo as cus_room_no',
            'customers.start_paid_date',
            'customers.Contract_Startdate',
            'customers.Contract_Enddate',
            'customers.Price',
            'customers.Phone',
            'customers.Contract',
            'customers.price_insurance as cus_price_insurance',
            'customers.code_contract_old',

        )
            ->join('projects', 'projects.pid', '=', 'rooms.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            ->join('lease_auto_code', 'lease_auto_code.ref_cus_id', '=', 'customers.id')
            ->where('rooms.id', $request->room_id)
            // ->where('lease_auto_code.ref_rental_room_id',$request->room_id)
            ->first();

        // dd($rents);
        if ($rents->print_contract_manual) {
        }

        if ($rents->Price) {
            $customer_price = $this->convertAmount($rents->Price);
        } else {
            $customer_price = null;
        }
        if ($rents->price_insurance) {
            $price_insurance = $this->convertAmount($rents->price_insurance);
        } else {
            $price_insurance = null;
        }
        if ($rents->price) {
            $room_price = $this->convertAmount($rents->price);
        } else {
            $room_price = null;
        }


        // dd($request->all());
        // สัญญาเช่าช่วงห้องชุด ห้องพักอาศัย
        if ($request->status_approve == 1) {
            // return view('rental.print.sub_apartment',compact('dataLoginUser'));
            // dd($request->status_approve);
            // dd($rents);
            $pdf = Pdf::loadView('rental.print.sub_apartment', ['dataLoginUser' => $dataLoginUser, 'rents' => $rents, 'getCode' => $getCode, 'phayarn1' => $phayarn1, 'phayarn2' => $phayarn2, 'customer_price' => $customer_price, 'price_insurance' => $price_insurance]);
            // return $pdf->download();
            return $pdf->stream();
        }

        // สัญญาเฟอร์
        if ($request->status_approve == 2) {
            // dd($request->status_approve);
            $pdf = Pdf::loadView('rental.print.furniture', ['dataLoginUser' => $dataLoginUser, 'rents' => $rents, 'getCode' => $getCode, 'phayarn1' => $phayarn1, 'phayarn2' => $phayarn2, 'customer_price' => $customer_price, 'price_insurance' => $price_insurance]);
            // return $pdf->download('invoice.pdf');
            return $pdf->stream();
            // dd($request->status_approve);
        }
        // สัญญาแต่งตั้งตัวแทน
        if ($request->status_approve == 3) {
            // dd($request->status_approve);
            $pdf = Pdf::loadView('rental.print.representative', ['dataLoginUser' => $dataLoginUser, 'rents' => $rents, 'getCode' => $getCode, 'phayarn1' => $phayarn1, 'phayarn2' => $phayarn2, 'customer_price' => $customer_price, 'price_insurance' => $price_insurance]);
            return $pdf->stream();
            // dd($request->status_approve);
        }
        // สัญญาเช่าห้องชุด
        if ($request->status_approve == 4) {
            // dd($request->status_approve);
            $pdf = Pdf::loadView('rental.print.apartment', ['dataLoginUser' => $dataLoginUser, 'rents' => $rents, 'getCode' => $getCode, 'phayarn1' => $phayarn1, 'phayarn2' => $phayarn2, 'room_price' => $room_price, 'price_insurance' => $price_insurance]);
            return $pdf->stream();
            // dd($request->status_approve);
        }
    }

    public function getLeaseCode($id){
        $LeaseCode = Lease_code::where('pid', $id)->first();
        return response()->json($LeaseCode, 200);
    }

    public function convertAmount($amount_number)
    {
        $amount_number = number_format($amount_number, 2, ".", "");
        $pt = strpos($amount_number, ".");
        $number = $fraction = "";
        if ($pt === false)
            $number = $amount_number;
        else {
            $number = substr($amount_number, 0, $pt);
            $fraction = substr($amount_number, $pt + 1);
        }

        $ret = "";
        $baht = $this->readNumber($number);
        if ($baht != "")
            $ret .= $baht . "บาท";

        $satang = $this->readNumber($fraction);
        if ($satang != "")
            $ret .=  $satang . "สตางค์";
        else
            $ret .= "ถ้วน";
        return $ret;
    }

    public function readNumber($number)
    {
        $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
        $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
        $number = $number + 0;
        $ret = "";
        if ($number == 0) return $ret;
        if ($number > 1000000) {
            $ret .= $this->readNumber(intval($number / 1000000)) . "ล้าน";
            $number = intval(fmod($number, 1000000));
        }

        $divider = 100000;
        $pos = 0;
        while ($number > 0) {
            $d = intval($number / $divider);
            $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : ((($divider == 10) && ($d == 1)) ? "" : ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
            $ret .= ($d ? $position_call[$pos] : "");
            $number = $number % $divider;
            $divider = $divider / 10;
            $pos++;
        }
        return $ret;
    }

    public function rent(Request $request)
    {
        // dd($result);
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        // $result = Room::select('rooms.*','projects.*')
        // ->join('projects', 'projects.pid', '=', 'rooms.pid')
        // ->where('rooms.id', '=', $request->id)
        // ->first();
        $result = Room::select(
            'projects.*',
            'projects.pid as project_id',
            'rooms.*',
            'rooms.id as room_id',
            'rooms.Phone as phone',
            'customers.*',
            'customers.id as customer_id',
            'payments.id as payment_id',
            'payments.*',
        )
            ->join('projects', 'projects.pid', '=', 'rooms.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            ->join('payments', 'payments.cid', '=', 'customers.id')
            ->where('rooms.id', $request->id)
            ->first();
        // dd($result);

        return view('rental.rent.index', compact('dataLoginUser', 'result'));
        // dd($result);
    }

    public function download(Request $request, $id, $date)
    {
        // dd($date);
        // Determine the absolute path to the file
        // $absoluteFilePath = storage_path('app/public/uploads/' . $filePath);

        // Check if the file exists
        // if (file_exists($absoluteFilePath)) {
        //     // Set headers for file download
        //     return response()->download($absoluteFilePath);
        // } else {
        //     // Handle if the file does not exist
        //     abort(404);
        // }
        // $Due = explode('-',$date); 
        $monthY = thaidate('F Y', $date);
        // dd($monthY);
        $result = Room::select(
            'projects.Project_Name',
            'projects.address_full',
            'rooms.HomeNo',
            'rooms.RoomNo',
            'customers.Cus_Name',
            'customers.Contract_Status',
            'customers.pid',
            'payments.*',
        )
            ->join('projects', 'projects.pid', '=', 'rooms.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            ->join('payments', 'payments.cid', '=', 'customers.id')
            ->where('rooms.id', $request->id)
            ->first();

        $pdf = Pdf::loadView('rental.rent.print', ['result' => $result, 'monthY' => $monthY]);
        return $pdf->stream();
    }

    public function recordRent(Request $request)
    {
        // dd($request->all());
       
        $payment = Payment::where('id', $request->payment_id)->first();
        for ($i = 1; $i <= 28; $i++) {
            if ($request->hasFile("slips{$i}")) {
                $num = ($i > 12 ? $i - 16 : $i);
                // dd($num);
                $file = $request->file("slips{$i}");
                $extension = $file->getClientOriginalExtension();
                $month = str_replace("'", '', str_replace('-', '', $request->{"Payment_Date{$num}"}));
                $filename = 'slip_' . $i . '_' . $request->project_id . '_' . $month . '_'.rand().'.' . $extension;
                // dd($filename);
                // $file->move('uploads/image_slip/', $filename);
                $payment->{"slip{$i}"} = $filename ?? null;
                // dd($payment->{"slip{$i}"});
                $url = "https://property.vbeyond.co.th";
                $toEmail = ['sakeerin.k@vbeyond.co.th'];
                $toCC = ['santi.c@vbeyond.co.th'];
                $toBCC = ['noreply@vbeyond.co.th'];

                Mail::send(
                    'rental.rent.mail',
                    ['Link' => $url, 'roomNo' => $request->roomNo, 'project' => $request->projectName, 'owner' => $request->owner, 'monthY' => $request->{"Payment_Date{$num}"}],
                    function (Message $message) use ($toEmail, $toCC, $toBCC) {
                        $message->to($toEmail)
                            ->cc($toCC)
                            ->bcc($toBCC)
                            ->subject('สลิปรอการอนุมัติ');
                    }
                );
                
                // update status approve
                $payment->{"status_approve{$i}"} = 0;

                dd($filename);
            }
        }
        $payment->Bail = $request->Bail ?? 0;
        $payment->Bail_date = $request->Bail_date ?? null; // ***
        $payment->Bail_slip = $request->Bail_slip ?? null;
        $payment->Bail_status = $request->Bail_status ?? null;
        $payment->Deposit = $request->Deposit ?? 0;
        $payment->Deposit_date = $request->Deposit_date ?? null;
        $payment->Deposit_slip = $request->Deposit_slip ?? null;
        $payment->Deposit_status = $request->Deposit_status ?? null;
        $payment->Due1_Date = $request->Due1_Date ?? null;
        $payment->Due2_Date = $request->Due2_Date ?? null;
        $payment->Due3_Date = $request->Due3_Date ?? null;
        $payment->Due4_Date = $request->Due4_Date ?? null;
        $payment->Due5_Date = $request->Due5_Date ?? null;
        $payment->Due6_Date = $request->Due6_Date ?? null;
        $payment->Due7_Date = $request->Due7_Date ?? null;
        $payment->Due8_Date = $request->Due8_Date ?? null;
        $payment->Due9_Date = $request->Due9_Date ?? null;
        $payment->Due10_Date = $request->Due10_Date ?? null;
        $payment->Due11_Date = $request->Due11_Date ?? null;
        $payment->Due12_Date = $request->Due12_Date ?? null;
        $payment->Due1_Amount = $request->Due1_Amount ?? null;
        $payment->Due2_Amount = $request->Due2_Amount ?? null;
        $payment->Due3_Amount = $request->Due3_Amount ?? null;
        $payment->Due4_Amount = $request->Due4_Amount ?? null;
        $payment->Due5_Amount = $request->Due5_Amount ?? null;
        $payment->Due6_Amount = $request->Due6_Amount ?? null;
        $payment->Due7_Amount = $request->Due7_Amount ?? null;
        $payment->Due8_Amount = $request->Due8_Amount ?? null;
        $payment->Due9_Amount = $request->Due9_Amount ?? null;
        $payment->Due10_Amount = $request->Due10_Amount ?? null;
        $payment->Due11_Amount = $request->Due11_Amount ?? null;
        $payment->Due12_Amount = $request->Due12_Amount ?? null;
        $payment->Payment_Date1 = $request->Payment_Date1 ?? null;
        $payment->Payment_Date2 = $request->Payment_Date2 ?? null;
        $payment->Payment_Date3 = $request->Payment_Date3 ?? null;
        $payment->Payment_Date4 = $request->Payment_Date4 ?? null;
        $payment->Payment_Date5 = $request->Payment_Date5 ?? null;
        $payment->Payment_Date6 = $request->Payment_Date6 ?? null;
        $payment->Payment_Date7 = $request->Payment_Date7 ?? null;
        $payment->Payment_Date8 = $request->Payment_Date8 ?? null;
        $payment->Payment_Date9 = $request->Payment_Date9 ?? null;
        $payment->Payment_Date10 = $request->Payment_Date10 ?? null;
        $payment->Payment_Date11 = $request->Payment_Date11 ?? null;
        $payment->Payment_Date12 = $request->Payment_Date12 ?? null;
       
        $payment->Remark1 = $request->Remark1 ?? null;
        $payment->Remark2 = $request->Remark2 ?? null;
        $payment->Remark3 = $request->Remark3 ?? null;
        $payment->Remark4 = $request->Remark4 ?? null;
        $payment->Remark5 = $request->Remark5 ?? null;
        $payment->Remark6 = $request->Remark6 ?? null;
        $payment->Remark7 = $request->Remark7 ?? null;
        $payment->Remark8 = $request->Remark8 ?? null;
        $payment->Remark9 = $request->Remark9 ?? null;
        $payment->Remark10 = $request->Remark10 ?? null;
        $payment->Remark11 = $request->Remark11 ?? null;
        $payment->Remark12 = $request->Remark12 ?? null;

        $payment->Remarkpay1 = $request->Remarkpay1 ?? null;
        $payment->Remarkpay2 = $request->Remarkpay2 ?? null;
        $payment->Remarkpay3 = $request->Remarkpay3 ?? null;
        // $payment->slip16 = $request->slip16 ?? null;
        // $payment->slip17 = $request->slip17 ?? null;
        // $payment->slip18 = $request->slip18 ?? null;
        // $payment->slip19 = $request->slip19 ?? null;
        // $payment->slip20 = $request->slip20 ?? null;
        // $payment->slip21 = $request->slip21 ?? null;
        // $payment->slip22 = $request->slip22 ?? null;
        // $payment->slip23 = $request->slip23 ?? null;
        // $payment->slip24 = $request->slip24 ?? null;
        // $payment->slip25 = $request->slip25 ?? null;
        // $payment->slip26 = $request->slip26 ?? null;
        // $payment->slip27 = $request->slip27 ?? null;
        // $payment->slip28 = $request->slip28 ?? null;

        dd($payment);
    }

    public function preapprove($id) {
        $result = Room::select(
            'projects.Project_Name',
            'rooms.id as room_id',
            'rooms.HomeNo',
            'rooms.RoomNo',
            'rooms.Owner',
            'rooms.Phone as phone',
            'customers.id as customer_id',
            'customers.Cus_Name',
            'customers.pid',
            'payments.id as payment_id',
            'payments.*',
        )
            ->join('projects', 'projects.pid', '=', 'rooms.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            ->join('payments', 'payments.cid', '=', 'customers.id')
            ->where('rooms.id', $id)
            ->first();

        return response()->json($result, 200);
    }

    public function approve($id, $status, $index){
        $payment = Payment::where('id', $id)->first();
        $payment->{"approve{$index}_date"} = now();
        $payment->{"status_approve{$index}"} = $status;
        $payment->save();


        return response()->json([
            'data' => $payment,
            'message' => 'อัพเดทข้อมูลสำเร็จ'], 200);
        // dd($payment);
    }

    public function history(Request $request, $id){
        // dd($id);
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $rent = Room::select(
            'projects.Project_Name',
            'rooms.RoomNo',
            'rooms.HomeNo',
            'rooms.Owner',
            'rooms.Phone',
            // 'customers.id as customer_id',
            // 'payments.id as payment_id',
        )
            ->join('projects', 'projects.pid', '=', 'rooms.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
            OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            // ->join('payments', 'payments.cid', '=', 'customers.id')
            ->where('rooms.id', $id)
            ->first();

        $history = Room::select(
            // 'rooms.*',
            // 'rooms.id as room_id',
            // 'rooms.Phone as phone',
            // DB::raw('COUNT(customers.Contract) as count'),
            'customers.Cus_Name',
            'customers.contract_startdate',
            'customers.contract_enddate',
            'customers.Contract_Status',
            'payments.Due1_Date',
            'payments.Due2_Date',
            'payments.Due3_Date',
            'payments.Due4_Date',
            'payments.Due5_Date',
            'payments.Due6_Date',
            'payments.Due7_Date',
            'payments.Due8_Date',
            'payments.Due9_Date',
            'payments.Due10_Date',
            'payments.Due11_Date',
            'payments.Due12_Date',
            'payments.Due1_Amount',
            'payments.Due2_Amount',
            'payments.Due3_Amount',
            'payments.Due4_Amount',
            'payments.Due5_Amount',
            'payments.Due6_Amount',
            'payments.Due7_Amount',
            'payments.Due8_Amount',
            'payments.Due9_Amount',
            'payments.Due10_Amount',
            'payments.Due11_Amount',
            'payments.Due12_Amount',
            'payments.slip1',
            'payments.slip2',
            'payments.slip3',
            'payments.slip4',
            'payments.slip5',
            'payments.slip6',
            'payments.slip7',
            'payments.slip8',
            'payments.slip9',
            'payments.slip10',
            'payments.slip11',
            'payments.slip12',
            'payments.Payment_Date1',
            'payments.Payment_Date2',
            'payments.Payment_Date3',
            'payments.Payment_Date4',
            'payments.Payment_Date5',
            'payments.Payment_Date6',
            'payments.Payment_Date7',
            'payments.Payment_Date8',
            'payments.Payment_Date9',
            'payments.Payment_Date10',
            'payments.Payment_Date11',
            'payments.Payment_Date12',
            'payments.Remark1',
            'payments.Remark2',
            'payments.Remark3',
            'payments.Remark4',
            'payments.Remark5',
            'payments.Remark6',
            'payments.Remark7',
            'payments.Remark8',
            'payments.Remark9',
            'payments.Remark10',
            'payments.Remark11',
            'payments.Remark12',
            'payments.id as payment_id',
            'payments.*',
        )
            ->join('projects', 'projects.pid', '=', 'rooms.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers) AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            ->join('payments', 'payments.cid', '=', 'customers.id')
            ->where('rooms.id', $id)
            // ->groupBy('customers.Cus_Name')
            ->get();

        $count = $history->count();
        // dd($count);

        $productPid = Product::join('rooms', function ($join) use ($id) {
            $join->on('rooms.HomeNo', '=', 'products.HomeNo')
                 ->on('rooms.RoomNo', '=', 'products.RoomNo')
                 ->on('rooms.pid', '=', 'products.project_id');
        })
        ->where('rooms.id', $id)
        // ->where('product.HomeNo', '=', trim($result['HomeNo']))
        // ->where('product.RoomNo', '=', trim($result['RoomNo']))
        // ->where('product.project_id', '=', trim($result['pid']))
        ->orderByDesc('id')
        ->limit(1)
        ->pluck('products.pid')
        ->first();

        $sum = Quarantee::where('pid', $productPid)
                ->where('status_quarantee', 'enabled')
                ->count('pid');

        if($productPid){
            $quaranteeIdASC = Quarantee::where('pid', $productPid)
                ->where('status_quarantee', 'enabled')
                ->where('due_date','!=', null)
                ->where('amount_fix', '!=',null)
                ->where('amount_fix', '!=',0)
                ->orderBy('id', 'ASC')
                ->get();
                // ->pluck('id');
            $quaranteeIdDESC = Quarantee::where('pid', $productPid)
                ->where('status_quarantee', 'enabled')
                ->orderBy('id', 'DESC')
                ->pluck('id');
            $rows = ceil($sum/12);
        }
        // dd($sum);

        $quarantees = Quarantee::where('pid', $productPid)
        ->where('status_quarantee', 'enabled')
        ->orderBy('due_date', 'ASC')
        ->get();

        // dd($quarantees);

        $dueDate = array();
        $amountFix = array();
        $amount = array();
        $paymentDate = array();
        $count_krows=0;
        // for($j=1; $j<= $sum; $j++){
        //     // foreach ($quarantees as $key => $value) {
        //     for($i=1; $i<= 12; $i++){
        //         // if ($count_krows < 12*$j) {
        //             // $final_id = ((int)$quaranteeIdASC[$count_krows])+$count_krows;
        //             // $final_id = $quaranteeIdASC[$count_krows];
        //             // if ($final_id) {
        //             //     $data = Quarantee::where('id', $final_id)
        //             //     ->where('status_quarantee', 'enabled')
        //             //     ->first();
        //             //     // $dueDate[$j][$i] = $data->due_date ?? '';
        //             //     // $amountFix[$j][$i] = $data->amount_fix ?? '';
        //             //     // $amount[$j][$i] = $data->amount ?? '';
        //             //     // $paymentDate[$j][$i] = $data->payment_date ?? '';
        //             //     // dump($final_id);
        //             // }
        //             // dump($quaranteeIdASC[$j]);
        //             // $count_krows++;
        //         // }
        //     }
        //  // }
        // }
        // if($count_krows <= $sum){
        //     for ($i=1; $i <= $rows ; $i++) { 
        //         for ($j=0; $j <= 11; $j++) { 
        //             // $data = Quarantee::where('id', $quaranteeIdASC[$count_krows])
        //             //     ->where('status_quarantee', 'enabled')
        //             //     ->where('due_date','!=', null)
        //             //     ->where('amount_fix', '!=',null)
        //             //     ->where('amount_fix', '!=',0)
        //             //     ->first();
        //             // $dueDate[$i][$j] = $data->due_date ?? '';
        //             // $amountFix[$i][$j] = $data->amount_fix ?? '';
        //             // $amount[$i][$j] = $data->amount ?? '';
        //             // $paymentDate[$i][$j] = $data->payment_date ?? '';
        //             // dump($count_krows);
        //             // $count_krows++;
        //             foreach($quaranteeIdASC as $data){
        //                 $dueDate[$i][$j] = $data->due_date ?? '';
        //                 $amountFix[$i][$j] = $data->amount_fix ?? '';
        //                 $amount[$i][$j] = $data->amount ?? '';
        //                 $paymentDate[$i][$j] = $data->payment_date ?? '';
        //                 // dump($count_krows);
        //             }
        //         }
        //     }
        // }
        // foreach($quaranteeIdASC as $data){
            // for ($i=1; $i <= $sum ; $i++) { 
            //     for ($j=0; $j <= 11; $j++) { 
            //         $dueDate[$i][$j] = $data->due_date ?? '';
            //         $amountFix[$i][$j] = $data->amount_fix ?? '';
            //         $amount[$i][$j] = $data->amount ?? '';
            //         $paymentDate[$i][$j] = $data->payment_date ?? '';
            //     }
            // }
        // }


        // dd($dueDate);

        // foreach ($dueArr as $key => $value) {
            
        // }

        // dd($dueDate);

        return view('rental.history', compact('dataLoginUser', 'rent', 'count','history','quarantees','dueDate','amountFix','amount','rows','sum'));
            dd($history);
    }
}
