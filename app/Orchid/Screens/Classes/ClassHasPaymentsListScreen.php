<?php

namespace App\Orchid\Screens\Classes;

use Orchid\Screen\Screen;
use App\Models\Classes;
use App\Models\ClassHasTest;
use App\Models\ClassHasTutes;
use App\Models\ClassHasVideos;
use Orchid\Support\Facades\Alert;
use App\Models\PaymentHasClass;
use App\Models\StudentHasClass;
use App\Orchid\Layouts\Classes\ClassesPaymentsListLayout;
use Orchid\Screen\Fields\Select;
use Illuminate\Http\Request;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use Orchid\Screen\Actions\Link as ActionsLink;
use Orchid\Support\Facades\Layout;

class ClassHasPaymentsListScreen extends Screen
{

    public $id;
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
        return 'Payments';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ActionsLink::make('Back')->icon('arrow-left')->route('platform.systems.classes.view', $this->id),
            ActionsLink::make(__('Students'))
                ->route('platform.systems.classes.view.student', $this->id),

        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ClassesPaymentsListLayout::class,
            Layout::modal('Paid or Free Card', [
                Layout::rows([
                    Select::make('paidandfree')
                        ->placeholder('Select Paid or Free Card')
                        ->options([
                            '1' => 'Paid',
                            '3' => 'Free Card',
                        ])
                    ]),
                ]),
            Layout::modal('Paid or Remove Access', [
                Layout::rows([
                    Select::make('paidandremove')
                        ->placeholder('Select Paid or Free Card')
                        ->options([
                            '1' => 'Paid',
                            '0' => 'Remove Access',
                        ])
                    ]),
                ])
        ];
    }

    public function removePayment(Request $request)
    {
        // Find the payment record
        $paymentHasClass = PaymentHasClass::where('id', $request->get('payment_id'))
                                          ->firstOrFail();
    
        $monthNumber = $request->get('month_number');
        $paymentHasClass->{$monthNumber} = 0;

        $studentHasClass = StudentHasClass::where('student_id', $request->get('student_id'))->where('class_id', $request->get('class_id'))->firstOrFail();
        $video = explode(',', $studentHasClass->video_access);
        $test = explode(',', $studentHasClass->test_access);
        $tute = explode(',', $studentHasClass->tute_access);

        $video = array_diff($video, [$monthNumber]);
        $test = array_diff($test, [$monthNumber]);
        $tute = array_diff($tute, [$monthNumber]);
        $studentHasClass->video_access = implode(',', $video);
        $studentHasClass->test_access = implode(',', $test);
        $studentHasClass->tute_access = implode(',', $tute);
    
        $studentHasClass->save();
        $paymentHasClass->save();

        Alert::info('Successfully removed payment');

    }

    public function ApprovalPayment(Request $request)
    {


        $studentHasClass = StudentHasClass::where('student_id', $request->get('student_id'))->where('class_id', $request->get('class_id'))->firstOrFail();
        $video = explode(',', $studentHasClass->video_access);
        $test = explode(',', $studentHasClass->test_access);
        $tute = explode(',', $studentHasClass->tute_access);
        

        if($request->paidandremove == '1'){ 
            $paymentHasClass = PaymentHasClass::where('id',$request->get('payment_id'))->firstOrFail();
        $monthNumber = $request->get('month_number');
        $paymentHasClass->{$monthNumber} = 1;

            $video = array_merge($video, [$monthNumber]);
            $test = array_merge($test, [$monthNumber]);
            $tute = array_merge($tute, [$monthNumber]);
            $studentHasClass->video_access = implode(',', array_filter($video));
            $studentHasClass->test_access = implode(',', array_filter($test));
            $studentHasClass->tute_access = implode(',', array_filter($tute));  

        }elseif($request->paidandremove == '0'){

            $paymentHasClass = PaymentHasClass::where('id',$request->get('payment_id'))->firstOrFail();
        $monthNumber = $request->get('month_number');
        $paymentHasClass->{$monthNumber} = 0;

            $video = array_diff($video, [$monthNumber]);
            $test = array_diff($test, [$monthNumber]);
            $tute = array_diff($tute, [$monthNumber]);
            $studentHasClass->video_access = implode(',', array_filter($video));
        $studentHasClass->test_access = implode(',', array_filter($test));
        $studentHasClass->tute_access = implode(',', array_filter($tute)); 
            
        }
        

        $studentHasClass->save();
        $paymentHasClass->save();

        Alert::info('Successfully ');

    }
    

    public function NotPaid(Request $request)
    {

        $paymentHasClass = PaymentHasClass::where('id', $request->get('payment_id'))->firstOrFail();
        $monthNumber = $request->get('month_number');
        $paymentHasClass->{$monthNumber} = $request->paidandfree;

        $studentHasClass = StudentHasClass::where('student_id', $request->get('student_id'))->where('class_id', $request->get('class_id'))->firstOrFail();
        $video = explode(',', $studentHasClass->video_access);
        $test = explode(',', $studentHasClass->test_access);
        $tute = explode(',', $studentHasClass->tute_access);

        $video = array_merge($video, [$monthNumber]);
        $test = array_merge($test, [$monthNumber]);
        $tute = array_merge($tute, [$monthNumber]);
        $studentHasClass->video_access = implode(',', array_filter($video));
        $studentHasClass->test_access = implode(',', array_filter($test));
        $studentHasClass->tute_access = implode(',', array_filter($tute));   

      
        $studentHasClass->save();
        $paymentHasClass->save();
        Alert::info('Successfully removed payment');

    }
}
