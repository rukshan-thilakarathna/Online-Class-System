<?php

namespace App\Orchid\Screens\Classes;

use App\Models\Classes;
use App\Models\ClassHasTest;
use App\Models\ClassHasTutes;
use App\Models\ClassHasVideos;
use App\Models\PaymentHasClass;
use App\Models\StudentHasClass;
use App\Models\Videos;
use App\Orchid\Layouts\Classes\ClassesPaymentsListLayout;
use App\Orchid\Layouts\Classes\ClassesStudentsListLayout;
use App\Orchid\Layouts\Classes\ClassesTestListLayout;
use App\Orchid\Layouts\Classes\ClassesTutesListLayout;
use App\Orchid\Layouts\Classes\ClassesVideosLayout;
use App\Orchid\Layouts\Classes\ClassesVideosListLayout;
use App\View\Components\ClassView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Layouts\Modal;
use Orchid\Support\Facades\Layout;

class ClassesViewScreen extends Screen
{
    public $id = 0;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Classes $id): iterable
    {
        $this->id = $id->id;
        $classVideo = ClassHasVideos::where('class_id', $id->id)->with('video', 'class')->get();
        $classTutes = ClassHasTutes::where('class_id', $id->id)->with('tute', 'class')->get();
        $classTest = ClassHasTest::where('class', $id->id)->with('test', 'test.testType','classes')->get();
        $classStudents = StudentHasClass::where('class_id', $id->id)->with('student','paymentHasClass')->get();

        // dd($classStudents);


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
        return 'Classes';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $user = \App\Models\User::find((Auth::user())->id);
        return [
            Link::make(__('Students'))
                ->route('platform.systems.classes.view.student', $this->id),

            Link::make(__('Payments'))
            ->canSee($user->hasAnyAccess(['platform.systems.payment']))
                ->route('platform.systems.classes.view.paymenrs', $this->id),
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
            Layout::component(ClassView::class),
            
            
            ClassesVideosListLayout::class,
            ClassesTutesListLayout::class,
            ClassesTestListLayout::class,
            

            Layout::modal('Change Open Month', [
                Layout::rows([
                    Select::make('month')
                        ->title('Open Month')
                        ->placeholder('Select Open Month')
                        ->options([
                            '1' => 'January',
                            '2' => 'February',
                            '3' => 'March',
                            '4' => 'April',
                            '5' => 'May',
                            '6' => 'June',
                            '7' => 'July',
                            '8' => 'August',
                            '9' => 'September',
                            '10' => 'October',
                            '11' => 'November',
                            '12' => 'December',

                        ])
                ]),
            ]),

           
        ];
    }

    public function remove(Request $request)
    {
        // First, ensure you find the correct record based on both class_id and video_id
        $classHasVideo = ClassHasVideos::where('class_id', $request->get('class_id'))
                                       ->where('video_id', $request->get('video_id'))
                                       ->firstOrFail();
    
        // Now that you have the correct instance, delete it
        $classHasVideo->delete();
    
        // Notify the user about successful deletion
        Alert::info('Successfully Removed');
    }
    
    public function removeTute(Request $request)
    {
        // First, ensure you find the correct record based on both class_id and video_id
        $classHasVideo = ClassHasTutes::where('class_id', $request->get('class_id'))
                                       ->where('tute_id', $request->get('tutes_id'))
                                       ->firstOrFail();
    
        // Now that you have the correct instance, delete it
        $classHasVideo->delete();
    
        // Notify the user about successful deletion
        Alert::info('Successfully Removed');
    }
    
    public function removetest(Request $request)
    {
        // First, ensure you find the correct record based on both class_id and video_id
        $ClassHasTest = ClassHasTest::where('class', $request->get('class_id'))
                                       ->where('test', $request->get('tests_id'))
                                       ->firstOrFail();
    
        // Now that you have the correct instance, delete it
        $ClassHasTest->delete();
    
        // Notify the user about successful deletion
        Alert::info('Successfully Removed');
    }

    public function ChangeOpenMonth(Request $request)
    {   
        $classHassTutes = ClassHasTutes::where('id', $request->get('id'))->first();

        $classHassTutes->month_number = $request->get('month');
        $classHassTutes->save();


       
        // Notify the user about successful deletion
        Alert::info('Successfully Changed Open Month');
    }

   
    
    
}
