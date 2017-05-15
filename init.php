<?php
/*
Plugin Name: Russ Shop
Description: It is a plugin for russ shop
Version: 0.0.1
Author: Crondale
*/

register_activation_hook(__FILE__, 'crondale_options_install');

function crondale_options_install() {

    define( 'WP_DEBUG', true );

    global $wpdb;
    $table_name = $wpdb->prefix . "russ_";

    $create_color_table_query = "
	CREATE TABLE IF NOT EXISTS `{$table_name}colors` (
	`Id` INT NOT NULL AUTO_INCREMENT ,
	`Name` text NOT NULL,
	PRIMARY KEY (Id)
	) ENGINE = InnoDB  DEFAULT CHARSET=utf8;
	";

    $create_item_table_query = "
	CREATE TABLE IF NOT EXISTS `{$table_name}items` (
	`Id` INT NOT NULL AUTO_INCREMENT , `Name` VARCHAR(255) NOT NULL , `Description` TEXT NOT NULL , `Price`  FLOAT(11) NOT NULL , `MinimumOrder` SMALLINT NOT NULL , `FrontBackOption` BOOLEAN NOT NULL , `ExtraLogo` BOOLEAN NOT NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8;
	";

    $create_item_color_table_query = "
	CREATE TABLE IF NOT EXISTS `{$table_name}item_colors` (
	`Item_Id` INT NOT NULL , `Color_Id` INT NOT NULL,
	PRIMARY KEY (`Item_Id`, `Color_Id`)
	) ENGINE = InnoDB  DEFAULT CHARSET=utf8;
	";


    $create_order_receiver_table_query = "
	CREATE TABLE IF NOT EXISTS `{$table_name}order_receiver_info` (
	`id` INT NOT NULL AUTO_INCREMENT , `fullName` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `address` TEXT NOT NULL , `telephone` VARCHAR(255) NOT NULL , `postNumber` VARCHAR(255) NOT NULL , 
    `city` VARCHAR(255) NOT NULL , `russGroupName` VARCHAR(255) NOT NULL ,
	PRIMARY KEY (`id`)
	) ENGINE = InnoDB  DEFAULT CHARSET=utf8;
	";



    $create_order_table_query = " CREATE TABLE IF NOT EXISTS `{$table_name}orders` ( 
    `id` INT NOT NULL AUTO_INCREMENT , `frontBack` VARCHAR(10) NOT NULL , `extraLogo` BOOLEAN NOT NULL , `price` INT NOT NULL , `receiver_id` INT NOT NULL, `item_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
    ";

    $create_order_details_table_query = " CREATE TABLE IF NOT EXISTS `{$table_name}order_details` ( 
     `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(20) NOT NULL , `size` VARCHAR(5) NOT NULL , `color` VARCHAR(5) NOT NULL , `orderId` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
     ";


    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $create_color_table_query );
    dbDelta( $create_item_table_query );
    dbDelta( $create_item_color_table_query );
    dbDelta( $create_order_receiver_table_query );
    dbDelta( $create_order_table_query );
    dbDelta( $create_order_details_table_query );

}


//menu items
add_action('admin_menu','crondale_modifymenu');
function crondale_modifymenu() {

    //this is the main item for the menu
    add_menu_page('Russ Shop', //page title
        'Russ Shop', //menu title
        'manage_options', //capabilities
        'russ_item_list', //menu slug
        'russ_item_list' //function
    );

    //this is a submenu
    add_submenu_page('russ_item_list', //parent slug
        'Add New Color', //page title
        'Add New Color', //menu title
        'manage_options', //capability
        'russ_create_color', //menu slug
        'russ_create_color'); //function


    add_submenu_page('russ_item_list', //parent slug
        'Add New Item', //page title
        'Add New Item', //menu title
        'manage_options', //capability
        'russ_create_item', //menu slug
        'russ_create_item'); //function


    //this submenu is HIDDEN, however, we need to add it anyways
    add_submenu_page(null, //parent slug
        'Delete Color', //page title
        'Delete', //menu title
        'manage_options', //capability
        'russ_update_color', //menu slug
        'russ_update_color'); //function

}


function my_enqueue($hook) {
    wp_register_style('my-plugin', plugins_url('crondale-russ-plugin/style-admin.css'));
    wp_enqueue_style('my-plugin');
}


add_action( 'admin_enqueue_scripts', 'my_enqueue' );

add_action( 'wp_enqueue_scripts', 'my_enqueue_client' );

add_action( 'admin_post_add_order', 'prefix_admin_add_order' );



add_shortcode("crondale_russ_shop", "crondale_russ_shop_client");


define('ROOTDIR1', plugin_dir_path(__FILE__));

require_once(ROOTDIR1 . 'russ-item-list.php');
require_once(ROOTDIR1 . 'russ-create-color.php');
require_once(ROOTDIR1 . 'russ-update-color.php');
require_once(ROOTDIR1 . 'russ-create-item.php');

require_once(ROOTDIR1 . 'client/russ-client.php');


?>