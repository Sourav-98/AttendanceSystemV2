<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    public static function get_attendance_data($std_usn){
        $lec_attd = DB::table('attendance')->join('lectures', 'lectures.lec_id', '=', 'attendance.lec_id')->join('subjects', 'lectures.sub_code', '=', 'subjects.sub_code')->where('attendance.std_usn', $std_usn)->get();
        return $lec_attd;
    }
}
