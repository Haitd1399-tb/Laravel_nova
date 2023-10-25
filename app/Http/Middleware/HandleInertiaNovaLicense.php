<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Laravel\Nova\Http\Middleware\HandleInertiaRequests;
use Laravel\Nova\Http\Resources\UserResource;
use Laravel\Nova\Nova;

class HandleInertiaNovaLicense extends HandleInertiaRequests
{
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'validLicense' => function () {
                return true;
            },
        ]);
    }
}
