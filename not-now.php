<?php

/*
Plugin Name: not-now
Plugin URI: https://github.com/bobbingwide/not-now
Description: NOT NOW! I'm not interested in your admin_notices. Not now, not never. Well, hardly ever.
Version: 0.0.0
Author: bobbingwide
Author URI: https://www.bobbingwide.com/about-bobbing-wide
Text Domain: not-now
Domain Path: /languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

    Copyright 2020 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

function not_now_loaded() {
	if ( true ) {
		add_action( 'admin_notices', 'not_now_admin_notices_first', - 99999 );
		add_action( 'admin_notices', 'not_now_admin_notices_last', 99999 );
	}
	//add_filter( 'admin_footer_text', 'not_now_admin_footer_text');
	//add_action( 'admin_print_footer_scripts', 'not_now_display_trapped_notices');
	add_action( 'admin_menu', 'not_now_admin_menu');

}

function not_now_admin_notices_first() {
	ob_start();
	not_now_admin_notice("not now - first");
}

function not_now_admin_notices_last() {
	not_now_admin_notice( 'not now - last');
	not_now_save_notices();
}

function not_now_save_notices() {
	global $trapped_notices;
	$trapped_notices = ob_get_clean();
	bw_trace2( $trapped_notices, 'trapped_notices', false);

}

/**
 * Attempts to display admin notices in the footer text
 *
 * It doesn't work since WordPress has logic to move the Notices to the front.
 * It's not easy to filter the notices without parsing the classes in the divs.
 *
 * @param $text
 * @return string
 */

function not_now_admin_footer_text( $text ) {
	global $trapped_notices;
	//$escaped = esc_html( $trapped_notices);
	$text .= $trapped_notices;
	return $text;
}


/**
 * Attempts to display admin notices after everything else
 *
 * Doesn't work for the same reason as above.
 */

function not_now_display_trapped_notices() {
	global $trapped_notices;
	//$escaped = esc_html( $trapped_notices);
	bw_trace2( $trapped_notices, 'Display trapped notices');
	echo '<div class="trapped">';
	$notices = str_replace( 'updated', 'not-nowed ', $trapped_notices);
	echo $notices;
	echo '</div>';
	//$trapped_notices = null;

}

function not_now_admin_notice( $text ) {
	$message = '<div class=" updated fade">';
	$message .= $text;
	//$message .= oik_oik_install_link( $depends, $problem );
	$message .= '</div>';
	echo $message;
}

function not_now_admin_menu() {
	$hook = add_menu_page( __('Not now', 'not-now'), __('Not now', 'not-now'), 'manage_options', 'not_now', 'not_now_admin_page', 'div' );
}

function not_now_admin_page() {
	echo '<h1>Not now</h1>';
	echo '<p>Trapped notices are:</p>';
	not_now_display_trapped_notices();

}

not_now_loaded();
