<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Day;
use Carbon\Carbon;
use Laravel\Nova\Fields\Number;

class AddDayAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = "Thêm ngày điều trị --";

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $day = Day::latest()->first();

        if (!$day) {
            Day::create();
        } else {
            $now = Carbon::now()->format('d/m/Y');
            $date = $day->created_at;
            $time = $date->format('d/m/Y');
            if ($time != $now) {
                Day::Create();
            }
        }
            
        foreach ($models as $model) {
            $days = Day::latest()->first();
            $model->days()->attach($days['id']);
            $model->days()->update([
                'price' => $fields->price
            ]);
        }

    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Number::make('Giá tiền', 'price')
                    ->rules('required')
                    ->default(fn() => 100000),
        ];
    }
}
