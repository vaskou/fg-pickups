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
			'template'     => 'list'
		);

		$args = shortcode_atts( $default, $atts );

		$args['post__in'] = ! empty( $args['post__in'] ) ? explode( ',', $args['post__in'] ) : array();

		$query = FG_Pickups_Post_Type::instance()->get_query( $args );

		ob_start();

		if ( $query->have_posts() ) :

			while ( $query->have_posts() ) :
				$query->the_post();

				$template_args = array( 'template' => $args['template'] );
				get_template_part( 'template-parts/content', get_post_type(), $template_args );

			endwhile;
		endif;
		wp_reset_postdata();

		$html = ob_get_clean();

		if ( 'grid' == $args['template'] ):
			ob_start();
			?>
            <div class="uk-grid uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m uk-grid-medium" uk-grid>
				<?php echo $html; ?>
            </div>
			<?php
			$html = ob_get_clean();
		endif;

		return $html;

	}
}