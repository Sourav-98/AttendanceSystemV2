<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QRGeneratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $req){
           $lec_id = $req->input("lec_id");
           DB::table('attendance')->where('lec_id', $lec_id)->update(['attd_taken'=>0]);
           $date = date('d/m/y');
           $code = $lec_id."--".$date;
           $code = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($code))))));
           return view('teacher.genqr', compact(['code', 'lec_id']));
    }
}
