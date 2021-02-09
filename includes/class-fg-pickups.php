<?php

defined( 'ABSPATH' ) or die();

class FG_Pickups {

	private static $instance = null;

	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * FG_Pickups constructor.
	 */
	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );

		FG_Pickups_Dependencies::instance();
		FG_Pickups_Post_Type::instance();
		FG_Pickups_CMB2_Field_Dropdown::instance();
		FG_Pickups_Shortcodes::instance();
	}

	public function on_plugins_loaded() {
		load_plugin_textdomain( 'fg-pickups', false, FG_PICKUPS_PLUGIN_DIR_NAME . '/languages/' );
	}

}