<?php

namespace App\Orchid\Layouts\Classes;

use App\Models\Classes;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class ClassesLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'Classes';

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
                ->render(fn (Classes $class) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        
                        Link::make(__('View'))
                            ->route('platform.systems.classes.view', $class->id),

                        Link::make(__('Update'))
                            ->route('platform.systems.classes.update', $class->id)
                            ->icon('bs.pencil'),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'id' => $class->id,
                            ]),
                    ])),
                    
            TD::make('id', __('Class Id'))
                ->render(function (Classes $class) {
                    return 'CL-' . $class->id;
                })
                ->filter(Input::make()),

            TD::make('name', __('Name'))
            ->render(function (Classes $class) {
                return '<a href="' . route('platform.systems.classes.view', $class->id) . '">' . $class->name . '</a>';
            })
                ->filter(Input::make()),

            // TD::make('slug', __('Slug'))
            //     ->filter(Input::make()),

            TD::make('class_year', __('Year'))
                ->filter(Input::make())
                ->width('50px'),

            TD::make('GetType.name', __('Type'))->render(function (Classes $class) {
                return  Button::make($class->GetType->name)->type(Color::INFO)->disabled();
            }),

            TD::make('GetCategory.name', __('Category'))->render(function (Classes $class) {
                return  Button::make($class->GetCategory->name)->type(Color::SUCCESS)->disabled();
            }),

            TD::make('grade', __('Grade/Grades'))
            ->render(function ($model) {
                // Assuming $model->grade contains a comma-separated string of grade IDs
                $gradeIds = explode(',', $model->grade);
        
                // Fetch grade names dynamically (optimize this for performance)
                $grades = \App\Models\Grade::whereIn('id', $gradeIds)->pluck('name')->toArray();
        
                // Wrap badges in a flexbox container
                $badges = collect($grades)->map(function ($grade) {
                    return "<span style='color: white; background: #717171; padding: 3px 5px; border-radius: 3px; margin-right: 3px; margin-bottom: 3px;'>$grade</span>";
                })->implode(' ');
        
                // Add a flex container
                return "<div style='display: flex; flex-wrap: wrap; gap: 5px;'>$badges</div>";
            })
            ->filter(Input::make())
            ->width('200px'), 
        
            TD::make('class_fees', __('Class Fees'))
                ->render(function (Classes $class) {
                    return 'R.' . $class->class_fees;
                })
                ->filter(Input::make())
                ->width('100px'),

            TD::make('status', __('Status'))->render(function (Classes $class) {

                if ($class->status == 1) {
                    return  Button::make('On Going')->type(Color::DANGER)->disabled();
                }elseif ($class->status == 2) {
                    return  Button::make('Completed')->type(Color::WARNING)->disabled();
                }
                else{
                    return  Button::make('Upcoming')->type(Color::SUCCESS)->disabled();
                }
            }),

            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->filter(Input::make())
                ->defaultHidden()
                ->sort(),

            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->filter(Input::make())
                ->sort(),

            
        ];

    }

}
