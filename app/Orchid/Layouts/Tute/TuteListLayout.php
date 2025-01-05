<?php

namespace App\Orchid\Layouts\Tute;

use App\Models\Tutes;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TuteListLayout extends Table
{
   /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'Tutes';

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
            ->render(fn (Tutes $Tutes) => DropDown::make()
                ->icon('bs.three-dots-vertical')
                ->list([

                    ModalToggle::make('Tutes Has Class or Classes')
                    ->modal('Tute Has Class or Classes')
                    ->method('classesHasTutes', [
                        'id' => $Tutes->id,
                    ]) ->asyncParameters([
                        'tute'=>$Tutes->id
                    ]),
                    ModalToggle::make('Update Tute')
                    ->modal('Update Tute')
                    ->method('UpdateTuteMethod', [
                        'id' => $Tutes->id,
                    ])

                    ->asyncParameters([
                        'tute'=>$Tutes->id
                    ]),

                    Button::make(__('Delete'))
                    ->confirm(__(' '))
                    ->method('remove', [
                        'id' => $Tutes->id,
                    ]),


               
            ])),
            TD::make('id', __('Tutes Id'))
                ->render(function (Tutes $Tutes) {
                    return 'Tutes-' . $Tutes->id;
                })
                ->filter(Input::make())
                ->sort(),

            TD::make('title', __('Title'))
            ->render(function (Tutes $Tutes) {
                return ModalToggle::make($Tutes->title)
                ->modal('Update Tute')
                ->method('UpdateTuteMethod', [
                    'id' => $Tutes->id,
                ]);
            })
                ->filter(Input::make())
                ->sort(),

            TD::make('video.link', __('Tute'))
            ->render(function (Tutes $Tutes) {
                
                
                return view('components.table-tute', [
                    'pdf' =>$Tutes->pdf,
                ]);
            }),


            // TD::make('status', __('Status'))
            //     ->render(function (Tutes $Tutes) {
            //         return $Tutes->status == 0 ? 'N/A' : 'Active' ;
            //     })
            //     ->sort(),

            
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
