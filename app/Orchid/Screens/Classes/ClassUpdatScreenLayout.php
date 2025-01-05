<?php

namespace App\Orchid\Screens\Classes;

use App\Models\Classes;
use Orchid\Screen\Screen;
use App\Models\ClassCategories;
use App\Models\ClassTypes;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use function Termwind\style;

class ClassUpdatScreenLayout extends Screen
{
    public $grade;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Classes $id): iterable
    {
        $class = Classes::find($id->id);

        $grades = explode(',', $id->grade);

        // $this->grade = $grades;

        $class->grade = $grades;

      
        return [
            'class' => $class

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Class Updat Screen';
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
                Group::make([
                    Input::make('class.name')
                        ->title('Class Name')
                        ->placeholder('Enter your class name')
                        ->help('Enter your Class name.')
                        ->type('text')
                        ->required()
                        ->horizontal(),

                        Input::make('image')
                        ->type('file')
                        ->title('Upload Class Image')
                        ->horizontal(),

                ]),

                Group::make([
                    Select::make('class.class_category')
                        ->fromModel(ClassCategories::class, 'name','id')
                        ->title('Class Category')
                        ->placeholder('Select class Category')
                        ->help('Select your Class Category.')
                        ->required()
                        ->horizontal(),

                    Select::make('class.class_type')
                        ->fromModel(ClassTypes::class, 'name','id')
                        ->title('Class Type')
                        ->placeholder('Select class type')
                        ->help('Select your Class type.')
                        ->required()
                        ->horizontal(),

                ]),
                Group::make([

                    Select::make('class.class_year')
                        ->options([
                            2025 => '2025',
                            2026 => '2026',
                            2027 => '2027',
                            2028 => '2028',
                            2029 => '2029',
                            2030 => '2030',
                            2031 => '2031',
                            2032 => '2032',
                            2033 => '2033',
                            2034 => '2034',
                            2035 => '2035',

                        ])
                        ->title('Select Year')
                        ->placeholder('Select Year')
                        ->help('Select Year')
                        ->required()
                        ->horizontal(),

                    Select::make('class.grade')
                        ->fromModel(Grade::class, 'name','id')
                        ->title('Grade or Grades')
                        ->placeholder('Select class Grade')
                        ->help('Select Grade or Grades')
                        ->Multiple()
                        ->required()
                        ->horizontal(),
                ]),

                Group::make([
                    Input::make('class.class_fees')
                        ->title('Class Fees')
                        ->placeholder('Enter Class Fees')
                        ->type('text')
                        ->required()
                        ->horizontal(),

                    DateRange::make('class.class_fees_date')
                        ->title('Class Fees Range date')
                        ->horizontal()
                        ->required(),
                ]),

                Group::make([
                    Input::make('class.class_start_date')
                            ->type('datetime-local')
                            ->required()
                            ->title('Start Date And Time')
                            ->placeholder('YYYY-MM-DDTHH:MM')
                            ->horizontal(),

                    Select::make('class.status')
                        ->options([
                            1 => 'On Going',
                            2 => 'Completed',
                            3 => 'Upcoming',
                        ])
                        ->title('Select status')
                        ->placeholder('Select status')
                        ->help('Select status')
                        ->required()
                        ->horizontal(),
                ]),

                SimpleMDE::make('class.description')
                    ->title('Description'),

                // Matrix::make('class_date')
                //     ->columns([
                //         'Day',
                //         'Time',
                //     ])
                //     ->addRowLabel('Add New Day')
                //     ->maxRows(7)
                //     ->title('Class Day And Time')
                //     ->fields([
                //         'Day'   => Select::make()->options([
                //             'Monday' => 'Monday',
                //             'Tuesday' => 'Tuesday',
                //             'Wednesday' => 'Wednesday',
                //             'Thursday' => 'Thursday',
                //             'Friday' => 'Friday',
                //             'Saturday' => 'Saturday',
                //             'Sunday' => 'Sunday',
                //         ]),
                //         'Time' => Input::make()->type('time'),
                //     ]),

              
Input::make('class.id')
                    ->type('hidden'),
                Button::make('Submit')
                    ->method('UpdateClass')
                    ->style('width: 100%;display: flex;align-items: center;justify-content: center;background: #AA81A0 !important;color: white !important;font-weight: bold;')
                    ->type(Color::BASIC),
            ]),
        ];
    }

    public function UpdateClass(Request $request)
    {
        // Find the class by ID from the nested array
        $class = Classes::find($request->class['id']);
    
        if (!$class) {
            return back()->withErrors(['error' => 'Class not found.']);
        }
    
        // Handle the grade input (array to comma-separated string)
        $grade = implode(",", $request->class['grade'] ?? []);
    
        // Handle the image upload
        if (isset($request->class['image']) && $request->hasFile('class.image')) {
            $image = $request->file('class.image');
    
            // Get the image size
            list($width, $height) = getimagesize($image);
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
            
                // Get the image size
                list($width, $height) = getimagesize($image);
            
                // Check if the width and height are less than the required dimensions
                if ($width <= 1200 && $height <= 300) {
                    // Define the target directory
                    $destinationPath = public_path('images/classes');
                    
                    // Generate a unique file name (optional)
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    
                    // Move the uploaded image to the desired location
                    $image->move($destinationPath, $fileName);
            
                    // Set the image path to be stored in the database
                    $imagePath = 'images/classes/' . $fileName;
                } else {
                    return back()->withErrors(['image' => 'The image must be less than 1200px wide and 300px high.']);
                }
            } else {
                $imagePath = null; // In case there's no file uploaded
            }
            
        }
    
        // Generate a new slug if not provided
        $slug = $request->class['slug'] ?? Str::slug($request->class['name']);
    
        // Validate the input
        $request->validate([
            'class.name' => 'required|string|max:255',
        ]);
    
        // Update the class attributes
        $class->name = $request->class['name'];
        $class->slug = $slug;
        $class->grade = $grade;
        $class->class_dates = json_encode($request->class['class_date'] ?? [], JSON_PRETTY_PRINT);
        $class->class_category = $request->class['class_category'];
        $class->class_type = $request->class['class_type'];
        $class->class_year = $request->class['class_year'];
        $class->class_fees = $request->class['class_fees'];
        $class->class_fees_date = json_encode($request->class['class_fees_date'] ?? [], JSON_PRETTY_PRINT);
        $class->class_start_date = $request->class['class_start_date'];
        $class->status = $request->class['status'];
        $class->description = $request->class['description'];
    
        // Save the updated class
        $class->save();
    
        // Set an alert message
        Alert::info('Successfully updated the class.');
    
        // Redirect back or to another route
        return redirect()->back();
    }
    
}
