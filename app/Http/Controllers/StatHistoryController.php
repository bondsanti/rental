<?php

namespace App\Http\Controllers;

use App\Models\Role_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StatHistoryController extends Controller
{
    public function index(){
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        return view(
            'summary.history',
            compact(
                'dataLoginUser',
                'isRole',
            )
        );
    }

    public function search(Request $request){
        $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $monthly = $request->monthly;
        $results = DB::table(DB::raw("(SELECT DISTINCT pr.pid, r.pid AS project_id, p.Project_Name, r.id AS rid, r.HomeNo, r.RoomNo, rental_status
                                FROM rooms AS r
                                INNER JOIN projects p ON p.pid = r.pid
                                INNER JOIN customers c ON c.rid = r.id
                                LEFT JOIN (SELECT * FROM products WHERE status = 'Mortgaged') AS pr ON pr.project_id = r.pid
                                    AND TRIM(pr.Homeno) = TRIM(r.HomeNo)
                                    AND REPLACE(TRIM(r.RoomNo), '-', '') = REPLACE(TRIM(pr.RoomNo), '-', '')
                                WHERE IFNULL(r.Trans_Status, '') NOT IN ('del', 'off') AND c.Contract_Status = 'เช่าอยู่') AS a"))
            ->select('a.*', DB::raw('IFNULL(b.paid_r, 0) AS paid_r'), DB::raw('IFNULL(b.total_r, 0) AS total_r'), DB::raw('IFNULL(q.paid_q, 0) AS paid_q'), DB::raw('IFNULL(q.total_q, 0) AS total_q'))
            ->leftJoin(DB::raw("(SELECT rid, SUM(paid) AS paid_r, SUM(amount) AS total_r
                                FROM (
                                        SELECT rid, cid, SUM(CASE WHEN Payment_Date1 <= '$monthly'  THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date2 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date3 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date4 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date5 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date6 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date7 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date8 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date9 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date10 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date11 <= '$monthly' THEN 1 ELSE 0 END
                                                + CASE WHEN Payment_Date12 <= '$monthly' THEN 1 ELSE 0 END
                                        ) AS paid,
                                        SUM(CASE WHEN Payment_Date1 <= '$monthly' THEN Due1_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date2 <= '$monthly' THEN Due2_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date3 <= '$monthly' THEN Due3_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date4 <= '$monthly' THEN Due4_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date5 <= '$monthly' THEN Due5_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date6 <= '$monthly' THEN Due6_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date7 <= '$monthly' THEN Due7_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date8 <= '$monthly' THEN Due8_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date9 <= '$monthly' THEN Due9_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date10 <= '$monthly' THEN Due10_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date11 <= '$monthly' THEN Due11_Amount ELSE 0 END
                                            + CASE WHEN Payment_Date12 <= '$monthly' THEN Due12_Amount ELSE 0 END
                                        ) AS amount
                                        FROM payments
                                        GROUP BY rid, cid
                                    ) AS paid
                                GROUP BY rid
                                ) AS b"), 'a.rid', '=', 'b.rid')
            ->leftJoin(DB::raw("(SELECT pid, COUNT(*) AS paid_q, SUM(amount) AS total_q
                                FROM `quarantees`
                                WHERE payment_date <= '$monthly'
                                GROUP BY pid) AS q"), 'q.pid', '=', 'a.pid')
            ->orderBy('Project_Name')
            ->orderBy('RoomNo')
            ->get();
            
        return view(
            'summary.search_history',
            compact(
                'dataLoginUser',
                'isRole',
                'monthly',
                'results'
            )
        );
        
    }
}
