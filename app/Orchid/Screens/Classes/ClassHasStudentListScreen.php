<?php

namespace App\Orchid\Screens\Classes;

use Orchid\Screen\Screen;
use App\Models\Classes;
use App\Models\ClassHasTest;
use App\Models\ClassHasTutes;
use App\Models\ClassHasVideos;
use App\Models\PaymentHasClass;
use App\Models\Student;
use App\Models\StudentHasClass;
use App\Orchid\Layouts\Classes\ClassesStudentsListLayout;
use Illuminate\Http\Request;
use Orchid\Alert\Toast;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast as FacadesToast;

class ClassHasStudentListScreen extends Screen
{

    public $id;
    public $type;
    public $type_name;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array  
     */
    public function query(Classes $id): iterable
    {
        $classVideo = ClassHasVideos::where('class_id', $id->id)->with('video', 'class')->get();
        $classTutes = ClassHasTutes::where('class_id', $id->id)->with('tute', 'class')->get();
        $classTest = ClassHasTest::where('class', $id->id)->with('test', 'test.testType','classes')->get();
        $classStudents = StudentHasClass::where('class_id', $id->id)->with('student','paymentHasClass')->get();

        // dd($classStudents);
        $this->id = $id->id;
        $this->type = $id->class_type;
        $this->type_name = $this->type == 1 ? 'online' : 'physical';
        




        return [
            'name' => $id,
            'videos' => $classVideo,
            'tutes' => $classTutes,
            'tests' => $classTest,
            'students' => $classStudents
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Students';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Back')->icon('arrow-left')->route('platform.systems.classes.view', $this->id),
            Link::make(__('Payments'))->route('platform.systems.classes.view.paymenrs', $this->id),
            ModalToggle::make('Add Student')
                ->modal('AddStudent')
                // ->cansee($this->type == 2)
                ->modalTitle('Add Student')
                ->method('AddStudent',['class_id' => $this->id]),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $months = [
            1 => "January", 
            2 => "February", 
            3 => "March", 
            4 => "April", 
            5 => "May", 
            6 => "June", 
            7 => "July", 
            8 => "August", 
            9 => "September", 
            10 => "October", 
            11 => "November", 
            12 => "December" 
        ];
    
        return [
            ClassesStudentsListLayout::class,

            Layout::modal('AddStudent', [
                Layout::rows([
                    Select::make('student_id')
                    ->fromQuery(
                        Student::selectRaw("id, CONCAT(first_name, ' ', last_name, ' (', student_id, ')') as full_name")
                               ->where('class_type', $this->type_name),
                       
                        'full_name'
                    )
                    ->title('Select Student'),
                    
                ]),
            ]),
            Layout::modal('VideoAccessModal', [
                Layout::rows([
                    Select::make('array.month')
                        ->options($months) 
                        ->multiple() 
                        ->title('Select Months'),
                    Input::make('id')
                        ->type('hidden'),
                    Input::make('colom')
                        ->type('hidden'),
                ]),
            ])->async('asyncGetData'),
            Layout::modal('TuteAccessModal', [
                Layout::rows([
                    Select::make('array.month')
                        ->options($months) 
                        ->multiple() 
                        ->title('Select Months'),
                    Input::make('id')
                        ->type('hidden'),
                    Input::make('colom')
                        ->type('hidden'),
                ]),
            ])->async('asyncGetData'),
            Layout::modal('TestAccessModal', [
                Layout::rows([
                    Select::make('array.month')
                        ->options($months) 
                        ->multiple() 
                        ->title('Select Months'),
                    Input::make('id')
                        ->type('hidden'),
                    Input::make('colom')
                        ->type('hidden'),
                ]),
            ])->async('asyncGetData'),
        ];
    }
    
    public function asyncGetData(StudentHasClass $id, $colom): array
    {
        $studentHasClass = StudentHasClass::where('id', $id->id)->select($colom)->first(); 

        return [
            'array' => [
                'month' => explode(',', $studentHasClass->$colom), // Preselect some options (January, February, August, May)
            ],
            'id' => $id->id,
            'colom' => $colom

        ];
    }

    public function ChangeVideoAccess(Request $request)
    {
        $array = $request->array['month'];
        $string = implode(',', $array);

        StudentHasClass::where('id', $request->id)->update([$request->colom => $string]);

        Alert::info('Successfully changed access');

       

    }

    public function AddStudent(Request $request){

        $PaymentHasClass = New PaymentHasClass();
        $PaymentHasClass->class_id = $request->class_id;
        $PaymentHasClass->student_id = $request->student_id;
        $PaymentHasClass->save();

        $studentHasClass = new StudentHasClass();
        $studentHasClass->class_id = $request->class_id;
        $studentHasClass->student_id = $request->student_id;
        $studentHasClass->payment_has_classes_id = $PaymentHasClass->id;
        $studentHasClass->save();

        FacadesToast::info('Successfully added student');
       
    }

}
