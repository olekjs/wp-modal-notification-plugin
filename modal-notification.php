<?php
/*
Plugin Name: Modal Notification
Description: Proste tworzenie okna modalnego z powiadomieniem.
Version: 1.0
Author: Olek Kaim
Author URI: https://olekkaim.pl
 */

function init_styles()
{
    echo '<link rel="stylesheet" href="' . plugins_url('includes/styles/modal-notification.css', __FILE__) . '" type="text/css"/>';
}
add_action('wp_head', 'init_styles');

function init_scripts()
{
    if (!wp_script_is('jquery')) {

        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
    }

    echo '<script type="text/javascript" src="' . plugins_url('includes/scripts/modal-notification.js', __FILE__) . '"></script>';
}
add_action('wp_head', 'init_scripts');

require_once plugin_dir_path(__FILE__) . 'includes/class-modal-notification.php';

new Modal_Notification();
