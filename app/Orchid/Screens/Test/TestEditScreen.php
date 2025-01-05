<?php

namespace App\Orchid\Screens\Test;

use App\Models\ClassHasTest;
use App\Models\QandA;
use App\Models\Test;
use App\Models\TestType;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;

class TestEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Test $id): iterable
    {
        return [
            'data' => $id
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Test Update Screen';
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
            Layout::rows([

                Input::make('data.name')
                    ->title('Test Name')
                    ->placeholder('Enter your Test name')
                    ->help('Enter your Test name.')
                    ->type('text')
                    ->required()
                    ->horizontal(),

                Select::make('data.test_type_id')
                    ->fromModel(TestType::class, 'name','id')
                    ->title('Test Type')
                    ->placeholder('Select Test Type')
                    ->help('Select your Test Type.')
                    ->required()
                    ->horizontal(),


                Input::make('data.test_time')
                    ->title('Test Time')
                    ->placeholder('Enter Time (MINUTES)')
                    ->help('Enter Time (MINUTES).')
                    ->type('number')
                    ->required()
                    ->horizontal(),

                Input::make('data.marks')
                    ->title('Marks')
                    ->placeholder('Enter Marks')
                    ->help('Enter Marks.')
                    ->type('number')
                    ->required()
                    ->horizontal(),

                Input::make('file')
                    ->type('file')
                    ->title('Upload XML File')
                    ->horizontal(),
                
                Input::make('data.description')
                    ->title('Discription')
                    ->placeholder('Enter Discription')
                    ->help('Enter Discription.')
                    ->type('text')
                    ->horizontal(),

                    Input::make('data.id')
                    ->type('hidden')
                    ->horizontal(),

                Button::make('Submit')
                    ->method('UpdateMethod')
                    ->style('width: 100%;display: flex;align-items: center;justify-content: center;background: #AA81A0 !important;color: white !important;font-weight: bold;')
                    ->type(Color::BASIC),
            ]),
        ];
    }

    public function UpdateMethod(Request $request)
    {

        // Validate the incoming request data
        $validatedData = $request->validate([
            'data.name' => 'required|string|max:255',
            'data.test_type_id' => 'required|exists:test_types,id',
            'data.test_time' => 'required|integer|min:1',
            'data.marks' => 'required|integer|min:0',
        ]);

        // Check if a file has been uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Store the uploaded file in the 'test_files' directory
            $filePath = $file->store('test_files', 'public'); 
        }
        $test = Test::find($request['data']['id']);

        // Create a new Test entry in the database
        $test->update([
            'name' => $validatedData['data']['name'],
            'test_type_id' => $validatedData['data']['test_type_id'],
            'test_time' => $validatedData['data']['test_time'],
            'marks' => $validatedData['data']['marks'],
            'xml_file' => $filePath ?? $test->xml_file, 
            'description' => $request['data']['description'],
        ]);


        QandA::where('test_id', $request['data']['id'])->delete();

            $excelFilePath = public_path('/storage/'.$test->xml_file);
            $spreadsheet = IOFactory::load($excelFilePath); 

            // Get the active sheet or specify a specific sheet
            $sheet = $spreadsheet->getActiveSheet();

            // Initialize an array to hold the quiz question
            $quiz = [];

            foreach ($sheet->getRowIterator() as $row) {
                
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
            
                // Initialize question data array
                $questionData = [];
                $answerData = [];
            
                foreach ($cellIterator as $cell) {
                    $cellValue = $cell->getValue();
            
                    // Customize how you read each cell for question and answers
                    // Assuming column layout:
                    // A = Question, B = Correct Answer, C = Answer 1, D = Answer 2, E = Answer 3, F = Answer 4
            
                    if ($cell->getColumn() == 'A') {
                        $questionData['question'] = $cellValue;
                    } elseif ($cell->getColumn() == 'B') {
                        $questionData['correct_answer'] = $cellValue;
                        $answerData[] = $cellValue;
                    } elseif ($cell->getColumn() == 'C') {
                        $answerData[] = $cellValue;
                    } elseif ($cell->getColumn() == 'D') {
                        $answerData[] = $cellValue;
                    } elseif ($cell->getColumn() == 'E') {
                        $answerData[] = $cellValue;
                    } elseif ($cell->getColumn() == 'F') {
                        $answerData[] = $cellValue;
                    }
                }
            
                $questionData['answers'] = $answerData;
                $quiz[] = $questionData;
            }

            // Calculate marks and time allocation for each question
            $mark = $test->marks / count($quiz);
            $time = $test->test_time / count($quiz);


            foreach ($quiz as $questionData) {
                $question = new QandA();
                $question->question = $questionData['question'];
                $question->answer_1 = $questionData['answers'][0];
                $question->answer_2 = $questionData['answers'][1];
                $question->answer_3 = $questionData['answers'][2] ?? 'null';
                $question->answer_4 = $questionData['answers'][3] ?? 'null';
                $question->answer_5 = $questionData['answers'][4] ?? 'null';
                $question->correct_answer = $questionData['correct_answer'];
            
                // Set additional properties for the question
                $question->type_id = $test->test_type_id;
                $question->test_id = $test->id;
                $question->image = 0; // Placeholder for image (not used in this example)
                $question->marks = $mark; // Set marks for the question
                $question->time = $time; // Set time for the question
                $question->status = 1; // Active status
            
                // Save the question to the database
                $question->save();
            }



       Alert::info('You have successfully updated.');
       return redirect()->route('platform.systems.test');
        
      
    }
}
