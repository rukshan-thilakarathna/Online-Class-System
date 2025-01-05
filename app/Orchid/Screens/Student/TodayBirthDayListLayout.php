<?php

namespace App\Orchid\Screens\Student;

use App\Models\Student;
use App\Orchid\Layouts\Student\TodayBirthDayListLayout as StudentTodayBirthDayListLayout;
use Orchid\Screen\Screen;

class TodayBirthDayListLayout extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {

        // Retrieve students where type = 0 and birth_date matches today
        $students = Student::where('type', 0)
    ->whereDate('birthday', date('Y-m-d')) // Ensures correct date format comparison
    ->filters() // Custom method or scope, ensure implementation
    ->get();
    
        // Return the result as an iterable
        return [
            'students' => $students
        ];
    }
    

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Today BirthDay List';
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
            StudentTodayBirthDayListLayout::class
        ];
    }
}
