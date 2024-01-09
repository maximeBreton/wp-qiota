<?php

/**
 * @todo: See how to handling nonce on the admin settings page
 */

class QiotaAdmin
{
    private static $initiated = false;

    public static function init() 
    {
        if (!self::$initiated) {
            self::init_hooks();
        }

        if (isset($_POST['action']) && $_POST['action'] == 'qiota-update-config') {
            self::update_config();
        }
    }

    public static function init_hooks() 
    {
        self::$initiated = true;
        add_action('admin_init', array('QiotaAdmin', 'admin_init'));
        add_action('admin_menu', array('QiotaAdmin', 'admin_menu'));
        add_filter( 'plugin_action_links_'.plugin_basename( plugin_dir_path( __FILE__ ) . 'qiota.php'), array( 'QiotaAdmin', 'admin_plugin_settings_link' ));
    }

    public static function admin_init() 
    {
        if (get_option('Activated_Qiota')) {
            delete_option('Activated_Qiota');
            if (!headers_sent()) {
                $admin_url = self::get_page_url('init');
                wp_redirect($admin_url);
            }
        }

        load_plugin_textdomain('qiota');

        if (function_exists('wp_add_privacy_policy_content')) {
            wp_add_privacy_policy_content(
                __( 'Qiota', 'qiota' ),
                __( 'We collect information about visitors who comes on Sites. The information we collect depends on how the User sets up Qiota for the Site', 'qiota')
            );
        }
    }

    public static function admin_menu()
    {
        $hook = add_options_page( __( 'Qiota', 'qiota' ), __( 'Qiota', 'qiota' ), 'manage_options', 'qiota-key-config', array( 'QiotaAdmin', 'display_page' ) );
        add_action( "load-$hook", array( 'QiotaAdmin', 'admin_help' ) );
    }

    public static function admin_plugin_settings_link($links) 
    {
        $settings_link = '<a href="'.esc_url( self::get_page_url() ).'">'.__('Settings', 'qiota').'</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public static function get_page_url($page = 'config')
    {
        $args = ['page' => 'qiota-key-config'];
        return add_query_arg($args, menu_page_url('qiota-key-config', false));
    }

    public static function display_page() 
    {
        self::display_configuration_page();
    }

    public static function display_configuration_page()
    {
        Qiota::view('setup');
    }

    public static function admin_help()
    {
        // @todo : add help for settings about qiota
    }

    public static function update_config()
    {
        $options = ['qiotatoken', 'qiotamode'];
        foreach($options as $option) {
            if (isset($option) && !empty($option)) {
                update_option($option, $_POST[$option]);
                continue;
            }
            delete_option($option);
        }
    }
}