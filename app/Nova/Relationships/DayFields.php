<?php

namespace App\Nova;

use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class DayFields
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
            Number::make('Điều trị hôm nay', 'price')
                ->textAlign('center'),

            DateTime::make('Ngày điều trị', 'created_at')
                ->textAlign('center')
                ->displayUsing(fn ($value) => $value->format('d/m/Y'))
                ->hideFromIndex()
                ->hideWhenCreating()
        ];
    }
}
