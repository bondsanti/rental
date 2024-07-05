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
use Illuminate\Support\Carbon;

class RentalPaymentReportController extends Controller
{
    public function index(){
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
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

        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $countPayment = array();
        $monthly = $request->monthly;
        $invoiceDate = $request->invoiceDate;
        $p = $request->p ?? '';
        $np = $request->np ?? '';
        $sp = $request->sp ?? '';
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

        $results = DB::table('customers as c')
        ->select(
            'p.project_name',
            'c.Roomno',
            'r.HomeNo',
            'r.status_room',
            'c.cus_name',
            'c.Phone',
            'c.price',
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
            'c.price','c.Contract_Status','Cancle_Date', 'contract_startdate', 'contract_enddate','c.Phone', 'c.pid', 'c.rid', 'pa.*'
            // Add similar CASE statements for other columns
        )
        ->join('projects as p', 'p.pid', '=', 'c.pid')
        ->join('payments as pa', 'pa.cid', '=', 'c.id')
        ->join('rooms as r', 'r.id', '=', 'c.rid')
        ->whereRaw("DATE_FORMAT('".$monthly."', '%Y%m%d') BETWEEN DATE_FORMAT(c.contract_startdate, '%Y%m%d') AND DATE_FORMAT(c.contract_enddate, '%Y%m%d')
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
        ->where(function ($query) use($monthly){
            $query->whereRaw("IFNULL(c.contract_startdate, '') = '' OR c.contract_startdate = '0000-00-00' AND r.status_room <> 'สวัสดิการ'")
                ->orWhere('r.status_room', '=', 'สวัสดิการ')
                ->orWhere(function ($query) use($monthly) {
                    $query->whereIn('c.Contract_Status', ['เช่าอยู่', 'ต่อสัญญา'])
                        ->orWhere(function ($query) use($monthly){
                            $query->whereIn('c.Contract_Status', ['ออก', 'ยกเลิกสัญญา'])
                                ->whereRaw("DATE_FORMAT(c.Cancle_Date, '%Y%m') >= DATE_FORMAT('".$monthly."', '%Y%m')");
                        });
                });
        })
        ->where('c.contract_startdate', '<=', $monthly)
        ->whereNotIn(DB::raw("IFNULL(r.Trans_status, '')"), ['del'])
        ->orderBy('p.project_name')
        ->orderBy('c.Roomno')
        ->get();

        foreach ($results as $key => $item) {
            if ($item->paid == 'ยังไม่จ่าย' && ($item->STATUS < $monthly)) {
                $countPayment[$key] = $this->countNumMonth($item->STATUS, $monthly, $item->cid, $item->rid);
            }else if($item->paid == 'ยังไม่จ่าย' && ($item->STATUS >= $monthly)){
                $countPayment[$key] = 'ยังไม่จ่าย';
            }else{
                $countPayment[$key] = 'จ่ายแล้ว';
            }
        }

        return view('report_payment.search', compact(
            'results',
            'dataLoginUser',
            'isRole',
            'countPayment',
            'monthly',
            'invoiceDate',
            'p',
            'np',
            'sp'
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

        $st = explode('-', $startDate);
        if ($countPayment == '0' && date('d') < $st[2]) {
            $rowNumAns = '-';
        } elseif ($countPayment == '0') {
            $rowNumAns = 'ยังไม่จ่าย';
        } else {
            $rowNumAns = 'ยังไม่จ่าย (' . $countPayment . ')';
        }

        return $rowNumAns;
    }

    public function download($rid, $cid, $date, $status){

        $monthY = thaidate('F Y', $date);
        $current_date = Carbon::now()->format('Y-m-d');
        $print_date = Carbon::now()->format('d-m-Y');
        $DateChk = explode('-', $current_date);
        $date_check = $DateChk[0].'-'.$DateChk[1].'-01';
        $Payment = explode('-', $date);
        $year = $Payment[0]+543;
        $Payment_Dates = $Payment[2].' / '.$Payment[1].' / '.$year;
        $rent = DB::table('customers')
            ->select('customers.Cus_Name', 'customers.Contract_Status', 'customers.price','customers.pid', 'customers.rid', 'rooms.HomeNo', 'rooms.RoomNo', 'projects.Project_Name', 'projects.address_full')
            ->leftJoin('rooms', 'customers.rid', '=', 'rooms.id')
            ->leftJoin('projects', 'customers.pid', '=', 'projects.pid')
            ->where('customers.rid', $rid)
            ->where('customers.Contract_Status', 'เช่าอยู่')
            ->get();

        foreach ($rent as $item) {
            $Cus_Name = $item->Cus_Name;
            $price = $item->price;
        }

        if ($status == 'ยังไม่จ่าย') {
            $invoce = DB::table('list_invoice')
            ->where('rid', $rid)
            ->where('cid', $cid)
            ->where('payment_date', $date)
            ->first();

            $invoceLimit = DB::table('list_invoice')
                ->where('date_check', $date_check)
                ->orderBy('id', 'DESC')
                ->limit(1)
                ->get();

            $check=0;
            foreach ($invoceLimit as $item) {
                $check++;
                if (is_object($item) && property_exists($item, 'invoce_id')) {
                    $invoice_id = $item->invoce_id + 1;
                } else {
                    // Handle the case when $item is not an object or 'invoce_id' property doesn't exist
                    // You can set a default value for $invoice_id or handle the error accordingly
                }
            }

            if (!$invoce){
                if ($check == '0') {
                    DB::table('list_invoice')->insert([
                        'cid' => $cid,
                        'rid' => $rid,
                        'invoce_id' => 1,
                        'cus_name' => $Cus_Name,
                        'amount' => $price,
                        'payment_date' => $date,
                        'date_check' => $date_check,
                        'current_dates' => $current_date
                    ]);
                }else{
                    DB::table('list_invoice')->insert([
                        'cid' => $cid,
                        'rid' => $rid,
                        'invoce_id' => $invoice_id,
                        'cus_name' => $Cus_Name,
                        'amount' => $price,
                        'payment_date' => $date,
                        'date_check' => $date_check,
                        'current_dates' => $current_date
                    ]);
                }
            }

            $getYmd = DB::table('list_invoice')
                ->select('invoce_id', DB::raw('MONTH(date_check) as monthdate'), DB::raw('YEAR(date_check) as yeardate'))
                ->where('rid', $rid)
                ->where('cid', $cid)
                ->where('payment_date', $date)
                ->first();
            $INV = 'INV'.substr($getYmd->yeardate, -2).'/'.$getYmd->monthdate.'/'. str_pad($getYmd->invoce_id, 4, '0', STR_PAD_LEFT);

        } elseif($status == 'จ่ายแล้ว') {
            $bill = DB::table('list_bills')
            ->where('rid', $rid)
            ->where('cid', $cid)
            ->where('payment_date', $date)
            ->first();

            $billLimit = DB::table('list_bills')
                ->where('date_check', $date_check)
                ->orderBy('id', 'DESC')
                ->limit(1)
                ->get();

            $check=0;
            foreach ($billLimit as $item) {
                $check++;
                if (is_object($item) && property_exists($item, 'bill_id')) {
                    $bill_id = $item->bill_id + 1;
                } else {
                    // Handle the case when $item is not an object or 'invoce_id' property doesn't exist
                    // You can set a default value for $invoice_id or handle the error accordingly
                }
            }
            if (!$bill){
                if ($check == '0') {
                    DB::table('list_bills')->insert([
                        'cid' => $cid,
                        'rid' => $rid,
                        'bill_id' => 1,
                        'cus_name' => $Cus_Name,
                        'amount' => $price,
                        'payment_date' => $date,
                        'date_check' => $date_check
                    ]);
                }else{
                    DB::table('list_bills')->insert([
                        'cid' => $cid,
                        'rid' => $rid,
                        'bill_id' => $bill_id,
                        'cus_name' => $Cus_Name,
                        'amount' => $price,
                        'payment_date' => $date,
                        'date_check' => $date_check
                    ]);
                }
            }
            $getBill = DB::table('list_bills')
                ->select('bill_id')
                ->where('rid', $rid)
                ->where('cid', $cid)
                ->where('payment_date', $date)
                ->first();
            $REC = substr($year, -2).'/'.$Payment[1].'/'. str_pad($getBill->bill_id, 4, '0', STR_PAD_LEFT);

        }

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
                ->first();

            if ($result->Price) {
                $customer_price = $this->convertAmount($result->Price);
            } else {
                $customer_price = null;
            }
            if ($status == 'ยังไม่จ่าย') {
                $pdf = Pdf::loadView('report_payment.print', ['result' => $result, 'monthY' => $monthY, 'INV' => $INV, 'current_date' => $current_date,'print_date' => $print_date, 'date_check' => $date_check]);
                return $pdf->stream();
            } elseif($status == 'จ่ายแล้ว') {
                $pdf = Pdf::loadView('report_payment.print_receipt', ['result' => $result, 'monthY' => $monthY, 'REC' => $REC, 'Payment_Dates' => $Payment_Dates, 'date_check' => $date_check, 'customer_price' => $customer_price]);
                return $pdf->stream();
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
}
