<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Student;
use App\Teacher;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->user_id;
        if(Auth::user()->type == "student"){
            $attd_data = Student::get_attendance_data($user_id);  //use the student email to query the database
            return view('student.home')->with('attendance_data', $attd_data);
        }
        else{
            $attd_list = Teacher::get_attendance_list($user_id);
            $sub_list = Teacher::get_subject_list($user_id);
            return view('teacher.home', compact(['attd_list', 'sub_list']));
        }
    }

    public function attendance_taken(Request $req){     //for teacher
        $lec_id = $req->input('lec_id');
        $std_list = DB::table('attendance')->where('lec_id', $lec_id)->get();
        $lec_taken = false;
        $std_count=0;
        foreach($std_list as $std){
            if($std->attd_taken == 1){
                $lec_taken = true;
                $std_count++;
            }
        }
        if($lec_taken){
            DB::table('lectures')->where('lec_id', $lec_id)->increment('lec_count');
        }
        DB::table('attendance')->where('lec_id', $lec_id)->where('attd_taken', 1)->increment('attd_count');
        DB::table('attendance')->where('lec_id', $lec_id)->update(['attd_taken' => 0]);
        if($lec_taken){
            $msg = "Lecture Taken!";
        }
        else{
            $msg = "Lecture Not Taken!";
        }
        return redirect('/home')->with(['msg' => $msg, 'lec_taken' => $lec_taken, 'std_count' => $std_count]);
    }

    public function attendance_given(Request $req){     // for student
        $data =  ($req->input('result'));
        $data = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data))))));
        $std_usn = Auth::user()->user_id;
        $lec_id = (int)strtok($data, "--");
        $date = strtok("--");
        $msg = "QR Code Invalid!";
        $feedback = 0;
        $attd_data = DB::table('attendance')->where('std_usn', $std_usn)->where('lec_id', $lec_id)->get();
        if(sizeof($attd_data)==0){
            return redirect('/home')->with(['msg' => 'QR Code Invalid!', 'feedback' => -1]);
        }
        else{
            if($date == date('d/m/y')){     // if date in qr code is same as current date
                $attd_taken_bit = DB::table('attendance')->where('std_usn', $std_usn)->where('lec_id', $lec_id)->value('attd_taken');
                if($attd_taken_bit == 0){
                    DB::table('attendance')->where('std_usn', $std_usn)->where('lec_id', $lec_id)->increment('attd_taken');
                    
                }
                return redirect('/home')->with(['msg' => 'Attendance Taken', 'feedback' => 1]);
            }
        }
    }
}
