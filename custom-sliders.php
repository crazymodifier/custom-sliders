<?php

/**
 * CustumSlider
 *
 * @package           CustumSlider
 * @author            Crazy Modifier
 * @copyright         2019 Your Name or Company Name
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Sliders - Post types, Taxonomies
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Responsive sliders for custom post types and taxonomies.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Crazy Modifier
 * Author URI:        https://crazymodifier.com
 * Text Domain:       custom-sliders
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://example.com/my-plugin/
 */


/**
* CustomSliders
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CustomSliders 
{
    
    function __construct(){

        $this->register();

    }


    private function register(){
        
        $this->all_in_one_slider_widget();

        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_custom_scripts') );

    }

    function enqueue_custom_scripts(){

        // wp_enqueue_style( 'slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' , array());
        wp_enqueue_style( 'custom-sliders', plugin_dir_url( __FILE__ ).'assets/css/style.css' , array());

        wp_enqueue_script('jquery');

        // wp_enqueue_script( 'slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'));
        wp_enqueue_script( 'custom-sliders', plugin_dir_url( __FILE__ ).'assets/js/scripts.js', array('slick') ,time(),true);
    }

    private function all_in_one_slider_widget(){
        require_once('inc/abstracts/abstract-custom-sliders-widget.php');

        require_once('inc/custom-sliders-posts-widget.php');    
    }
}

if(class_exists("CustomSliders")){
    $customsliders = new CustomSliders();
}

register_activation_hook( __FILE__, array($customsliders) );