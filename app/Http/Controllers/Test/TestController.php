<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\QandA;
use App\Models\StudentHasTest;
use App\Models\Test;
use App\Models\testMarkingHistory;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function TestSubmit(Request $request)
    {
        // return $request->all();

        $qna = QandA::where('test_id', $request->get('test_id'))->get();
        $test = Test::where('id', $request->get('test_id'))->first();

        foreach ($qna as $key => $value) {
           $testhistory = new testMarkingHistory();
           $testhistory->test_id = $request->get('test_id');
           $testhistory->Qanda_id = $value->id;
           $testhistory->student_id = Session()->get('user_id');
           $testhistory->student_answer = $request->get('q'.$value->id);
           $testhistory->marks = $request->get('q'.$value->id) == $value->correct_answer ? $value->marks : 0;;
           $testhistory->correct_answer = $value->correct_answer;
           $testhistory->status = $request->get('q'.$value->id) == $value->correct_answer ? 1 : 0;
           $testhistory->save();
        }

        $get_result = testMarkingHistory::where('test_id', $request->get('test_id'))->where('student_id', Session()->get('user_id'))->get();

        $total_marks = 0;
        foreach ($get_result as $key => $value) {
            $total_marks = $total_marks + $value->marks;
        }

        $totalcroct = 0;
        foreach ($get_result as $key => $value) {
            if ($value->status == 1) {
                $totalcroct = $totalcroct + 1;
            }
        }

        $marksPrasentage = $total_marks / intval($test->marks) * 100;

        switch ($marksPrasentage) {

            case $marksPrasentage >= 75:
                $result = 'A';
                break;
            case $marksPrasentage >= 65 && $marksPrasentage <= 74:
                $result = 'B';
                break;
            case $marksPrasentage >= 50 && $marksPrasentage <= 64:
                $result = 'C';
                break;
            case $marksPrasentage >= 35 && $marksPrasentage <= 49:
                $result = 'S';
                break;
            case $marksPrasentage < 34:
                $result = 'W';
                break;
        }

        $student_test = new StudentHasTest();
        $student_test->student_id = Session()->get('user_id');
        $student_test->test_id = $request->get('test_id');
        $student_test->class_id = $request->get('class_id');
        $student_test->full_marks = intval($test->marks);
        $student_test->get_marks = $total_marks;
        $student_test->start_time = 0;
        $student_test->end_time = 0;
        $student_test->marks_percentage = $marksPrasentage;
        $student_test->status = $result;
        $student_test->save();

        $data = [
            'QA' => $qna,
            'test' => $test,
        ];

        $result = true;

        $QA = $data;
        $class_id = $request->get('class_id');

        return redirect()->route('classes.profile',$class_id);

    }

}
