<?php

namespace App\Orchid\Layouts\Classes;

use App\Orchid\Filters\ClassCategoryFilter;
use App\Orchid\Filters\ClassStatusFilter;
use App\Orchid\Filters\ClassTypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ClassSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            ClassTypeFilter::class,

            ClassCategoryFilter::class,

            ClassStatusFilter::class
        ];
    }
}
