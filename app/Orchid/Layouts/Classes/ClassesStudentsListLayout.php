<?php

namespace App\Orchid\Layouts\Classes;

use App\Models\Classes;
use App\Models\ClassHasTest;
use App\Models\StudentHasClass;
use App\Models\Test;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\TD;

class ClassesStudentsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'students';
    protected $title = 'Students in this class';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        $columns_students = [
            TD::make('student.id', 'ID')
                ->width('50px')
                ->cantHide()
                ->filter(TD::FILTER_NUMERIC),

                TD::make('student.student_id', 'Student ID')
                ->width('150px')
                ->filter(TD::FILTER_TEXT),


            TD::make('student.first_name', 'First Name')
                ->width('150px')
                ->filter(TD::FILTER_TEXT),

           
            TD::make('student.last_name', 'Last Name')
                ->width('150px')
                ->filter(TD::FILTER_TEXT),

            TD::make('student.phone_number', 'Phone Number')
                ->width('150px')
                ->filter(TD::FILTER_TEXT),

            TD::make('video_access', 'Video Access')
                ->render(function (StudentHasClass $studentHasClass) {
                    $months = array(
                        1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",
                        7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"
                      );

                     

                      if($studentHasClass->video_access != null){
                        $va = explode(',', $studentHasClass->video_access);
                        $currentMonth = date('n');
                        $text = "<div style='display: flex;background: #c7c7c7;flex-wrap: wrap;padding: 8px;border-radius: 4px;'>";

                        foreach ($va as $mNumber) {
                            $color = ($mNumber == $currentMonth) ? 'color: red;' : '';
                            $text .= '<span style="font-weight: bold;width:48%;'. $color .'">'.$months[$mNumber].'</span>';
                          }
    
                        //   $text = rtrim($text, ' / ');
                           $text .= '</div>';
                        //   $text .= '</div>
                        //     <button 
                        //     style="background: #6d6d6d;margin-top: 4px;border-radius: 4px;color: white;" 
                        //     type="button"
                        //     class="btn btn-link icon-link" 
                        //     formaction="'.env('APP_URL').'/admin/classes/view/student/133/ChangeVideoAccess?id='.$studentHasClass->id.'&amp;colom=video_access" 
                        //     id="field-video-access-a266a0502de565ba4fbd75ef290e9582f5f88588" 
                        //     data-controller="modal-toggle" 
                        //     data-action="click->modal-toggle#targetModal" 
                        //     data-modal-toggle-title="Video Access Control" 
                        //     data-modal-toggle-key="VideoAccessModal" 
                        //     data-modal-toggle-async="true" 
                        //     data-modal-toggle-params="{&quot;id&quot;:'.$studentHasClass->id.',&quot;colom&quot;:&quot;video_access&quot;}" 
                        //     data-modal-toggle-action="'.env('APP_URL').'/admin/classes/view/student/133/ChangeVideoAccess?id='.$studentHasClass->id.'&amp;colom=video_access" 
                        //     data-modal-toggle-open="">
                        //         <span>Video Access Control</span>
                        //     </button>';
    
                          return $text;
                      }else{
                        return '<span style="color: red;">No Access</span>';
                      }

                      
                })
                ->width('200px'),

            TD::make('tute_access', 'Tute Access')
                ->render(function (StudentHasClass $studentHasClass) {
                    $months = array(
                        1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",
                        7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"
                    );

                   if($studentHasClass->tute_access != null){
                        $va = explode(',', $studentHasClass->tute_access);
                        $currentMonth = date('n');
                        $text = "<div style='display: flex;background: #c7c7c7;flex-wrap: wrap;padding: 8px;border-radius: 4px;'>";

                        foreach ($va as $mNumber) {
                        $color = ($mNumber == $currentMonth) ? 'color: red;' : '';
                        $text .= '<span style="font-weight: bold;width:48%;'. $color .'">'.$months[$mNumber].'</span>';
                        }
                        $text .= '</div>';
                        

                        return $text;
                    }else{
                        return '<span style="color: red;">No Access</span>';
                    }
                })
                ->width(200),

            TD::make('test_access', 'Test Access')
            ->width(200)
                ->render(function ( $studentHasClass) {
                    $months = array(
                        1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",
                        7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"
                    );

                    if($studentHasClass->test_access != null){
                        $va = explode(',', $studentHasClass->test_access);
                        $currentMonth = date('n');
                        $text = "<div style='display: flex;background: #c7c7c7;flex-wrap: wrap;padding: 8px;border-radius: 4px;'>";

                        foreach ($va as $mNumber) {
                        $color = ($mNumber == $currentMonth) ? 'color: red;' : '';
                        $text .= '<span style="font-weight: bold;width:48%;'. $color .'">'.$months[$mNumber].'</span>';
                        }
                        $text .= '</div>';
                       
                        return $text;
                    }else{
                        return '<span style="color: red;">No Access</span>';
                    }
                }),

                TD::make(__('Test Result '))
                    ->width('100px')
                    ->align(TD::ALIGN_CENTER)
                    ->render(function (StudentHasClass $classHasTest) {
                        $class = $classHasTest->class;
                        $student = $classHasTest->student;

                        // Retrieve all tests for the class
                        $tests = ClassHasTest::where('class', $class->id)->with('testdata')->get();

                        // Generate the links for each testgft5
                        $links = [];
                        foreach ($tests as $test1) {
                            $links[] = Link::make($test1->testdata->name)
                                ->route('platform.systems.classes.test-result', [$class->id, $test1->testdata->id, $student->id]);
                        }


                        // Return the DropDown with the generated links
                        return DropDown::make()
                            ->icon('bs.three-dots-vertical')
                            ->list($links); // Pass the $links array directly
                }),

        ];

        // Months array
        // $months = [
        //     1 => 'Jan', 2 => 'Feb', 3 => 'Mar',
        //     4 => 'Apr', 5 => 'May', 6 => 'Jun',
        //     7 => 'Jul', 8 => 'Aug', 9 => 'Sep',
        //     10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
        // ];

        // // Get the current month number
        // $currentMonth = date('n');
        // $columnsPayments = [];

        // // Dynamically create payment columns for each month
        // foreach ($months as $monthNumber => $monthName) {
        //     $columnsPayments[] = TD::make("paymentHasClass.$monthNumber", $monthName)
        //         ->align(TD::ALIGN_CENTER)
        //         ->render(function (StudentHasClass $studentHasClass) use ($monthNumber) {
        //             $payments = $studentHasClass->paymentHasClass;

        //             // Payment status badges
        //             switch ($payments[$monthNumber]) {
        //                 case 1:
        //                     return Button::make(__('Paid'))
        //                         ->applyButton('asdas')
        //                         ->style('background: #32c90c;color: #040000;padding: 6px 10px;border-radius: 6px;')
        //                         ->confirm(__('Are you sure you want to remove this payment?'))
        //                         ->method('removePayment', [
        //                             'payment_id' => $payments->id,
        //                             'month_number' => $monthNumber
        //                         ]);
        //                 case 2:
        //                     return '<span style="background: #d6fd0d;color: black;padding: 10px 10px;" class="badge badge-warning">Pending Approval</span>';
        //                 case 3:
        //                     return '<span style="background: #0024a9;color: #ffffff;padding: 10px 10px;" class="badge badge-danger">Free Card</span>';
        //                 default:
        //                     return '<span style="background: #eb0202;color: #ffffff;padding: 10px 10px;" class="badge badge-secondary">Not Paid</span>';
        //             }
        //         })
        //         ->sort()
        //         ->filter(TD::FILTER_SELECT, [
        //             '' => 'All',
        //             '1' => 'Paid',
        //             // Add other filter options if necessary
        //         ])
        //         ->style($monthNumber == $currentMonth ? 'background-color: #c7c7c7;' : ''); // Set gray background for current month
        // }

        // Merge student columns and payment columns
        return $columns_students;
    }
}
