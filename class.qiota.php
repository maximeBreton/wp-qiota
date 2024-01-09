<?php

class Qiota 
{
	public static function view($name, array $args = array()) 
    {
		$args = apply_filters( 'qiota_view_arguments', $args, $name );
		
		foreach ( $args AS $key => $val ) {
			$$key = $val;
		}
		
		load_plugin_textdomain( 'qiota' );

		$file = QIOTA__PLUGIN_DIR . 'views/'. $name . '.php';

		include( $file );
	}
}