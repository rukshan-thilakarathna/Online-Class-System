<?php

namespace App\Orchid\Screens\Student;

use App\Models\Student;
use App\Orchid\Layouts\Student\GuardiansListLayout;
use Orchid\Screen\Screen;

class GuardiansListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $guardians = Student::where('type', '=', 1)->filters()->orderBy('created_at', 'DESC')
        ->get();
        return [
            'guardians' => $guardians
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'All Guardians';
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
            GuardiansListLayout::class
        ];
    }
}
