<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Log;
use App\Models\Role_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        // $users = Role_user::with('role:id,code,name_th,active,department_id')->orderBy('id', 'desc')->get();

        foreach ($users as $key => $value) {
            $deparment[$key] = Department::select('name')->where('id',$value->role->department_id)->first();
        }
        if ($isRole->role_type=="SuperAdmin") {
            return view('users.index', compact(
                'dataLoginUser',
                'users',
                'isRole',
                'deparment'
            ));
        }else{
            return redirect()->back();
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ], [
            'code.required' => 'กรอก Code',
        ]);

        if ($validator->passes()) {

            $userFound = User::where('code', $request->code)->where('active',1)->count();
            if($userFound===0){
                return response()->json([
                    'message' => 'รหัสผิด / ไม่พบผู้ใช้งาน / ลาออก'
                ],400);
            }
            $users = User::where('code',$request->code)->where('active',1)->first();
            $exitUsers = Role_user::where('user_id',$users->id)->first();
            if($exitUsers){
                return response()->json([
                    'message' => 'มีผู้ใช้ท่านนี้อยู่ในระบบแล้ว'
                ],400);
            }

            $roleUser = new Role_user();
            $roleUser->user_id = $users->id;
            // $roleUser->role_id = $users->position_id;
            $roleUser->role_type = $request->role_type;
            $roleUser->active = 1;
            $roleUser->save();


            $roleUser->refresh();

            Log::addLog($request->session()->get('loginId'), 'Add Role', 'RoleUser : '. $roleUser);

            return response()->json([
                'message' => 'เพิ่มข้อมูลสำเร็จ'
            ],201);

        }

        return response()->json(['error'=>$validator->errors()]);
    }


    public function edit(Request $request,$id)
    {

        $users = Role_user::with('role:id,code,name_th,active','position:id,name')->where('id', $id)->first();

        return response()->json($users, 200);
    }

    public function update(Request $request,$id)
    {

        $roleUser = Role_user::where('id', $id)->first();
        $roleUser_old = $roleUser->toArray();

        $roleUser->role_type = $request->role_type_edit;

        $roleUser->save();

       Log::addLog($request->user_id,json_encode($roleUser_old), 'Update RoleUser : '.$roleUser);

        return response()->json([
            'message' => 'อัพเดทข้อมูลสำเร็จ'
        ], 201);

    }

    public function destroy($id,$user_id)
    {

        $roleUser = Role_user::where('id', $id)->first();

        $roleUser_old = $roleUser->toArray();

        Log::addLog($user_id,json_encode($roleUser_old), 'Delete RoleUser : '.$roleUser);
        $roleUser->delete($id);

        return response()->json([
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 201);

    }
}
