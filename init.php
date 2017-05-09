<?php
/*
Plugin Name: Russ Shop
Description: It is a plugin for russ shop
Version: 0.0.1
Author: Crondale
*/

register_activation_hook(__FILE__, 'crondale_options_install');

function crondale_options_install() {

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
	`Id` INT NOT NULL AUTO_INCREMENT , `Name` VARCHAR(255) NOT NULL , `Description` TEXT NOT NULL , `Price` INT NOT NULL , `MinimumOrder` SMALLINT NOT NULL , `FrontBackOption` BOOLEAN NOT NULL , `ExtraLogo` BOOLEAN NOT NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8;
	";


	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $create_color_table_query );
	dbDelta( $create_item_table_query );
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


	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Delete Color', //page title
	'Delete', //menu title
	'manage_options', //capability
	'russ_update_color', //menu slug
	'russ_update_color'); //function
	
}

define('ROOTDIR1', plugin_dir_path(__FILE__));

require_once(ROOTDIR1 . 'russ-item-list.php');
require_once(ROOTDIR1 . 'russ-create-color.php');
require_once(ROOTDIR1 . 'russ-update-color.php');

	
?>