
One Install, one DB, multiple domains, each with its own theme!
if you have more than one domain and no time to update both, this plugin is the answer.


### Features

 - Install wordpress only once and have single copy of content in one place
 - Show your 'same' content on different domains / subdomains using different theme per domain.
 - Supports wordpress installation at domain / subdomain root or any subfolder/path.
 - All links to your own site are auto-converted for each domain.
 - Add / remove or modify themes from wp-admin page 
 - Supports both http and https domains, need to add both http and https domain in admin page.
 - Supports different themes on http and https  for the same domain!

**For theme Developers**

 - Great for theme developers who want to see different versions of the same theme / different themes on the same content.
 - Showcase all your themes on the same content, save diskspace and wordpress maintenance times.

**SEO**

 - Good for design based SEO, you can use different visual settings for the same content at different domains and see which domain works out well.
 -  
### Usage Guideline

**0. Install WP**

Assuming you have wp with this plugin installed. You don't need to do anything.
We will call this as the *master install* or the *master domain*. 

You should have plenty of themes available in this install to use for all your domains.

**1. Domains Setup** 
 
From your cpanel / apache configuration of virtual hosts, point your domains / subdomains to the root directory of wordpress install. Repeat this for all domains you want to use.

**2. Add Domains**

From your master install wp-admin, goto the multiple domains admin page and add the domains including http:// part in the backend.  You can select any existing theme from the dropdown.

In case if you want to update a theme, just add another copy and then remove the original one to allow zero interruption.

**3. Visit Sites**

Visit your sites to ensure everything is fine and different themes are there.


**Modifying theme Settings**

 You will need to activate each theme one by one on master and customize its settings. The saved settings will be used on other sites even if the theme is no longer active on the master site.

 *We recommend to use a staging server as the master install, that way your live sites wont be disturbed.*


**4. htaccess (\*maybe required)**

In cases if one or more of your domains / subdomains is not using wordpress installation at the site root (at www.site.com/path instead of www.site.com), you will need to let apache know about that.

From the same admin page, copy the .htaccess file and replace the wp_part in existing one. Make sure to have a backup. 

Note that the htaccess file contents are not visible in admin panel if these are not needed to be updated for the domains.



### Limitations

 - Wordpress does not allow multiple sites on same subdomain at different paths, this plugin does not attempt to allow that. However you can use as many subdomains as you like as well as different domains without issue. 
 - If you need to modify theme settings, you must enable it on the 'master' site and modify there, once done, you can apply the same theme with same settings to any other site.
 - You cannot have the same theme applied with DIFFERENT settings to different sites. This may apply to some child themes using the same db entries too.
 - Not tested with wordpress multisite network install.
 
 