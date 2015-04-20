<?php
//TD : PLAN : allow copies of the site to run from same db
namespace ark\multidomain;

class domainHandler {

    //Return output text with domain set to new one.
    public static function changeUrl($buffer) {
        $original = \ark\multidomain\domainHandler::getdefaultDomain(); //stripslashes('localhost/wpyajax/');
        $target = \ark\multidomain\domainHandler::getCurrDomain();// 'w1.localhost/';
        $buffer = preg_replace("#$original#", $target, $buffer);

        
        $originalTrimmed = preg_replace('#^http[s]?:\/\/#','',$original);
        $targetTrimmed = preg_replace('#^http[s]?:\/\/#','',$target);
        $buffer = preg_replace("#$originalTrimmed#", $targetTrimmed, $buffer);
        return $buffer;
    }

    public static function applyChange() {
        $output = '';
        $levels = count(ob_get_level());
        for ($i = 0; $i < $levels; $i++) {
            $output .= ob_get_clean();
        }
        echo apply_filters('final_output', $output);
    }

    public static function getCurrDomain() {
        if($_SERVER['REQUEST_SCHEME']=='https' || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')   ){
            $protocol = 'https://';
         
        }
        else $protocol = 'http://'; 
        //$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
        // find current domain exact from the backend list and return
        $currHost = $protocol.$_SERVER['HTTP_HOST'];
        $domains = unserialize(get_option('armultidomains'));
        if (is_array($domains)) { 
            foreach ($domains as $domain) {
                if (preg_match("#^$currHost#", $domain['name'])) {
                    return $domain['name'];
                }
            }
        } 
        return $currHost;  
    }
 
    public static function getdefaultDomain() {
        return get_option('siteurl');
    }

}
