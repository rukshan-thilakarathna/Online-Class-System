<?php

namespace App\Orchid\Screens\Student;

use App\Models\Student;
use App\Orchid\Layouts\Student\StudentListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class StudentListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $students = Student::where('type', '=', 0)->filters()->orderBy('created_at', 'DESC')
        ->get();
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
        return 'All Students';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Today Birthdays')->icon('clock')->route('platform.systems.students.today-birthdays'),
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
            StudentListLayout::class
        ];
    }
}
