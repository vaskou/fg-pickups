<?php

/**
 * @wordpress-plugin
 * Plugin Name:       FremeditiGuitars - Pickups
 * Description:       FremeditiGuitars - Pickups Post Type
 * Version:           1.0.2
 * Author:            Vasilis Koutsopoulos
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fg-pickups
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or die();

define( 'FG_PICKUPS_VERSION', '1.0.2' );
define( 'FG_PICKUPS_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'FG_PICKUPS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'FG_PICKUPS_PLUGIN_DIR_NAME', basename( FG_PICKUPS_PLUGIN_DIR_PATH ) );
define( 'FG_PICKUPS_PLUGIN_URL', plugins_url( FG_PICKUPS_PLUGIN_DIR_NAME ) );

include 'includes/class-fg-pickups.php';
include 'includes/class-fg-pickups-dependencies.php';
include 'includes/class-fg-pickups-post-type.php';
include 'includes/class-fg-pickups-shortcodes.php';

include 'includes/pickups-post-type-fields/abstract-class-fg-pickups-post-type-fields.php';
include 'includes/pickups-post-type-fields/class-fg-pickups-specifications-fields.php';

include 'includes/cmb2-custom-fields/class-fg-pickups-cmb2-field-dropdown.php';

FG_Pickups::instance();

