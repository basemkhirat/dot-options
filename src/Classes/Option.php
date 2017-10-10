<?php

namespace Dot\Options\Classes;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

/**
 * Class Option
 * @package Dot\Platform\Classes
 */
class Option
{

    /**
     * Option pages
     * @var array
     */
    public static $pages = [];


    /**
     * @var array
     */
    public static $all = [];

    public static $page;


    /**
     * System options
     * @var array
     */
    public static $options = [];

    /**
     * Option constructor.
     */
    function __construct()
    {

        /**
         * Load all system options from database
         */
        try {

            foreach (DB::table("options")->get() as $option) {
                self::$options[$option->name] = $option->value;
            }

        } catch (QueryException $exception) {
            abort(400, "Dot Platform is not installed");
        }
    }

    /**
     * Check option name is exists
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, self::$options);
    }

    /**
     * Get option value by name
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public function get($name, $default = NULL)
    {
        return array_key_exists($name, self::$options) ? self::$options[$name] : $default;
    }

    /**
     * Create or update options
     * @param $name
     * @param null $value
     */
    public function set($name, $value = NULL)
    {

        if (array_key_exists($name, self::$options)) {

            if (self::$options[$name] != $value) {

                self::$options[$name] = $value;

                // Sync changes with database

                DB::table("options")->where("name", $name)->update(["value" => $value]);
            }

        } else {

            self::$options[$name] = $value;

            // Sync changes with database

            DB::table("options")->insert([
                "name" => $name,
                "value" => $value
            ]);

        }
    }

    /**
     * Delete option by name
     * @param $name
     */
    public function delete($name)
    {

        if (array_key_exists($name, self::$options)) {

            unset(self::$options[$name]);

            // Sync changes with database

            DB::table("options")->where("name", $name)->delete();
        }
    }

    public function page($name, $callback = false)
    {

        if (!in_array($name, self::$all)) {
            self::$all[] = $name;
        }

        Event::listen($name . '.options', function () use ($name, $callback) {

            self::$page = new self();

            self::$page->name = $name;
            self::$page->title = "";
            self::$page->order = 0;
            self::$page->icon = "fa-sliders";
            self::$page->permission = NULL;
            self::$page->views = [];

            call_user_func_array($callback, [self::$page]);

            self::$pages[$name] = self::$page;
        });

    }

    public function getPage($name)
    {
        return array_key_exists($name, self::$pages) ? self::$pages[$name] : false;
    }


    public function pages()
    {

        foreach (self::$all as $name) {
            Event::fire($name . ".options");
        }

        if(count(self::$pages)){
            self::$pages = collect(self::$pages)->where("views", "!=", [])->toArray();
        }

        return self::$pages;
    }

    /**
     * Set name of page
     * @param string $name
     * @return mixed
     */
    function name($name)
    {
        self::$page->name = $name;
        return self::$page;
    }

    /**
     * Set title of page
     * @param string $title
     * @return mixed
     */
    function title($title = "")
    {
        self::$page->title = $title;
        return self::$page;
    }

    /**
     * Set icon of page
     * @param string $icon
     * @return mixed
     */
    function icon($icon = "")
    {
        self::$page->icon = $icon;
        return self::$page;
    }

    /**
     * Set page order
     * @param int $order
     * @return mixed
     */
    function order($order = 0)
    {
        self::$page->order = $order;
        return self::$page;
    }

    /**
     * Set page permission
     * @param string $permission
     * @return mixed
     */
    function permission($permission = NULL)
    {
        self::$page->permission = $permission;
        return self::$page;
    }

    /**
     * Set page view
     * @param $view
     * @param array $payload
     * @return mixed
     */
    function view($view, $payload = [])
    {
        self::$page->views[$view] = $payload;
        return self::$page;
    }

}
