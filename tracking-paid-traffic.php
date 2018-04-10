<?php
/*
Plugin Name: Tracking-paid-traffic
Description: This plugin is tracking paid traffic for Gravity Form. Whithout plugin Gravity Form not working
Version: 1.0
Author: developer

*/
?>
<?php
/*  Copyright 2018  developer

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.


*/
?>
<?php
//HOOK FROM ADMIN_PANEL FOR CHECK ACTIVATE Gravity form PLUGIN
function check_gravity_forms_plugin_activate(){
    // check of Gravity form active plugin
    if( !is_plugin_active( 'gravityforms/gravityforms.php' ) ){
        echo('<h2 style="max-width: 960px; margin: 0 auto; color: red">Sorry! For use plugin Tracking-paid-traffic in your site</h2>');
        echo('<h2 style="max-width: 960px; margin: 0 auto;">you can activated gravityforms plugin in your site!</h2>');
        return;
    }
    add_action( 'plugins_loaded', 'init_tracking_traffic_paid' ); //LOAD PLUGIN
  }
add_action('admin_init','check_gravity_forms_plugin_activate');

// check of Gravity form active plugin
do_action('check_gravity-forms_plugin_activate');

add_action( 'plugins_loaded', 'init_tracking_traffic_paid' );
// ADD MENU IN ADMIN MENU GRAVITY FORMS
function add_view_in_admin_menu(){
    echo '<h3 class="heading">COOKIE PARAMETRES FOR USE TRACKING PAID TRAFFIC</h3>';

    if (isset($_POST['save'])){
        if(isset ($_POST['argument_name']) && isset($_POST['time_cookie'])){
            update_option( 'argument_name', $_POST['argument_name'] );
            update_option( 'time_cookie', $_POST['time_cookie'] );}
        } //SAVE META OPTION

    ?>
    <div>For correct use this plugin you must correct create element in Gravity Form
        <p>
           CREATE 'STANDART FIELDS -SINGLE LINE TEXT- element example content:
        </p>
        <pre>
          with Field Label content 'Adv'
            And Custom CSS Class 'adv'
            in Advanced use 'hidden' visibility
        </pre>
    </div>
<form method="POST">
    <table class="form-table">
        <tr>
            <th><label for="argument_name">Parsing query string parameters</label></th>
            <td><input type="text" class="input-text form-control" name="argument_name" value="<?php  echo get_option( 'argument_name' );?>"/></td>
        </tr>
        <tr>
            <th><label for="time_cookie">Days for save set cookies</label></th>
            <td><input type="text" class="input-number form-control" name="time_cookie" value="<?php echo get_option( 'time_cookie' );?>"/></td>
        </tr>

    </table>
    <input type="submit" name="save" value="Save"/>
</form>
    <?php
}

function init_tracking_traffic_paid(){
    $param_name = (string)get_option( 'argument_name' );
    $param_cookie =  (int)get_option( 'time_cookie' );

    //LOAD JS IN PLUGIN
    wp_register_script( 'plugin_script', plugins_url() . '/tracking-paid-traffic/script_methods.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script( 'plugin_script' );
    $params_array = array(
        'param_name' =>  $param_name,
        'param_cookie'=> $param_cookie);
    wp_localize_script( 'plugin_script', 'add_params_to_script', $params_array );

    add_filter( 'gform_addon_navigation', 'create_menu' );
    function create_menu( $menus ) {
        $menus[] = array( 'name' => 'my_custom_page', 'label' => __( 'Menu for plugin tracking traffic' ), 'callback' =>  'my_custom_page' );
        return $menus;
    }
    //CALL VIEW PLUGIN MENU
    function my_custom_page(){
        add_view_in_admin_menu();

    }


}