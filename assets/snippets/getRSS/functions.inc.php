<?php
if(!function_exists(('evo'))) {
    function evo() {
        global $modx;
        return $modx;
    }
}
if(!function_exists(('array_get'))) {
    function array_get($array, $key, $default=null) {
        if(!isset($array[$key])) {
            return $default;
        }
        return $array[$key];
    }
}

class getRss {
    public function simplepie_object() {
        static $feed = null;
        if($feed) {
            return $feed;
        }
        //where is simplepie?
        require_once(__DIR__ . '/simplepie/autoloader.php');

        $feed = new SimplePie();
        $feed->set_feed_url(static::param('url'));
        if(!is_dir(MODX_BASE_PATH . 'assets/cache/rss/')) {
            mkdir(MODX_BASE_PATH . 'assets/cache/rss/', 0777, true);
        }
        $feed->set_cache_location(MODX_BASE_PATH . 'assets/cache/rss/');
        $feed->set_cache_duration(1800);
        return $feed;
    }
    
    public function format() {
        static $format = null;

        if($format) {
            return $format;
        }

        if(static::param('tpl')) {
            $format = evo()->getChunk(static::param('tpl'));
        } elseif(is_file(__DIR__ . '/default.tpl')) {
            $format = file_get_contents(__DIR__ . '/default.tpl');
        }
        if($format) {
            return $format;
        }

        exit('tpl is empty');
    }

    public function param($key, $default=null) {
        return array_get(evo()->event->params, $key, $default);
    }

    public function is_modifier() {
        global $value;
        return $value;
    }
}