<?php

namespace App\Orchid\Layouts\Tute;

use App\Orchid\Filters\TuteStatusFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class TutesSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TuteStatusFilter::class
        ];
    }
}
