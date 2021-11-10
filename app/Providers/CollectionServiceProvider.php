<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('recursive', function () {
            return $this->whenNotEmpty($recursive = function ($item) use (&$recursive) {
                if (is_array($item)) {
                    return $recursive(new static($item));
                } elseif ($item instanceof Collection) { // <-- Should have added \Illuminate\Support\Collection
                    $item->transform(static function ($collection, $key) use ($recursive, $item) {
                        return $item->{$key} = $recursive($collection);
                    });
                } elseif (is_object($item)) {
                    foreach ($item as $key => &$val) {
                        $item->{$key} = $recursive($val);
                    }
                }
                return $item;
            });
        });
    }
}
