<?php

namespace App\Nova;

use App\Models\TraditionalMed;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

use function Laravel\Prompts\select;

class Prescription extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Prescription>
     */
    public static $model = \App\Models\Prescription::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */

    protected $casts = [
        'flexible-content' => FlexibleCast::class
    ];

    public function getMed() {
        $nameMedicines = TraditionalMed::pluck('name');

        return $nameMedicines;
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Tên đơn thuốc' , 'name'),
            DateTime::make('Ngày tạo đơn thuốc', 'created_at')
                ->displayUsing(fn ($value) => $value->format('d/m/Y'))
                ->onlyOnIndex(),

            Flexible::make('Content')
            ->addLayout('Loại thuốc', 'wysiwyg', [
                Select::make('Tên thuốc:', 'content')
                    ->searchable()
                    ->displayUsingLabels()
                    ->options($this->getMed()),
                Text::make('Cân nặng (g):', 'weight'),
            ])
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
