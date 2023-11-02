<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;

class Drug extends Resource
{
    public static function label() {
        return 'Thuốc Tây Y';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Drug>
     */
    public static $model = \App\Models\Drug::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * The pagination per-page options configured for this resource.
     *
     * @return array
     */
    public static $perPageOptions = [5, 10, 25, 50];

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

            Text::make('Tên:', 'name')
                ->rules(['required', 'min:1', 'max:255']),

            Textarea::make('Ghi chú:', 'note')
                ->rules(['min:1'])
                ->showOnCreating()
                ->showOnUpdating()
                ->showOnPreview(),

            DateTime::make('Ngày thêm:', 'updated_at')
            ->rules(['required'])
            ->hideFromIndex()
            ->showOnDetail()
            ->showOnPreview()
            ->displayUsing(fn($value) => $value->format('d/m/Y')),
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
