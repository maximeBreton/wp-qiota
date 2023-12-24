<?php

class QiotaAdmin
{

    private static $initiated = false;

    public static function init() 
    {
		if (!self::$initiated) {
			self::init_hooks();
		}
    }

    public static function init_hooks() 
    {
        add_action('admin_init', array('QiotaAdmin', 'admin_init'));
        add_action('admin_menu', array('QiotaAdmin', 'admin_menu'));
        self::$initiated = true;
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
        $hook = add_options_page( __( 'Qiota', 'qiota' ), __( 'Qiota', 'qiota' ), 'manage_options', 'qiota-key-config', array( 'Qiota_Admin', 'display_page' ) );
        add_action( "load-$hook", array( 'Qiota_Admin', 'admin_help' ) );
    }
}