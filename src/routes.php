<?php

use Dot\Options\Facades\Option;

/*
 * WEB
 */
Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:options.manage"],
    "namespace" => "Dot\\Options\\Controllers"
], function ($route) {
    $route->group(["prefix" => "options"], function ($route) {


        foreach (Option::pages() as $page) {
            $route->any('/{page?}', ["as" => "admin.options", "uses" => "OptionsController@index"]);
        }
    });
});
