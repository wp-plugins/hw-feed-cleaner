<?php
/*
Plugin Name: HW Feed Cleaner
Plugin URI: http://wordpress.org/extend/plugins/hw-feed-cleaner/
Description: Silently discards invalid UTF-8 characters from the various WordPress feeds in order to keep t valid.
Version: 1.0
Author: H&aring;kan Wennerberg
Author URI: http://wordpress.wennerberg.biz/
License: LGPLv3
License URI: http://www.gnu.org/licenses/lgpl-3.0.html
*/

class HW_Feed_Cleaner {
	/**
	 * Initializes plugin, registers hooks (only if UTF-8 is in use).
	 */
	public function initialize() {
		if ( in_array( get_option( 'blog_charset' ), array( 'utf8', 'utf-8', 'UTF8', 'UTF-8' ) ) ) {
			add_filter( 'the_title_rss', array( $this, 'utf8_filter' ), 10 );
			add_filter( 'the_excerpt_rss', array($this, 'utf8_filter' ), 10 );
			add_filter( 'the_content_feed', array($this, 'utf8_filter_content' ), 10, 2 );
		}
	}

	public function utf8_filter( $value ) {
		return iconv("UTF-8", "UTF-8//IGNORE", $value);
	}

	public function utf8_filter_content( $type, $content ) {
		return $this->utf8_filter( $content );
	}
}
add_action( 'init', array( new HW_Feed_Cleaner(), 'initialize' ) );