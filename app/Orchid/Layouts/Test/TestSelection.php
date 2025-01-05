<?php

namespace App\Orchid\Layouts\Test;

use App\Orchid\Filters\TestTypeStatusFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class TestSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TestTypeStatusFilter::class
        ];
    }
}
