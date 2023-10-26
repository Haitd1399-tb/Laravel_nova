<?php

namespace App\Nova;

use App\Models\Drug;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Date;

class Patient extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Patient>
     */
    public static $model = \App\Models\Patient::class;

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
        'address',
        'phone'
    ];

        /**
     * The pagination per-page options configured for this resource.
     *
     * @return array
     */
    public static $perPageOptions = [5, 10, 25];

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

            Text::make('Họ và tên', 'name')
                ->rules(['required', 'min:4', 'max:50']),

            Number::make('Tuổi', 'age')
                ->rules(['required'])
                ->textAlign('center')
                ->sortable(),

            Text::make('Địa chỉ', 'address')
                ->rules(['required', 'min:1', 'max:255']),

            Text::make('Điên thoại', 'phone')
            ->rules(['required', 'min:1', 'max:15']),

            Text::make('Ghi chú', 'note')
                ->onlyOnIndex(),

            Textarea::make('Ghi chú', 'note')
                ->rules(['required', 'min:1', 'max:255'])
                ->showOnDetail()
                ->showOnUpdating()
                ->showOnCreating(),

            Date::make('Ngày vào', 'created_at')
                ->onlyOnIndex()
                ->displayUsing(fn ($value) => $value->format('d/m/Y'))
                ->sortable(),

            Boolean::make('Điều trị', 'active'),

            BelongsToMany::make('Drugs')
                ->rules('required')
                ->showCreateRelationButton()
                ->allowDuplicateRelations()
                ->fields(new DrugFields()),

            BelongsToMany::make('Days')
                ->rules('required')
                ->allowDuplicateRelations(),

        ];
    }

    // /**
    //  * Get the fields displayed by the resource on create page.
    //  *
    //  * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
    //  * @return array
    //  */
    // public function fieldsForCreate(NovaRequest $request)
    // {
    //     return [
    //         Text::make('Họ và tên', 'name')->rules('required', 'min:1', 'max: 20'),
    //         Number::make('Tuổi', 'age')->rules('required', 'max:255'),
    //         Text::make('Địa chỉ', 'address')->rules('required', 'max:255'),
    //         Text::make('Điện thoại', 'phone')->rules('required'),
    //         Textarea::make('Ghi chú', 'note'),

    //         BelongsToMany::make('Drugs')                
    //             ->showCreateRelationButton()
    //             ->allowDuplicateRelations(),
    //         BelongsToMany::make('Days')
    //             ->allowDuplicateRelations(),

    //     ];
    // }

    //     /**
    //  * Get the fields displayed by the resource on detail page.
    //  *
    //  * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
    //  * @return array
    //  */
    // public function fieldsForDetail(NovaRequest $request)
    // {
    //     return [
    //         ID::make()->sortable(),
    //         Text::make('Họ và tên', 'name'),
    //         Number::make('Tuổi', 'age'),
    //         Text::make('Địa chỉ', 'address'),
    //         Text::make('Điện thoại', 'phone'),
    //         Date::make('Ngày vào','created_at')
    //             ->displayUsing(fn ($value) => $value->format('d/m/y')),
    //         Textarea::make('Ghi chú', 'note'),
    //         Boolean::make('Trạng thái', 'active'),

    //         BelongsToMany::make('Drugs')
    //             ->showCreateRelationButton()
    //             ->allowDuplicateRelations()
    //             ->fields(fn () => [
    //                 // ID::make()->sortable(),
    //                 Date::make('Created At', 'created_at'),
    //             ]),
    //         BelongsToMany::make('Days')
    //             // ->withSubtitles()
    //             ->allowDuplicateRelations(),
    //     ];
    // }

    //         /**
    //  * Get the fields displayed by the resource on update page.
    //  *
    //  * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
    //  * @return array
    //  */
    // public function fieldsForUpdate(NovaRequest $request)
    // {
    //     return [
    //         Text::make('Name', 'name')->rules(['required', 'min:1', 'max:50']),
    //         Number::make('Tuổi', 'age')->rules(['required', 'min:1', 'max:150']),
    //         Text::make('Địa chỉ', 'address')->rules(['required', 'min:1', 'max:255']),
    //         Text::make('Điện thoại', 'phone')->rules(['required', 'min:1']),
    //         Date::make('Ngày vào', 'created_at')
    //             ->rules('required')
    //             ->displayUsing(fn ($value) => $value->format('d/m/y')),
    //         Textarea::make('Ghi chú', 'note'),
    //         Boolean::make('Active')->rules('required'),

    //         BelongsToMany::make('Drugs'),
    //         BelongsToMany::make('Days'),
    //     ];
    // }

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
        return [
            new Filters\ActiveFilter,
            new Filters\CreatedAtFilter,
        ];
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
