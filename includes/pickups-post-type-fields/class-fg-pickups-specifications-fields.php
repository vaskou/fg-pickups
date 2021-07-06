<?php

class FG_Pickups_Specifications_Fields extends FG_Pickups_Post_Type_Fields {

	private static $instance;

	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->metabox_id    = 'specifications';
		$this->metabox_title = __( 'Specifications', 'fg-pickups' );
		$this->fields        = apply_filters( 'fg_pickups_specifications_fields', array(
			'single_image'           => array(
				'name'         => __( 'Image', 'fg-pickups' ),
				'type'         => 'file',
				'options'      => array(
					'url' => false
				),
				'text'         => array(
					'add_upload_file_text' => 'Add Image'
				),
				'preview_size' => array( 200, 100 )
			),
			'image'                  => array(
				'name'         => __( 'Specs Image', 'fg-pickups' ),
				'type'         => 'file',
				'options'      => array(
					'url' => false
				),
				'text'         => array(
					'add_upload_file_text' => 'Add Image'
				),
				'preview_size' => array( 200, 100 )
			),
			'price'                  => array(
				'name'       => __( 'Price for single', 'fg-pickups' ),
				'type'       => apply_filters( 'fg_pickups_specifications_price_field_type', 'text_small' ),
				'attributes' => array(
					'type' => apply_filters( 'fg_pickups_specifications_price_field_type', 'number' )
				)
			),
			'price_set'              => array(
				'name'       => __( 'Price for set', 'fg-pickups' ),
				'type'       => apply_filters( 'fg_pickups_specifications_price_set_field_type', 'text_small' ),
				'attributes' => array(
					'type' => apply_filters( 'fg_pickups_specifications_price_set_field_type', 'number' )
				)
			),
			'prices_grid_visibility' => array(
				'name'        => __( 'Hide Prices from Grid', 'fg-pickups' ),
				'type'        => 'multicheck',
				'description' => __( 'Check the prices that you want to hide from grid', 'fg-pickups' ),
				'options'     => array(
					'price'     => __( 'Price for single', 'fg-pickups' ),
					'price_set' => __( 'Price for set', 'fg-pickups' ),
				),
			),
			'availability'           => array(
				'name' => __( 'Availability', 'fg-pickups' ),
				'type' => 'text',
			),
			'notes'                  => array(
				'name' => __( 'Notes', 'fg-pickups' ),
				'type' => 'text',
			),
			'video'                  => array(
				'name' => __( 'Video', 'fg-pickups' ),
				'type' => 'text',
			),
		) );
	}

	public function getSingleImage( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'single_image', true );
	}

	public function getSingleImageID( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'single_image_id', true );
	}

	public function getImage( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'image', true );
	}

	public function getImageID( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'image_id', true );
	}

	public function getPrice( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'price', true );
	}

	public function getPriceSet( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'price_set', true );
	}

	public function getAvailability( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'availability', true );
	}

	public function getPricesGridVisibility( $post_id ) {
		$prices_grid_visibility = get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'prices_grid_visibility', true );

		return is_array( $prices_grid_visibility ) && ! empty( $prices_grid_visibility ) ? $prices_grid_visibility : array();
	}

	public function getNotes( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'notes', true );
	}

	public function getVideo( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'video', true );
	}

}