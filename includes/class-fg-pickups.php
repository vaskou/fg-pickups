<?php

defined( 'ABSPATH' ) or die();

class FG_Pickups {

	private static $instance = null;

	/**
	 * FG_Pickups constructor.
	 */
	private function __construct() {
		FG_Pickups_Dependencies::instance();
		FG_Pickups_Post_Type::instance();
		FG_Pickups_CMB2_Field_Dropdown::instance();
		FG_Pickups_Shortcodes::instance();
	}

	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}