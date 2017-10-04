<?php

namespace Dot\Options\Controllers;

use Dot;
use Dot\Options\Models\Option;
use Dot\Platform\Controller;
use File;
use Gate;
use Redirect;
use Request;
use Session;
use View;


class OptionsController extends Controller
{

    protected $data = [];


    function index()
    {

        if (Request::isMethod("post")) {

            $options = Request::except("_token");

            $options["site_status"] = Request::get("site_status", 0);

            if (Request::has("app_locale")) {
                Session::put("locale", Request::get("app_locale"));
            }

            Option::store($options);

            return Redirect::back()
                ->with("message", trans("options::options.events.saved", [], "messages", Request::get("app_locale")));
        }
        $this->data["option_page"] = "main";
        return View::make("options::show", $this->data);
    }

    function check_update()
    {

        $version = Dot::check();

        if ($version) {

            Option::store([
                "latest_version" => $version->version
            ]);

            $this->data["version"] = $version->version;
        } else {
            $this->data["version"] = false;
        }

        return View::make("options::update", $this->data);

    }

    function seo()
    {

        if (Request::isMethod("post")) {

            // creating sitemap directory if not exists
            $sitemap_path = Request::get("sitemap_path");
            if (!File::exists($sitemap_path)) {
                File::makeDirectory($sitemap_path, 0777, true, true);
                //Sitemap::refresh();
            }

            $options = Request::except("_token");

            $options["sitemap_status"] = Request::get("sitemap_status", 0);
            $options["sitemap_xml_status"] = Request::get("sitemap_xml_status", 0);
            $options["sitemap_html_status"] = Request::get("sitemap_html_status", 0);
            $options["sitemap_txt_status"] = Request::get("sitemap_txt_status", 0);
            $options["sitemap_ping"] = Request::get("sitemap_ping", 0);
            $options["sitemap_google_ping"] = Request::get("sitemap_google_ping", 0);
            $options["sitemap_bing_ping"] = Request::get("sitemap_bing_ping", 0);
            $options["sitemap_yahoo_ping"] = Request::get("sitemap_yahoo_ping", 0);
            $options["sitemap_ask_ping"] = Request::get("sitemap_ask_ping", 0);

            Option::store($options);

            return Redirect::back()
                ->with("message", trans("options::options.events.saved"));
        }
        $this->data["option_page"] = "seo";
        return View::make("options::seo", $this->data);
    }

    function social()
    {

        if (Request::isMethod("post")) {

            Option::store(Request::except("_token"));

            Cache::forget("breaking_tweets");

            return Redirect::back()
                ->with("message", trans("options::options.events.saved"));
        }
        $this->data["option_page"] = "social";
        return View::make("options::social", $this->data);
    }

    function media()
    {

        if (Request::isMethod("post")) {

            $options = Request::except("_token");

            $options["media_thumbnails"] = Request::get("media_thumbnails", 0);
            $options["media_cropping"] = Request::get("media_cropping", 0);
            $options["media_watermarking"] = Request::get("media_watermarking", 0);
            $options["s3_status"] = Request::get("s3_status", 0);
            $options["s3_delete_locally"] = Request::get("s3_delete_locally", 0);

            $options["resize_mode"] = Request::get("media_resize_mode", "resize_crop");
            $options["resize_background_color"] = Request::get("resize_background_color", "#FFFFFF");
            $options["resize_gradient_first_color"] = Request::get("resize_gradient_first_color", "#FFFFFF");
            $options["resize_gradient_second_color"] = Request::get("resize_gradient_second_color", "#000000");

            // dd($options);

            // background_color
            Option::store($options, "media");

            return Redirect::back()
                ->with("message", trans("options::options.events.saved"));
        }
        $this->data["option_page"] = "media";
        return View::make("options::media", $this->data);
    }

}
