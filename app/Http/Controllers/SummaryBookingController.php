<?php

namespace App\Http\Controllers;

use App\Models\Role_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SummaryBookingController extends Controller
{
    public function index(){
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();


        return view(
            'summary.index',
            compact(
                'dataLoginUser',
                'isRole',
            )
        );
    }

    public function search(Request $request){
        $monthly = $request->monthly;
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $where = "DATE_FORMAT('{$request->monthly}', '%Y%m') = DATE_FORMAT(contract_startdate, '%Y%m')";
        $results = DB::table('customers')
            ->select('projects.Project_Name', DB::raw('COUNT(*) AS amtroom'), DB::raw('SUM(Deposit) AS deposit1'), DB::raw('SUM(Bail) AS bail1'))
            ->join('projects', 'customers.pid', '=', 'projects.pid')
            ->join('payments', 'customers.id', '=', 'payments.cid')
            ->where('customers.Contract_Status', 'เช่าอยู่')
            ->whereRaw($where)
            ->groupBy('projects.Project_Name')
            ->get();

        return view(
            'summary.search',
            compact(
                'dataLoginUser',
                'isRole',
                'monthly',
                'results',
            )
        );
    }
}
