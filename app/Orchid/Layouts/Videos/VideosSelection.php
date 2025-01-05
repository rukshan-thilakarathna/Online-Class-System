<?php

namespace App\Orchid\Layouts\Videos;

use App\Orchid\Filters\VideoStatusFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class VideosSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            VideoStatusFilter::class
        ];
    }
}
