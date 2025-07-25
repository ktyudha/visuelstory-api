<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Request::macro('apiValidate', function ($rules) {
            $validator = Validator::make($this->all(), $rules);

            if ($validator->fails()) {
                throw new HttpResponseException(
                    response()->json([
                        'status' => 'error',
                        'message' => 'Format data tidak sesuai!',
                        'data' => $validator->errors(),
                    ], Response::HTTP_BAD_REQUEST)
                );
            }

            return collect($validator->validated());
        });
    }
}
