<?php

namespace App\Orchid\Screens\Videos;

use App\Models\Classes;
use App\Models\ClassHasVideos;
use App\Models\Videos;
use Illuminate\Http\Request;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class VideosUpdateScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Videos $id): iterable
    {
        $video = Videos::with('classHasVideos.class')->find($id->id);

        $class = ClassHasVideos::where('video_id', $id->id)->select('class_id')->get();

        $classes = [];

        foreach ($class as $key => $value) {
            $classes[] = $value->class_id;
        }   

        $link = 'https://youtu.be/'.$video->link;

        
        return [
            'data' => $video,
            'classes' => $classes,
            'link' => $link
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Videos Update';
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
                Input::make('data.title')
                    ->title('Title')
                    ->placeholder('Enter your video title')
                    ->help('Enter your video title.')
                    ->type('text')
                    ->horizontal()
                    ->required(),

                Input::make('link')
                    ->title('Youtube Video Link')
                    ->placeholder('Enter your video link')
                    ->help('Enter your video link.')
                    ->type('text')
                    ->horizontal()
                    ->required(),

                Input::make('data.recoded_at')
                    ->title('Recorded At')
                    ->placeholder('Enter Recorded date')
                    ->help('Enter Recorded date.')
                    ->type('date')
                    ->horizontal()
                    ->required(),

                Select::make('classes')
                    ->title('Class')
                    ->placeholder('Select Class or Classes')
                    ->help('Select Class or Classes.')
                    ->fromModel(Classes::class, 'name','id')
                    // ->required()
                    ->horizontal()
                    ->multiple(),

                Input::make('data.description')
                    ->title('Description')
                    ->placeholder('Enter your video description')
                    ->help('Enter your video description.')
                    ->horizontal()
                    ->type('text'),

                // Select::make('data.status')
                //     ->title('Status')
                //     ->placeholder('Select Status')
                //     ->help('Select Status.')
                //     ->horizontal()
                //     ->options([
                //         '1' => 'Active',
                //         '0' => 'Inactive',
                //     ])
                //     ->required(),

                    CheckBox::make('data.status')
                    ->title('Status')
                    ->help('Check if the video is active.')
                    ->horizontal(),

                    Input::make('data.id')
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

        // Validate the request data
        $validated = $request->validate([
            'data.title' => 'required|string|max:255',
            'link' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Custom validation for YouTube URL
                    if (!preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|live\/|embed\/|v\/|)([a-zA-Z0-9_-]+)|youtu\.be\/([a-zA-Z0-9_-]+))/', $value)) {
                        $fail($attribute . ' is not a valid YouTube URL.');
                    }
                }
            ],
            // 'classes' => 'required|array',
            // 'classes.*' => 'required|integer'
        ]);


        ClassHasVideos::where('video_id', $request['data.id'])->delete();

        // Extract the YouTube video ID
        $video_id = $this->getYouTubeVideoID($request['link']);

        // Create new video record
        $video = Videos::find($request['data.id']);
        $video->title = $request['data.title'];
        $video->link = $video_id; // Store video ID instead of full link
        $video->description = $request['data.description'];
        $video->recoded_at = $request['data.recoded_at'];
        $video->status =  isset($request['data.status']) ? 1 : 0;
        $video->save();

        if(!empty($request['classes'])) {

            // Associate video with classes
            foreach ($request['classes'] as $class) {
                $classHasVideo = new ClassHasVideos();
                $classHasVideo->class_id = $class;
                $classHasVideo->video_id = $video->id;
                $classHasVideo->month_number = date('n');
                $classHasVideo->save();
            }
        }

        // Show success alert
        Alert::info('Successfully Updated video.');
    }



    function getYouTubeVideoID($url) {
    // Regular expression to match YouTube video ID
    preg_match('/(youtu\.be\/|youtube\.com\/(watch\?(.*&)?v=|v\/|embed\/|live\/))([^\?&"\'#]+)/', $url, $matches);
    
    // Return video ID if found
    return isset($matches[4]) ? $matches[4] : null;
    }
}
