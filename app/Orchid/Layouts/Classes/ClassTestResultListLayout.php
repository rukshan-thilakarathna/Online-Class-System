<?php

namespace App\Orchid\Layouts\Classes;

use App\Models\StudentHasTest;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClassTestResultListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'result';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

            TD::make('student_id', 'Student Number')
            ->width('50px')
            ->render(function (StudentHasTest $studentHasTest) {
                return $studentHasTest->student->student_id; 
            })
            ->sort(),

            TD::make('student_name', 'Student Name')
            ->width('150px')
            ->render(function (StudentHasTest $studentHasTest) {
                return $studentHasTest->student->first_name . ' ' . $studentHasTest->student->last_name; 
            })
            ->sort(),

           TD::make('test_name', 'Test Name')
            ->width('150px')
            ->render(function (StudentHasTest $studentHasTest) {
                return $studentHasTest->test->name;
            })
            ->sort(),

            TD::make('full_marks', 'Full Marks')
            ->width('50px')
            ->render(function (StudentHasTest $studentHasTest) {
                return $studentHasTest->full_marks;
            }),


            TD::make('get_marks', 'Get Marks')
            ->width('50px')
            ->render(function (StudentHasTest $studentHasTest) {
                return $studentHasTest->get_marks;
            })
            ->filter(TD::FILTER_TEXT)
            ->sort(),

            TD::make('marks_percentage', 'Percentage')
            ->width('50px')
            ->render(function (StudentHasTest $studentHasTest) {
                return $studentHasTest->marks_percentage.'%';
            })
            ->filter(TD::FILTER_TEXT)
            ->sort(),

            TD::make('status','Result')
            ->width('50px')
            ->render(function (StudentHasTest $studentHasTest) {
                return $studentHasTest->status;
            })
            ->filter(TD::FILTER_TEXT)
            ->sort(),


        ];
    }
}
