<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Models\Project;
use App\Models\Role_user;
use App\Models\Room;
use App\Models\Room_Images;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RoomController extends Controller
{
    public function index(){
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();


        // dd($projects);
            
        return view('rooms.index',compact(
            'dataLoginUser',
            'isRole',
            'projects'
        ));

    }

    public function store(StoreRoomRequest $request){

        // $validator = Validator::make($request->all(), [
        //     'project_id' => 'required',
        //     'room_type' => 'required',
        //     'Floor' => 'required',
        //     'Building' => 'required',
        //     'room_address' => 'required',
        //     'address' => 'required',
        //     'Location' => 'required',
        //     'room_price' => 'required',
        //     'room_size' => 'required',

        // ], [
        //     'project_id.required' => 'เลือก โครงการ',
        //     'room_type.required' => 'เลือก Type',
        //     'Floor.required' => 'กรอก ชั้น',
        //     'Building.required' => 'กรอก ตึก',
        //     'room_address.required' => 'กรอก ห้องเลขที่',
        //     'address.required' => 'กรอก บ้านเลขที่',
        //     'Location.required' => 'กรอก ทิศ/ฝั่ง',
        //     'room_price.required' => 'กรอก ราคาห้อง',
        //     'room_size.required' => 'กรอก ขนาด',
        // ]);

        // if($validator->fails()){
        //     return response()->json(['error' => $validator->errors()]);
        // }else{
            $request->validated();

            $room = new Room();
            
            $room->Create_Date = now();
            $room->pid = $request->project_id;
            $room->numberhome = $request->numberhome ?? NULL;
            $room->RoomNo = $request->RoomNo;
            $room->HomeNo = $request->HomeNo;
            $room->Owner = $request->onwername ?? NULL;
            $room->cardowner = $request->cardowner ?? NULL;
            // $room->filUploadPersonID = $request->filUploadPersonID;
            $room->owner_soi = $request->owner_soi ?? NULL;
            $room->owner_road = $request->owner_road ?? NULL;
            $room->owner_district = $request->owner_district ?? NULL;
            $room->owner_khet = $request->owner_khet ?? NULL;
            $room->owner_province = $request->owner_province ?? NULL;
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
            // $room->filUploadMain = $request->filUploadMain; // รูปภาพปก
            // $room->filUpload = $request->filUpload; // รูปภาพห้อง
        
            // $room->save();
            if ($room->save()) { 
                $lastId = $room->id;
                $updateRoom = Room::where('id', $lastId)->first();
                 // อัปโหลดไฟล์บัตรประชาชน
                if ($request->hasFile('filUploadPersonID') && $updateRoom) {
                    $file = $request->file('filUploadPersonID');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'Idcard' . $lastId . '_' . $request->project_id . '_' . $request->RoomNo . '.' . $extension;
                    $file->move('uploads/image_id/', $filename);
                    $updateRoom->file_id_path = $filename;
                }
                // รูปภาพปก
                if ($request->hasFile('filUploadMain') && $updateRoom) {
                    $URL = request()->getHttpHost();
                    $file = $request->file('filUploadMain');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'main_' . $lastId . '_' . $request->project_id . '_' . $request->RoomNo . '.' . $extension;
                    $file->move('uploads/images_room/', $filename);
                    $updateRoom->image = $URL . '/uploads/images_room/' . $filename;
                }
                // รูปภาพห้อง
                if ($request->hasFile('filUpload')) {
                    $URL = request()->getHttpHost();
                    $allowedfileExtension = ['jpg', 'png'];
                    $files = $request->file('filUpload');
                    $isImage = NULL;
                    $isImage = Room_Images::where('rid', $lastId)->where('img_category', 'เช่าอยู่')->first();
                    foreach ($files as $key => $file) {
                        $extension = $file->getClientOriginalExtension();
                        $check = in_array($extension, $allowedfileExtension);
                        if ($check) {
                            $filename = $file->getClientOriginalName();
                            $file->move('uploads/images_room', $filename);
                            $img_room[$key] =  $URL . '/uploads/images_room/' . $lastId . '_' . $request->project_id . '_' . $request->RoomNo . '_' . $key . '.' . $extension;
                            if($isImage){
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
                    }
                }

                if ($updateRoom) {
                    $updateRoom->save();
                }
            }


            // dd($request->all());
            // return response()->json([
            //     'message' => 'เพิ่มข้อมูลสำเร็จ'
            // ], 201);
            // return redirect()->back();
            Alert::success('Success', 'เพิ่มข้อมูลสำเร็จ');
            return redirect(route('room'));

        // }
        
    }
}
