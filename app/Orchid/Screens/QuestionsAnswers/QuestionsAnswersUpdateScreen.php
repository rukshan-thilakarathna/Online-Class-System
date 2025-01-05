<?php

namespace App\Orchid\Screens\QuestionsAnswers;

use App\Models\QandA;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Color;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class QuestionsAnswersUpdateScreen extends Screen
{
    public $answer = [];
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(QandA $id): iterable
    {

        $this->answer = [
            $id->answer_1 => $id->answer_1,
            $id->answer_2 => $id->answer_2,
            $id->answer_3 => $id->answer_3,
            $id->answer_4 => $id->answer_4,
            $id->answer_5 => $id->answer_5,
        ];
        return [
            'data' => $id,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'QuestionsAnswersUpdateScreen';
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
            layout::rows([
                Group::make([
                    Input::make('data.question')
                        ->title('Question')
                        ->type('text')
                        ->required(),

                    Input::make('data.answer_1')
                        ->title('Answer 1')
                        ->type('text')
                        ->required(),
                ]),    
                Group::make([
                    Input::make('data.answer_2')
                        ->title('Answer 2')
                        ->type('text')
                        ->required(),
                        
                    Input::make('data.answer_3')
                        ->title('Answer 3')
                        ->type('text')
                        ->required(),
                        
                ]),

                Group::make([
                    
                    Input::make('data.answer_4')
                        ->title('Answer 4')
                        ->type('text')
                        ->required(),

                      

                    Input::make('data.answer_5')
                        ->title('Answer 5')
                        ->type('text')
                        ->required(),

                ]),   

                Group::make([
                    Select::make('data.correct_answer')
                        ->title('Correct Answer')
                        ->options($this->answer)
                        ->required(),

                    Input::make('image')
                        ->type('file')
                        ->title('Upload Image'),

                ]),

                Group::make([
                    Select::make('data.status')
                        ->options([
                            1 => 'Active',
                            // 0 => 'Unactive',
                        ])
                        ->title('Select status'),

                    CheckBox::make('image_delete')
                        ->title('Delete Image')
                ]),   

                Input::make('data.id')
                ->type('hidden'),

                Input::make('data.test_id')
                ->type('hidden'),

                Button::make('Submit')
                    ->method('UpdateMethod')
                    ->style('width: 100%;display: flex;align-items: center;justify-content: center;background: #AA81A0 !important;color: white !important;font-weight: bold;')
                    ->type(Color::BASIC),
            ]),
        ];
    }

    public function UpdateMethod(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = $image->store('images/question', 'public');
            $imagePath = Storage::url($path);
            
        }
        $id = QandA::find(request('data.id'));
        if (isset($request->image_delete)) {
            $id->update([
                'image' => null,
            ]);
        }

        $id->update([
            'question' => request('data.question'),
            'answer_1' => request('data.answer_1'),
            'answer_2' => request('data.answer_2'),
            'answer_3' => request('data.answer_3'),
            'image' => $imagePath ?? 0,
            'answer_4' => request('data.answer_4'),
            'correct_answer' => request('data.correct_answer'),
            'status' => request('data.status'),
        ]);
        

        Alert::info('You have successfully updated.');
        return redirect()->route('platform.systems.test.questions&answers',request('data.test_id'));
    }   
}
