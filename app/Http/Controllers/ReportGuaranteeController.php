<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Product;
use App\Models\Project;
use App\Models\Quarantee;
use App\Models\Role_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportGuaranteeController extends Controller
{
    public function index(){
        // $dataLoginUser = User::with('role_position:id,name')->where('id', Session::get('loginId'))->first();
        // $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();

        $projects = Project::selectRaw("DISTINCT CASE WHEN lh_rise IS NULL THEN 99 ELSE pid END AS pid")
                    ->selectRaw("CASE WHEN lh_rise IS NULL THEN 'อื่น ๆ' ELSE Project_Name END AS Project_Name")
                    ->orderBy('Project_Name', 'ASC')
                    ->get();
        $activeBanks = Bank::where('Status', '1')->get();

        return view(
            'report_guarantee.index',
            compact(
                'dataLoginUser',
                'isRole',
                'projects',
                'activeBanks'
            )
        );
    }

    public function search(Request $request){
        $dataLoginUser = User::where('user_id', Session::get('loginId'))->first();
        $isRole = Role_user::where('user_id', Session::get('loginId'))->first();
        $projects = Project::selectRaw("DISTINCT CASE WHEN lh_rise IS NULL THEN 99 ELSE pid END AS pid")
                    ->selectRaw("CASE WHEN lh_rise IS NULL THEN 'อื่น ๆ' ELSE Project_Name END AS Project_Name")
                    ->orderBy('Project_Name', 'ASC')
                    ->get();
        $activeBanks = Bank::where('Status', '1')->get();
        $month = $request->monthly;
        $pid = $request->pid;
        $bid = $request->bid;
        $search_date = '%'.substr($request->monthly, 0,7).'%';
        $banks_id = $request->bid;

        if ($request->pid == 'All') {
            $whereConditions = '';
        }else{
            $whereConditions = 'products.project_id = ' . $request->pid. ' AND ';
        }

        $str_banks = '';
        if ($request->monthly != '' && $request->bid == '0' && $request->p != '' && $request->np != '' && $request->fp != '') {
          // Condition 1: No bank id specified
        } elseif ($request->monthly != '' && $request->bid != 0 && $request->p != '' && $request->np != '' && $request->fp != '') {
          // Condition 2: Bank id specified
          $str_banks = 'products.bank_id_quarantee = '.$banks_id.' AND ';
        } elseif ($request->p != '' && $request->np != '' && $request->bid == '0') {
          // Condition 3: No bank id specified, other parameters provided
          $str_banks = '(amount > 0 OR amount IS NULL) AND ';
        } elseif ($request->p != '' && $request->np != '' && $request->bid != '0') {
          // Condition 4: Bank id specified, other parameters provided
          $str_banks = 'products.bank_id_quarantee = '.$banks_id.' AND (amount > 0 OR amount IS NULL) AND ';
        } elseif ($request->p != '' && $request->fp != '' && $request->bid == '0') {
          // Condition 5: No bank id specified, other parameters provided
          $str_banks = '(amount > 0 OR amount = 0) AND ';
        } elseif ($request->p != '' && $request->fp != '' && $request->bid != '0') {
          // Condition 6: Bank id specified, other parameters provided
          $str_banks = 'products.bank_id_quarantee = '.$banks_id.' AND (amount > 0 OR amount = 0) AND ';
        } elseif ($request->np != '' && $request->fp != '' && $request->bid == '0') {
          // Condition 7: No bank id specified, other parameters provided
          $str_banks = '(amount IS NULL OR amount = 0) AND ';
        } elseif ($request->np != '' && $request->fp != '' && $request->bid != '0') {
          // Condition 8: Bank id specified, other parameters provided
          $str_banks = 'products.bank_id_quarantee = '.$banks_id.' AND (amount IS NULL OR amount = 0) AND ';
        } elseif ($request->p != '' && $request->bid == '0') {
          // Condition 9: No bank id specified, other parameters provided
          $str_banks = 'amount > 0 AND ';
        } elseif ($request->p != '' && $request->bid != '0') {
          // Condition 10: Bank id specified, other parameters provided
          $str_banks = 'products.bank_id_quarantee ='.$banks_id.' AND amount > 0 AND ';
        } elseif ($request->np != '' && $request->bid == '0') {
          // Condition 11: No bank id specified, other parameters provided
          $str_banks = 'amount IS NULL AND ';
        } elseif ($request->np != '' && $request->bid != '0') {
          // Condition 12: Bank id specified, other parameters provided
          $str_banks = 'products.bank_id_quarantee ='.$banks_id.' AND amount IS NULL AND ';
        } elseif ($request->fp != '' && $request->bid == '0') {
          // Condition 13: No bank id specified, other parameters provided
          $str_banks = 'amount = 0 AND ';
        } elseif ($request->fp != '' && $request->bid != '0') {
          // Condition 14: Bank id specified, other parameters provided
          $str_banks = 'products.bank_id_quarantee ='.$banks_id.' AND amount = 0 AND ';
        }

        $quarantees = Quarantee::select(
            'a.*',
            'b.date_new'
        )
        ->from(DB::raw('(
            SELECT a.*
            FROM (
                SELECT
                    quarantees.due_date_amount,
                    quarantees.pid,
                    quarantees.create_date,
                    quarantees.id,
                    quarantees.due_date,
                    quarantees.amount_fix,
                    products.gauranteeamount,
                    projects.Project_Name,
                    products.name,
                    REPLACE(products.RoomNo, "-", "") AS RoomNo,
                    products.gauranteestart,
                    products.gauranteeend,
                    quarantees.amount,
                    quarantees.payment_date,
                    banks.Code AS bank_name,
                    products.bank_id_quarantee,
                    products.bank_acc_quarantee,
                    products.loan_account_number1,
                    products.loan_account_number2,
                    products.loan_account_number3
                FROM quarantees
                LEFT JOIN products ON quarantees.pid = products.pid
                LEFT JOIN projects ON products.project_id = projects.pid
                LEFT JOIN banks ON products.bank_id_quarantee = banks.id
                WHERE '.$whereConditions.' '.$str_banks.' quarantees.due_date LIKE "'.$search_date.'"
                    AND status_quarantee = "enabled"
                    AND products.status = "Mortgaged"
            ) AS a
            INNER JOIN (
                SELECT MAX(create_date) AS create_date, pid
                FROM quarantees
                WHERE status_quarantee = "enabled"
                GROUP BY pid
            ) AS b ON a.create_date = b.create_date AND a.pid = b.pid
        ) AS a'))
        ->leftJoin(DB::raw('(
            SELECT (
                SELECT DISTINCT payment_date
                FROM quarantees
                WHERE DATE_FORMAT(due_date, "%Y%m") = DATE_FORMAT(DATE_ADD(a.due_date, INTERVAL -1 MONTH), "%Y%m")
                    AND status_quarantee = "enabled"
                    AND pid = a.pid
            ) AS date_new, a.pid
            FROM (
                SELECT
                    quarantees.due_date_amount,
                    quarantees.pid,
                    quarantees.create_date,
                    quarantees.id,
                    quarantees.due_date,
                    quarantees.amount_fix,
                    products.gauranteeamount,
                    projects.Project_Name,
                    products.name,
                    products.RoomNo,
                    products.gauranteestart,
                    products.gauranteeend,
                    quarantees.amount,
                    quarantees.payment_date,
                    banks.Code AS bank_name,
                    products.bank_id_quarantee,
                    products.bank_acc_quarantee,
                    products.loan_account_number1,
                    products.loan_account_number2,
                    products.loan_account_number3
                FROM quarantees
                LEFT JOIN products ON quarantees.pid = products.pid
                LEFT JOIN projects ON products.project_id = projects.pid
                LEFT JOIN banks ON products.bank_id_quarantee = banks.id
                WHERE '.$whereConditions.' '.$str_banks.' quarantees.due_date LIKE "'.$search_date.'"
                    AND status_quarantee = "enabled"
                    AND products.status = "Mortgaged"
            ) AS a
            INNER JOIN (
                SELECT MAX(create_date) AS create_date, pid
                FROM quarantees
                WHERE status_quarantee = "enabled"
                    AND create_date IS NOT NULL
                GROUP BY pid
            ) AS b ON a.create_date = b.create_date AND a.pid = b.pid
        ) AS b'), 'a.pid', '=', 'b.pid')
        ->orderBy('a.Project_Name')
        ->orderBy('a.RoomNo')
        ->get();

        // dd($quarantees);
        return view(
          'report_guarantee.search',
          compact(
              'dataLoginUser',
              'isRole',
              'quarantees',
              'projects',
              'activeBanks',
              'month',
              'pid',
              'bid'
          )
      );
    }

    public function updateBank(Request $request,$pid,$bankId,$bankName){

      $product = Product::where('pid', $pid)
        ->update([
            'bank_id_quarantee' => $bankId,
            'bank_acc_quarantee' => $bankName,
        ]);

      return response()->json([
        'data' => $product,
        'message' => 'อัพเดทข้อมูลสำเร็จ'], 200);
    }

    public function saveData(Request $request){
        // dd('=====================');
        // dd($request->amount_check);

        // กรณีเงินเท่ากับค่างวด
        if($request->amounts == $request->amount_check){
          $count = DB::table('quarantees')
            ->where('pid', $request->pid)
            ->where('create_date', $request->create_date)
            ->where('status_quarantee', 'enabled')
            ->count();
          // dd($count);
            for ($i=1; $i <= $count; $i++) {
              $idRows = ($request->id - 1) + $i;
              // dump($idRows);
              // dd('=========================');
              if($i == 1){
                Quarantee::where('id', $idRows)
                ->where('status_quarantee', 'enabled')
                ->update([
                    'due_date_amount' => $request->amount_check,
                    'amount' => $request->amounts,
                    'payment_date' => $request->date_payments
                ]);
              }else{
                Quarantee::where('id', $idRows)
                ->where('status_quarantee', 'enabled')
                ->update([
                    'due_date_amount' => $request->gauranteeamount,
                    'amount' => 'DEFAULT',
                    'payment_date' => 'DEFAULT'
                ]);
              }
            }

        //กรณีเงินมากกว่าค่างวด
        }elseif ($request->amounts > $request->amount_check) {
          $quarantee = Quarantee::where('pid', $request->pid)
            ->where('create_date', $request->create_date)
            ->where('id', $request->id)
            ->where('status_quarantee', 'enabled')
            ->orderBy('id', 'ASC')
            ->first();
          $n = $request->amounts - $quarantee->due_date_amount;
          $count_num_row = ceil($n / $request->gauranteeamount)+1;
          $sum_Money = $request->sum_Money;
          for ($i=1; $i <= $count_num_row ; $i++) {
            $id_rows = ($request->id-1)+$i;
            // dump($id_rows);
            // dd('=========================');
            $quaLimit = DB::table('quarantees')
              ->where('pid', $request->pid)
              ->where('create_date', $request->create_date)
              ->where('id', $id_rows)
              ->where('status_quarantee', 'enabled')
              ->orderBy('id', 'DESC')
              ->first();

              $sum_Money += $quaLimit->due_date_amount;
              $result_sum_Money = ($request->amounts - $sum_Money)+$quaLimit->due_date_amount;

              if ($i == 1) {
                $amounts_insert = $request->amounts;
                DB::table('quarantees')
                  ->where('id', $id_rows)
                  ->where('status_quarantee', 'enabled')
                  ->update([
                      'amount' => $amounts_insert,
                      'payment_date' => $request->date_payments
                  ]);
              }elseif (($i<=$count_num_row-1)&&($i!=1)) {
                $amounts_insert = 0;
                DB::table('quarantees')
                  ->where('id', $id_rows)
                  ->where('status_quarantee', 'enabled')
                  ->update([
                      'amount' => $amounts_insert,
                      'payment_date' => $request->date_payments
                  ]);
              }elseif ($result_sum_Money == $quaLimit->due_date_amount) {
                $amounts_insert = 0;
                DB::table('quarantees')
                  ->where('id', $id_rows)
                  ->where('status_quarantee', 'enabled')
                  ->update([
                      'amount' => $amounts_insert,
                      'payment_date' => $request->date_payments
                  ]);
              }else {
                $amounts_insert = $quarantee->due_date_amount-$result_sum_Money;
                DB::table('quarantees')
                  ->where('id', $id_rows)
                  ->where('status_quarantee', 'enabled')
                  ->update([
                      'due_date_amount' => $amounts_insert
                  ]);
              }
          }
        }elseif ($request->amounts < $request->amount_check) {
          // error

          dd('error');
          // echo "<script>alert('กรุณาระบุค่างวดขั้นต่ำ ".number_format($_POST['amount_check'])." บาท');</script>";
        }

        // insert log quarantee

        return redirect()->route('report.guarantee');
    }

}
