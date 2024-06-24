<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function getStatus(){
        $projects = Project::select('pid as project_id', 'Project_Name')
            ->where('rent', 1)
            ->orderBy('Project_Name', 'asc')
            ->get();
 
        return response()->json(['data' => $projects], 200);
    }

    public function getStatusRoom(){
        $status = Room::select('status_room')
            ->distinct()
            ->whereNotIn('status_room', ['', 'คืนห้อง'])
            ->orderBy('status_room', 'ASC')
            ->get();

        return response()->json(['data' => $status], 200);
    }


    public function searchRental(Request $request){
        $rents = Room::select(
            'projects.Project_Name',
            'rooms.id',
            'rooms.pid',
            'rooms.Create_Date',
            'rooms.HomeNo',
            'rooms.RoomNo',
            'rooms.RoomType',
            'rooms.Location',
            'rooms.rental_status',
            'rooms.Electric_Contract',
            'rooms.Size',
            'rooms.Owner',
            'rooms.Status_Room',
            'rooms.Phone',
            'rooms.Phone as phone_owner',
            'rooms.price',
            'rooms.price as room_price',
            'rooms.Trans_Status',
            'rooms.contract_owner',
            'rooms.Owner',
            'rooms.Guarantee_Startdate',
            'rooms.Guarantee_Enddate',
            'rooms.date_firstrend',
            'rooms.date_endrend',
            'rooms.Other',
            'customers.id as cid',
            'customers.Contract_Status',
            'customers.Contract_Startdate',
            'customers.Contract_Enddate',
            'customers.Cus_Name',
            'customers.contract_cus',
            'customers.Phone as phone_cus',
            'customers.Price as price_cus'

        )
            ->from('rooms as rooms')
            ->join('projects', 'rooms.pid', '=', 'projects.pid')
            ->leftJoin(DB::raw('(SELECT * FROM customers WHERE Contract_Status = "เช่าอยู่"
        OR Contract_Status IS NULL OR Contract_Status = "") AS customers'), function ($join) {
                $join->on('rooms.pid', '=', 'customers.pid')
                    ->on('rooms.RoomNo', '=', 'customers.RoomNo')
                    ->on('rooms.id', '=', 'customers.rid');
            })
            // ->whereRaw('ifnull(rooms.status_room, "") <> ?', ['คืนห้อง'])
            ->where(function ($query) {
                $query->where('rooms.Trans_Status', '=', '')
                    ->orWhereNull('rooms.Trans_Status');
            });

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

        if ($request->Cusmoter) {
            $rents->where('customers.Cus_Name', 'LIKE', '%' . $request->Cusmoter . '%');
        }

        if ($request->typerent != 'all') {
            $rents->where('rooms.rental_status', $request->typerent);
        }

        if ($request->status != 'all') {
            if ($request->status == "เช่าอยู่") {
                $rents->where('customers.Contract_Status', $request->status);
            }else{
                $rents->where('rooms.Status_Room', $request->status);
            }
        }else{
            $rents->whereRaw("IFNULL(status_room, '') <> 'คืนห้อง'");
        }

        if ($request->dateselect && $request->startdate) {
            if ($request->dateselect == "transfer_date") {
                if ($request->enddate != null) {
                    $rents->whereBetween('rooms.Transfer_Date', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('rooms.Transfer_Date', [$request->startdate, $request->startdate]);
                }
            } elseif ($request->dateselect == "Guarantee_Startdate") {
                if ($request->enddate != null) {
                    $rents->whereBetween('rooms.Guarantee_Startdate', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('rooms.Guarantee_Startdate', [$request->startdate, $request->startdate]);
                }
            } elseif ($request->dateselect == "Guarantee_Enddate") {
                if ($request->enddate != null) {
                    $rents->whereBetween('rooms.Guarantee_Enddate', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('rooms.Guarantee_Enddate', [$request->startdate, $request->startdate]);
                }
            } elseif ($request->dateselect == "Contract_Startdate") {
                if ($request->enddate != null) {
                    $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->startdate]);
                }
            }elseif ($request->dateselect == "Payment_date") {
                $new_date = date('Y-m-d', strtotime($request->startdate . ' -1 year'));
                $new_date = date('Y-m-01', strtotime($new_date));
                if ($request->enddate != null) {
                    $rents->whereBetween('customers.Contract_Startdate', [$new_date, $request->enddate]);
                } else {
                    $rents->whereBetween('customers.Contract_Startdate', [$request->startdate, $request->startdate]);
                }
            }elseif ($request->dateselect == "Cancle_Date") {
                if ($request->enddate != null) {
                    $rents->whereBetween('customers.Cancle_Date', [$request->startdate, $request->enddate]);
                } else {
                    $rents->whereBetween('customers.Cancle_Date', [$request->startdate, $request->startdate]);
                }
            }else{
                // $rents->whereBetween('rooms.Create_Date', [$request->startdate, $request->enddate]);
                $rents->where('rooms.Create_Date', '<=',$request->enddate);
                // $rents->where('rooms.Create_Date', '<=', '2024-06-21');
            }
        }

        // $rentsCount = $rents->count();

        $rents = $rents
            ->orderBy('Project_Name', 'asc')
            ->get();

        return response()->json(['data' => $rents], 200);
    }


    public function exampleGetApiInController(Request $request){
        $formInputs = $request->all();
        // $response = Http::post('https://example.com/api/search-rental', $formInputs);
        $response = Http::post('http://127.0.0.1:8000/api/search-rental', $formInputs);
        if ($response->successful()) {
            dd(response()->json($response->json()));
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Failed to fetch data'], $response->status());
        }
    }
}

