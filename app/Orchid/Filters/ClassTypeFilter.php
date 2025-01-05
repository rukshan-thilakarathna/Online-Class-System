<?php

namespace App\Orchid\Filters;

use App\Models\ClassTypes;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ClassTypeFilter extends Filter
{
   
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Class Types';
    }



    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['type'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('class_type', $this->request->get('type'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('type')
            ->fromModel(ClassTypes::class, 'name','id')
            ->empty()
            ->value($this->request->get('type'))
            ->title(__('Class Types')),
        ];
    }
}
