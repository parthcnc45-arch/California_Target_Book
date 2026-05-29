<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\Cache\Repository;

class CacheDirectiveProvider extends ServiceProvider
{

    const prefix = 'cache-directive';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerDirectives();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function parseMultipleArgs($expression)
    {
        return collect(explode(',', $expression))->map(function ($item) {
            return trim($item);
        });
    }

    public function registerDirectives() {

	return FALSE;
        /**
         * Expects parameters:
         *  cache($name, $lifetime, $use)
         *      @param string - $name - Unique name for cached section
         *      @param int - $lifetime (optional) - Time in minutes to cache section
         *      @param array - $use (optional) - variables to pass to closure
         */
        Blade::directive('cache', function($expression) {
            $expression = rtrim($expression, ')');

            // Get use () variables
            preg_match('/\[(.*?)\]/', $expression, $match);

            $use = '';
            if (isset($match[1])) {
                $use = 'use ('.$match[1].')';
            }

            // Create leading param string
            list($name, $lifetime) = explode(',', $expression);
            if (is_numeric($lifetime)) {
                $params = join(', ', [$name, $lifetime]);
            } else {
                $params = $name;
            }

           return "<?php echo App\\Providers\\CacheDirectiveProvider::section($params, function() $use { ?>";
        });
        Blade::directive('endcache', function() {
            return '<?php }); ?>';
        });

    }

    /**
     * Register a section to cache
     *
     * @param string       $name
     * @param int          $lifetime
     * @param Closure|null $contents
     *
     * @return string
     */
    public static function section($name, $lifetime, $contents = null)
    {

        if (empty($contents)) {
            // Life time is optional,
            // defaults to forever
            $contents = $lifetime;
            unset($lifetime);
        }

        $render = function () use ($contents) {
            ob_start();
            $contents();
            return ob_get_clean();
        };

        if (isset($lifetime)) {
            return \Cache::remember(self::prefix . $name, $lifetime, $render);
        } else {
            return \Cache::rememberForever(self::prefix . $name, $render);
        }
    }

}
