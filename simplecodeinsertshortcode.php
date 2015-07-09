<?php

/**
 * @package simplecodeinsertshortcode
 */
/*
Plugin Name: Simple Code Insert Shortcode
Plugin URI: http://www.developersnote.net/portfolio/simple-code-insert-plugin/
Description: SCI Shortcode plugin allows you to insert or embed codes in posts, pages, and sidebars. This is very useful for embedding videos, images, banner ads, and etc. The best thing about this plugin is that you only use shortcodes in order to display everything you want.
Version: 1.0
Author: Lodel Geraldo
Author URI: http://www.developersnote.net/about-me/
*/

/*
Copyright (C) 2015 www.developersnote.net

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License as
published by the Free Software Foundation; either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'SCIS_VERSION', '1.0' );
define( 'SCIS_MINIMUM_WP_VERSION', '3.2' );
define( 'SCIS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SCIS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SCIS_PLUGIN_SHORTCODE', 'scis');
define( 'SCIS_TABLE_NAME', 'scistbl');

register_activation_hook( __FILE__, array( 'Scis', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Scis', 'plugin_deactivation' ) );

if ( is_admin() ) {
	require_once( SCIS_PLUGIN_DIR . 'class.scis.admin.php' );
	add_action( 'init', array( 'Scis_Admin', 'init' ) );
}

require_once( SCIS_PLUGIN_DIR . 'class.scis.php' );
require_once( SCIS_PLUGIN_DIR . 'class.scis-widget.php' );

add_action( 'init', array( 'Scis', 'init' ) );
add_shortcode(SCIS_PLUGIN_SHORTCODE, array('Scis','scis_plugin'));
add_filter('widget_text', 'do_shortcode');
