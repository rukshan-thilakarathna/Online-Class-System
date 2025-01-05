<?php

namespace App\Orchid\Screens\Tutes;

use App\Models\Classes;
use App\Models\ClassHasTutes;
use App\Models\Tutes;
use App\Orchid\Filters\TuteStatusFilter;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\ModalToggle;
use App\Orchid\Layouts\Test\TestListLayout;
use App\Orchid\Layouts\Tute\TuteListLayout;
use App\Orchid\Layouts\Tute\TutesSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Layouts\Modal;

use function PHPSTORM_META\type;

class TutesListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {

        return [
            'Tutes' => Tutes::filters()
                            ->filtersApplySelection(TutesSelection::class)
                            ->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tutes List';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Upload Tute')
            ->modal('Upload Tute')
            ->method('UploadTuteMethod')
            ->icon('bs.book'),
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
            TutesSelection::class,
            TuteListLayout::class,
            Layout::modal('Upload Tute', [
                Layout::rows([

                    Input::make('title')
                        ->title('Title')
                        ->placeholder('Enter Title')
                        ->help('Enter Title.')
                        ->type('text')
                        ->required()
                        ->horizontal(),

                    Input::make('file')
                        ->type('file')
                        ->help('Upload pdf,doc,docx File.')
                        ->title('Upload File')
                        ->required()
                        ->horizontal(),

                    Select::make('open_class')
                        ->fromModel(Classes::class, 'name','id')
                        ->title('Open Class')
                        ->placeholder('Select Class')
                        ->help('Select Open Class.')
                        // ->required()
                        ->multiple()
                        ->horizontal(),
                    
                    Input::make('description')
                        ->title('description')
                        ->placeholder('Enter description')
                        ->help('Enter description.')
                        ->type('text')
                        ->horizontal(),
                ]),
            ]) ->size(Modal::SIZE_LG),

            Layout::modal('Update Tute', [
                Layout::rows([
                    Input::make('tute.title')
                        ->title('Title')
                        ->placeholder('Enter Title')
                        ->help('Enter Title.')
                        ->type('text')
                        ->required()
                        ->horizontal(),

                    Input::make('file')
                        ->type('file')
                        ->help('Upload pdf,doc,docx File.')
                        ->title('Upload File')
                        ->horizontal(),
                    
                    Input::make('tute.description')
                        ->title('description')
                        ->placeholder('Enter description')
                        ->help('Enter description.')
                        ->type('text')
                        ->horizontal(),

                        CheckBox::make('tute.status')
                        ->title('Status')
                        ->help('Check if the tute is active.')
                        ->horizontal(),

                    Input::make('tute.id')
                        ->type('hidden'),


                ]),
            ]) ->size(Modal::SIZE_LG)->async('asyncGetClass'),

            Layout::modal('Tute Has Class or Classes', [
                Layout::rows([
                    Select::make('class')
                        ->fromModel(Classes::class, 'name','id')
                        // ->required()
                        ->multiple(),
                    Input::make('id')
                        ->type('hidden'),
                ]),
            ]) ->size(Modal::SIZE_LG)->async('asyncGetClass')
        ];
    }

    public function asyncGetClass(Tutes $tute): iterable
    {
        $class = ClassHasTutes::where('tute_id', $tute->id)->select('class_id')->get();

        $classes = [];

        foreach ($class as $key => $value) {
            $classes[] = $value->class;
        }   

        return [
            'tute' => $tute,
            'class' => $classes,
            'id' => $tute->id,
        ];
    }

    public function classesHasTutes(Request $request): void
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            // 'class' => 'required|array',
        ]);

        ClassHasTutes::where('tute_id', $request->get('id'))->delete();

        if (!empty($request->get('class'))) {

            foreach ($request->get('class') as $key => $value) {
                ClassHasTutes::create([
                    'class_id' => $value,
                    'tute_id' => $request->get('id'),
                    'month_number' => date('n'),
                ]);
            }
        }

        Toast::info('Tute Class Updated successfully.');
    }

    public function UploadTuteMethod(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'title' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:20480',
 // You can adjust the mime types and size limit
         
        ]);
    
        // Check if a file has been uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Define the target directory
            $destinationPath = public_path('Tutes');
            // Generate a unique file name (optional)
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Move the uploaded file to the desired location
            $file->move($destinationPath, $fileName);
        
            // Define the file path to store in the database
            $filePath = 'Tutes/' . $fileName;
        } else {
            // If no file is uploaded, set a default or handle accordingly
            $filePath = null;
        }
        
        // Create the new Tute record
        $tute = Tutes::create([
            'title' => $request->get('title'),
            'pdf' => $filePath, // Save the file path in the database
            'description' => $request->get('description') ?? " ",
            'status' => 1
        ]);
        

        if ($request->has('open_class')) {
            foreach ($request->get('open_class') as $open_class) {
                ClassHasTutes::create([
                    'tute_id' => $tute->id,
                    'class_id' => $open_class,
                    'month_number' => date('n'),
                ]);
            }
        }

        // Associate the test with the open classes
        // foreach ($request->get('open_class') as $open_class) {
        //     ClassHasTutes::create([
        //         'tute_id' => $tute->id,
        //         'class_id' => $open_class
        //     ]);
        // }
    
        // Display a success message
        Toast::info('Tute Uploaded successfully.');
    }

    public function UpdateTuteMethod(Request $request)
    {


        // Validate incoming request data
        $request->validate([
            'tute.title' => 'required',
        ]);
    
        // Check if a file has been uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('Tutes', 'public');
        }
    
        // Find the Tutes record by ID
        $tute = Tutes::find($request->tute['id']);
        // Check if the record was found
        if ($tute) {
            $tute->update([
                'title' => $request->tute['title'],
                'status' =>  isset($request->tute['status']) ? 1 : 0,
                'pdf' => $filePath ?? $tute->pdf, // Update the file path only if a new file is uploaded
                'description' => $request->tute['description'] ?? $tute->description,
            ]);
    
            Toast::info('Tute Updated successfully.');
        } else {
            // Handle the case where the Tutes record is not found
            Toast::error('Tute not found.');
            return back();
        }
    }

    public function remove(Request $request): void
    {
        $tuteId = $request->get('id');
    
        // First, delete the related records in ClassHasTutes
        ClassHasTutes::where('tute_id', $tuteId)->delete();
    
        // Then, delete the Tutes record
        Tutes::findOrFail($tuteId)->delete();
    
        Toast::info(__('Test was removed'));
    }
    
}
