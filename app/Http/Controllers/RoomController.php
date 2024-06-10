<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Models\Project;
use App\Models\Role_user;
use App\Models\Room;
use App\Models\Room_Images;
use App\Models\Tambon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class RoomController extends Controller
{
    public function index(){
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();

        $provinces = Tambon::select('province', 'province_id')->distinct()->get();
        $amphoes = Tambon::select('amphoe', 'amphoe_id')->distinct()->get();
        $tambons = Tambon::select('tambon', 'tambon_id')->distinct()->get();

        return view('rooms.index',compact(
            'dataLoginUser',
            'isRole',
            'projects',
            'provinces',
            'amphoes',
            'tambons'
        ));

    }

    public function store(StoreRoomRequest $request){

        $request->validated();

        $getLastId = DB::table('rooms')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->first();

        if ($getLastId) {
            $lastId = $getLastId->id + 1;
        } else {
            $lastId = 1;
        }

        if($request->owner_province && $request->owner_khet && $request->owner_district){
            $owner_province = Tambon::select('province')->distinct()->where('province_id',$request->owner_province)->first();
            $owner_khet = Tambon::select('amphoe')->distinct()->where('amphoe_id',$request->owner_khet)->first();
            $owner_district = Tambon::select('tambon')->distinct()->where('tambon_id',$request->owner_district)->first();
        }

        $room = new Room();
        $room->Create_Date = now();
        $room->pid = $request->project_id;
        $room->numberhome = $request->numberhome ?? NULL;
        $room->RoomNo = $request->RoomNo;
        $room->HomeNo = $request->HomeNo;
        $room->Owner = $request->onwername ?? NULL;
        $room->cardowner = $request->cardowner ?? NULL;
        $room->owner_soi = $request->owner_soi ?? NULL;
        $room->owner_road = $request->owner_road ?? NULL;
        $room->owner_district = $owner_district->tambon ?? NULL;
        $room->owner_khet = $owner_khet->amphoe ?? NULL;
        $room->owner_province = $owner_province->province ?? NULL;
        $room->Phone = $request->ownerphone ?? NULL;
        $room->Transfer_Date = $request->transfer_date ?? NULL;
        $room->RoomType = $request->room_type ?? NULL;
        $room->Size = $request->room_size ?? NULL;
        $room->Location = $request->Location ?? NULL;
        $room->Building = $request->Building ?? NULL;
        $room->Floor = $request->Floor ?? NULL;
        $room->Key_front = $request->room_key_front ?? NULL;
        $room->Key_bed = $request->room_key_bed ?? NULL;
        $room->Key_balcony = $request->room_key_balcony ?? NULL;
        $room->Key_mailbox = $request->room_key_mailbox ?? NULL;
        $room->KeyCard	 = $request->room_card ?? NULL;
        $room->KeyCard_P = $request->room_card_p ?? NULL;
        $room->KeyCard_B = $request->room_card_b ?? NULL;
        $room->KeyCard_C = $request->room_card_c ?? NULL;
        $room->Guarantee_Startdate = $request->gauranteestart ?? NULL;
        $room->Guarantee_Enddate = $request->gauranteeend ?? NULL;
        $room->Guarantee_Amount = $request->gauranteeamount ?? NULL;
        $room->Status_Room = $request->Status_Room ?? NULL;
        $room->Electric_Contract = $request->Electric_Contract ?? NULL;
        $room->Meter_Code = $request->Meter_Code ?? NULL;
        $room->rental_status = $request->rental_status ?? NULL;
        $room->price = $request->room_price ?? NULL;

        if ($request->hasFile('filUploadPersonID')) {
            $allowedfileExtension = ['jpg', 'jpeg','png','pdf'];
            $file = $request->file('filUploadPersonID');
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);
            if ($check) {
                $filename = 'Idcard' . $lastId . '_' . $request->project_id . '_' . $request->RoomNo . '.' . $extension;
                $file->move('uploads/image_id/', $filename);
                $room->file_id_path = $filename;
            }else {
                Alert::error('Error', 'Allowed types: jpg, jpeg, png','pdf');
                return redirect()->back(); 
            }
        }

        // รูปภาพปก
        if ($request->hasFile('filUploadMain')) {
            $allowedfileExtension = ['jpg', 'jpeg','png'];
            $file = $request->file('filUploadMain');
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);
            if ($check) {
                $filename = 'main_' . $lastId . '_' . $request->project_id . '_' . $request->RoomNo . '.' . $extension;
                $file->move('uploads/images_room/', $filename);
                $room->image = 'uploads/images_room/' . $filename;
            }else{
                Alert::error('Error', 'Allowed types: jpg, jpeg, png');
                return redirect()->back(); 
            }
        }

        // รูปภาพห้อง
        if ($request->hasFile('filUpload')) {
            $allowedfileExtension = ['jpg', 'jpeg', 'png'];
            $files = $request->file('filUpload');
            $isImage = Room_Images::where('rid', $lastId)->where('img_category', 'เช่าอยู่')->first();
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $file->getClientOriginalName();
                    $name =  $lastId . '_' . $request->project_id . '_' . $request->RoomNo . '_' . $key . '.' . $extension;
                    $file->move('uploads/images_room', $name);
                    $img_room[$key] = 'uploads/images_room/' . $lastId . '_' . $request->project_id . '_' . $request->RoomNo . '_' . $key . '.' . $extension;
                    if($isImage){
                        $isImage->img_path = $img_room[$key];
                        $isImage->img_category = 'เช่าอยู่';
                        $isImage->save();
                    }else{
                        $image = new Room_Images();
                        $image->rid = $lastId;
                        $image->img_path = $img_room[$key];
                        $image->img_category = 'เช่าอยู่';
                        $image->save();
                    }
                }else{
                    Alert::error('Error', 'Allowed types: jpg, jpeg, png');
                    return redirect()->back(); 
                }
            }
        }
        
        // $room->save();
        if ($room->save()) {
            Alert::success('Success', 'เพิ่มข้อมูลสำเร็จ');
            return redirect(route('rental'));
        }else {
            Alert::error('Error', 'เพิ่มข้อมูลไม่สำเร็จ !กรุณาลองอีกครั้ง');
            return redirect(route('room'));
        }   
    }
}
