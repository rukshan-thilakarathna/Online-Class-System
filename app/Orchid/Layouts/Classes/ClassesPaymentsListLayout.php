<?php

namespace App\Orchid\Layouts\Classes;

use App\Models\Payment;
use App\Models\StudentHasClass;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClassesPaymentsListLayout extends Table
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
    protected $title = 'Payments made to this class';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
         // Months array
         $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar',
            4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep',
            10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
        ];
        $columnsPayments = [
            TD::make('student.id', 'ID')
                ->width('50px')
                ->cantHide()
                ->filter(TD::FILTER_NUMERIC),

            TD::make('student.first_name', 'First Name')
                ->width('150px')
                ->filter(TD::FILTER_TEXT),
        ];

        // Get the current month number
        $currentMonth = date('n');

        // Rearrange the array to start with the current month while preserving keys
        $months = array_slice($months, $currentMonth - 1, null, true) // Months from current month to December
                + array_slice($months, 0, $currentMonth - 1, true);   // Months from January to the month before the current month
        


 

        // Dynamically create payment columns for each month
        foreach ($months as $monthNumber => $monthName) {
            $columnsPayments[] = TD::make("paymentHasClass.$monthNumber", $monthName)
                ->align(TD::ALIGN_CENTER)
                ->render(function (StudentHasClass $studentHasClass) use ($monthNumber) {
                    $payments = $studentHasClass->paymentHasClass;


                    $slip = Payment::where('user_id', $payments->student_id)
                                ->where('class_id', $payments->class_id)
                                ->where('month_id', $monthNumber)
                                ->first();

                           

             
                   $out = '';

                    // Payment status badges
                    switch ($payments[$monthNumber]) {
                        case 1:
                            if($studentHasClass->student->class_type == 'online'  && $slip != null){
                                $out .= '<a href="' . asset('/slip/' . $slip->slip) . '" target="_blank" style="background: #000000; color: #ffffff; padding: 5px 10px; margin-bottom: 10px; font-size: 12px;" class="badge badge-warning">Slip</a>' ;
                            }
                            $out .=  Button::make(__('Paid'))
                            ->applyButton('asdas')
                            ->style('background: #186a03;color: #ffffff;padding: 0px 10px;border-radius: 6px;')
                            ->confirm(__('Are you sure you want to remove this payment?'))
                            ->method('removePayment', [
                                'payment_id' => $payments->id,
                                'student_id' => $payments->student_id,
                                'class_id' => $payments->class_id,
                                'month_number' => $monthNumber
                            ]);
                            return $out;

                                
                        case 2:
                            if($studentHasClass->student->class_type == 'online'  && $slip != null){
                                    $out .= '<a href="' . asset('/slip/' . $slip->slip) . '" target="_blank" style="background: #000000; color: #ffffff; padding: 5px 10px; margin-bottom: 10px; font-size: 12px;" class="badge badge-warning">Slip</a>' ;
                                }

                                $out .=  ModalToggle::make('Pending')
                                ->modal('Paid or Remove Access')
                                ->style('background: #e3b32d;color: #ffffff;padding: 0px 10px;border-radius: 6px; ')
                                ->method('ApprovalPayment', [
                                   'payment_id' => $payments->id,
                                   'student_id' => $payments->student_id,
                                   'class_id' => $payments->class_id,
                                   'month_number' => $monthNumber
                                    ]);
                              return  $out;
                              
                              
                             
                                
                        case 3:
                            return '<span style="background: #0024a9;color: #ffffff;padding: 5px 10px;" class="badge badge-danger">Free Card</span>';
                        default:
                            // return '<span style="background: #eb0202;color: #ffffff;padding: 5px 10px;" class="badge badge-secondary">Not Paid</span>';
                             return  ModalToggle::make('Not Paid')
                             ->modal('Paid or Free Card')
                             ->style('background: #eb0202;color: #ffffff;padding: 0px 10px;border-radius: 6px; ')
                             ->method('NotPaid', [
                                'payment_id' => $payments->id,
                                'student_id' => $payments->student_id,
                                'class_id' => $payments->class_id,
                                'month_number' => $monthNumber
                            ]);
                    }
                })
                ->filter(TD::FILTER_SELECT, [
                    '' => 'All',
                    '1' => 'Paid',
                    '2' => 'Pending Approval',
                    '3' => 'Free Card',
                    '0' => 'Not Paid',
                    // Add other filter options if necessary
                ])
                ->style($monthNumber == $currentMonth ? 'background-color: #c7c7c7;' : ''); // Set gray background for current month
        }
        return $columnsPayments;
    }
}
