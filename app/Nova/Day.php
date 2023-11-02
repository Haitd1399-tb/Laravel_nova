<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Day extends Resource
{
    public static function label() {
        return 'Ngày Điều Trị';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Day>
     */
    public static $model = \App\Models\Day::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'created_at';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'note', 
        'created_at'
    ];
    
    /**
     * The pagination per-page options configured for this resource.
     *
     * @return array
     */
    public static $perPageOptions = [5, 10, 25, 50];

    public static function indexQuery(NovaRequest $request, $query) {
        // adds a `tags_count` column to the query result based on 
        // number of tags associated with this product
        return $query->withCount('patients'); 
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Number::make('Số người điểu trị', 'patients_count')
                ->textAlign('center')
                ->onlyOnIndex()
                ->sortable(),

            Textarea::make('Ghi chứ', 'note')
                ->showOnCreating()
                ->showOnPreview()
                ->hideFromIndex(),

            Date::make('Ngày điều trị', 'created_at')
                ->textAlign('center')
                ->displayUsing(fn($value) => $value->format('d/m/Y'))
                ->showOnIndex()
                ->showOnDetail(),

            BelongsToMany::make('Người bệnh', 'patients', patient::class)
            // DateTime::make('Updated at')
            //     ->displayUsing(fn ($value) => $value->format('d/m/Y'))
            //     ->hideWhenCreating(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
