<?php

namespace App\Orchid\Layouts\Classes;

use App\Models\ClassHasTutes;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Layouts\Table;
use Orchid\Support\Color;
use Orchid\Screen\TD;

class ClassesTutesListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tutes';
    protected $title = 'This Class Has  Tutes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {

        return [
            TD::make('tute.id', __('Video Id'))
                ->render(function (ClassHasTutes $classHasTutes) {
                    $tutes = $classHasTutes->tute;
                    return 'TUTES-' . $tutes->id;
                }),

            TD::make('tute.title', __('Title')),

            TD::make('video.link', __('Tute'))
                ->render(function (ClassHasTutes $classVideo) {
                    $tutes = $classVideo->tute; // Assuming there's a relation to Video
                    
                    return view('components.table-tute', [
                        'pdf' =>$tutes->pdf,
                    ]);
                }),
                
            TD::make('tute.view', __('Views'))
                ->render(function (ClassHasTutes $classHasTutes) {
                return $classHasTutes->views;
            }),

            TD::make('tute.description', __('Description'))->width('250px'),

            TD::make('tute.month_number', __('Month'))->render(function (ClassHasTutes $classVideo) {
                $tutes = $classVideo->tute; // Assuming there's a relation to Video
                $months = array(
                    1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",
                    7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December"
                  );
                
                return $months[$classVideo->month_number];
            }),

            TD::make('tute.status', __('Status'))->render(function (ClassHasTutes $classVideo) {
                $tutes = $classVideo->tute; // Assuming there's a relation to Video
                
                if ($tutes->status == 1) {
                    return Button::make('Active')->type(Color::DANGER)->disabled();
                } elseif ($tutes->status == 0) {
                    return Button::make('Not Active')->type(Color::WARNING)->disabled();
                } else {
                    return Button::make('Upcoming')->type(Color::SUCCESS)->disabled();
                }
            }),
                

            TD::make('tute.created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden(),

            TD::make('tute.updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT),

                TD::make(__('Actions'))
                ->width('100px')
                ->align(TD::ALIGN_CENTER)
                ->render(function (ClassHasTutes $classVideo) {
                    $tutes = $classVideo->tute;
                    $class = $classVideo->class;
                    
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            ModalToggle::make('Change Open Month')
                            ->modal('Change Open Month')
                            ->method('ChangeOpenMonth', [
                                'id' => $classVideo->id,
                            ]),

                            Button::make(__('Remove from this class'))
                                ->icon('bs.trash3')
                                ->confirm(__('Are you sure you want to remove this Tute from the class?'))
                                ->method('removeTute', [
                                    'tutes_id' => $tutes->id,
                                    'class_id' => $class->id,
                                ]),
                        ]);
                })
            
                
        ];

    }
}
