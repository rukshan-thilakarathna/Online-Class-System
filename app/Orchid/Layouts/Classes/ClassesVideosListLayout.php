<?php

namespace App\Orchid\Layouts\Classes;

use App\Models\ClassHasVideos;
use App\Models\Videos;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link as ActionsLink;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClassesVideosListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'videos';
    protected $title = 'This Class Has Videos';

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
                ->render(function (ClassHasVideos $classVideo) {
                    $video = $classVideo->video;
                    $class = $classVideo->class;
                    
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Button::make(__('Remove from this class'))
                                ->icon('bs.trash3')
                                ->confirm(__('Are you sure you want to remove this video from the class?'))
                                ->method('remove', [
                                    'video_id' => $video->id,
                                    'class_id' => $class->id,
                                ]),
                        ]);
                }),
            TD::make('video.id', __('Video Id'))
                ->render(function (ClassHasVideos $classVideo) {
                    $video = $classVideo->video;
                    return 'VDO-' . $video->id;
                }),

            TD::make('video.title', __('Title')),

            TD::make('video.link', __('Video'))
                ->render(function (ClassHasVideos $classVideo) {
                    $video = $classVideo->video; // Assuming there's a relation to Video
                    
                    return view('components.table-video', [
                        'VideoLink' =>$video->link,
                    ]);
                }),
         
            TD::make('tute.view', __('Views'))
                ->render(function (ClassHasVideos $classVideo) {
                return $classVideo->views;
            }),

            TD::make('video.description', __('Description'))->width('250px'),

            TD::make('video.status', __('Status'))->render(function (ClassHasVideos $classVideo) {
                $video = $classVideo->video; // Assuming there's a relation to Video
                
                if ($video->status == 1) {
                    return Button::make('Active')->type(Color::DANGER)->disabled();
                } elseif ($video->status == 0) {
                    return Button::make('Not Active')->type(Color::WARNING)->disabled();
                } else {
                    return Button::make('Upcoming')->type(Color::SUCCESS)->disabled();
                }
            }),
                

            TD::make('video.created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden(),

            TD::make('video.updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT),

                
            
                
        ];

    }
}
