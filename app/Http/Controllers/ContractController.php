<?php

namespace App\Http\Controllers;

use App\Models\Role_user;
use App\Models\User;
use App\Models\Lease_auto_code;
use App\Models\Lease_code;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ContractController extends Controller
{
    public function index()
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $Lease_code = DB::table('Lease_codes')
            ->join('projects', 'Lease_codes.pid', '=', 'projects.pid')
            ->select('Lease_codes.*', 'projects.Project_Name', 'projects.rent')
            ->where('rent', '=', 1)
            ->orderBy('projects.Project_Name', 'ASC')
            ->get();


        return view(
            'contract.index',
            compact(
                'dataLoginUser',
                'isRole',
                'Lease_code'
            )
        );
    }
    public function update(Request $request)
    {
        $update_lcode = Lease_code::where('lease_code_id', $request->lease_code_id)->first();
        $update_lcode->lease_agr_code       = $request->lease_agr_code;
        $update_lcode->sub_lease_code       = $request->sub_lease_code;
        $update_lcode->insurance_code       = $request->insurance_code;
        $update_lcode->agent_contract_code  = $request->agent_contract_code;
        $updated = $update_lcode->save(); // บันทึกข้อมูลและเก็บผลลัพธ์การบันทึกไว้

        // ตรวจสอบว่าการอัพเดทเสร็จสมบูรณ์หรือไม่
        if ($updated) {
            // ถ้าเสร็จสมบูรณ์ ใช้ JavaScript เพื่อแสดง Alert ว่าอัพเดทสำเร็จ
            echo '<script>alert("อัพเดทข้อมูลสำเร็จ!");</script>';
        } else {
            // ถ้าไม่เสร็จสมบูรณ์ ใช้ JavaScript เพื่อแสดง Alert ว่ามีปัญหาเกิดขึ้น
            echo '<script>alert("มีบางอย่างผิดพลาด ไม่สามารถอัพเดทข้อมูลได้");</script>';
        }

        // หลังจากนั้นให้กลับไปยังหน้าเดิม
        return redirect()->back();
    }

    public function out_index()
    {
        $dataLoginUser  = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole         = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects       = DB::table('projects')
            ->where('rent', '=', 1)
            ->orderBy('projects.Project_Name')
            ->get();

        return view(
            'contract.out_contract.out_index',
            compact(
                'dataLoginUser',
                'isRole',
                'projects'
            )
        );
    }

    public function out_update(Request $request)
    {
        $update_out = Project::where('pid', $request->pid)->first();
        $update_out->Project_NameTH = $request->Project_NameTH;
        $update_out->address_full   = $request->address_full;
        $upout = $update_out->save(); // บันทึกข้อมูลและเก็บผลลัพธ์การบันทึกไว้

        //ตรวจสอบว่าการอัพเดทเสร็จสมบูรณ์หรือไม่
        if ($upout) {
            // ถ้าเสร็จสมบูรณ์ ใช้ JavaScript เพื่อแสดง Alert ว่าอัพเดทสำเร็จ
            echo '<script>alert("อัพเดทข้อมูลสำเร็จ!");</script>';
        } else {
            // ถ้าไม่เสร็จสมบูรณ์ ใช้ JavaScript เพื่อแสดง Alert ว่ามีปัญหาเกิดขึ้น
            echo '<script>alert("มีบางอย่างผิดพลาด ไม่สามารถอัพเดทข้อมูลได้");</script>';
        }
        return redirect()->back();
    }

    public function room_con()
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = DB::connection('mysql_report')
            ->table('project')
            ->where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();


        return view(
            'contract.room_con.roomcon',
            compact(
                'dataLoginUser',
                'isRole',
                'projects'
            )
        );
    }
    public function search(Request $request)
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();
        // $currentYear = Carbon::now()->year;
        // $results = DB::table('customers as c')
        //     ->leftJoin('rooms as r', 'c.rid', '=', 'r.id')
        //     ->join('projects as p', 'r.pid', '=', 'p.pid')
        //     ->select(
        //         'r.price as txtprice',
        //         'c.price as txtcusprice',
        //         'c.id AS cus_id',
        //         'r.Building AS Buile',
        //         'r.Floor AS layers',
        //         'r.*',
        //         'p.*',
        //         'c.*',
        //         'r.RoomNo AS RoomNo1',
        //         'r.Size AS Size1',
        //         'r.id AS id1',
        //         'c.id AS id2',
        //         'r.phone AS phone1',
        //         'c.phone AS phone2'
        //     )
        //     ->where('c.Contract_Startdate')
        //     ->orderBy('p.Project_Name')
        //     ->orderBy('r.RoomNo')
        //     ->get();


        //dd($results);
        return view(
            'contract.room_con.room_search',
            compact(
                'dataLoginUser',
                'isRole',
                'projects',
            )
        );
    }

    public function list_contracct()
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = DB::connection('mysql_report')
            ->table('project')
            ->where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();




        return view(
            'contract.list_contract.list_lease_code',
            compact(
                'dataLoginUser',
                'isRole',
                'projects'
            )
        );
    }

    public function list_search(Request $request)
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();

        $year = request()->input('year') - 543;
        $pid = request()->input('pid');

        $query = Lease_auto_code::query()
            ->leftJoin('customers', 'lease_auto_code.ref_cus_id', '=', 'customers.id')
            ->leftJoin('rooms', 'lease_auto_code.ref_rental_room_id', '=', 'rooms.id')
            ->leftJoin('projects', 'rooms.pid', '=', 'projects.pid');

        // เพิ่มเงื่อนไขเพื่อตรวจสอบว่า $pid เป็น 'ทั้งหมด' หรือไม่
        if ($pid == 'all') {
            // เพิ่มเงื่อนไขในการค้นหาตามปี
            $query->whereYear('lease_auto_code.create_at', $year);
        } else {
            // ถ้าไม่ใช่ 'ทั้งหมด' ให้เพิ่มเงื่อนไขในการค้นหาตาม $pid
            $query->where('projects.pid', $pid)->where('lease_auto_code.create_at', $year);
        }


        $selectedPid = request('pid');
        $selectedYear = request('year');

        $results = $query->orderByDesc('lease_auto_code.id')->get();


        //dd($query);
        return view(
            'contract.list_contract.list_search',
            compact(
                'dataLoginUser',
                'isRole',
                'projects',
                'results',
                'selectedYear',
                'selectedPid'

            )
        );
    }
}
