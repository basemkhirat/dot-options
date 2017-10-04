<?php

namespace Dot\Options;

use Illuminate\Support\Facades\Auth;
use Navigation;
use Roumen\Sitemap\SitemapServiceProvider;
use URL;

class Options extends \Dot\Platform\Plugin
{

    protected $providers = [
        SitemapServiceProvider::class
    ];

    public $permissions = [
        "general",
        "seo",
        "media",
        "social"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("options")) {

                $menu->item('options', trans("admin::common.settings"), "")
                    ->order(9)
                    ->icon("fa-cogs");

                if (Auth::user()->can("options.general")) {
                    $menu->item('options.main', trans("options::options.main"), URL::to(ADMIN . '/options'))
                        ->icon("fa-sliders");
                }

                if (Auth::user()->can("options.seo")) {
                    $menu->item('options.seo', trans("options::options.seo"), URL::to(ADMIN . '/options/seo'))
                        ->icon("fa-line-chart");
                }

                if (Auth::user()->can("options.media")) {
                    $menu->item('options.media', trans("options::options.media"), URL::to(ADMIN . '/options/media'))
                        ->icon("fa-camera");
                }

                if (Auth::user()->can("options.social")) {
                    $menu->item('options.social', trans("options::options.social"), URL::to(ADMIN . '/options/social'))
                        ->icon("fa-globe");
                }
            }

        });

        Navigation::menu("topnav", function ($menu) {
            $menu->make("options::locales");
        });

        Navigation::menu("topnav", function ($menu) {
            if (Auth::user()->can("options.general")) {
                $menu->make("options::dropmenu");
            }
        });
    }
}
