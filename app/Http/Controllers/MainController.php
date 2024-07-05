<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Role_user;
use App\Models\Room;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function index(Request $request)
    {

        // $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();

        $status = $request->input('status', 'all');

        // ดึงปีปัจจุบัน
        $currentYear = Carbon::now()->year;
        $now = Carbon::now()->format('Y-m-d');
        $oneMonthAgoDate = Carbon::now()->subMonth();

        $query = Room::select(
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
            'rooms.price',
            'rooms.Trans_Status',
            'rooms.contract_owner',
            'rooms.Owner',
            'rooms.Guarantee_Startdate',
            'rooms.Guarantee_Enddate',
            'rooms.date_firstrend',
            'rooms.date_endrend',
            'customers.id as cid',
            'customers.Contract_Status',
            'customers.Contract_Startdate',
            'customers.Contract_Enddate',
            'customers.Cus_Name'
        )
            ->from('rooms as rooms')
            ->join('projects', 'rooms.pid', '=', 'projects.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
                OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            // ->whereBetween('customers.Contract_Startdate', [$startYear , $endYear]);
            // ->whereBetween('rooms.date_endrend', [$startYear , $endYear]);
            ->whereYear('rooms.date_endrend', '=', $currentYear);
            // ->where('customers.Contract_Enddate', '<', $now)
            // ->where('customers.Contract_Enddate', '>=', $oneMonthAgoDate);

        // กรองสถานะ
        if ($status != 'all') {
            if ($status == 'ready') {
                $query->where('rooms.Status_Room', 'พร้อมอยู่');
            } elseif ($status == 'not_ready') {
                $query->whereIn('rooms.Status_Room', ['ไม่พร้อมอยู่', 'รอคลีน', 'รอตรวจ', 'รอเฟอร์']);
            } elseif ($status == 'occupied') {
                $query->whereIn('rooms.Status_Room', ['สวัสดิการ', 'ห้องออฟฟิต', 'เช่าอยู่']);
            } elseif ($status == 'already') {
                $query->where('rooms.Status_Room', 'อยู่แล้ว');
            }
        }else{
            $query->whereRaw("IFNULL(rooms.Status_Room, '') <> 'คืนห้อง'");
            $query->where('customers.Contract_Enddate', '<=', $now)
            ->where('customers.Contract_Enddate', '>=', $oneMonthAgoDate);
        }
        $rents = $query
            ->orderBy('Project_Name', 'ASC')
            ->get();

        // dd(Carbon::create(null, 6, 1));

        // นับจำนวนห้องในแต่ละสถานะ
        $readyCount = Room::where('Status_Room', 'พร้อมอยู่')
            ->whereRaw("IFNULL(rooms.Status_Room, '') <> 'คืนห้อง'")
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('date_endrend', '=', $currentYear)
            ->count();

        $notReadyCount = Room::whereIn('Status_Room', ['ไม่พร้อมอยู่', 'รอคลีน', 'รอตรวจ', 'รอเฟอร์'])
            ->whereRaw("IFNULL(rooms.Status_Room, '') <> 'คืนห้อง'")
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('date_endrend', '=', $currentYear)
            ->count();

        $occupiedCount = Room::whereIn('Status_Room', ['สวัสดิการ', 'ห้องออฟฟิต', 'เช่าอยู่'])
            ->whereRaw("IFNULL(rooms.Status_Room, '') <> 'คืนห้อง'")
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('date_endrend', '=', $currentYear)
            ->count();

        $alreadyCount = Room::where('Status_Room', 'อยู่แล้ว')
            ->whereRaw("IFNULL(rooms.Status_Room, '') <> 'คืนห้อง'")
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('date_endrend', '=', $currentYear)
            ->count();
        // นับจำนวนห้องทั้งหมด
        // $totalCount = Room::whereRaw("IFNULL(rooms.Status_Room, '') <> 'คืนห้อง'")
        //     ->where(function ($query) {
        //         $query->where('rooms.Trans_Status', '=', '')
        //             ->orWhereNull('rooms.Trans_Status');
        //     })
        //     // ->whereYear('rooms.date_endrend', '=', $currentYear)
        //     ->where('rooms.date_endrend', '<', $now)
        //     ->where('rooms.date_endrend', '>=', $oneMonthAgoDate)
        //     ->count();

        $totalCount = Room::join('projects', 'rooms.pid', '=', 'projects.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
                OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('rooms.date_endrend', '=', $currentYear)
            ->where('customers.Contract_Enddate', '<=', $now)
            ->where('customers.Contract_Enddate', '>=', $oneMonthAgoDate)
            ->count();

        return view('main.index', compact(
            'rents',
            'dataLoginUser',
            'isRole',
            'projects',
            'status',
            'readyCount',
            'notReadyCount',
            'occupiedCount',
            'alreadyCount',
            'totalCount'
        ));
    }

    public function compareRentRoom(){

        $startDate = Carbon::create(null, 1, 1); // January 1st of the current year
        $endDate = Carbon::now();
        $currentYear = Carbon::now()->year;
        $months = [];
        $dataCurrentYear = [];
        $dataLastYear = [];
        $i = 1;
        $lastYear = date('Y') - 1;
        while ($startDate->lessThanOrEqualTo($endDate)) {
            $months[] = $startDate->format('F');
            $startDate->addMonth();
            $dataCurrentYear[] = Room::join('projects', 'rooms.pid', '=', 'projects.pid')
                ->leftJoin(DB::raw('(SELECT * FROM customers) AS customers'), function ($join) {
                    $join->on('rooms.pid', '=', 'customers.pid')
                        ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                        ->on('rooms.id', '=', 'customers.rid');
                })
                // ->where(function ($query) {
                //     $query->where('rooms.Trans_Status', '=', '')
                //         ->orWhereNull('rooms.Trans_Status');
                // })
                ->whereYear('customers.Contract_Startdate', '=', $currentYear)
                ->whereBetween('customers.Contract_Startdate', [Carbon::create(null, $i, 1) , Carbon::create(null, $i, 31)])->count();

            $dataLastYear[] = Room::join('projects', 'rooms.pid', '=', 'projects.pid')
                ->leftJoin(DB::raw('(SELECT * FROM customers) AS customers'), function ($join) {
                    $join->on('rooms.pid', '=', 'customers.pid')
                        ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                        ->on('rooms.id', '=', 'customers.rid');
                })
                // ->where(function ($query) {
                //     $query->where('rooms.Trans_Status', '=', '')
                //         ->orWhereNull('rooms.Trans_Status');
                // })
                ->whereYear('customers.Contract_Startdate', '=', $lastYear)
                ->whereBetween('customers.Contract_Startdate', [Carbon::create($lastYear, $i, 1) , Carbon::create($lastYear, $i, 31)])->count();

            $i++;
        }

        $labels = $months;
        $datasets = [
            [
                'label' => 'ปีปัจจุบัน',
                'backgroundColor' => 'rgba(60,141,188,0.9)',
                'borderColor' => 'rgba(60,141,188,0.8)',
                'pointRadius' => false,
                'pointColor' => '#3b8bba',
                'pointStrokeColor' => 'rgba(60,141,188,1)',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(60,141,188,1)',
                'data' => $dataCurrentYear,
            ],
            [
                'label' => 'ปีที่แล้ว',
                'backgroundColor' => 'rgba(210, 214, 222, 1)',
                'borderColor' => 'rgba(210, 214, 222, 1)',
                'pointRadius' => false,
                'pointColor' => 'rgba(210, 214, 222, 1)',
                'pointStrokeColor' => '#c1c7d1',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(220,220,220,1)',
                'data' => $dataLastYear,
            ],
        ];

        $responseData = [
            'labels' => $labels,
            'datasets' => $datasets,
        ];

        return response()->json($responseData);
    }

    public function getContractRent(){
        $startDate = Carbon::create(null, 1, 1); // January 1st of the current year
        $endDate = Carbon::now();
        $currentYear = Carbon::now()->year;
        $months = [];
        $dataContractStartdate = [];
        $dataContractEnddate = [];
        $i = 1;
        while ($startDate->lessThanOrEqualTo($endDate)) {
            $months[] = $startDate->format('F');
            $startDate->addMonth();
            $dataContractStartdate[] = Room::join('projects', 'rooms.pid', '=', 'projects.pid')
                ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
                    OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                    $join->on('rooms.pid', '=', 'customers.pid')
                        ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                        ->on('rooms.id', '=', 'customers.rid');
                })
                ->where(function ($query) {
                    $query->where('rooms.Trans_Status', '=', '')
                        ->orWhereNull('rooms.Trans_Status');
                })
                ->whereYear('customers.Contract_Startdate', '=', $currentYear)
                ->whereBetween('customers.Contract_Startdate', [Carbon::create(null, $i, 1) , Carbon::create(null, $i, 31)])->count();

            $dataContractEnddate[] = Room::join('projects', 'rooms.pid', '=', 'projects.pid')
                ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
                    OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                    $join->on('rooms.pid', '=', 'customers.pid')
                        ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                        ->on('rooms.id', '=', 'customers.rid');
                })
                ->where(function ($query) {
                    $query->where('rooms.Trans_Status', '=', '')
                        ->orWhereNull('rooms.Trans_Status');
                })
                ->whereYear('customers.Contract_Enddate', '=', $currentYear)
                ->whereBetween('customers.Contract_Enddate', [Carbon::create(null, $i, 1) , Carbon::create(null, $i, 31)])->count();

            $i++;
        }

        $labels = $months;
        $datasets = [
            [
                'label' => 'หมดสัญญา',
                'backgroundColor' => 'rgba(243, 50, 15)',
                'borderColor' => 'rgba(243, 50, 15)',
                'pointRadius' => false,
                'pointColor' => '#3b8bba',
                'pointStrokeColor' => 'rgba(60,141,188,1)',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(60,141,188,1)',
                'data' => $dataContractEnddate,
            ],
            [
                'label' => 'เริ่มต้นสัญญา',
                'backgroundColor' => 'rgba(11, 205, 4)',
                'borderColor' => 'rgba(11, 205, 4)',
                'pointRadius' => false,
                'pointColor' => 'rgba(11, 205, 4)',
                'pointStrokeColor' => '#c1c7d1',
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => 'rgba(220,220,220,1)',
                'data' => $dataContractStartdate,
            ],
        ];

        $responseData = [
            'labels' => $labels,
            'datasets' => $datasets,
        ];

        return response()->json($responseData);
    }
}
