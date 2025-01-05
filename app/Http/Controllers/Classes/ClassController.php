<?php

namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassHasTest;
use App\Models\ClassHasTutes;
use App\Models\ClassHasVideos;
use App\Models\PaymentHasClass;
use App\Models\QandA;
use App\Models\StudentHasClass;
use App\Models\Test;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function GetStudentHasClass(){

        $studentHasClass = StudentHasClass::where('student_id',session()->get('user_id'))->with('class','student')->get();

        return $studentHasClass;
    }

    public function RelatedClass(){

        $userHasClass = StudentHasClass::where('student_id',session()->get('user_id'))->with('class','student')->get();
        $userclassid = [];
        foreach ($userHasClass as $key => $value) {

            $userclassid[] = $value->class_id;
        }


        $classtype = session()->get('user')->class_type == 'online' ? 1 : 2;
        $RelatedClass = Classes::where('grade', 'like', '%' . session()->get('user')->grade . '%')->where('class_type', $classtype)->whereNotIn('id', $userclassid)->get();

        return $RelatedClass;
    }

    public function ClassProfile($id){
        $class = Classes::where('id', $id)->first();
        $payment = PaymentHasClass::where('class_id', $id)->where('student_id', session()->get('user_id'))->first();
        $studentHasClass = StudentHasClass::where('student_id',session()->get('user_id'))->where('class_id', $id)->with('class','student')->first();

    

        $accsessmonth = explode(',', $studentHasClass->video_access);

        $videos = ClassHasVideos::where('class_id', $id)->WhereIn('month_number', $accsessmonth)->with('video', 'class')->get();
        $tests = ClassHasTest::where('class', $id)->WhereIn('month_number', $accsessmonth)->with('test','test.testType', 'classes')->get();
        $tutes = ClassHasTutes::where('class_id', $id)->WhereIn('month_number', $accsessmonth)->with('tute', 'class')->get();

        $number = date('m');
$numberWithoutZero = ltrim($number, '0'); // Result: "1"

        $data = [
            'class' => $class,
            'payment_status' => $payment[$numberWithoutZero],
            'videos' => $videos,
            'tests' => $tests,
            'tutes' => $tutes
        ];
        return $data;
    }

    public function StartTest($id){
        $QA = QandA::where('test_id', $id)->get();
        $test = Test::where('id', $id)->first();

        $data = [
            'QA' => $QA,
            'test' => $test,
        ];
        return $data;
    }


}
