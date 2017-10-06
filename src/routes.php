<?php

/*
 * WEB
 */
Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend"],
    "namespace" => "Dot\\Options\\Controllers"
], function ($route) {
    $route->group(["prefix" => "options"], function ($route) {
        $route->any('/', ["as" => "admin.options.show", "uses" => "OptionsController@index"])->middleware('can:options.general');
        $route->any('/seo', ["as" => "admin.options.seo", "uses" => "OptionsController@seo"])->middleware('can:options.seo');
        $route->any('/media', ["as" => "admin.options.media", "uses" => "OptionsController@media"])->middleware('can:options.media');
        $route->any('/social', ["as" => "admin.options.social", "uses" => "OptionsController@social"])->middleware('can:options.social');
        $route->any('/check_update', ["as" => "admin.options.check_update", "uses" => "OptionsController@check_update"]);
        $route->get('google/keywords', ["as" => "admin.google.search", "uses" => "ServicesController@keywords"]);
    });
});

Route::any('sitemap', ["as" => "admin.sitemap.update", "uses" => 'SitemapController@update']);

/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"],
    "namespace" => "Dot\\Options\\Controllers"
], function ($route) {
    $route->get("/options/show", "OptionsApiController@show");
    $route->post("/options/create", "OptionsApiController@create");
    $route->post("/options/update", "OptionsApiController@update");
    $route->post("/options/destroy", "OptionsApiController@destroy");
});


