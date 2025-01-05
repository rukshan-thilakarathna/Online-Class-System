<?php

namespace App\Orchid\Layouts\Classes;

use App\Models\Classes;
use App\Models\ClassHasTest;
use App\Models\Test;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Support\Color;
use Orchid\Screen\TD;

class ClassesTestListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tests';
    protected $title = 'This Class Has Tests';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make(__('Actions'))
                ->width('100px')
                ->align(TD::ALIGN_CENTER)
                ->render(function (ClassHasTest $classHasTest) {
                    $tests = $classHasTest->test;
                    $class = $classHasTest->class;
                    $test = Test::find($tests);
                    $clas = Classes::find($class);
                    
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make(__('Q&As'))
                                ->icon('bs.question-circle')
                                ->route('platform.systems.test.questions&answers',$test->id),

                            Link::make(__('View Result'))
                                ->icon('bs.eye')
                                ->route('platform.systems.classes.test-result',[$clas->id,$test->id]),

                            Button::make(__('Remove from this class'))
                                ->icon('bs.trash3')
                                ->confirm(__('Are you sure you want to remove this test from the class?'))
                                ->method('removetest', [
                                    'tests_id' => $test->id,
                                    'class_id' => $clas->id,
                                ]),
                        ]);
                }),
            TD::make('test.id', __('Test Id'))
                ->render(function (ClassHasTest $classHasTest) {
                    $test = $classHasTest->test;
                    return 'TEST-' . $test;
                }),

            TD::make('test.name', __('Name')),

        

            TD::make('test.completed_count', __('Completed'))
                ->render(function (ClassHasTest $ClassHasTest) {
                return $ClassHasTest->completed_count;
            }),



            TD::make('test.description', __('Description'))->width('250px'),

            TD::make('test.month_number', __('Month'))->render(function (ClassHasTest $classHasTest) {
                $tests = $classHasTest->test; // Assuming there's a relation to Video
                $months = array(
                    1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",
                    7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"
                  );
                
                return $months[$classHasTest->month_number];
            }),

            TD::make('test.status', __('Status'))->render(function (ClassHasTest $classHasTest) {
                $tests = $classHasTest->test; // Assuming there's a relation to Video
                $test = Test::find($tests);

                
                if ($test->status == 1) {
                    return Button::make('Active')->type(Color::DANGER)->disabled();
                } elseif ($test->status == 0) {
                    return Button::make('Not Active')->type(Color::WARNING)->disabled();
                } else {
                    return Button::make('Upcoming')->type(Color::SUCCESS)->disabled();
                }
            }),
                

            TD::make('test.created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden(),

            TD::make('test.updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT),

                
            
                
        ];
    }
}
