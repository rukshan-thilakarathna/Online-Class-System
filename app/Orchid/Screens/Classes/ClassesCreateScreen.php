<?php

namespace App\Orchid\Screens\Classes;

use App\Models\ClassCategories;
use App\Models\Classes;
use App\Models\ClassTypes;
use App\Models\Grade;
use App\Models\Timetable;
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
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use function Termwind\style;

class ClassesCreateScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ' Create a New Class';
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
                    Input::make('name')
                        ->title('Class Name')
                        ->placeholder('Enter your class name')
                        ->help('Enter your Class name.')
                        ->type('text')
                        ->required()
                        ->horizontal(),

                        Input::make('image')
                        ->type('file')
                        ->required()
                        ->title('Upload Class Image Size 1200 X 300')
                        ->horizontal(),

                ]),

                Group::make([
                    Select::make('class_category')
                        ->fromModel(ClassCategories::class, 'name','id')
                        ->title('Class Category')
                        ->placeholder('Select class Category')
                        ->help('Select your Class Category.')
                        ->required()
                        ->horizontal(),

                    Select::make('class_type')
                        ->fromModel(ClassTypes::class, 'name','id')
                        ->title('Class Type')
                        ->placeholder('Select class type')
                        ->help('Select your Class type.')
                        ->required()
                        ->horizontal(),

                ]),
                Group::make([

                    Select::make('class_year')
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

                    Select::make('grade')
                        ->fromModel(Grade::class, 'name','id')
                        ->title('Grade or Grades')
                        ->placeholder('Select class Grade')
                        ->help('Select Grade or Grades')
                        ->Multiple()
                        ->required()
                        ->horizontal(),
                ]),

                Group::make([
                    Input::make('class_fees')
                        ->title('Class Fees')
                        ->placeholder('Enter Class Fees')
                        ->type('text')
                        ->required()
                        ->horizontal(),

                   Input::make('class_start_date')
                            ->type('datetime-local')
                            ->required()
                            ->title('Start Date And Time')
                            ->placeholder('YYYY-MM-DDTHH:MM')
                            ->horizontal(),
                ]),

                Group::make([
                    

                    Select::make('status')
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

                        Input::make('class_time_range')
                        ->type('number')
                        ->required()
                        ->title('Class Time Range')
                        ->placeholder('Enter Class Time Range')
                        ->help('Enter Class Time Range in minutes')
                        ->horizontal(),
                ]),

                SimpleMDE::make('description')
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

                Group::make([
                    Input::make('time_table.monday')
                            ->type('time')
                            ->title('Monday')
                            ->placeholder('HH:MM'),

                            Input::make('time_table.tuesday')
                            ->type('time')
                            ->title('Tuesday')
                            ->placeholder('HH:MM'),

                            Input::make('time_table.wednesday')
                            ->type('time')
                            ->title('Wednesday')
                            ->placeholder('HH:MM'),

                            Input::make('time_table.thursday')
                            ->type('time')
                            ->title('Thursday')
                            ->placeholder('HH:MM'),

                            Input::make('time_table.friday')
                            ->type('time')
                            ->title('Friday')
                            ->placeholder('HH:MM'),

                            Input::make('time_table.saturday')
                            ->type('time')
                            ->title('Saturday')
                            ->placeholder('HH:MM'),

                            Input::make('time_table.sunday')
                            ->type('time')
                            ->title('Sunday')
                            ->placeholder('HH:MM'),

                    
                ]),

              

                Button::make('Submit')
                    ->method('SaveNewClass')
                    ->style('width: 100%;display: flex;align-items: center;justify-content: center;background: #AA81A0 !important;color: white !important;font-weight: bold;')
                    ->type(Color::BASIC),
            ]),
        ];
    }


    public function SaveNewClass(Request $request)
    {
        $class_fees_date = json_encode($request->input('class_fees_date'), JSON_PRETTY_PRINT);
        // $class_date = json_encode($request->input('class_date'), JSON_PRETTY_PRINT);
        $grade = implode(",", $request->grade);

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
        

        // Generate slug if not provided
        $request->merge([
            'slug' => $request->input('slug') ?? Str::slug($request->input('name'))
        ]);

        // Validate the form input
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:classes,slug', // Update the table name to 'classes'
        ]);

        $newClass = new Classes();

        $newClass->name = $request->input('name');
        $newClass->slug = $request->input('slug');
        $newClass->grade = $grade;
        $newClass->class_dates = null;
        $newClass->image = $imagePath ?? null;
        $newClass->class_category = $request->input('class_category');
        $newClass->class_type = $request->input('class_type');
        $newClass->class_year = $request->input('class_year');
        $newClass->class_time_range = $request->input('class_time_range');
        $newClass->class_fees = $request->input('class_fees');
        $newClass->class_fees_date = $class_fees_date;
        $newClass->class_start_date = $request->input('class_start_date');
        $newClass->status = $request->input('status');
        $newClass->description = $request->input('description');
        $newClass->save();

        $newTimeTable = new Timetable();

        $newTimeTable->monday = $request->input('time_table.monday');
        $newTimeTable->tuesday = $request->input('time_table.tuesday');
        $newTimeTable->wednesday = $request->input('time_table.wednesday');
        $newTimeTable->thursday = $request->input('time_table.thursday');
        $newTimeTable->friday = $request->input('time_table.friday');
        $newTimeTable->saturday = $request->input('time_table.saturday');
        $newTimeTable->sunday = $request->input('time_table.sunday');
        $newTimeTable->class_id = $newClass->id;
        $newTimeTable->save();

        Alert::info('You have successfully created a new class.');
    }
}
