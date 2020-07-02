<?php

defined( 'ABSPATH' ) or die();

class FG_Pickups {

	private static $instance = null;

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function init() {
		FG_Pickups_Dependencies::getInstance()->init();
		FG_Pickups_Post_Type::getInstance()->init();
		FG_Pickups_CMB2_Field_Dropdown::get_instance();
		FG_Pickups_Shortcodes::getInstance()->init();
	}
}