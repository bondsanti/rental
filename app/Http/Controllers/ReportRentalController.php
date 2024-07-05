<?php

namespace App\Http\Controllers;

use App\Models\Rental_Report;
use App\Models\Role_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportRentalController extends Controller
{
    public function index(){
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        return view(
            'report_rental.index',
            compact(
                'dataLoginUser',
                'isRole',
            )
        );
    }

    public function search(Request $request){
        // dd($request->monthly);
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $reports = Rental_Report::where('rental_months', $request->monthly)->get();

        if ($request->monthly == '1') {
            $monthY = 'มกราคม';
        }elseif ($request->monthly == '2') {
            $monthY = 'กุมภาพันธ์';
        }elseif ($request->monthly == '3') {
            $monthY = 'มีนาคม';
        }elseif ($request->monthly == '4') {
            $monthY = 'เมษายน';
        }elseif ($request->monthly == '5') {
            $monthY = 'พฤษภาคม';
        }elseif ($request->monthly == '6') {
            $monthY = 'มิถุนายน';
        }elseif ($request->monthly == '7') {
            $monthY = 'กรกฎาคม';
        }elseif ($request->monthly == '8') {
            $monthY = 'สิงหาคม';
        }elseif ($request->monthly == '9') {
            $monthY = 'กันยายน';
        }elseif ($request->monthly == '10') {
            $monthY = 'ตุลาคม';
        }elseif ($request->monthly == '11') {
            $monthY = 'พฤศจิกายน';
        }else{
            $monthY = 'ธันวาคม';
        }

        // dd($monthY);

        return view(
            'report_rental.search',
            compact(
                'dataLoginUser',
                'isRole',
                'monthY',
                'reports'
            )
        );
    }
}
