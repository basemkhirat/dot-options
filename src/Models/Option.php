<?php

namespace Dot\Options\Models;

use Dot\Platform\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Option
 * @package Dot\Options\Models
 */
class Option extends Model
{

    /**
     * @var string
     */
    protected $table = "options";

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * is_localized attribute
     * @return bool
     */
    public function getIsLocalizedAttribute()
    {
        return !in_array($this->lang, [NULL, ""]);
    }

    /**
     * Delete options cache on deleting and saving
     */
    public static function boot()
    {

        parent::boot();

        static::saved(function () {
            //Cache::forget("platform.options");
        });

        static::deleted(function () {
            //Cache::forget("platform.options");

        });
    }


}
