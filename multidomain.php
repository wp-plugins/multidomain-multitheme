<?php

/*
  Plugin Name: MultiDomain enabler
  Plugin URI: http://www.eveniz.com/showcase/multisite
  Description: Enable same content on multiple domains
  Version: 1.1
  Author: ArkOak

 */
//TD : PLAN : add support for domain specific page , domain specific text, domain specific menu etc.

define("ARMULTIDOMAIN", dirname(__FILE__) . DIRECTORY_SEPARATOR);
require_once(ARMULTIDOMAIN . '/classes/domainHandler.php' );
require_once(ARMULTIDOMAIN . '/classes/themeHandler.php' );
require_once(ARMULTIDOMAIN . '/classes/adminHandler.php' );

//The admin menu
add_action('admin_menu', '\ark\multidomain\adminHandler::menu');


// 1. detect if the domain is same or different
$defaultDomain = \ark\multidomain\domainHandler::getdefaultDomain();
$currDomain = \ark\multidomain\domainHandler::getCurrDomain();
if ($defaultDomain != $currDomain) {

    //2. detect if the current url is admin (excluded) or not
    if (!preg_match("#\/wp\-(admin|login|register|rss[2]|feed|signup|feed)[\/\.]#", $_SERVER['REQUEST_URI'])) {
        //3. filter and apply changes
        ob_start();
        add_action('shutdown', '\ark\multidomain\domainHandler::applyChange', 0);
        add_filter('final_output', '\ark\multidomain\domainHandler::changeUrl');


        //4.  deregister and register theme on the fly if there is a change required
        $newTheme = \ark\multidomain\themeHandler::getDomainTheme(\ark\multidomain\domainHandler::getCurrDomain());
        $setTheme = wp_get_theme()->template; 
        if (strlen($newTheme) > 1 && $newTheme != $setTheme) {
            add_filter('template', '\ark\multidomain\themeHandler::changeTheme');
            add_filter('stylesheet', '\ark\multidomain\themeHandler::changeTheme');
            //add_filter('pre_option_stylesheet', '\ark\multidomain\themeHandler::changeTheme');
        }
    }
}
 