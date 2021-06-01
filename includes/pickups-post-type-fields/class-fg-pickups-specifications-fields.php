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
			'image'        => array(
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
			'price'        => array(
				'name'       => __( 'Price', 'fg-pickups' ),
				'type'       => apply_filters( 'fg_pickups_specifications_price_field_type', 'text_small' ),
				'attributes' => array(
					'type' => apply_filters( 'fg_pickups_specifications_price_field_type', 'number' )
				)
			),
			'availability' => array(
				'name' => __( 'Availability', 'fg-pickups' ),
				'type' => 'text',
			),
			'video'        => array(
				'name' => __( 'Video', 'fg-pickups' ),
				'type' => 'text',
			),
		) );
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

	public function getAvailability( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'availability', true );
	}

	public function getVideo( $post_id ) {
		return get_post_meta( $post_id, $this->getFieldMetaKeyPrefix() . 'video', true );
	}

}