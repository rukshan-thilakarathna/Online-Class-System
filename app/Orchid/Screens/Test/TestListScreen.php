<?php

namespace App\Orchid\Screens\Test;

use App\Jobs\ProcessTestQuestionsJob;
use App\Models\Classes;
use App\Models\ClassHasTest;
use App\Models\QandA;
use App\Models\Test;
use App\Models\TestType;
use App\Orchid\Layouts\Test\TestListLayout;
use App\Orchid\Layouts\Test\TestSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Layouts\Modal;
use Orchid\Support\Color;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class TestListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {

        $test = Test::with('testType')->defaultSort('id', 'desc')
                ->filtersApplySelection(TestSelection::class)
                ->filters()
                ->paginate(10);


        return [
            'test' => $test
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Test List';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Create Test')
            ->modal('Create Test')
            ->method('CreateTestMethod')
            ->icon('bs.book'),
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
            // Layout::rows([
            //     Group::make([
            //         Input::make('name')
            //             ->title('Test Name')
            //             ->placeholder('Enter your Test name')
            //             ->help('Enter your Test name.')
            //             ->type('text')
            //             ->required()
            //             ->horizontal(),

            //         Select::make('test_type')
            //             ->fromModel(TestType::class, 'name','id')
            //             ->title('Test Type')
            //             ->placeholder('Select Test Type')
            //             ->help('Select your Test Type.')
            //             ->required()
            //             ->horizontal(),
            //     ]),
            //     Group::make([
            //         Select::make('open_class')
            //             ->fromModel(Classes::class, 'name','id')
            //             ->title('Open Class')
            //             ->placeholder('Select Class')
            //             ->help('Select Open Class.')
            //             ->multiple()
            //             ->horizontal(),

            //         Input::make('test_time')
            //             ->title('Test Time')
            //             ->placeholder('Enter Time (MINUTES)')
            //             ->help('Enter Time (MINUTES).')
            //             ->type('number')
            //             ->required()
            //             ->horizontal(),
            //     ]),
            //     Group::make([
            //         Input::make('marks')
            //             ->title('Marks')
            //             ->placeholder('Enter Marks')
            //             ->help('Enter Marks.')
            //             ->type('number')
            //             ->value(100)
            //             ->required()
            //             ->horizontal(),

            //         Input::make('file')
            //             ->type('file')
            //             ->title('Upload excel File')
            //             ->required()
            //             ->horizontal(),
            //     ]),

            //     Button::make('Cteate New Test')
            //         ->method('CreateTestMethod')
            //         ->style('width: 100%;display: flex;align-items: center;justify-content: center;background: #AA81A0 !important;color: white !important;font-weight: bold;')
            //         ->type(Color::BASIC),
            // ])->title('Create Test'),
            TestSelection::class,
            TestListLayout::class,
            Layout::modal('Create Test', [
                Layout::rows([

                    Input::make('name')
                        ->title('Test Name')
                        ->placeholder('Enter your Test name')
                        ->help('Enter your Test name.')
                        ->type('text')
                        ->required()
                        ->horizontal(),

                    Select::make('test_type')
                        ->fromModel(TestType::class, 'name','id')
                        ->title('Test Type')
                        ->placeholder('Select Test Type')
                        ->help('Select your Test Type.')
                        ->required()
                        ->horizontal(),

                    Select::make('open_class')
                        ->fromModel(Classes::class, 'name','id')
                        ->title('Open Class')
                        ->placeholder('Select Class')
                        ->help('Select Open Class.')
                        ->multiple()
                        ->horizontal(),

                    Input::make('test_time')
                        ->title('Test Time')
                        ->placeholder('Enter Time (MINUTES)')
                        ->help('Enter Time (MINUTES).')
                        ->type('number')
                        ->required()
                        ->horizontal(),

                    Input::make('marks')
                        ->title('Marks')
                        ->placeholder('Enter Marks')
                        ->help('Enter Marks.')
                        ->type('number')
                        ->value(100)
                        ->required()
                        ->horizontal(),

                    Input::make('file')
                        ->type('file')
                        ->title('Upload excel File')
                        ->required()
                        ->horizontal(),
                    
                    Input::make('discription')
                        ->title('Discription')
                        ->placeholder('Enter Discription')
                        ->help('Enter Discription.')
                        ->type('text')
                        ->horizontal(),
                ]),
            ]) ->size(Modal::SIZE_LG),

            Layout::modal('Test Has Class or Classes', [
                Layout::rows([
                    Select::make('class')
                        ->fromModel(Classes::class, 'name','id')
                        // ->required()
                        ->multiple(),
                    Input::make('id')
                        ->type('hidden'),
                ]),
            ]) ->size(Modal::SIZE_LG)->async('asyncGetClass')
        ];
    }

    public function asyncGetClass(Test $test): iterable
    {
        $class = ClassHasTest::where('test', $test->id)->select('class')->get();

        $classes = [];

        foreach ($class as $key => $value) {
            $classes[] = $value->class;
        }   

        return [
            'class' => $classes,
            'id' => $test->id,
        ];
    }

    public function classesHasTest(Request $request): void
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'class' => 'exists:classes,id',
        ]);

        ClassHasTest::where('test', $request->get('id'))->delete();

        if(!empty($request->get('class'))) {
            foreach ($request->get('class') as $key => $value) {
                ClassHasTest::create([
                    'class' => $value,
                    'test' => $request->get('id'),
                    'month_number' => date('n'),
                ]);
            }
        }

        

        Toast::info('Test Class Updated successfully.');
    }

    public function CreateTestMethod(Request $request): void
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'test_type' => 'required|exists:test_types,id',
            'open_class' => 'exists:classes,id',
            'test_time' => 'required|integer|min:1',
            'marks' => 'required|integer|min:0',
            'file' => 'required|file',
        ]);
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Define the target directory
            $destinationPath = public_path('test_files');
            // Generate a unique file name (optional)
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Move the uploaded file to the desired location
            $file->move($destinationPath, $fileName);
        
            // Set the file path to be stored in the database
            $filePath = 'test_files/' . $fileName;
        } else {
            $filePath = null; // If no file is uploaded, set it to null
        }
        
        // Create the new Test record
        $test = Test::create([
            'name' => $validatedData['name'],
            'test_type_id' => $validatedData['test_type'],
            'open_class' => 1,
            'test_time' => $validatedData['test_time'],
            'marks' => $validatedData['marks'],
            'xml_file' => $filePath,
            'description' => $request['discription'],
        ]);
        
    
        if (!empty($validatedData['open_class'])) {
            foreach ($validatedData['open_class'] as $open_class) {
                ClassHasTest::create([
                    'test' => $test->id,
                    'class' => $open_class,
                    'month_number' => date('n'),
                ]);
            }
        }
    
        // Dispatch job to process test questions
        ProcessTestQuestionsJob::dispatch($test);
    
        Toast::info('Test created successfully and processing queued.');
    }


    public function remove(Request $request): void
    {

        if($request->get('isdelete')){
             Test::findOrFail($request->get('id'))->delete();
        QandA::where('test_id', $request->get('id'))->delete();

        Toast::info(__('Test was removed'));
        }else{
            $test = Test::findOrFail($request->get('id'));
            $test->status = $request->get('status');
            $test->save();

            Toast::info(__('Test status was changed'));
            // dd($request);
        }
       
        
    }

   
}
