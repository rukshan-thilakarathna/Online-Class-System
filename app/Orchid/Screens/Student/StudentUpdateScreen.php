<?php

namespace App\Orchid\Screens\Student;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as FacadesLayout;

class StudentUpdateScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Student $id): iterable
    {
        return [
            'student' => $id
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Student Update';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
{
    return [

        FacadesLayout::rows([

            Group::make([
                
                Input::make('student.student_id')
                    ->type('number')
                    ->required()
                    ->title('Student ID'),

                Input::make('student.class_type')
                    ->type('text')
                    ->title('Class Type'),
            ]),
            Group::make([
                Input::make('student.first_name')
                    ->type('text')
                    ->required()
                    ->title('First Name'),

                Input::make('student.last_name')
                    ->type('text')
                    ->required()
                    ->title('Last Name'),
            ]),
            Group::make([
                Input::make('student.email')
                    ->type('email')
                   
                    ->title('Email'),

                Input::make('student.phone_number')
                    ->type('text')
                    ->required()
                    ->title('Phone Number'),
            ]),
            Group::make([
                Input::make('password')
                    ->type('password')
                    ->title('Password'),

               
                Select::make('student.grade')
                    ->fromModel(Grade::class, 'name','id')
                    ->title('Grade or Grades')
                    ->placeholder('Select class Grade')
                    ->help('Select Grade or Grades')
                    ->required(),
            ]),
            Group::make([
                Input::make('student.whatsapp_number')
                    ->type('text')
                    ->type('hidden'),
                    Input::make('student.id')
                    ->type('hidden'),

            ]),
            Group::make([
                Input::make('student.address')
                    ->type('textarea')
                    ->title('Address'),

                Input::make('student.birthday')
                    ->type('date')
                    ->title('Birthday'),
            ]),
            Group::make([
                Select::make('student.gender')
                    ->options([
                        '0' => 'Male',
                        '1' => 'Female',
                    ])
                    ->title('Gender'),

                Select::make('status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->required()
                    ->title('Status'),
            ]),

            Button::make('Submit')
            ->method('UpdateStudentMethod')
            ->style('width: 100%;display: flex;align-items: center;justify-content: center;background: #AA81A0 !important;color: white !important;font-weight: bold;')
            ->type(Color::BASIC),


        ])
        
    ];
}

public function UpdateStudentMethod(Request $request)
{
    $validatedData = $request->validate([
        'student.first_name' => 'required|string|max:255',
        'student.last_name' => 'required|string|max:255',
        'student.phone_number' => 'required|numeric|digits_between:10,15|unique:students,phone_number,' . request('student.id'),

        'student.gender' => 'required|in:0,1',
        
    ]);

    $student = Student::find(request('student.id'));

    $student->update([
        'student_id' => request('student.student_id'),
        'class_type' => request('student.class_type'),
        'first_name' => request('student.first_name'),
        'last_name' => request('student.last_name'),
        'email' => request('student.email'),
        'phone_number' => request('student.phone_number'),
        'password' => Hash::make(request('password')),
        'grade' => request('student.grade'),
        'whatsapp_number' => request('student.whatsapp_number'),
        'address' => request('student.address'),
        'birthday' => request('student.birthday'),
        'gender' => request('student.gender'),
        'status' => request('status'),
    ]);

    Alert::info('Student Updated Successfully');



}

}
