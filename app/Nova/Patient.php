<?php

namespace App\Nova;

use App\Nova\Actions\AddDayAction;
use App\Nova\Drug;
use App\Nova\Day;
use App\Nova\Prescription;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\DateTime;

class Patient extends Resource
{
    public static function label() {
        return 'Bệnh Nhân';
    }

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
    public static $perPageOptions = [5, 10, 25, 50];

    public static function indexQuery(NovaRequest $request, $query) {
        // adds a `tags_count` column to the query result based on 
        // number of tags associated with this product
        return $query->withCount('days'); 
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

            Number::make('Số ngày điều trị', 'days_count')
            ->textAlign('center')
            ->onlyOnIndex()
            ->sortable(),

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

            DateTime::make('Ngày vào', 'created_at')
                ->onlyOnIndex()
                ->displayUsing(fn ($value) => $value->format('d/m/Y'))
                ->sortable(),

            Boolean::make('Điều trị', 'active'),

            BelongsToMany::make('Thuốc', 'drugs', Drug::class)
                ->rules('required')
                ->showCreateRelationButton()
                ->allowDuplicateRelations()

                ->fields(new DrugFields()),

            BelongsToMany::make('Ngày điều trị', 'days', Day::class)
                ->rules('required')
                ->fields(new DayFields())
                ->allowDuplicateRelations(),

            HasMany::make('Đơn thuốc đông y', 'prescriptions', Prescription::class)
                ->rules('required'),
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
        return [
                Actions\AddDayAction::make()
                    ->confirmText('Bạn chắc chắn. Muốn thêm ngày điều trị ?')
                    ->confirmButtonText('Thêm')
                    ->cancelButtonText("Không"),
        ];
    }
}
