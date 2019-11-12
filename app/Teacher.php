<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    public static function get_subject_list($tec_id){
        $sub_list = DB::table('lectures')->join('subjects', 'lectures.sub_code', '=', 'subjects.sub_code')->where('lectures.tec_id', $tec_id)->get();
        return $sub_list;
    }
    public static function get_attendance_list($tec_id){
        $attd_list = DB::table('teachers')->join('lectures', 'lectures.tec_id', '=', 'teachers.tec_id')->join('attendance', 'lectures.lec_id', '=', 'attendance.lec_id')->join('students', 'students.std_usn', '=', 'attendance.std_usn')->where('lectures.tec_id', $tec_id)->get();;
        return $attd_list;
    }
}
