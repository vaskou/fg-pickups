<?php

defined( 'ABSPATH' ) or die();

class FG_Pickups_CMB2_Field_Dropdown {

	private $field_type;

	private static $instance;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->field_type = 'FG_Pickups_CMB2_Field_Dropdown';
		add_action( "cmb2_render_{$this->field_type}", array( $this, 'render' ), 10, 5 );
//		add_action( "cmb2_sanitize_{$this->field_type}", array( $this, 'sanitize' ), 10, 2 );
//		add_action( "cmb2_types_esc_{$this->field_type}", array( $this, 'escape_value' ), 10, 2 );
	}

	/**
	 * @param $field         CMB2_Field
	 * @param $escaped_value mixed
	 * @param $object_id     int
	 * @param $object_type   string
	 * @param $field_type    CMB2_Types
	 */
	public function render( $field, $escaped_value, $object_id, $object_type, $field_type ) {

		$pickups = FG_Pickups_Post_Type::getInstance()->get_items();
		
		$options = array( __( 'None', 'fg-pickups' ) );

		foreach ( $pickups as $pickup ) {
			$options[ $pickup->ID ] = $pickup->post_title;
		}

		$field->args['options'] = $options;

		$args = array(
			'class'   => 'cmb2_select',
			'name'    => $field_type->_name(),
			'id'      => $field_type->_id(),
			'desc'    => $field_type->_desc( true ),
			'options' => $field_type->concat_items(),
		);

		echo $field_type->select( $args );

	}

}