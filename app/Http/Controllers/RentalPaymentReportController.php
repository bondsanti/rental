<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Role_user;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class RentalPaymentReportController extends Controller
{
    public function index(){
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        return view(
            'report_payment.index',
            compact(
                'dataLoginUser',
                'isRole'
            )


        );
    }

    public function search(Request $request){

        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        $countPayment = array();
        $monthly = $request->monthly;
        if($request->p && $request->np && $request->sp){
            $w = "จ่ายแล้ว','ยังไม่จ่าย','ห้องสวัสดิการ";
        }elseif($request->p && $request->np){
            $w = "จ่ายแล้ว','ยังไม่จ่าย";
        }elseif($request->p && $request->sp){
            $w = "จ่ายแล้ว','ห้องสวัสดิการ";
        }elseif($request->np && $request->sp){
            $w = "ยังไม่จ่าย','ห้องสวัสดิการ";
        }elseif($request->p && !$request->np && !$request->sp){
            $w = "จ่ายแล้ว";
        }elseif(!$request->p && $request->np && !$request->sp){
            $w = "ยังไม่จ่าย";
        }elseif(!$request->p && !$request->np && $request->sp){
            $w = "ห้องสวัสดิการ";
        }
        // $w = $request->p ? "จ่ายแล้ว" : "";
        // $w .= $request->np ? "ยังจ่าย" : "";
        // $w .= $request->sp ? "ห้องสวัสดิการ" : "";
        // dd($w);
        $results = DB::table('customers as c')
        ->select(
            'p.project_name',
            'c.Roomno',
            'r.HomeNo',
            'r.status_room',
            'c.cus_name',
            'c.Phone',
            'c.price',
            // 'c.Contract_Status',
            // 'c.Cancle_Date',
            // 'c.contract_startdate',
            // 'c.contract_enddate',
            // 'c.Phone',
            // 'c.pid',
            // 'c.rid',
            // 'pa. * ',
            // 'pa.id as room_id',
            DB::raw("CASE 
                        WHEN IFNULL(c.contract_startdate, '') = '' OR c.contract_startdate = '0000-00-00' AND r.status_room <> 'สวัสดิการ' THEN 'ไม่มีวันเซ็นต์สัญญา' 
                        WHEN r.status_room = 'สวัสดิการ' THEN 'ห้องสวัสดิการ' 
                        ELSE c.contract_startdate 
                    END AS STATUS"),
            DB::raw("CASE 
                        WHEN IFNULL(c.contract_startdate, '') = '' OR c.contract_startdate = '0000-00-00' AND r.status_room <>'สวัสดิการ' THEN 'ยังไม่จ่าย' 
                        WHEN r.status_room ='สวัสดิการ' THEN 'ห้องสวัสดิการ'
                        WHEN (
                            DATE_FORMAT(pa.due1_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date1, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due2_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date2, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due3_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date3, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due4_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date4, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due5_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date5, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due6_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date6, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due7_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date7, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due8_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date8, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due9_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date9, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due10_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date10, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due11_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date11, '') NOT IN ('', '0000-00-00')
                            OR DATE_FORMAT(pa.due12_Date, '%Y%m') = DATE_FORMAT('".$monthly."', '%Y%m') AND IFNULL(pa.Payment_Date12, '') NOT IN ('', '0000-00-00')
                        ) THEN 'จ่ายแล้ว' 
                        ELSE 'ยังไม่จ่าย' 
                    END AS paid"),
            DB::raw("CASE 
                        WHEN IFNULL( contract_startdate, '' ) = ''
                            OR contract_startdate = '0000-00-00'
                            THEN '-'
                            WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then Payment_Date1
                            WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then Payment_Date2
                            WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then Payment_Date3
                            WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then Payment_Date4
                            WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then Payment_Date5
                            WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then Payment_Date6
                            WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then Payment_Date7
                            WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then Payment_Date8
                            WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then Payment_Date9
                            WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then Payment_Date10
                            WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then Payment_Date11
                            WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then Payment_Date12
                        ELSE '-' end as date_paid"),
            DB::raw("CASE
                        WHEN IFNULL( contract_startdate, '' ) = ''
                        OR contract_startdate = '0000-00-00'
                        THEN '0'
                        WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then due1_amount
                        WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then due2_amount
                        WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then due3_amount
                        WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then due4_amount
                        WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then due5_amount
                        WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then due6_amount
                        WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then due7_amount
                        WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then due8_amount
                        WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then due9_amount
                        WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then due10_amount
                        WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then due11_amount
                        WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then due12_amount
                        else '0' end as total_paid"),
            DB::raw("CASE
                        WHEN IFNULL( contract_startdate, '' ) = ''
                        OR contract_startdate = '0000-00-00'
                        THEN '0'
                        WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then due1_Date
                        WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then due2_Date
                        WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then due3_Date
                        WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then due4_Date
                        WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then due5_Date
                        WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then due6_Date
                        WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then due7_Date
                        WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then due8_Date
                        WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then due9_Date
                        WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then due10_Date
                        WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then due11_Date
                        WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then due12_Date
                        else '0' end as due_dates"),
            DB::raw("CASE
                        WHEN IFNULL( contract_startdate, '' ) = ''
                        OR contract_startdate = '0000-00-00'
                        THEN '0'
                        WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then approve1_date
                        WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then approve2_date
                        WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then approve3_date
                        WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then approve4_date
                        WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then approve5_date
                        WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then approve6_date
                        WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then approve7_date
                        WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then approve8_date
                        WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then approve9_date
                        WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then approve10_date
                        WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then approve11_date
                        WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then approve12_date
                        else '0' end as  approve_dates"),
            // DB::raw("
            //     SUM(
            //         CASE WHEN Payment_Date1 IS NULL AND Due1_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date2 IS NULL AND Due2_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date3 IS NULL AND Due3_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date4 IS NULL AND Due4_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date5 IS NULL AND Due5_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date6 IS NULL AND Due6_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date7 IS NULL AND Due7_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date8 IS NULL AND Due8_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date9 IS NULL AND Due9_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date10 IS NULL AND Due10_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date11 IS NULL AND Due11_Date < '$monthly' THEN 1 ELSE 0 END +
            //         CASE WHEN Payment_Date12 IS NULL AND Due12_Date < '$monthly' THEN 1 ELSE 0 END
            //     ) AS countPayment
            // "),
            'c.price','c.Contract_Status','Cancle_Date', 'contract_startdate', 'contract_enddate','c.Phone', 'c.pid', 'c.rid', 'pa.*'         
            // Add similar CASE statements for other columns
        )
        // ->select(
        //     'p.project_name',
        // 'c.Roomno',
        // 'r.HomeNo',
        // 'r.status_room',
        // 'c.cus_name',
        // 'c.Phone',
        // 'c.price','c.Contract_Status','Cancle_Date', 'contract_startdate', 'contract_enddate','c.Phone', 'c.pid', 'c.rid', 'pa.*')
        ->join('projects as p', 'p.pid', '=', 'c.pid')
        ->join('payments as pa', 'pa.cid', '=', 'c.id')
        ->join('rooms as r', 'r.id', '=', 'c.rid')
        ->whereRaw("DATE_FORMAT('2024-05-14', '%Y%m%d') BETWEEN DATE_FORMAT(c.contract_startdate, '%Y%m%d') AND DATE_FORMAT(c.contract_enddate, '%Y%m%d')
                            and CASE WHEN IFNULL( contract_startdate, '' ) = '' 
                    OR contract_startdate = '0000-00-00' and r.status_room <>'สวัสดิการ' THEN 'ยังไม่จ่าย'
                    when r.status_room ='สวัสดิการ' then 'ห้องสวัสดิการ'
                    WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due2_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '".$monthly."', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00'))
                    or (
                    DATE_FORMAT( due1_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due2_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due3_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due4_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due5_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due6_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due7_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due8_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due9_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due10_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due11_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    and DATE_FORMAT( due12_Date, '%Y%m') <> DATE_FORMAT( '".$monthly."', '%Y%m')
                    )
                    then 'จ่ายแล้ว'
                    else 'ยังไม่จ่าย' end in ( '".$w."') 
        ")
        ->where(function ($query) {
            $query->whereRaw("IFNULL(c.contract_startdate, '') = '' OR c.contract_startdate = '0000-00-00' AND r.status_room <> 'สวัสดิการ'")
                ->orWhere('r.status_room', '=', 'สวัสดิการ')
                ->orWhere(function ($query) {
                    $query->whereIn('c.Contract_Status', ['เช่าอยู่', 'ต่อสัญญา'])
                        ->orWhere(function ($query) {
                            $query->whereIn('c.Contract_Status', ['ออก', 'ยกเลิกสัญญา'])
                                ->whereRaw("DATE_FORMAT(c.Cancle_Date, '%Y%m') >= DATE_FORMAT('2024-05-14', '%Y%m')");
                        });
                });
        })
        ->where('c.contract_startdate', '<=', '2024-05-14')
        ->whereNotIn(DB::raw("IFNULL(r.Trans_status, '')"), ['del'])
        ->orderBy('p.project_name')
        ->orderBy('c.Roomno')
        ->get();

        foreach ($results as $key => $item) {
            if ($item->paid == 'ยังไม่จ่าย' && ($item->STATUS < $monthly)) {
                $countPayment[$key] = $this->countNumMonth($item->STATUS, $monthly, $item->cid, $item->rid);
            }else{
                $countPayment[$key] = 0;
            }
        }
        // dump($countPayment);

        // dd($results);

        return view('report_payment.search', compact(
            'results',
            'dataLoginUser',
            'isRole',
            'countPayment',
            'monthly'
        ));

    }

    public function countNumMonth($startDate, $dates, $cids, $rids)
    {
        $countPayment = DB::table('payments')
            ->selectRaw('
                SUM(
                    CASE WHEN Payment_Date1 IS NULL AND Due1_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date2 IS NULL AND Due2_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date3 IS NULL AND Due3_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date4 IS NULL AND Due4_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date5 IS NULL AND Due5_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date6 IS NULL AND Due6_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date7 IS NULL AND Due7_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date8 IS NULL AND Due8_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date9 IS NULL AND Due9_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date10 IS NULL AND Due10_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date11 IS NULL AND Due11_Date < ? THEN 1 ELSE 0 END +
                    CASE WHEN Payment_Date12 IS NULL AND Due12_Date < ? THEN 1 ELSE 0 END
                ) AS countPayment', [$dates, $dates, $dates, $dates, $dates, $dates, $dates, $dates, $dates, $dates, $dates, $dates])
            ->where('cid', $cids)
            ->where('rid', $rids)
            ->first()->countPayment;
            
        // dd($countPayment);

        // $countPayment = $payments->count();

        $st = explode('-', $startDate);
        if ($countPayment == 0 && date('d') < $st[2]) {
            $rowNumAns = '-';
        } elseif ($countPayment == 0) {
            $rowNumAns = 'ยังไม่จ่าย';
        } else {
            $rowNumAns = 'ยังไม่จ่าย (' . $countPayment . ')';
        }

        return $rowNumAns;
    }

    public function download(Request $request, $rid, $cid, $date){
        // dd($rid, $cid, $date);

        $monthY = thaidate('F Y', $date);
        // dd($monthY);
        $Payment = explode('-', $date);
        $year = $Payment[0]+543;
        $Payment_Dates = $Payment[2].' / '.$Payment[1].' / '.$year;
        $rent = DB::table('customers')
            ->select('customers.Cus_Name', 'customers.Contract_Status', 'customers.pid', 'customers.rid', 'rooms.HomeNo', 'rooms.RoomNo', 'projects.Project_Name', 'projects.address_full')
            ->leftJoin('rooms', 'customers.rid', '=', 'rooms.id')
            ->leftJoin('projects', 'customers.pid', '=', 'projects.pid')
            ->where('customers.rid', $rid)
            ->where('customers.Contract_Status', 'เช่าอยู่')
            ->get();


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
                ->where('rooms.id', $rid)
                // ->where('rooms.id', $request->id)
                ->first();


            $pdf = Pdf::loadView('report_payment.print', ['result' => $result, 'monthY' => $monthY]);
            // return $pdf->download('invoice.pdf');
            return $pdf->stream();
        // dd($result);
    }
}
