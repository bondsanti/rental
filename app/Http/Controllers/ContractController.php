<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Role_user;
use App\Models\User;
use App\Models\Lease_auto_code;
use App\Models\Lease_code;
use App\Models\Log;
use App\Models\Project;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class ContractController extends Controller
{
    public function index()
    {
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
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
        dd($request->all());
        if ($request->lease_agr_code == '' || $request->sub_lease_code == '' || $request->insurance_code == '' || $request->agent_contract_code == '') {
            Alert::error('Error', 'มีบางอย่างผิดพลาด กรุณาลองใหม่อีกครั้ง');
            return redirect()->back();
        }
        $update_lcode = Lease_code::where('lease_code_id', $request->lease_code_id)->first();
        $update_lcode->lease_agr_code       = $request->lease_agr_code;
        $update_lcode->sub_lease_code       = $request->sub_lease_code;
        $update_lcode->insurance_code       = $request->insurance_code;
        $update_lcode->agent_contract_code  = $request->agent_contract_code;
        $updated = $update_lcode->save(); // บันทึกข้อมูลและเก็บผลลัพธ์การบันทึกไว้

        $projects = DB::table('projects')
                ->select('Project_Name')
                ->where('pid', $request->pid)
                ->first();
        // ตรวจสอบว่าการอัพเดทเสร็จสมบูรณ์หรือไม่
        if ($updated) {
            Log::addLog($request->session()->get('loginId'), 'แก้ไขรูปแบบเลขที่สัญญาเช่า', 'โครงการ ' .$projects->Project_Name);
            Alert::success('Success', 'บันทึกข้อมูลสำเร็จ!');
            return redirect()->back();
        } else {
            Alert::error('Error', 'มีบางอย่างผิดพลาด ไม่สามารถอัพเดทข้อมูลได้');
            return redirect()->back();
        }

    }

    public function out_index()
    {
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
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
        if ($request->Project_NameTH == '' || $request->address_full == '') {
            Alert::error('Error', 'มีบางอย่างผิดพลาด กรุณาลองใหม่อีกครั้ง');
            return redirect()->back();
        }
        $update_out = Project::where('pid', $request->pid)->first();
        $update_out->Project_NameTH = $request->Project_NameTH;
        $update_out->address_full   = $request->address_full;
        $upout = $update_out->save(); // บันทึกข้อมูลและเก็บผลลัพธ์การบันทึกไว้

        //ตรวจสอบว่าการอัพเดทเสร็จสมบูรณ์หรือไม่
        if ($upout) {
            Log::addLog($request->session()->get('loginId'), 'แก้ไขรายละเอียดโครงการ', $request->Project_NameTH);
            Alert::success('Success', 'อัพเดทข้อมูลสำเร็จ!');
        } else {
            Alert::error('Error', 'มีบางอย่างผิดพลาด ไม่สามารถอัพเดทข้อมูลได้');
        }
        return redirect()->back();
    }

    public function room_con()
    {
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        ///ssssss
        dd($isRole);
        $projects = Project::where('rent', 1)
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
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();

        $startdate = $request->startdate;
        $enddate = $request->enddate;
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
            'rooms.price as room_price',
            'rooms.Trans_Status',
            'rooms.contract_owner',
            'rooms.Owner',
            'rooms.Guarantee_Startdate',
            'rooms.Guarantee_Enddate',
            'rooms.date_firstrend',
            'rooms.date_endrend',
            'rooms.Electric_Contract',
            'rooms.Meter_Code',
            'rooms.Transfer_Date',
            'rooms.Other',
            'rooms.public',
            'customers.id as cid',
            'customers.Contract_Status',
            'customers.Contract_Startdate',
            'customers.Contract_Enddate',
            'customers.Cus_Name',
            'customers.Phone as Cus_phone',
            'customers.Price as Cus_price'

        )
        ->from('rooms as rooms')
        ->join('projects', 'rooms.pid', '=', 'projects.pid')
        ->leftJoin('customers','rooms.id','=','customers.rid');

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

        if ($request->Customer) {
            $rents->where('customers.Cus_Name', 'LIKE', '%' . $request->Customer . '%');
        }

        if ($request->dateselect && $request->startdate) {
            if ($request->dateselect == "Contract_Startdate") {
                if ($request->enddate != null) {
                    $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->startdate]);
                }
            }
        }

        $rentsCount = $rents->count();


        $rents = $rents
            ->orderBy('Project_Name', 'asc')
            ->orderBy('RoomNo', 'asc')
            ->get();

        $formInputs = $request->all();

        return view(
            'contract.room_con.room_search',
            compact(
                'dataLoginUser',
                'isRole',
                'projects',
                'rents',
                'rentsCount',
                'startdate',
                'enddate',
                'formInputs'
            )
        );
    }

    public function list_contracct()
    {
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
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
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
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
