<?php

namespace ark\multidomain;

class adminHandler {
    
    //Default notification message is empty.
    static $defaultMsg = [
        0 => '',
        1 => 'notification'
    ];

    /**
     * display the wordpress menu
     */
    public static function menu() {
        add_menu_page('Multiple Domains', 'Multiple Domains', 'edit_posts', 'armultidomain', '\ark\multidomain\adminHandler::setDomains');
    }

    /**
     * Displays the Admin page to set domains and domain themes  
     */ 
    public static function setDomains() { 
        $data = [];
        //Fetch domains from db
        $data['domains'] = unserialize(get_option('armultidomains'));
        
        //Get list of current themes
        $data['themes'] = wp_get_themes(array('allowed' => true));


        $submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_STRING);

        if (strlen($submit) > 1) {
            switch ($submit) {
                case 'add': //Add domain & select theme from dropdown
                    if (self::addDomain($data['domains'])) {
                        $data['domains'] = unserialize(get_option('armultidomains')); //refresh
                        $data['msg'] = array("Domain added successfully", 'notification');
                    } else {
                        $data['msg'] = array("Error in adding domain, make sure name starts with http", 'error');
                    }
                    break;
                case 'delete': // Delete domain 
                    self::deleteDomain($data['domains']);
                    $data['domains'] = unserialize(get_option('armultidomains')); //refresh
                    $data['msg'] = array("Domain removed successfully", 'notification');
                    break;
            }
        }
        $data['htaccess'] = self::getHtaccess($data['domains']);
        $data['htpath'] = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . ".htaccess";
        self::view('setDomains', $data);
    }

    static function deleteDomain($domains) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        if (isset($domains[$id])) {
            unset($domains[$id]);
            update_option('armultidomains', serialize($domains));
        }
    }

    static function addDomain($domains) {
        //validate domain format, remove spaces and check for http[s]?
        $name = preg_replace('#\/$#', '', trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)));
        $theme = filter_input(INPUT_POST, 'theme', FILTER_SANITIZE_STRING);
        if (preg_match('#^http[s]?:\/\/#', $name)) {
            if (!is_array($domains)) {
                $domains = [];
            }
            $newdomain = array('name' => $name, 'theme' => $theme);
            array_push($domains, $newdomain);
            update_option('armultidomains', serialize($domains));
            return true;
        } else {
            return false; // domain incorrect!
        }
    }

    /**
     * show or return the view according to the data
     * @param type $view
     * @param type $data
     * @param type $return
     * @return type the view html content if return is set to true, otherwise prints to output the same content
     */
    public static function view($view, $data = null, $return = false) {
        if ($data != null) {
            extract($data);
        }
        if (!isset($data['msg'])) {
            $msg = self::$defaultMsg;
        }
        if (strlen($msg[1]) < 1) {
            $msg[1] = 'notificaton';
        }
        ob_start();
        if (isset($data['msg'])) {
            require self::getPlugPath() . "/views/msg.php";
        }

        if (!preg_match("#msg$#", $view))
            require self::getPlugPath() . "/views/$view.php";
        $viewdata = ob_get_clean();
        if ($return) {
            return $viewdata;
        } else {
            echo $viewdata;
        }
    }

    static function getPlugPath() {
        return dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
    }

    static function getHtaccess($domains) {
        $useHtaccess = false;
        // return text to be used for htaccess file
        $htaccess = '# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]';


        foreach ($domains as $domain) {
            $name = preg_replace('#^http[s]?:\/\/#','',$domain['name']);
                
            if (preg_match("#\/#", $name)) {
                $useHtaccess = true;
                $path = preg_quote(preg_replace('#^[^\/]+#', '', $name));
                $host = preg_quote(preg_replace('#(^[^\/]+).*#', '$1', $name));
                $htname = preg_quote($name);
                $htaccess.="

#for $host$path at non-root level
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{HTTP_HOST} ^$htname.* [NC]
RewriteRule . $path/index.php [L]";
            }
        }
        $htaccess .='

#all other domains at root level
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d 
RewriteRule . /index.php [L]

</IfModule>

# END WordPress';
        if ($useHtaccess)
            return $htaccess;
        return false;
    }

}
