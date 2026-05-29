<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UtilServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public static $query_count = 0;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

    public static function query($sql)
    {
        self::$query_count++;
        error_log('SQL query count: ' . self::$query_count);

        $conn =  self::get_ctb_conn();
        return $conn->query($sql);
    }

    public static function require_ctb_api()
    {
        require_once(__DIR__.'/../../resources/views/old/php/ctb_api.php');
    }

    public static function get_ctb_conn()
    {
        require_once(__DIR__.'/../../resources/views/old/php/connections.php');
        return $GLOBALS['ctb_conn'];
    }
    public static function get_ctb_pdo()
    {
        $conn = \DB::connection('ctb_data')->getPdo();
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    // Set error reporting
    //  to ignore empty index operator errors
    public static function set_errors()
    {
        error_reporting( error_reporting() & ~E_NOTICE );
    }


    /**
     * Include file from old resource root
     * @param $file
     */
    public static function include($file)
    {
        include(__DIR__.'/../../resources/views/old/'.$file);
    }

    public static $view_root = __DIR__.'/../../resources/views/old/';
    public static $resource_root = __DIR__.'/../../public/';


    // Extract certain tags from html,
    // useful for getting rid of <style> or <script> elements
    public static function extractTags($html, $tags)
    {
        // Extract <style> and <script> tags
        $doc = new DOMDocument();
        $doc->loadHTML($html);

        $extracted = [];

        foreach ($tags as $tag) {
            $nodeList = $document->getElementsByTagName($tag);
            $extracted[$tag] = '';
            for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0; ) {
                $node = $nodeList->item($nodeIdx);
                $extracted[$tag] .= $node->textContent;
                $node->parentNode->removeChild($node);
            }
        }

        $extracted['html'] = $doc->saveHtml();

        return $extracted;
    }

}
