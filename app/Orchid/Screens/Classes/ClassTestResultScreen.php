<?php

namespace App\Orchid\Screens\Classes;

use App\Models\Classes;
use App\Models\Student;
use App\Models\StudentHasTest;
use App\Models\Test;
use App\Orchid\Layouts\Classes\ClassTestResultListLayout;
use Orchid\Screen\Screen;

class ClassTestResultScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Classes $class_id, Test $test_id, $student_id = null): iterable
    {
        // Start the query
        $query = StudentHasTest::where('class_id', $class_id->id)
            ->with('student', 'test', 'class')
            ->where('test_id', $test_id->id);
    
        // Add conditionally based on $student_id
        if ($student_id) {
            $query->where('student_id', $student_id);
        }
    
        // Apply filters and get results
        $result = $query->filters()->get();
    
        return [
            'result' => $result
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Class Test Result Screen';
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
            ClassTestResultListLayout::class
        ];
    }
}
