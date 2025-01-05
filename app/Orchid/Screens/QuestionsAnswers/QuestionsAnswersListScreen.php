<?php

namespace App\Orchid\Screens\QuestionsAnswers;

use App\Models\Classes;
use App\Models\QandA;
use App\Models\Test;
use App\View\Components\QuestionsAnswers;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class QuestionsAnswersListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Test $id): iterable
    {

      
     
      
        return [
            'questions' => QandA::where('test_id', $id->id)->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Questions & Answers';
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
            Layout::component(QuestionsAnswers::class),
        ];
    }

    public function remove(Request $request): void
    {
        QandA::findOrFail($request->get('id'))->delete();

        Alert::info(__('Question was removed'));
    }

}
