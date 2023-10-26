<?php

namespace App\Nova;

use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;

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
            ->rules(['min:1', 'max:255']),

            DateTime::make('Ngày sử dụng', 'date')
            ->rules(['required']),
        ];
    }
}