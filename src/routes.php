<?php

/*
 * WEB
 */
Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
    $route->group(array("prefix" => "options"), function($route) {
        $route->any('/', array("as" => "admin.options.show", "uses" => "Dot\Options\Controllers\OptionsController@index"))->middleware('can:options.general');
        $route->any('/seo', array("as" => "admin.options.seo", "uses" => "Dot\Options\Controllers\OptionsController@seo"))->middleware('can:options.seo');
        $route->any('/modules', array("as" => "admin.options.modules", "uses" => "Dot\Options\Controllers\OptionsController@modules"));
        $route->any('/media', array("as" => "admin.options.media", "uses" => "Dot\Options\Controllers\OptionsController@media"))->middleware('can:options.media');
        $route->any('/social', array("as" => "admin.options.social", "uses" => "Dot\Options\Controllers\OptionsController@social"))->middleware('can:options.social');
        $route->any('/plugins', array("as" => "admin.options.plugins", "uses" => "Dot\Options\Controllers\OptionsController@plugins"));
        $route->any('/check_update', array("as" => "admin.options.check_update", "uses" => "Dot\Options\Controllers\OptionsController@check_update"));
        $route->any('/plugins/activation/{name}/{status}/{step?}', array("as" => "admin.plugins.activation", "uses" => "Dot\Options\Controllers\OptionsController@plugin"));
    });
});

Route::any('sitemap', array("as" => "admin.sitemap.update", "uses" => 'SitemapController@update'));

/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"]
], function ($route) {
    $route->get("/options/show", "Dot\Options\Controllers\OptionsApiController@show");
    $route->post("/options/create", "Dot\Options\Controllers\OptionsApiController@create");
    $route->post("/options/update", "Dot\Options\Controllers\OptionsApiController@update");
    $route->post("/options/destroy", "Dot\Options\Controllers\OptionsApiController@destroy");
});


