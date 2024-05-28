<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Role_user;
use App\Models\Room;
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

        return view('main.index', compact(
            'dataLoginUser',
        ));
    }
}
