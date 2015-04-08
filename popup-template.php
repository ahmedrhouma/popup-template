<?php
/**
 * Plugin Name: PopUp Pro Template: Isometric
 * Plugin URI:  https://premium.wpmudev.org/project/the-pop-over-plugin/
 * Description: Adds a new layout template to the PopUp Pro plugin.
 * Author:      Philipp Stracker
 * Author URI:  https://github.com/stracker-phil/
 * Version:     1.0.0
 * Text Domain: tpl-isometric
 *
 * This is a demonstration of how to create your own templates for use in
 * PopUp Pro. Copy and modify this plugin to easily create your own layouts!
 * ----------------------------------------------------------------------------
 */

/**
 * Copyright (c) 2015 Philipp Stracker. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * ****************************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * ****************************************************************************
 */

class PopupTemplate_Isometric {

	/**
	 * Sets up action hooks and filters.
	 *
	 * @since  1.0.0
	 */
	static function init_hooks() {
		add_filter(
			'popup-styles',
			array( __CLASS__, 'register' )
		);
	}

	/**
	 * Registers our custom template with the PopUp Pro plugin.
	 *
	 * This short function is all that is needed so PopUp Pro knows about the
	 * new template!
	 * The main work will be to modify the style.css file in the template
	 * subdirectory, and maybe modify the HTML structure in template.php
	 *
	 * @since  1.0.0
	 */
	static function register( $styles ) {
		$plugin_dir = trailingslashit( dirname( __FILE__ ) );
		$plugin_url = plugin_dir_url( __FILE__ );

		/*
		 * Styles and template files are stored in subdirectory 'isometric'.
		 *
		 * Every template needs to contain the following files:
		 *   style.css     .. CSS styles used by the popup.
		 *   style.php     .. Returns some meta data about the template.
		 *   template.php  .. Returns the actual HTML template of the popup.
		 */
		$styles[ 'tpl_isometric' ] = (object) array(
			'url' => trailingslashit( $plugin_url . 'isometric' ),
			'dir' => trailingslashit( $plugin_dir . 'isometric' ),
			'name' => 'Isometric',
		);

		return $styles;
	}
};

// Register our template after all plugins are loaded (i.e. very early)
add_action(
	'plugins_loaded',
	array( 'PopupTemplate_Isometric', 'init_hooks' )
);