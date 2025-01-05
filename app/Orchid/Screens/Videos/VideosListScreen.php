<?php

namespace App\Orchid\Screens\Videos;

use App\Models\Classes;
use App\Models\ClassHasVideos;
use App\Models\Videos;
use App\Orchid\Layouts\Videos\VideosSelection;
use App\View\Components\VideoView;
use Illuminate\Console\View\Components\Secret;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Modal;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class VideosListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $videos = Videos::with('classHasVideos.class')->filtersApplySelection(VideosSelection::class)->orderBy('created_at', 'desc')->get();

        $classes = [];
        foreach ($videos as $video) {
            foreach ($video->classHasVideos as $classHasVideo) {
                $classes[] = $classHasVideo->class->name; // Accessing class name
            }
        }

       
       
        return [
            'videos' => $videos,
            'classes' => $classes,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Videos List';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Create New Video')
            ->modal('CreateVideoModal')
            ->modalTitle('Create New Video')
            ->method('CreateVideoModal'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            
            VideosSelection::class,
            Layout::component(VideoView::class),
            Layout::modal('CreateVideoModal', [
                Layout::rows([
                    Input::make('title')
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

                    Input::make('recoded_at')
                        ->title('Recorded At')
                        ->placeholder('Enter Recorded date')
                        ->help('Enter Recorded date.')
                        ->type('date')
                        ->horizontal()
                        ->required(),

                    Select::make('class')
                        ->title('Class')
                        ->placeholder('Select Class or Classes')
                        ->help('Select Class or Classes.')
                        ->fromModel(Classes::class, 'name','id')
                        // ->required()
                        ->horizontal()
                        ->multiple(),

                    Input::make('description')
                        ->title('Description')
                        ->placeholder('Enter your video description')
                        ->help('Enter your video description.')
                        ->horizontal()
                        ->type('text'),

                    Select::make('status')
                        ->title('Status')
                        ->placeholder('Select Status')
                        ->help('Select Status.')
                        ->horizontal()
                        ->options([
                            '1' => 'Active',
                            '0' => 'Inactive',
                        ])
                        ->required(),
                
                ]),
            ]) ->size(Modal::SIZE_LG),
            
            Layout::modal('Class', [
                Layout::rows([
                    Select::make('class')
                        ->fromModel(Classes::class, 'name','id')
                        ->required()
                        ->multiple(),
                    Input::make('id')
                        ->type('hidden'),
                ]),
            ]) ->size(Modal::SIZE_LG)->async('asyncGetClass')
        ];
    }

    public function asyncGetClass(Videos $video): iterable
    {
        $class = ClassHasVideos::where('video_id', $video->id)->select('class')->get();

        $classes = [];

        foreach ($class as $key => $value) {
            $classes[] = $value->class;
        }   

        return [
            'class' => $classes,
            'id' => $video->id,
        ];
    }



    /**
     * Saves a new video from the given data
     *
     * @param array $data
     *
     * @return \Illuminate\Http\RedirectResponse
     */


     public function CreateVideoModal(Request $request)
     {
         // Validate the request data
         $validated = $request->validate([
             'title' => 'required|string|max:255',
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

         
             'status' => 'required|in:0,1',
            //  'class' => 'required|array',
            //  'class.*' => 'required|integer'
         ]);
     
         // Extract the YouTube video ID
         $video_id = $this->getYouTubeVideoID($request['link']);
     
         // Create new video record
         $video = new Videos();
         $video->title = $request['title'];
         $video->link = $video_id; // Store video ID instead of full link
         $video->description = $request['description'];
         $video->recoded_at = $request['recoded_at'];
         $video->status = $request['status'];
         $video->save();

         if(!empty($request['class'])){
             // Associate video with classes
            foreach ($request['class'] as $class) {
                $classHasVideo = new ClassHasVideos();
                $classHasVideo->class_id = $class;
                $classHasVideo->video_id = $video->id;
                $classHasVideo->month_number = date('n');
                $classHasVideo->save();
            }
         }
         // Show success alert
         Alert::info('Successfully created new video.');
     }
     


    function getYouTubeVideoID($url) {
        // Regular expression to match YouTube video ID
        preg_match('/(youtu\.be\/|youtube\.com\/(watch\?(.*&)?v=|v\/|embed\/|live\/))([^\?&"\'#]+)/', $url, $matches);
        
        // Return video ID if found
        return isset($matches[4]) ? $matches[4] : null;
    }

    public function remove(Request $request): void
    {
        Videos::findOrFail($request->get('id'))->delete();
        ClassHasVideos::where('video_id', $request->get('id'))->delete();


       Toast::info(__('Test was removed'));
    }

}
