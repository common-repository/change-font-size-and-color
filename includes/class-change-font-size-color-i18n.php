<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.topinfosoft.com/about
 * @since      1.0.0
 *
 * @package    Change_Font_Size_Color
 * @subpackage Change_Font_Size_Color/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Change_Font_Size_Color
 * @subpackage Change_Font_Size_Color/includes
 * @author     Top Infosoft <topinfosoft@gmail.com>
 */
class Change_Font_Size_Color_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'change-font-size-color',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
