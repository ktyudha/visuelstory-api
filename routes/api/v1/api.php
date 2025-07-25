<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {

    // import api user
    require __DIR__ . '/user.php';

    // import api global
    require __DIR__ . '/global.php';
});
