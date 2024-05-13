<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Room;
use App\Models\Role_user;
use App\Models\User;
use App\Models\Lease_auto_code;
use App\Models\Lease_code;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ReportRoomController extends Controller
{
    public function index()
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        $reports = DB::table(DB::raw("
        (
            SELECT Project_Name, COUNT(*) AS total,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' THEN 1 ELSE 0 END) AS rent,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'พร้อมอยู่' THEN 1 ELSE 0 END) AS readyroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'สวัสดิการ' THEN 1 ELSE 0 END) AS welfareroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'ห้องออฟฟิต' THEN 1 ELSE 0 END) AS officeroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'จอง' THEN 1 ELSE 0 END) AS reserveroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'รอตรวจ' THEN 1 ELSE 0 END) AS examroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'รอคลีน' THEN 1 ELSE 0 END) AS cleanroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'ไม่พร้อมอยู่' THEN 1 ELSE 0 END) AS noreadyroom,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' AND IFNULL(rental_status,'') = 'การันตี' THEN 1 ELSE 0 END) AS rent1,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' AND IFNULL(rental_status,'') = 'การันตีรับล่วงหน้า' THEN 1 ELSE 0 END) AS rent2,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' AND IFNULL(rental_status,'') = 'ฝากเช่า' THEN 1 ELSE 0 END) AS rent3,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' AND IFNULL(rental_status,'') = 'เบิกจ่ายล่วงหน้า' THEN 1 ELSE 0 END) AS rent4,
                SUM(CASE WHEN IFNULL(Contract_Status,'') != 'เช่าอยู่' AND IFNULL(Status_Room,'') = 'จอง' THEN 1 ELSE 0 END) AS rent5,
                COUNT(*) - SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' THEN 1 ELSE 0 END) AS balance
            FROM (
                SELECT r.Create_Date, r.pid, r.HomeNo, r.RoomNo, r.Building, r.Floor, RoomType, r.Size, Status_Room, Owner, r.Phone, Transfer_Date, Guarantee_Contract, Guarantee_Amount, Guarantee_Startdate, Guarantee_Enddate, Trans_Status, rental_status, p.Project_Name, c.Contract_Status
                FROM rooms r
                JOIN projects p ON r.pid = p.pid
                LEFT JOIN (SELECT * FROM customers WHERE Contract_Status IN ('เช่าอยู่', NULL, '')) c ON r.pid = c.pid AND c.RoomNo = r.RoomNo AND c.rid = r.id
                WHERE IFNULL(status_room,'') <> 'คืนห้อง' AND (Trans_Status = '' OR Trans_Status IS NULL)
                ORDER BY r.RoomNo
            ) AS a
            GROUP BY Project_Name

            UNION

            SELECT Project_Name, COUNT(*) AS total,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' THEN 1 ELSE 0 END) AS rent,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'พร้อมอยู่' THEN 1 ELSE 0 END) AS readyroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'สวัสดิการ' THEN 1 ELSE 0 END) AS welfareroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'ห้องออฟฟิต' THEN 1 ELSE 0 END) AS officeroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'จอง' THEN 1 ELSE 0 END) AS reserveroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'รอตรวจ' THEN 1 ELSE 0 END) AS examroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'รอคลีน' THEN 1 ELSE 0 END) AS cleanroom,
                SUM(CASE WHEN IFNULL(Status_Room,'') = 'ไม่พร้อมอยู่' THEN 1 ELSE 0 END) AS noreadyroom,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' AND IFNULL(rental_status,'') = 'การันตี' THEN 1 ELSE 0 END) AS rent1,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' AND IFNULL(rental_status,'') = 'การันตีรับล่วงหน้า' THEN 1 ELSE 0 END) AS rent2,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' AND IFNULL(rental_status,'') = 'ฝากเช่า' THEN 1 ELSE 0 END) AS rent3,
                SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' AND IFNULL(rental_status,'') = 'เบิกจ่ายล่วงหน้า' THEN 1 ELSE 0 END) AS rent4,
                SUM(CASE WHEN IFNULL(Contract_Status,'') != 'เช่าอยู่' AND IFNULL(Status_Room,'') = 'จอง' THEN 1 ELSE 0 END) AS rent5,
                COUNT(*) - SUM(CASE WHEN IFNULL(Contract_Status,'') = 'เช่าอยู่' THEN 1 ELSE 0 END) AS balance
            FROM (
                SELECT r.Create_Date, r.pid, r.HomeNo, r.RoomNo, r.Building, r.Floor, RoomType, r.Size, Status_Room, Owner, r.Phone, Transfer_Date, Guarantee_Contract, Guarantee_Amount, Guarantee_Startdate, Guarantee_Enddate, Trans_Status, rental_status, p.Project_Name, c.Contract_Status
                FROM rooms r
                JOIN projects p ON r.pid = p.pid
                LEFT JOIN (SELECT * FROM customers WHERE Contract_Status IN ('เช่าอยู่', NULL, '')) c ON r.pid = c.pid AND c.RoomNo = r.RoomNo AND c.rid = r.id
                WHERE IFNULL(status_room,'') <> 'คืนห้อง' AND (Trans_Status = '' OR Trans_Status IS NULL)
                ORDER BY r.RoomNo
            ) AS a
            GROUP BY Project_Name
        ) AS a
        JOIN (
            SELECT Project_Name
            FROM (
                SELECT r.Create_Date, r.pid, r.HomeNo, r.RoomNo, r.Building, r.Floor, RoomType, r.Size, Status_Room, Owner, r.Phone, Transfer_Date, Guarantee_Contract, Guarantee_Amount, Guarantee_Startdate, Guarantee_Enddate, Trans_Status, rental_status, p.Project_Name, c.Contract_Status
                FROM rooms r
                JOIN projects p ON r.pid = p.pid
                LEFT JOIN (SELECT * FROM customers WHERE Contract_Status IN ('เช่าอยู่', NULL, '')) c ON r.pid = c.pid AND c.RoomNo = r.RoomNo AND c.rid = r.id
                WHERE IFNULL(status_room,'') <> 'คืนห้อง' AND (Trans_Status = '' OR Trans_Status IS NULL)
                ORDER BY r.RoomNo
            ) AS a
            GROUP BY Project_Name
        ) AS b ON a.Project_Name = b.Project_Name
        ORDER BY a.Project_Name
        "))
            ->get();
        //dd($reports);
        return view(
            'report_room.index',
            compact(
                'dataLoginUser',
                'isRole',
                'reports'
            )


        );
    }

    public function report_rental()
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $date1 = request()->input('date1', date('Y-m-d'));

        return view(
            'report_room.report_rental.retal_index',
            compact(
                'dataLoginUser',
                'isRole',
                'date1'
            )
        );
    }

    public function report_search(Request $request)
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        $date1 = request()->get('date1');

        $where = "WHERE";
        $w = "จ่ายแล้ว','ยังไม่จ่าย','ห้องสวัสดิการ";

        $where .= "  DATE_FORMAT( '" . $date1 . "', '%Y%m' ) between  DATE_FORMAT( contract_startdate, '%Y%m' ) and DATE_FORMAT( contract_enddate, '%Y%m' ) ";
        $where .= " and CASE WHEN IFNULL( contract_startdate, '' ) = ''
                    OR contract_startdate = '0000-00-00' and r.status_room <>'สวัสดิการ' THEN 'ยังไม่จ่าย'
                    when r.status_room ='สวัสดิการ' then 'ห้องสวัสดิการ'
                    WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due2_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00'))
                    OR (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00'))
                    or (
                    DATE_FORMAT( due1_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due2_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due3_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due4_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due5_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due6_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due7_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due8_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due9_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due10_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due11_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    and DATE_FORMAT( due12_Date, '%Y%m') <> DATE_FORMAT( '" . $date1 . "', '%Y%m')
                    )
                    then 'จ่ายแล้ว'
                    else 'ยังไม่จ่าย' end in ( '" . $w . "') ";

        $requests = DB::select("SELECT COUNT(project_name) AS room,project_name, c.Roomno,r.HomeNo,r.status_room, c.cus_name ,c.Phone, SUM(c.price) AS total,  pa.id AS room_id,
            CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00' and r.status_room <>'สวัสดิการ' THEN 'ไม่มีวันเซ็นต์สัญญา'
            when r.status_room ='สวัสดิการ' then 'ห้องสวัสดิการ'
            ELSE contract_startdate
            END AS STATUS ,
            CASE WHEN IFNULL(contract_startdate, '') = '' OR contract_startdate = '0000-00-00' AND r.status_room <> 'สวัสดิการ' THEN 'ยังไม่จ่าย' WHEN r.status_room = 'สวัสดิการ' THEN 'ห้องสวัสดิการ' WHEN(
                    DATE_FORMAT(due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date1 IS NULL
                ) OR(
                    DATE_FORMAT(due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date2 IS NULL
                ) OR(
                    DATE_FORMAT(due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date3 IS NULL
                ) OR(
                    DATE_FORMAT(due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date4 IS NULL
                ) OR(
                    DATE_FORMAT(due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date5 IS NULL
                ) OR(
                    DATE_FORMAT(due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date6 IS NULL
                ) OR(
                    DATE_FORMAT(due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date7 IS NULL
                ) OR(
                    DATE_FORMAT(due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date8 IS NULL
                ) OR(
                    DATE_FORMAT(due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date9 IS NULL
                ) OR(
                    DATE_FORMAT(due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date10 IS NULL
                ) OR(
                    DATE_FORMAT(due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date11 IS NULL
                ) OR(
                    DATE_FORMAT(due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date12 IS NULL
                ) THEN 'ยังไม่จ่าย' WHEN(
                    DATE_FORMAT(due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date1, '') NOT IN('', '0000-00-00') AND due1_Date <= Payment_Date1
                ) OR(
                    DATE_FORMAT(due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date2, '') NOT IN('', '0000-00-00') AND due2_Date <= Payment_Date2
                ) OR(
                    DATE_FORMAT(due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date3, '') NOT IN('', '0000-00-00') AND due3_Date <= Payment_Date3
                ) OR(
                    DATE_FORMAT(due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date4, '') NOT IN('', '0000-00-00') AND due4_Date <= Payment_Date4
                ) OR(
                    DATE_FORMAT(due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date5, '') NOT IN('', '0000-00-00') AND due5_Date <= Payment_Date5
                ) OR(
                    DATE_FORMAT(due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date6, '') NOT IN('', '0000-00-00') AND due6_Date <= Payment_Date6
                ) OR(
                    DATE_FORMAT(due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date7, '') NOT IN('', '0000-00-00') AND due7_Date <= Payment_Date7
                ) OR(
                    DATE_FORMAT(due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date8, '') NOT IN('', '0000-00-00') AND due8_Date <= Payment_Date8
                ) OR(
                    DATE_FORMAT(due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date9, '') NOT IN('', '0000-00-00') AND due9_Date <= Payment_Date9
                ) OR(
                    DATE_FORMAT(due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date10, '') NOT IN('', '0000-00-00') AND due10_Date <= Payment_Date10
                ) OR(
                    DATE_FORMAT(due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date11, '') NOT IN('', '0000-00-00') AND due11_Date <= Payment_Date11
                ) OR(
                    DATE_FORMAT(due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date12, '') NOT IN('', '0000-00-00') AND due12_Date <= Payment_Date12
                ) THEN 'ล่าช้า' ELSE 'จ่ายแล้ว'
            END AS paid,CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00'
            THEN '-'
            WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then Payment_Date1
            WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then Payment_Date2
            WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then Payment_Date3
            WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then Payment_Date4
            WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then Payment_Date5
            WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then Payment_Date6
            WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then Payment_Date7
            WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then Payment_Date8
            WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then Payment_Date9
            WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then Payment_Date10
            WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then Payment_Date11
            WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then Payment_Date12
            else '-' end as date_paid
            ,CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00'
            THEN '0'
            WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then due1_amount
            WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then due2_amount
            WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then due3_amount
            WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then due4_amount
            WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then due5_amount
            WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then due6_amount
            WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then due7_amount
            WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then due8_amount
            WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then due9_amount
            WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then due10_amount
            WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then due11_amount
            WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then due12_amount
            else '0' end as total_paid

            ,CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00'
            THEN '0'
            WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then due1_Date
            WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then due2_Date
            WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then due3_Date
            WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then due4_Date
            WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then due5_Date
            WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then due6_Date
            WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then due7_Date
            WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then due8_Date
            WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then due9_Date
            WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then due10_Date
            WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then due11_Date
            WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then due12_Date
            else '0' end as due_dates

            ,CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00'
            THEN '0'
            WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then approve1_date
            WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then approve2_date
            WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then approve3_date
            WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then approve4_date
            WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then approve5_date
            WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then approve6_date
            WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then approve7_date
            WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then approve8_date
            WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then approve9_date
            WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then approve10_date
            WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then approve11_date
            WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then approve12_date
            else '0' end as  approve_dates


            ,c.Contract_Status,Cancle_Date, contract_startdate, contract_enddate,c.Phone, c.pid, c.rid, pa. *
            FROM customers c
            INNER JOIN projects p ON p.pid = c.pid
            inner JOIN payments AS pa ON pa.cid = c.id
            INNER JOIN rooms AS r ON c.rid = r.id
            " . $where . "
            and (c.Contract_Status =  'เช่าอยู่' or c.Contract_Status =  'ต่อสัญญา' or (c.Contract_Status ='ออก' and DATE_FORMAT( Cancle_Date, '%Y%m' ) >= DATE_FORMAT( '" . $date1 . "', '%Y%m' ) ))
            and ifnull(r.Trans_status,'') != 'del'

            GROUP BY project_name
            ORDER BY room DESC");


        $results = DB::select("SELECT project_name, c.Roomno,r.HomeNo,r.status_room, c.cus_name ,c.Phone, SUM(c.price) AS total, pa.id AS room_id,
            CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00' and r.status_room <>'สวัสดิการ' THEN 'ไม่มีวันเซ็นต์สัญญา'
            when r.status_room ='สวัสดิการ' then 'ห้องสวัสดิการ'
            ELSE contract_startdate
            END AS STATUS ,
            CASE WHEN IFNULL(contract_startdate, '') = '' OR contract_startdate = '0000-00-00' AND r.status_room <> 'สวัสดิการ' THEN 'ยังไม่จ่าย' WHEN r.status_room = 'สวัสดิการ' THEN 'ห้องสวัสดิการ' WHEN(
                    DATE_FORMAT('" . $date1 . "' , '%Y%m') = DATE_FORMAT(due1_Date, '%Y%m') AND IFNULL(Payment_Date1, '') NOT IN('', '0000-00-00')
                ) THEN 'ลูกค้าเข้าใหม่' WHEN(
                    DATE_FORMAT('" . $date1 . "' , '%Y%m') = DATE_FORMAT(contract_enddate, '%Y%m') AND Cancle_Date IS NULL
                ) THEN 'ลูกค้าหมดสัญญาในเดือน' WHEN(
                    DATE_FORMAT(due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date1, '') NOT IN('', '0000-00-00') AND due1_Date >= Payment_Date1
                ) OR(
                    DATE_FORMAT(due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date2, '') NOT IN('', '0000-00-00') AND due2_Date >= Payment_Date2
                ) OR(
                    DATE_FORMAT(due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date3, '') NOT IN('', '0000-00-00') AND due3_Date >= Payment_Date3
                ) OR(
                    DATE_FORMAT(due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date4, '') NOT IN('', '0000-00-00') AND due4_Date >= Payment_Date4
                ) OR(
                    DATE_FORMAT(due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date5, '') NOT IN('', '0000-00-00') AND due5_Date >= Payment_Date5
                ) OR(
                    DATE_FORMAT(due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date6, '') NOT IN('', '0000-00-00') AND due6_Date >= Payment_Date6
                ) OR(
                    DATE_FORMAT(due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date7, '') NOT IN('', '0000-00-00') AND due7_Date >= Payment_Date7
                ) OR(
                    DATE_FORMAT(due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date8, '') NOT IN('', '0000-00-00') AND due8_Date >= Payment_Date8
                ) OR(
                    DATE_FORMAT(due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date9, '') NOT IN('', '0000-00-00') AND due9_Date >= Payment_Date9
                ) OR(
                    DATE_FORMAT(due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date10, '') NOT IN('', '0000-00-00') AND due10_Date >= Payment_Date10
                ) OR(
                    DATE_FORMAT(due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date11, '') NOT IN('', '0000-00-00') AND due11_Date >= Payment_Date11
                ) OR(
                    DATE_FORMAT(due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date12, '') NOT IN('', '0000-00-00') AND due12_Date >= Payment_Date12
                ) THEN 'ลูกค้าชำระตามกำหนด' WHEN(
                    DATE_FORMAT(due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date1, '') NOT IN('', '0000-00-00') AND due1_Date <= Payment_Date1
                ) OR(
                    DATE_FORMAT(due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date2, '') NOT IN('', '0000-00-00') AND due2_Date <= Payment_Date2
                ) OR(
                    DATE_FORMAT(due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date3, '') NOT IN('', '0000-00-00') AND due3_Date <= Payment_Date3
                ) OR(
                    DATE_FORMAT(due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date4, '') NOT IN('', '0000-00-00') AND due4_Date <= Payment_Date4
                ) OR(
                    DATE_FORMAT(due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date5, '') NOT IN('', '0000-00-00') AND due5_Date <= Payment_Date5
                ) OR(
                    DATE_FORMAT(due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date6, '') NOT IN('', '0000-00-00') AND due6_Date <= Payment_Date6
                ) OR(
                    DATE_FORMAT(due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date7, '') NOT IN('', '0000-00-00') AND due7_Date <= Payment_Date7
                ) OR(
                    DATE_FORMAT(due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date8, '') NOT IN('', '0000-00-00') AND due8_Date <= Payment_Date8
                ) OR(
                    DATE_FORMAT(due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date9, '') NOT IN('', '0000-00-00') AND due9_Date <= Payment_Date9
                ) OR(
                    DATE_FORMAT(due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date10, '') NOT IN('', '0000-00-00') AND due10_Date <= Payment_Date10
                ) OR(
                    DATE_FORMAT(due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date11, '') NOT IN('', '0000-00-00') AND due11_Date <= Payment_Date11
                ) OR(
                    DATE_FORMAT(due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date12, '') NOT IN('', '0000-00-00') AND due12_Date <= Payment_Date12
                ) THEN 'ลูกค้าชำระล่าช้า' ELSE 'ลูกค้ายังไม่ได้ชำระ'
            END AS paid,
            SUM(CASE WHEN(
                    DATE_FORMAT('" . $date1 . "' , '%Y%m') = DATE_FORMAT(contract_startdate, '%Y%m')
                ) THEN '1' WHEN(
                    DATE_FORMAT('" . $date1 . "' , '%Y%m') = DATE_FORMAT(contract_enddate, '%Y%m') AND Cancle_Date IS NULL
                ) THEN '1' WHEN(
                    DATE_FORMAT(due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date1, '') NOT IN('', '0000-00-00') AND due1_Date >= Payment_Date1
                ) OR(
                    DATE_FORMAT(due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date2, '') NOT IN('', '0000-00-00') AND due2_Date >= Payment_Date2
                ) OR(
                    DATE_FORMAT(due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date3, '') NOT IN('', '0000-00-00') AND due3_Date >= Payment_Date3
                ) OR(
                    DATE_FORMAT(due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date4, '') NOT IN('', '0000-00-00') AND due4_Date >= Payment_Date4
                ) OR(
                    DATE_FORMAT(due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date5, '') NOT IN('', '0000-00-00') AND due5_Date >= Payment_Date5
                ) OR(
                    DATE_FORMAT(due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date6, '') NOT IN('', '0000-00-00') AND due6_Date >= Payment_Date6
                ) OR(
                    DATE_FORMAT(due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date7, '') NOT IN('', '0000-00-00') AND due7_Date >= Payment_Date7
                ) OR(
                    DATE_FORMAT(due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date8, '') NOT IN('', '0000-00-00') AND due8_Date >= Payment_Date8
                ) OR(
                    DATE_FORMAT(due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date9, '') NOT IN('', '0000-00-00') AND due9_Date >= Payment_Date9
                ) OR(
                    DATE_FORMAT(due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date10, '') NOT IN('', '0000-00-00') AND due10_Date >= Payment_Date10
                ) OR(
                    DATE_FORMAT(due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date11, '') NOT IN('', '0000-00-00') AND due11_Date >= Payment_Date11
                ) OR(
                    DATE_FORMAT(due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date12, '') NOT IN('', '0000-00-00') AND due12_Date >= Payment_Date12
                ) THEN '1' WHEN(
                    DATE_FORMAT(due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date1, '') NOT IN('', '0000-00-00') AND due1_Date <= Payment_Date1
                ) OR(
                    DATE_FORMAT(due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date2, '') NOT IN('', '0000-00-00') AND due2_Date <= Payment_Date2
                ) OR(
                    DATE_FORMAT(due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date3, '') NOT IN('', '0000-00-00') AND due3_Date <= Payment_Date3
                ) OR(
                    DATE_FORMAT(due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date4, '') NOT IN('', '0000-00-00') AND due4_Date <= Payment_Date4
                ) OR(
                    DATE_FORMAT(due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date5, '') NOT IN('', '0000-00-00') AND due5_Date <= Payment_Date5
                ) OR(
                    DATE_FORMAT(due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date6, '') NOT IN('', '0000-00-00') AND due6_Date <= Payment_Date6
                ) OR(
                    DATE_FORMAT(due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date7, '') NOT IN('', '0000-00-00') AND due7_Date <= Payment_Date7
                ) OR(
                    DATE_FORMAT(due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date8, '') NOT IN('', '0000-00-00') AND due8_Date <= Payment_Date8
                ) OR(
                    DATE_FORMAT(due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date9, '') NOT IN('', '0000-00-00') AND due9_Date <= Payment_Date9
                ) OR(
                    DATE_FORMAT(due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date10, '') NOT IN('', '0000-00-00') AND due10_Date <= Payment_Date10
                ) OR(
                    DATE_FORMAT(due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date11, '') NOT IN('', '0000-00-00') AND due11_Date <= Payment_Date11
                ) OR(
                    DATE_FORMAT(due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(Payment_Date12, '') NOT IN('', '0000-00-00') AND due12_Date <= Payment_Date12
                ) THEN '1' ELSE 1
            END) AS 'room',CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00'
            THEN '-'
            WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then Payment_Date1
            WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then Payment_Date2
            WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then Payment_Date3
            WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then Payment_Date4
            WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then Payment_Date5
            WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then Payment_Date6
            WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then Payment_Date7
            WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then Payment_Date8
            WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then Payment_Date9
            WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then Payment_Date10
            WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then Payment_Date11
            WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then Payment_Date12
            else '-' end as date_paid
            ,CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00'
            THEN '0'
            WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then due1_amount
            WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then due2_amount
            WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then due3_amount
            WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then due4_amount
            WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then due5_amount
            WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then due6_amount
            WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then due7_amount
            WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then due8_amount
            WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then due9_amount
            WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then due10_amount
            WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then due11_amount
            WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then due12_amount
            else '0' end as total_paid

            ,CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00'
            THEN '0'
            WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then due1_Date
            WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then due2_Date
            WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then due3_Date
            WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then due4_Date
            WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then due5_Date
            WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then due6_Date
            WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then due7_Date
            WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then due8_Date
            WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then due9_Date
            WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then due10_Date
            WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then due11_Date
            WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then due12_Date
            else '0' end as due_dates

            ,CASE WHEN IFNULL( contract_startdate, '' ) = ''
            OR contract_startdate = '0000-00-00'
            THEN '0'
            WHEN (DATE_FORMAT( due1_Date, '%Y%m' ) = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date1, '' ) not in ('','0000-00-00')) then approve1_date
            WHEN (DATE_FORMAT( due2_Date ,'%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date2, '' ) not in ('','0000-00-00')) then approve2_date
            WHEN (DATE_FORMAT( due3_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date3, '' ) not in ('','0000-00-00')) then approve3_date
            WHEN (DATE_FORMAT( due4_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date4, '' ) not in ('','0000-00-00')) then approve4_date
            WHEN (DATE_FORMAT( due5_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date5, '' ) not in ('','0000-00-00')) then approve5_date
            WHEN (DATE_FORMAT( due6_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date6, '' ) not in ('','0000-00-00')) then approve6_date
            WHEN (DATE_FORMAT( due7_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date7, '' ) not in ('','0000-00-00')) then approve7_date
            WHEN (DATE_FORMAT( due8_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date8, '' ) not in ('','0000-00-00')) then approve8_date
            WHEN (DATE_FORMAT( due9_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date9, '' ) not in ('','0000-00-00')) then approve9_date
            WHEN (DATE_FORMAT( due10_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date10, '' ) not in ('','0000-00-00')) then approve10_date
            WHEN (DATE_FORMAT( due11_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date11, '' ) not in ('','0000-00-00')) then approve11_date
            WHEN (DATE_FORMAT( due12_Date, '%Y%m') = DATE_FORMAT( '" . $date1 . "', '%Y%m' ) and ifnull(Payment_Date12, '' ) not in ('','0000-00-00')) then approve12_date
            else '0' end as  approve_dates


            ,c.Contract_Status,Cancle_Date, contract_startdate, contract_enddate,c.Phone, c.pid, c.rid, pa. *
            FROM customers c
            INNER JOIN projects p ON p.pid = c.pid
            inner JOIN payments AS pa ON pa.cid = c.id
            INNER JOIN rooms AS r ON c.rid = r.id
             " . $where . "
            and (c.Contract_Status =  'เช่าอยู่' or c.Contract_Status =  'ต่อสัญญา' or (c.Contract_Status ='ออก' and DATE_FORMAT( Cancle_Date, '%Y%m' ) >= DATE_FORMAT( '" . $date1 . "', '%Y%m' ) ))
            and ifnull(r.Trans_status,'') != 'del'
            GROUP BY paid ORDER BY room DESC");


        // $requests = DB::table('customers as c')
        //     ->select(DB::raw('COUNT(project_name) AS room'), 'project_name', 'c.Roomno', 'r.HomeNo', 'r.status_room', 'c.cus_name', 'c.Phone', DB::raw('SUM(c.price) AS total'), 'pa.id AS room_id')
        //     ->leftJoin('projects as p', 'p.pid', '=', 'c.pid')
        //     ->leftJoin('payments as pa', 'pa.cid', '=', 'c.id')
        //     ->leftJoin('rooms as r', 'c.rid', '=', 'r.id')
        //     ->where(function ($where) use ($date1) {
        //         $where->whereRaw("IFNULL(c.contract_startdate, '') = '' OR c.contract_startdate = '0000-00-00'")
        //             ->orWhere('r.status_room', '<>', 'สวัสดิการ')
        //             ->orWhere(function ($where) {
        //                 $where->where('r.status_room', '=', 'ไม่มีวันเซ็นต์สัญญา')
        //                     ->orWhere('r.status_room', '=', 'ห้องสวัสดิการ');
        //             });
        //     })
        //     ->orWhere('r.status_room', '=', 'สวัสดิการ')

        //     ->orWhere(function ($where) use ($date1) {
        //         $where->whereRaw("DATE_FORMAT(pa.due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date1, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date2, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date3, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date4, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date5, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date6, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date7, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date8, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date9, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date10, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date11, '') IS NULL")
        //             ->orWhereRaw("DATE_FORMAT(pa.due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date12, '') IS NULL")

        //             ->orWhereRaw("DATE_FORMAT(pa.due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date1, '') NOT IN('', '0000-00-00') AND pa.due1_Date <= pa.Payment_Date1")
        //             ->orWhereRaw("DATE_FORMAT(pa.due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date2, '') NOT IN('', '0000-00-00') AND pa.due2_Date <= pa.Payment_Date2")
        //             ->orWhereRaw("DATE_FORMAT(pa.due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date3, '') NOT IN('', '0000-00-00') AND pa.due3_Date <= pa.Payment_Date3")
        //             ->orWhereRaw("DATE_FORMAT(pa.due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date4, '') NOT IN('', '0000-00-00') AND pa.due4_Date <= pa.Payment_Date4")
        //             ->orWhereRaw("DATE_FORMAT(pa.due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date5, '') NOT IN('', '0000-00-00') AND pa.due5_Date <= pa.Payment_Date5")
        //             ->orWhereRaw("DATE_FORMAT(pa.due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date6, '') NOT IN('', '0000-00-00') AND pa.due6_Date <= pa.Payment_Date6")
        //             ->orWhereRaw("DATE_FORMAT(pa.due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date7, '') NOT IN('', '0000-00-00') AND pa.due7_Date <= pa.Payment_Date7")
        //             ->orWhereRaw("DATE_FORMAT(pa.due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date8, '') NOT IN('', '0000-00-00') AND pa.due8_Date <= pa.Payment_Date8")
        //             ->orWhereRaw("DATE_FORMAT(pa.due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date9, '') NOT IN('', '0000-00-00') AND pa.due9_Date <= pa.Payment_Date9")
        //             ->orWhereRaw("DATE_FORMAT(pa.due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date10, '') NOT IN('', '0000-00-00') AND pa.due10_Date <= pa.Payment_Date10")
        //             ->orWhereRaw("DATE_FORMAT(pa.due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date11, '') NOT IN('', '0000-00-00') AND pa.due11_Date <= pa.Payment_Date11")
        //             ->orWhereRaw("DATE_FORMAT(pa.due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date12, '') NOT IN('', '0000-00-00') AND pa.due12_Date <= pa.Payment_Date12")

        //             ->orWhereRaw("DATE_FORMAT(pa.due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date1, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date2, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date3, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date4, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date5, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date6, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date7, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date8, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date9, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date10, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date11, '') NOT IN('', '0000-00-00')")
        //             ->orWhereRaw("DATE_FORMAT(pa.due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND IFNULL(pa.Payment_Date12, '') NOT IN('', '0000-00-00')");
        //     })
        //     ->selectRaw("CASE
        //     WHEN IFNULL(contract_startdate, '') = '' OR contract_startdate = '0000-00-00' AND r.status_room <> 'สวัสดิการ' THEN 'ยังไม่จ่าย'
        //     WHEN r.status_room = 'สวัสดิการ' THEN 'ห้องสวัสดิการ'
        //     WHEN (
        //         DATE_FORMAT(due1_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date1 IS NULL
        //         OR DATE_FORMAT(due2_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date2 IS NULL
        //         OR DATE_FORMAT(due3_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date3 IS NULL
        //         OR DATE_FORMAT(due4_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date4 IS NULL
        //         OR DATE_FORMAT(due5_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date5 IS NULL
        //         OR DATE_FORMAT(due6_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date6 IS NULL
        //         OR DATE_FORMAT(due7_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date7 IS NULL
        //         OR DATE_FORMAT(due8_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date8 IS NULL
        //         OR DATE_FORMAT(due9_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date9 IS NULL
        //         OR DATE_FORMAT(due10_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date10 IS NULL
        //         OR DATE_FORMAT(due11_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date11 IS NULL
        //         OR DATE_FORMAT(due12_Date, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m') AND Payment_Date12 IS NULL
        //     ) THEN 'ยังไม่จ่าย'
        // END AS STATUS")
        //     ->orWhere(function ($where) use ($date1) {
        //         $where->whereRaw("DATE_FORMAT(c.contract_startdate, '%Y%m') = DATE_FORMAT('" . $date1 . "', '%Y%m')")
        //             ->orWhereRaw("DATE_FORMAT(c.Cancle_Date, '%Y%m') >= DATE_FORMAT('" . $date1 . "', '%Y%m')");
        //     })
        //     ->whereNotIn(DB::raw("IFNULL(r.Trans_status, '')"), ['del'])
        //     ->whereIn('c.Contract_Status', ['เช่าอยู่', 'ต่อสัญญา'])
        //     ->groupBy('project_name')
        //     ->orderByDesc('room')
        //     ->get();




        return view(
            'report_room.report_rental.retal_search',
            compact(
                'dataLoginUser',
                'isRole',
                'date1',
                'requests',
                'results'
            )
        );
    }

    public function avaliableRoom()
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        $results = Room::select(
            'project_name',
            DB::raw('count(*) as totalall'),
            DB::raw('sum(case when rental_status = "ฝากเช่า" then 1 else 0 end) as rental_status1'),
            DB::raw('sum(case when rental_status = "ติดต่อเจ้าของห้องไม่ได้" then 1 else 0 end) as rental_status2'),
            DB::raw('sum(case when rental_status = "เบิกจ่ายล่วงหน้า" then 1 else 0 end) as rental_status3'),
            DB::raw('sum(case when rental_status = "การันตี" then 1 else 0 end) as rental_status4'),
            DB::raw('sum(case when rental_status = "การันตีรับล่วงหน้า" then 1 else 0 end) as rental_status5'),
            DB::raw('sum(case when rental_status = "ฝากต่อหักภาษี" then 1 else 0 end) as rental_status6'),
            DB::raw('sum(case when rental_status = "ฝากต่อไม่หักภาษี" then 1 else 0 end) as rental_status7')
        )
            ->join('projects as b', 'rooms.pid', '=', 'b.pid')
            ->where('rooms.status_room', '=', 'พร้อมอยู่')
            ->whereNull('rooms.trans_status')
            ->groupBy('project_name')
            ->get();


        return view(
            'report_room.avaliable.avble_room',
            compact(
                'dataLoginUser',
                'isRole',
                'results'
            )
        );
    }

    public function listRoom()
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = DB::connection('mysql_report')
            ->table('project')
            ->where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();
        // Retrieve request parameters
        // Retrieve request parameters
        $date1 = request()->input('date1', Carbon::now()->startOfMonth()->toDateString());
        $date2 = request()->input('date2', Carbon::now()->endOfMonth()->toDateString());

        // Parse dates using Carbon
        // กำหนดเวลาเริ่มต้นเป็น 00:00:00
        $startDate = Carbon::createFromFormat('Y-m-d', $date1)->startOfMonth()->startOfDay();
        // กำหนดเวลาสิ้นสุดเป็น 23:59:59
        $endDate = Carbon::createFromFormat('Y-m-d', $date2)->endOfMonth()->endOfDay();

        $statuses = DB::table('rooms')
            ->select('status_room')
            ->distinct()
            ->whereNotIn('status_room', ['', 'คืนห้อง'])
            ->orderBy('status_room', 'ASC')
            ->get();


        return view(
            'report_room.listRoom.list_rent_inroom',
            compact(
                'dataLoginUser',
                'isRole',
                'startDate',
                'endDate',
                'projects',
                'statuses'
            )
        );
    }

    public function asset_search(Request $request)
    {
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = DB::connection('mysql_report')
            ->table('project')
            ->select(
                DB::raw("DISTINCT CASE WHEN lh_rise IS NULL THEN 99 ELSE pid END AS pid"),
                DB::raw("CASE WHEN lh_rise IS NULL THEN 'อื่น ๆ' ELSE Project_Name END AS Project_Name")
            )
            ->orderBy('Project_Name', 'ASC')
            ->get();
        // Retrieve request parameters
        $date1 = request()->input('date1', Carbon::now()->startOfMonth()->toDateString());
        $date2 = request()->input('date2', Carbon::now()->endOfMonth()->toDateString());

        // Parse dates using Carbon
        // กำหนดเวลาเริ่มต้นเป็น 00:00:00
        $startDate = Carbon::createFromFormat('Y-m-d', $date1)->startOfMonth()->startOfDay();
        // กำหนดเวลาสิ้นสุดเป็น 23:59:59
        $endDate = Carbon::createFromFormat('Y-m-d', $date2)->endOfMonth()->endOfDay();

        $statuses = DB::table('rooms')
            ->select('status_room')
            ->distinct()
            ->whereNotIn('status_room', ['', 'คืนห้อง'])
            ->orderBy('status_room', 'ASC')
            ->get();

        // $dt = request()->input('dt');
        // $g = request()->input('g');
        // $cn = request()->input('cn');
        // $s = request()->input('s');
        // $n = request()->input('n');
        // $s1 = request()->input('s1');
        // $rt = request()->input('rt');
        // $f = request()->input('f');
        // $b = request()->input('b');
        // $order = request()->input('order', 'rooms.RoomNo');
        // $sort = request()->input('sort');
        // $todayDate = now()->format('Y-m-d');

        // $query = Room::select(
        //             'rooms.price as txtprice',
        //             'customers.price as txtcusprice',
        //             'customers.id AS cus_id',
        //             'rooms.Building AS Buile',
        //             'rooms.Floor AS layers',
        //             'rooms.*',
        //             'projects.*',
        //             'customers.*',
        //             'rooms.RoomNo AS RoomNo1',
        //             'rooms.Size AS Size1',
        //             'rooms.id AS id1',
        //             'customers.id AS id2'
        //         )
        //         ->join('projects', 'rooms.pid', '=', 'projects.pid')
        //         ->leftJoin('customers', function ($join) {
        //             $join->on('rooms.pid', '=', 'customers.pid')
        //                 ->on('customers.RoomNo', '=', 'rooms.RoomNo')
        //                 ->on('customers.rid', '=', 'rooms.id');
        //         })
        //         ->where(function ($query) use ($dt, $todayDate) {
        //             if ($dt == 99) {
        //                 $query->where('Guarantee_Startdate', '<=', $todayDate);
        //             } elseif ($dt == 5) {
        //                 $query->whereBetween('Contract_Startdate', [$date3, $date2]);
        //             } else {
        //                 $query->whereBetween('Contract_Startdate', [$date1, $date2]);
        //             }
        //         })
        //         ->when($g, function ($query) use ($g) {
        //             $query->where('Cus_Name', 'like', '%' . $g . '%');
        //         })
        //         ->when($cn, function ($query) use ($cn) {
        //             $query->where('rooms.RoomNo', 'like', '%' . $cn . '%');
        //         })
        //         ->when($s, function ($query) use ($s) {
        //             if ($s == 99) {
        //                 $query->where('rooms.pid', $s);
        //             }
        //         })
        //         ->when($n, function ($query) use ($n) {
        //             $query->where('Owner', 'like', '%' . $n . '%');
        //         })
        //         ->when($s1 == "ALL", function ($query) use ($s1) {
        //             $query->where(function ($query) {
        //                 $query->where('status_room', '<>', 'คืนห้อง');
        //                 if ($dt != 6) {
        //                     $query->where(function ($query) {
        //                         $query->where('Contract_Status', 'เช่าอยู่')
        //                             ->orWhereNull('Contract_Status')
        //                             ->orWhere('Contract_Status', '');
        //                     });
        //                 }
        //             });
        //         })
        //         ->when($s1 == "เช่าอยู่", function ($query) use ($s1) {
        //             $query->where('Contract_Status', 'เช่าอยู่');
        //         })
        //         ->when($s1 == "ห้องว่าง", function ($query) use ($s1) {
        //             $query->where(function ($query) {
        //                 $query->where('Contract_Status', '!=', 'เช่าอยู่')
        //                     ->orWhereNull('Contract_Status');
        //             });
        //         })
        //         // ->when($s1 != "ALL" && $s1 != "เช่าอยู่" && $s1 != "ห้องว่าง", function ($query) use ($s1) {
        //         //     $query->where('status_room', 'like', '%' . $s1 . '%');
        //         //     if ($dt != 6) {
        //         //         $query->where(function ($query) {
        //         //             $query->where('Contract_Status', 'เช่าอยู่')
        //         //                 ->orWhereNull('Contract_Status')
        //         //                 ->orWhere('Contract_Status', '');
        //         //         });
        //         //     }
        //         // })
        //         ->when($rt != "ALL", function ($query) use ($rt) {
        //             $query->where('rooms.rental_status', $rt);
        //         })
        //         ->orderByRaw($order, $sort);

        //         $result = $query->get();






        return view(
            'report_room.listRoom.list_inroom_search',
            compact(
                'dataLoginUser',
                'isRole',
                'startDate',
                'endDate',
                'projects',
                'statuses'
                // 'result'
            )
        );
    }
}
