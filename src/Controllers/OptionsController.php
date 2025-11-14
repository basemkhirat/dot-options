<?php

namespace Dot\Options\Controllers;

use Dot\Platform\Facades\Dot;
use Dot\Options\Facades\Option;
use Dot\Platform\Controller;
use Dot\Platform\Facades\Action;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

/**
 * Class OptionsController
 * @package Dot\Options\Controllers
 */
class OptionsController extends Controller
{

    /**
     * View payload
     * @var array
     */
    protected $data = [];


    /**
     * Render the option page
     * @param $page
     * @return mixed
     */
    function index($page = false)
    {

        if (!$page) return redirect()->route("admin.options", ["page" => "general"]);

        if (Request::isMethod("post")) {

            foreach (Request::get("option") as $name => $value) {

                // Fire saving action

                Action::fire("option.saving", $name, $value);

                Option::set($name, $value);

                // Fire saved action

                Action::fire("option.saved", $name, $value);
            }

            return redirect()->back()
                ->with("message", trans("options::options.events.saved", [], "messages", option("site_locale")));
        }

        $this->data["option_pages"] = Option::pages();
        $this->data["option_page"] = Option::getPage($page);

        return View::make("options::show", $this->data);
    }
}
