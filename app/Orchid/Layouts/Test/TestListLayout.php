<?php

namespace App\Orchid\Layouts\Test;

use App\Models\Test;
use DateTime;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\TD;

class TestListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'test';

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
            ->render(fn (Test $test) => DropDown::make()
                ->icon('bs.three-dots-vertical')
                ->list([

                    ModalToggle::make('Test Has Class or Classes')
                    ->modal('Test Has Class or Classes')
                    ->method('classesHasTest', [
                        'id' => $test->id,
                        ])
                        ->asyncParameters([
                            'test'=>$test->id
                    ]),

                    Button::make(__('Delete'))
                        ->confirm(__(' '))
                        ->method('remove', [
                            'id' => $test->id,
                            'isdelete' => 1
                    ]),

                    Link::make(__('Update'))
                        ->route('platform.systems.test.edit', $test->id),

                    Link::make(__('Manage Questions And Answers'))
                        ->route('platform.systems.test.questions&answers', $test->id),

                ])),
            TD::make('id', __('Test Id'))
            ->render(function (Test $test) {
                return 'TEST-' . $test->id;
            })
            ->filter(Input::make()),

            TD::make('name', __('Name'))
            ->render(function (Test $test) {
                return '<a href="' . route('platform.systems.test.edit', $test->id) . '" style="background: #0c616e; color: white; text-decoration: none; padding: 10px;">' . $test->name . '</a>';
            })
            ->filter(Input::make()),

            TD::make('testType.name', __('Test Type'))
            ->sort(),

            TD::make('test_time', __('Time'))
            ->render(function (Test $test) {
                return 'MINUTES - ' . $test->test_time;
            })
            ->filter(Input::make()),

            TD::make('marks', __('Full Marks'))
            ->filter(Input::make()),

            TD::make('status', __('Status'))
            ->render(function (Test $test) {
                if ($test->status == 0) {
                    
                    return '<span>N/A</span>'.
                        Button::make(__('ACTIVE Now'))
                            ->confirm(__('Are you sure you want to Change this status?'))
                            ->style('background: #0c616e; color: white; text-decoration: none; padding: 10px;')
                            ->method('remove', [
                                'id' => $test->id,
                                'status' => 1,
                                'isdelete' => 0
                            ]);

                }else{
                    
                    return '<span>ACTIVE</span>'.
                        Button::make(__('N/A Now'))
                            ->confirm(__('Are you sure you want to Change this status?'))
                            ->style('background: #6e0c0c; color: white; text-decoration: none; padding: 10px;')
                            ->method('remove', [
                                'id' => $test->id,
                                'status' => 0,
                                'isdelete' => 0
                        ]);

                }

                
            })
            ->sort(),

            TD::make('xml_file', __('Download'))
            ->render(function (Test $test) {
                return '<a href="/' . $test->xml_file . '" download="' . $test->xml_file . '" style="background: #0c616e; color: white;text-decoration: none;padding: 10px;" >Download</a>';
            }),

            TD::make('created_at', __('Created'))
            ->usingComponent(DateTimeSplit::class)
            ->align(TD::ALIGN_RIGHT)
            ->filter(Input::make())
            ->sort(),

            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->filter(Input::make())
                ->sort(),

           
            ];

    }
}
