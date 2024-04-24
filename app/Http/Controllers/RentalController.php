<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Lease_auto_code;
use App\Models\Lease_code;
use App\Models\Project;
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
            ->join('projects', 'rooms.pid', '=', 'projects.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            ->whereNotIn('rooms.Status_room', ['คืนห้อง'])
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

        if ($request->Phone) {
            $rents->where('rooms.Phone', 'LIKE', '%' . $request->Phone . '%');
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

        if ($request->startdate  && $request->enddate) {
            $rents->whereBetween('rooms.Create_Date', [$request->startdate, $request->enddate]);
        }

        $rentsCount = $rents->count();

        $rents = $rents
            ->orderBy('Project_Name', 'asc')
            ->get();

        // dd($rents[2]);

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
            'rooms.Create_Date',
            'rooms.HomeNo',
            'rooms.RoomNo',
            'rooms.RoomType',
            'rooms.Location',
            'rooms.Size',
            'rooms.Electric_Contract',
            'rooms.Contract_Owner',
            'rooms.Owner',
            'rooms.Phone',
            'rooms.price',
            'rooms.date_firstrend',
            'rooms.date_endrend',
            'rooms.Guarantee_Startdate',
            'rooms.Guarantee_Enddate',
            'rooms.rental_status',
            'rooms.Status_Room',
            'rooms.Other',
            'rooms.contract_cus',
            'rooms.contract_owner',
            'rooms.price_insurance',
            'customers.Cus_Name',
            'customers.Phone',
            'customers.Price',
            'customers.Contract_Status',
            'customers.Contract_Startdate',
            'customers.Contract_Enddate'

        )
            ->join('projects', 'projects.pid', '=', 'rooms.pid')
            // ->join('customers', 'rooms.pid', '=', 'customers.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })

            ->where('rooms.id', $id)
            // ->whereHas('rental_customer', function(Builder $query) use($rental_room){
            //     $query->where('rental_customer.pid',$rental_room->pid);
            // })
            // ->where('rental_customer.pid',$rental_room->pid)
            // ->where('project.pid',$rental_room->pid)
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
        // $rental_room = Rental::where('id', $id)->first();
        $rents = Room::select(
            'projects.*',
            // 'projects.pid as pids',
            'rooms.*',
            'rooms.id as room_id',
            'rooms.pid as project_id',
            'rooms.Phone as owner_phone',
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
            $ref_cus_id = $item->id;
        }
        // $ref_cus_id = $ref_cus_id ?? NULL;

        // dd($rents);

        $lease_auto_code = DB::connection('mysql_report')
            ->table('lease_auto_code')
            ->where('ref_cus_id', $ref_cus_id)
            ->first();

        return view('rental.edit', compact('dataLoginUser', 'rents', 'projects', 'lease_auto_code'));
    }

    public function update(Request $request)
    {
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
        $rental_room->numberhome = $request->room_address ?? NULL;
        $rental_room->HomeNo = $request->numberhome ?? NULL;
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
                $file->move('uploads/image_custrent/', $filename);
                $rental_customer->file_contract_path = 'uploads/image_custrent/' . $filename;
            }

            // รูปภาพห้อง
            if ($request->hasFile('filUpload')) {
                $URL = request()->getHttpHost();
                $allowedfileExtension = ['jpg', 'png'];
                $files = $request->file('filUpload');
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    if ($check) {
                        $filename = $file->getClientOriginalName();
                        $file->move('uploads/images_room', $filename);
                        $img_room =  $URL . '/uploads/images_room/' . $rental_customer->id . '_' . $request->project_id . '_' . $request->RoomNo . '.' . $extension;
                        Room_Images::updateOrCreate(
                            ['img_path' => $img_room, 'img_category' => 'เช่าอยู่'],
                            ['rid' =>  $request->room_id, 'img_category' => 'เช่าอยู่']
                        );
                    }
                    // else {
                    //     echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg </div>';
                    // }
                }
            }
            $rental_customer->Cus_Name = $request->Cus_Name ?? NULL;
            $rental_customer->IDCard = $request->IDCard ?? NULL;
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
            $rental_customer->Contract_Status = $request->Contract_Status ?? NULL;
            $rental_customer->Contract_Reason = $request->file_contract_path ?? NULL;
            $rental_customer->date_print_contract_manual = $request->date_print_contract_manual ?? NULL;
            $rental_customer->cust_remark = $request->cust_remark;
            $rental_customer->save();
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
            $customer->Contract_Status = $request->Contract_Status ?? NULL;
            $customer->Contract_Reason = $request->file_contract_path ?? NULL;
            $customer->date_print_contract_manual = $request->date_print_contract_manual ?? NULL;
            $customer->cust_remark = $request->cust_remark ?? NULL;
            // dd($customer);
            $customer->save();

            // dd($rental_customer);
        }

        // update table lease_auto_code


        // insert date to table rental_payment

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

        if($rents->Price){
            $customer_price = $this->convertAmount($rents->Price);
        }else{
            $customer_price = null;
        }
        if($rents->price_insurance){
            $price_insurance = $this->convertAmount($rents->price_insurance);
        }else{
             $price_insurance = null;
        }
        if($rents->price){
            $room_price = $this->convertAmount($rents->price);
        }else{
            $room_price = null;
        }


        // dd($request->all());
        // สัญญาเช่าช่วงห้องชุด ห้องพักอาศัย
        if ($request->status_approve == 1) {
            // return view('rental.print.sub_apartment',compact('dataLoginUser'));
            // dd($request->status_approve);
            // dd($rents);
            $pdf = Pdf::loadView('rental.print.sub_apartment', ['dataLoginUser' => $dataLoginUser, 'rents' => $rents, 'getCode' => $getCode, 'phayarn1' => $phayarn1, 'phayarn2' => $phayarn2, 'customer_price'=> $customer_price, 'price_insurance' => $price_insurance]);
            // return $pdf->download();
            return $pdf->stream();
        }

        // สัญญาเฟอร์
        if ($request->status_approve == 2) {
            // dd($request->status_approve);
            $pdf = Pdf::loadView('rental.print.furniture', ['dataLoginUser' => $dataLoginUser, 'rents' => $rents, 'getCode' => $getCode, 'phayarn1' => $phayarn1, 'phayarn2' => $phayarn2, 'customer_price'=> $customer_price, 'price_insurance' => $price_insurance]);
            // return $pdf->download('invoice.pdf');
            return $pdf->stream();
            // dd($request->status_approve);
        }
        // สัญญาแต่งตั้งตัวแทน
        if ($request->status_approve == 3) {
            // dd($request->status_approve);
            $pdf = Pdf::loadView('rental.print.representative', ['dataLoginUser' => $dataLoginUser, 'rents' => $rents, 'getCode' => $getCode, 'phayarn1' => $phayarn1, 'phayarn2' => $phayarn2, 'customer_price'=> $customer_price, 'price_insurance' => $price_insurance]);
            return $pdf->stream();
            // dd($request->status_approve);
        }
        // สัญญาเช่าห้องชุด
        if ($request->status_approve == 4) {
            // dd($request->status_approve);
            $pdf = Pdf::loadView('rental.print.apartment', ['dataLoginUser' => $dataLoginUser, 'rents' => $rents, 'getCode' => $getCode, 'phayarn1' => $phayarn1, 'phayarn2' => $phayarn2, 'room_price'=> $room_price, 'price_insurance' => $price_insurance]);
            return $pdf->stream();
            // dd($request->status_approve);
        }
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

    public function rent(Request $request){
        // dd($result);
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        // $result = Room::select('rooms.*','projects.*')
        // ->join('projects', 'projects.pid', '=', 'rooms.pid')
        // ->where('rooms.id', '=', $request->id)
        // ->first();
        $result = Room::select(
            'projects.*',
            'rooms.*',
            'customers.*',
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
}
