<?php

/**
 * @todo : handling dynamically strategy
 */

class QiotaFront
{
    const PRODUCTIONMODE_BASEURI = 'https://www.qiota.com/assets/getQiota.js';
    const TESTMODE_BASEURI = 'https://beta.qiota.com/assets/getQiota.js';

    private static $token = null;
    private static $mode = null;
    private static $current_uri = null;

    public static function init() 
    {
        // only on frontend
        if (!is_admin()) {
            self::$current_uri = self::PRODUCTIONMODE_BASEURI;
            self::$mode = get_option('qiotamode');
            self::$token = get_option('qiotatoken');
            if (self::$mode == 'test') {
                self::$current_uri = self::TESTMODE;
            }

            add_filter('the_content', ['QiotaFront', 'handling_content']);
        }
    }

    public static function handling_content($content)
    {
        global $post;
        // only on posts for now
        if ($post->post_type == 'post') {
            add_action('wp_enqueue_scripts', ['QiotaFront', 'add_qiota_js']);
            $content = '<div class="qiota_reserve">' . $content . '</div><div class="qiota"></div>';
            $content .= "
                <script>
                    var q_token = '" . self::$token . "';
                    setupQiota(function(response) {
                        if(response) {
                            return;
                        }
                    });
                </script>
            ";
        }

        return $content;
    }

    public static function add_qiota_js()
    {
        wp_enqueue_script('getQiota', self::PRODUCTIONMODE_BASEURI, [], null, []);
    }

}