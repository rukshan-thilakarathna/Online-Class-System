<?php

namespace App\Orchid\Filters;

use App\Models\Test;
use App\Models\TestType;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class TestTypeStatusFilter extends Filter
{
   /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Type Status';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['test_type_id'];
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
        return $builder->where('test_type_id' , $this->request->get('test_type_id'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('test_type_id')
            ->fromModel(TestType::class, 'name','id')
            ->empty()
            ->value($this->request->get('test_type_id'))
            ->title(__('Test Type')),
        ];
    }
}
