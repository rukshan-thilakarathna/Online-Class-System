<?php

namespace App\Orchid\Layouts\Student;

use App\Models\Student;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TodayBirthDayListLayout extends Table
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

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make(__('Actions'))
                ->width('200px')
                ->align(TD::ALIGN_CENTER)
                ->render(function ($model) {
                    $phone = $model->phone_number; 
                    $countryCode = $model->c_code; // Add your country code here (94 for Sri Lanka)
                    $cleanPhone = preg_replace('/[^0-9]/', '', $phone); // Clean phone number (remove non-numeric characters)

                    // Combine country code and phone number
                    $fullPhone = $countryCode . $cleanPhone;

                    $name = $model->first_name;
                    $message = rawurlencode("
                        Hello {$name}, 
                        Happy Birthday!  Wishing you a wonderful day filled with joy and happiness.
                        Your loving English Teacher 
                        Asela S. Rathnayaka");

                    $whatsappLink = "https://wa.me/{$fullPhone}?text={$message}";
                
                    return "<a style=\"
                        background: #008dd1;
                        color: white;
                        font-weight: bold;
                        padding: 11px;
                        border-radius: 3px;
                        text-decoration: none;
                    \" href=\"{$whatsappLink}\" target=\"_blank\">{$fullPhone}</a>";
                }),
            TD::make('student_id', 'Student Number')
            ->width('50px')
            ->filter(TD::FILTER_TEXT)
            ->sort()
            ->cantHide(), 
            
            TD::make('class_type', 'Student Class Type')
            ->width('50px')
            ->filter(TD::FILTER_TEXT)
            ->sort()
            ->cantHide(),


            TD::make('first_name', 'First Name')
            ->filter(TD::FILTER_TEXT)
            ->render(fn (Student $student) => '<a href="' . route('platform.systems.students.update', $student->id) . '">' . $student->first_name . '</a>')
            ->sort(),


            TD::make('last_name', 'Last Name')
            ->render(fn (Student $student) => '<a href="' . route('platform.systems.students.update', $student->id) . '">' . $student->last_name . '</a>')
            ->filter(TD::FILTER_TEXT)
            ->sort(),


            TD::make('phone_number', 'Mobile Number')
            ->render(function ($model) {
                $phone = $model->phone_number; 
                $name = $model->name ?? 'there';
                $whatsappLink = "https://wa.me/{$phone}";
                
                return "<a href='{$whatsappLink}' target='_blank'>{$phone}</a>";
            })
            ->filter(TD::FILTER_TEXT)
            ->sort(),

            TD::make('birthday' , 'Birthday')
            ->filter(TD::FILTER_TEXT)
            ->usingComponent(DateTimeSplit::class)
            ->sort(),

            TD::make('address', 'Address')
            ->filter(TD::FILTER_TEXT)
            ->defaultHidden()
            ->width('150px')
            ->sort(),

            TD::make('email', 'Email')
            ->filter(TD::FILTER_TEXT)
            ->defaultHidden()
            ->sort(),

            TD::make('gender', 'Gender')
            ->sort()
            ->render(fn (Student $student) => $student->gender == 0 ? 'Male' : 'Female')
            ->filter(TD::FILTER_SELECT, [
                '' => 'All',
                '0' => 'Male',
                '1' => 'Female'
            ]),

            TD::make('grade' , 'Grade')
            ->sort()
            ->render(fn (Student $student) => 'Grade ' . $student->grade)
            ->filter(TD::FILTER_SELECT, [
                '' => 'All',
                '1' => 'Grade 1',
                '2' => 'Grade 2',
                '3' => 'Grade 3',
                '4' => 'Grade 4',
                '5' => 'Grade 5',
                '6' => 'Grade 6',
                '7' => 'Grade 7',
                '8' => 'Grade 8',
                '9' => 'Grade 9',
                '10' => 'Grade 10',
                '11' => 'Grade 11',
                '12' => 'Grade 12'
            ]),

            TD::make('status', 'Status')
            ->sort()
            ->render(fn (Student $student) => $student->status == 1 ? 'Active' : 'Inactive')
            ->filter(TD::FILTER_SELECT, [
                '' => 'All',
                '1' => 'Active',
                '0' => 'Inactive'
            ]),

            
            

        
            
        ];
    }
}
