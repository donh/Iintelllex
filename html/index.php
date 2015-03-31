<?php
// http://stackoverflow.com/questions/11616306/css-font-face-absolute-url-from-external-domain-fonts-not-loading-in-firefox
// header("Cache-Control: private, max-age=10800, pre-check=10800");
// header("Pragma: private");
// header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
// // header('Content-type: '.$IKnowMime );
// header("Content-Transfer-Encoding: binary");
// // header('Content-Length: '.filesize(FONT_FOLDER.$f));
// // header('Content-Disposition: attachment; filename="'.$f.'";');
// header('Access-Control-Allow-Origin: *');

/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
