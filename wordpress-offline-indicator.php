<?php
/*
Plugin Name: WordPress Offline Indicator
Plugin URI: http://www.subharanjan.in/wordpress-offline-indicator
Description: WordPress Offline Indicator uses 'offline.js' library to automatically alert users when they've lost internet connectivity, like Gmail. As soon as the browser senses the loss of the internet connection, a message is issued on the WordPress backend, giving your WP users the information that � they have lost the connection.
Version: 0.1
Author: Subharanjan
Author Email: subharanjanmantri@gmail.com
License:

  Copyright 2011 Subharanjan (subharanjanmantri@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class WordPressOfflineIndicator {

    /*--------------------------------------------*
     * Constants
     *--------------------------------------------*/
    const name = 'WordPress Offline Indicator';
    const slug = 'wordpress_offline_indicator';

    /**
     * Constructor
     */
    function __construct() {
        //Hook up to the init action
        add_action( 'init', array( &$this, 'init_wordpress_offline_indicator' ) );
    }

    /**
     * Runs when the plugin is activated
     */
    function install_wordpress_offline_indicator() {
        // do not generate any output here
    }

    /**
     * Runs when the plugin is initialized
     */
    function init_wordpress_offline_indicator() {
        // Setup localization
        load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
        // Load JavaScript and stylesheets
        $this->register_scripts_and_styles();

        if ( is_admin() ) {
            //this will run when in the WordPress admin
        }
        else {
            //this will run when on the frontend
        }

    }

    /**
     * Registers and enqueues stylesheets for the administration panel and the
     * public facing site.
     */
    private function register_scripts_and_styles() {
        if ( is_admin() ) {

            $this->load_file( self::slug . '-admin-script', '/js/admin.js', true );
            $this->load_file( self::slug . '-admin-style', '/css/admin.css' );

            // include the offline library script
            $this->load_file( self::slug . '-offline-script', '/js/offline.min.js', true );
            $this->load_file( self::slug . '-offline-style', '/css/themes/offline-theme-chrome.css' );

        }
        else {

        } // end if/else

    } // end register_scripts_and_styles

    /**
     * Helper function for registering and enqueueing scripts and styles.
     *
     * @name    The    ID to register with WordPress
     * @file_path        The path to the actual file
     * @is_script        Optional argument for if the incoming file_path is a JavaScript source file.
     */
    private function load_file( $name, $file_path, $is_script = false ) {

        $url  = plugins_url( $file_path, __FILE__ );
        $file = plugin_dir_path( __FILE__ ) . $file_path;

        if ( file_exists( $file ) ) {
            if ( $is_script ) {
                wp_register_script( $name, $url, array( 'jquery' ) ); //depends on jquery
                wp_enqueue_script( $name );
            }
            else {
                wp_register_style( $name, $url );
                wp_enqueue_style( $name );
            } // end if
        } // end if

    } // end load_file

} // end class
new WordPressOfflineIndicator();