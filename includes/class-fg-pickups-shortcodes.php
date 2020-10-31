<?php

defined( 'ABSPATH' ) or die();

class FG_Pickups_Shortcodes {

	const PICKUPS_SHORTCODE_NAME = 'fg-pickups';

	private static $instance = null;

	/**
	 * FG_Pickups_Shortcodes constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}

	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function register_shortcodes() {
		add_shortcode( self::PICKUPS_SHORTCODE_NAME, array( $this, 'pickups_shortcode' ) );
	}

	public function pickups_shortcode( $atts ) {

		$default = array(
			'is_shortcode' => true,
			'post__in'     => '',
		);

		$args = shortcode_atts( $default, $atts );

		$args['post__in'] = ! empty( $args['post__in'] ) ? explode( ',', $args['post__in'] ) : array();

		$query = FG_Pickups_Post_Type::instance()->get_query( $args );

		ob_start();

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) :
				$query->the_post();

				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;
		endif;
		wp_reset_postdata();

		$html = ob_get_clean();

		return $html;

	}
}