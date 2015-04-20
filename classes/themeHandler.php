<?php

namespace ark\multidomain;

class themeHandler {

    static $newTheme = '';
    static $allThemes = [];

    static function getDomainTheme($site) { 
        // return the theme saved against the current domain in options or null 
        $currHost = $_SERVER['HTTP_HOST'];
        $domains = unserialize(get_option('armultidomains'));
        if (is_array($domains)) {
            foreach ($domains as $domain) {
                if (preg_match("#$site#", $domain['name'])) {
                    return $domain['theme'];
                }
            }
        }
        return false; //defaults to host
    }

    public static function changeTheme() {
        if (strlen(self::$newTheme) < 1) {
            self::$newTheme = \ark\multidomain\themeHandler::getDomainTheme(\ark\multidomain\domainHandler::getCurrDomain());
        }
        if (count(self::$allThemes) < 1) {
            self::$allThemes = wp_get_themes(array('allowed' => true));
        }
        if (isset(self::$allThemes[self::$newTheme])) {
            return self::$newTheme;
        }
        return false;
    }

}
