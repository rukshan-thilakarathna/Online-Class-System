<?php

namespace App\Orchid\Screens\Classes;

use App\Models\Classes;
use App\Orchid\Filters\ClassTypeFilter;
use App\Orchid\Layouts\Classes\ClassesLayout;
use App\Orchid\Layouts\Classes\ClassSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ClassesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $classes = Classes::with('GetType', 'GetCategory')
            ->defaultSort('id', 'desc')
            ->filtersApplySelection(ClassSelection::class)
            ->filters()
            ->paginate(10);

        return [
            'Classes' => $classes
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Classes';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add')->icon('plus')->route('platform.systems.classes.create'),
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
            ClassSelection::class,
            ClassesLayout::class
        ];
    }

    public function remove(Request $request): void
    {

        $tuteId = $request->get('id');

        // First, delete the related records in ClassHasTutes

        try {
            Classes::findOrFail($tuteId)->delete();

        
        Toast::info(__('Class was removed'));
        } catch (\Exception $e) {
            Toast::info(__('Class was not removed'));
        }
    }
}
