<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Dashboards\Main;
use App\Nova\Day;
use App\Nova\Drug;
use App\Nova\Patient;
use App\Nova\TraditionalMed;
use App\Nova\User;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;


class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        Nova::userLocale(function () {
            return match (app()->getLocale()) {
                'en' => 'en-US',
                default => null,
            };
        });
        
        parent::boot();

        Nova::withBreadcrumbs();

        Nova::mainMenu(fn ($request) => [
            MenuSection::make('Bệnh Nhân', [
                MenuItem::resource(Patient::class)
            ])->icon('user-group'),
            
            MenuSection::make('Thuốc', [
                MenuItem::resource(Drug::class),
                // MenuItem::resource(TraditionalMed::class),
            ])->icon('shopping-bag')->collapsable(),

            MenuSection::make('Ngày', [
                MenuItem::resource(Day::class),
            ])->icon('calendar')->collapsable(),
            
            MenuSection::make('Cài Đặt', [
                MenuItem::resource(User::class),
            ])->collapsable()->icon('cog'),
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'admin@gmail.com'
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
