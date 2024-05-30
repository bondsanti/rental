<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Role_user;
use App\Models\Room;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
// use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function index(Request $request)
    {

        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();

        $projects = Project::where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();

        $status = $request->input('status', 'all');

        // ดึงปีปัจจุบัน
        $currentYear = Carbon::now()->year;

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
            ->whereRaw('ifnull(rooms.status_room, "") <> ?', ['คืนห้อง'])
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('rooms.date_endrend', '=', $currentYear);

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
        }
        $rents = $query
            ->orderBy('Project_Name', 'ASC')
            ->get();
        // นับจำนวนห้องในแต่ละสถานะ
        $readyCount = Room::where('Status_Room', 'พร้อมอยู่')
            ->whereRaw('ifnull(rooms.status_room, "") <> ?', ['คืนห้อง'])
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('date_endrend', '=', $currentYear)
            ->count();

        $notReadyCount = Room::whereIn('Status_Room', ['ไม่พร้อมอยู่', 'รอคลีน', 'รอตรวจ', 'รอเฟอร์'])
            ->whereRaw('ifnull(rooms.status_room, "") <> ?', ['คืนห้อง'])
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('date_endrend', '=', $currentYear)
            ->count();

        $occupiedCount = Room::whereIn('Status_Room', ['สวัสดิการ', 'ห้องออฟฟิต', 'เช่าอยู่'])
            ->whereRaw('ifnull(rooms.status_room, "") <> ?', ['คืนห้อง'])
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('date_endrend', '=', $currentYear)
            ->count();

        $alreadyCount = Room::where('Status_Room', 'อยู่แล้ว')
            ->whereRaw('ifnull(rooms.status_room, "") <> ?', ['คืนห้อง'])
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('date_endrend', '=', $currentYear)
            ->count();
        // นับจำนวนห้องทั้งหมด
        $totalCount = Room::whereRaw('ifnull(rooms.status_room, "") <> ?', ['คืนห้อง'])
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            })
            ->whereYear('rooms.date_endrend', '=', $currentYear)
            ->count();


        return view('main.index', compact(
            'rents',
            'dataLoginUser',
            'projects',
            'status',
            'readyCount',
            'notReadyCount',
            'occupiedCount',
            'alreadyCount',
            'totalCount'
        ));
    }
}
