<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Role_user;
use App\Models\Log;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use Session;

class CustomAuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function loginUser(Request $request)
    {

        $request->validate([
            'code' => 'required',
            'password' => 'required'
        ], [
            'code.required' => 'ป้อนรหัสพนักงาน',
            'password.required' => 'ป้อนรหัสผ่าน'
        ]);


        $user_hr = User::where('code', $request->code)->orWhere('old_code', $request->code)->where('active', 1)->first();
        //dd($user_hr);

        if (!$user_hr) {
            Alert::error('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        } else {

            if ($user_hr->active != 0 or $user_hr->resign_date == null) {

                $role_user = Role_user::where('user_id', $user_hr->user_id)->orwhere('active', 1)->first();
                //dd($role_user);
                if (!$role_user) {

                    Alert::warning('คุณไม่มีสิทธิ์เข้าระบบ', 'กรุณาติดต่อ Admin!!');
                    return back();
                } else {

                    if (Hash::check($request->password, $user_hr->password)) {

                        if ($user_hr->is_auth == 0) {

                            $request->session()->put('dataIsAuth', $user_hr);
                            Alert::info('กรุณาเปลี่ยนรหัสผ่าน');
                            return redirect('/change-password');
                        }

                        $request->session()->put('loginId', $user_hr->user_id);
                        $request->session()->put('code', $user_hr->code);

                        DB::table('vbeyond_report.log_login')->insert([
                            'username' => $user_hr->code,
                            'dates' => date('Y-m-d'),
                            'timeStm' => date('Y-m-d H:i:s'),
                            'page' => 'rantal'
                        ]);

                        Log::addLog($request->session()->get('loginId'), 'Login', 'Login');


                        Alert::success('เข้าสู่ระบบสำเร็จ');
                        return redirect('/');
                    } else {

                        Alert::warning('รหัสผ่านไม่ถูกต้อง', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                        return back();
                    }


                    Alert::warning('รหัสผ่านไม่ถูกต้อง', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                    return back();
                }
            } else {
                Alert::error('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                return back();
            }
        }
    }

    public function logoutUser(Request $request)
    {
        // dd($request->session()->has('loginId'));

        if ($request->session()->has('loginId')) {

            Log::addLog($request->session()->get('loginId'), 'Logout', 'Logout');

            $request->session()->pull('loginId');
            Alert::success('ออกจากระบบเรียบร้อย', 'ไว้พบกันใหม่ :)');

            return redirect('login');
        }
    }

    public function AllowLoginConnect(Request $request, $id, $token)
    {

        $user = User::where('user_id', '=', $id)->first();
       // dd($user);
        if ($user) {
            $request->session()->put('loginId', $user->user_id);
            // Auth::login($user);
            // $user->last_login_at = date('Y-m-d H:i:s');
            // $user->save();
            $checkToken = User::where('token', '=', $token)->first();

            if ($checkToken) {
                DB::table('vbeyond_report.log_login')->insert([
                    'username' => $user->code,
                    'dates' => date('Y-m-d'),
                    'timeStm' => date('Y-m-d H:i:s'),
                    'page' => 'rantal'
                ]);

                Log::addLog($request->session()->get('loginId'), 'Login', 'Login AllowLoginConnect By vBisConnect');
                return redirect('/');
            } else {
                $request->session()->pull('loginId');
                return redirect('/');
            }
        } else if ($user->active == 0) {
            $request->session()->pull('loginId');
            return redirect('/');
        } else {
            return redirect('/');
        }
    }

    public function changePassword()
    {
        return view('auth.password');
    }

    public function updatePassword(Request $request)
    {
        $user = User::where('id', Session::get('dataIsAuth')->id)->first();
        // dd(Session::get('dataIsAuth')->id);
        $request->validate([
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/', //one lowercase letter
                'regex:/[A-Z]/', //one uppercase letter
                'regex:/[0-9]/', //one least one digit
                'regex:/[@$!%*#?&]/', //one least one character
            ],

            'cfpassword' => ['required', 'same:password']

        ], [
            'password.required' => 'ป้อนรหัสผ่านใหม่',
            'cfpassword.same' => 'รหัสผ่านไม่ตรงกัน',
            'password.min' => 'รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร',
            'password.regex' => 'รหัสผ่านอย่างน้อยต้องมี ตัวพิมพ์เล็ก 1 ตัว,ตัวพิมพ์ใหญ่ 1 ตัว,ตัวเลข 1 ตัว และอักษรพิเศษ 1 ตัว',
            'cfpassword.required' => 'ป้อนยืนยันรหัสผ่านใหม่',

        ]);

        if (Hash::check($request->password, $user->password)) {
            Alert::warning('รหัสผ่านซ้ำกับรหัสเดิม', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        } else {
            $user->old_password = $user->password;
            $user->password = Hash::make($request->password);
            $user->is_auth = "1";
            $user->save();

            $user->refresh();

            $request->session()->put('loginId', $user->id);

            DB::table('vbeyond_report.log_login')->insert([
                'username' => $user->code,
                'dates' => date('Y-m-d'),
                'timeStm' => date('Y-m-d H:i:s'),
                'page' => 'Rantal'
            ]);
            Log::addLog($request->session()->get('loginId'), 'Update', 'Change Password');
            Log::addLog($request->session()->get('loginId'), 'Login', 'Login');


            Alert::success('เข้าสู่ระบบสำเร็จ!');
            return redirect('/');
        }
    }
}
