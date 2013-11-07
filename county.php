<?php
/*
	Plugin Name: County
	Demo: http://county.ahansson.com
	Description: County is a countdown section that can count down to any date into the future. Use as Coming Soon Page or as countdown for your birtday - or whatever you need a countdown for!
	Version: 1.7
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	v3: true
*/

class ah_County_Plugin {

	function __construct() {
		add_action( 'init', array( &$this, 'ah_updater_init' ) );
	}

	/**
	 * Load and Activate Plugin Updater Class.
	 * @since 0.1.0
	 */
	function ah_updater_init() {

		/* Load Plugin Updater */
		require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/plugin-updater.php' );

		/* Updater Config */
		$config = array(
			'base'      => plugin_basename( __FILE__ ), //required
			'repo_uri'  => 'http://shop.ahansson.com',  //required
			'repo_slug' => 'county',  //required
		);

		/* Load Updater Class */
		new AH_County_Plugin_Updater( $config );
	}

}

new ah_County_Plugin;