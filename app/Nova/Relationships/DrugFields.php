<?php

namespace App\Nova;

use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class DrugFields
{
    /**
     * Get the pivot fields for the relationship.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model  $relatedModel
     * @return array
     */
    public function __invoke($request, $relatedModel)
    {
        return [
            Textarea::make('Ghi chú', 'note')
                ->rules('max:255')
                ->onlyOnForms(),

            Text::make('Ghi chú', 'note')
                ->rules('max:255')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Ngày sử dụng', 'created_at')
                ->displayUsing(fn ($value) => $value->format('d/m/Y'))
                ->exceptOnForms(),

            DateTime::make('Ngày sửa đổi', 'updated_at')
                ->displayUsing(fn ($value) => $value->format('d/m/Y'))
                ->hideWhenCreating()
                ->hideFromIndex()
        ];
    }
}
