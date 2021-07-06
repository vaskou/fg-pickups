<?php

defined( 'ABSPATH' ) or die();

class FG_Pickups_Post_Type {

	const POST_TYPE_NAME = 'fg_pickups';
	const TAXONOMY_NAME = 'fg_pickups_cat';
	const SLUG = 'pickups';

	private static $instance = null;

	private function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
//		add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_metaboxes' ) );
		add_action( 'pre_get_posts', array( $this, 'custom_query' ) );
	}

	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'FG Pickups', 'FG Pickups General Name', 'fg-pickups' ),
			'singular_name'         => _x( 'FG Pickup', 'FG Pickup Singular Name', 'fg-pickups' ),
			'menu_name'             => __( 'FG Pickups', 'fg-pickups' ),
			'name_admin_bar'        => __( 'FG Pickups', 'fg-pickups' ),
			'archives'              => __( 'FG Pickup Archives', 'fg-pickups' ),
			'attributes'            => __( 'FG Pickup Attributes', 'fg-pickups' ),
			'parent_item_colon'     => __( 'Parent FG Pickup:', 'fg-pickups' ),
			'all_items'             => __( 'All FG Pickups', 'fg-pickups' ),
			'add_new_item'          => __( 'Add New FG Pickup', 'fg-pickups' ),
			'add_new'               => __( 'Add New', 'fg-pickups' ),
			'new_item'              => __( 'New FG Pickup', 'fg-pickups' ),
			'edit_item'             => __( 'Edit FG Pickup', 'fg-pickups' ),
			'update_item'           => __( 'Update FG Pickup', 'fg-pickups' ),
			'view_item'             => __( 'View FG Pickup', 'fg-pickups' ),
			'view_items'            => __( 'View FG Pickups', 'fg-pickups' ),
			'search_items'          => __( 'Search FG Pickup', 'fg-pickups' ),
			'not_found'             => __( 'Not found', 'fg-pickups' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'fg-pickups' ),
			'featured_image'        => __( 'Featured Image', 'fg-pickups' ),
			'set_featured_image'    => __( 'Set Featured Image', 'fg-pickups' ),
			'remove_featured_image' => __( 'Remove Featured Image', 'fg-pickups' ),
			'use_featured_image'    => __( 'Use as Featured Image', 'fg-pickups' ),
			'insert_into_item'      => __( 'Insert into FG Pickup', 'fg-pickups' ),
			'uploaded_to_this_item' => __( 'Uploaded to this FG Pickup', 'fg-pickups' ),
			'items_list'            => __( 'FG Pickups list', 'fg-pickups' ),
			'items_list_navigation' => __( 'FG Pickups list navigation', 'fg-pickups' ),
			'filter_items_list'     => __( 'Filter FG Pickups list', 'fg-pickups' ),
		);

		$rewrite = array(
			'slug'       => self::SLUG,
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'         => __( 'FG Pickup', 'fg-pickups' ),
			'description'   => __( 'FG Pickup Description', 'fg-pickups' ),
			'labels'        => $labels,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'taxonomies'    => array( self::TAXONOMY_NAME ),
			'hierarchical'  => false,
			'public'        => true,
			'show_ui'       => true,
			'menu_icon'     => 'dashicons-admin-post',
			'menu_position' => 30,
			'can_export'    => true,
			'rewrite'       => $rewrite,
			'map_meta_cap'  => true,
			'show_in_rest'  => false,
//			'has_archive'   => true,
		);
		register_post_type( self::POST_TYPE_NAME, $args );
	}

	public function register_taxonomy() {

		$labels = array(
			'name'              => __( 'FG Pickup Categories', 'fg-pickups' ),
			'singular_name'     => __( 'FG Pickup Category', 'fg-pickups' ),
			'search_items'      => __( 'Search FG Pickup Categories', 'fg-pickups' ),
			'all_items'         => __( 'All FG Pickup Categories', 'fg-pickups' ),
			'parent_item'       => __( 'Parent FG Pickup Category', 'fg-pickups' ),
			'parent_item_colon' => __( 'Parent FG Pickup Category:', 'fg-pickups' ),
			'edit_item'         => __( 'Edit FG Pickup Category', 'fg-pickups' ),
			'update_item'       => __( 'Update FG Pickup Category', 'fg-pickups' ),
			'add_new_item'      => __( 'Add New FG Pickup Category', 'fg-pickups' ),
			'new_item_name'     => __( 'New FG Pickup Category Name', 'fg-pickups' ),
			'menu_name'         => __( 'FG Pickup Categories', 'fg-pickups' ),
		);
		$args   = array(
			'hierarchical'       => true, // make it hierarchical (like categories)
			'labels'             => $labels,
			'public'             => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'meta_box_cb'        => 'post_categories_meta_box',
			'rewrite'            => true,
		);

		register_taxonomy( self::TAXONOMY_NAME, array( self::POST_TYPE_NAME ), $args );
	}

	/**
	 * Adds metaboxes
	 */
	public function add_metaboxes() {

		FG_Pickups_Specifications_Fields::instance()->addMetaboxes( self::POST_TYPE_NAME );

	}

	/**
	 * @param $query WP_Query
	 */
	public function custom_query( $query ) {
		$is_shortcode = $query->get( 'is_shortcode' );
		$is_post_in   = $query->get( 'post__in' );

		if ( ! is_admin() && ( $query->is_main_query() || $is_shortcode ) ) {
			if ( self::POST_TYPE_NAME == $query->get( 'post_type' ) ) {
				$query->set( 'orderby', 'menu_order title' );
				$query->set( 'order', 'ASC' );
				$query->set( 'suppress_filters', 'true' );

				if ( ! empty( $is_post_in ) ) {
					$query->set( 'orderby', 'post__in' );
				}
			}
		}
	}

	/**
	 * @param $atts array
	 *
	 * @return WP_Query
	 */
	public function get_query( $atts = array() ) {
		return $this->_get_query( $atts );
	}

	/**
	 * @return int[]|WP_Post[]
	 */
	public function get_items() {
		return $this->_get_items();
	}

	/**
	 * @param $id
	 *
	 * @return int[]|WP_Post[]
	 */
	public function get_item( $id ) {
		$args = array(
			'p'              => $id,
			'posts_per_page' => 1
		);

		return $this->_get_items( $args );
	}

	public function get_pickup_single_image_id( $id ) {
		$item = $this->get_item( $id );

		if ( empty( $item[0] ) ) {
			return false;
		}

		$pickup_id = $item[0]->ID;

		return FG_Pickups_Specifications_Fields::instance()->getSingleImageID( $pickup_id );
	}

	public function get_pickup_image_id( $id ) {
		$item = $this->get_item( $id );

		if ( empty( $item[0] ) ) {
			return false;
		}

		$pickup_id = $item[0]->ID;

		return FG_Pickups_Specifications_Fields::instance()->getImageID( $pickup_id );
	}

	public function get_price( $id ) {

		$price = FG_Pickups_Specifications_Fields::instance()->getPrice( $id );

		return apply_filters( 'fg_pickups_post_type_get_price', $price, $id );
	}

	public function get_price_set( $id ) {

		$price = FG_Pickups_Specifications_Fields::instance()->getPriceSet( $id );

		return apply_filters( 'fg_pickups_post_type_get_price_set', $price, $id );
	}


	public function get_availability( $id ) {
		return FG_Pickups_Specifications_Fields::instance()->getAvailability( $id );
	}

	public function get_prices_grid_visibility( $id ) {
		return FG_Pickups_Specifications_Fields::instance()->getPricesGridVisibility( $id );
	}

	public function get_notes( $id ) {
		return FG_Pickups_Specifications_Fields::instance()->getNotes( $id );
	}

	public function get_video( $id ) {
		return FG_Pickups_Specifications_Fields::instance()->getVideo( $id );
	}

	/**
	 * @param $atts array
	 *
	 * @return WP_Query
	 */
	private function _get_query( $atts = array() ) {
		$default = array(
			'post_type'      => self::POST_TYPE_NAME,
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
		);

		$args = wp_parse_args( $atts, $default );

		return new WP_Query( $args );
	}

	/**
	 * @param array $atts
	 *
	 * @return int[]|WP_Post[]
	 */
	private function _get_items( $atts = array() ) {
		$query = $this->_get_query( $atts );

		return $query->get_posts();
	}
}