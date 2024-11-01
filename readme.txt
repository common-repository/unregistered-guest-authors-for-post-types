=== Unregistered (Guest) Authors for post types ===
Contributors: primisdigital,vinshakp
Plugin Name: Unregistered (Guest) Authors for post types
Plugin URI: https://www.primisdigital.com/wordpress-plugins/
version :1.0
Author: Prims digital
Tags:author,guest author,post author,author for post types, unregistered author
Requires at least: any version
Tested up to: 5.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Unregistered (Guest) Authors for post types plugin lets you assign unregistered users as post author.

== Description ==

Guest Author plugin allow you to add authors to posts without registering them as users. 

Sometimes we have blogs of different authors, but we are not interested to register them as wordpress users. In this case usually we will create some custom fields and add those details.

With this plugin we are implementing a common way to do that. 

Here we listing all authors together at one place using a custom post type. We can add full details of those authors, like bio, social media links, job details, contact details and photo. 

Then we need to check where we want to(custom post types, pages) display those authors, then we can select those authors from each post type easily. 

Working
========
You can add details of all authors in the author listing section(custom post type) and select those author in posts, post types and pages.

To display the author box two options are available, automatically display after the post contents(the_content()) and using shortcode.

Once you selected posts type in which you want to display authors, a list of dropdown with authors will be listed on the respective post types.
Then you can select authors for those posts. So after contents those authors will be displayed as a box. 

To display it automatically, check the option on the plugins settings page, so it will display after page contents or post contents. 

To use the shortcode use : [guest_author]

Using this shortcode [guest_author] in widgets or sidebar, of single post types or pages, it will display the author of that post there.



== Installation ==

= Admin Installer via search =

1. Visit the Add New plugin screen and search for "Unregistered (Guest) Authors for post types".
2. Click the "Install Now" button.
3. Activate the plugin.
4. Navigate to the settings >> "Guest Author Settings" Menu.

= Install via FTP =
1. First unzip the plugin file
2. Using FTP go to your server's wp-content/plugins directory
3. Upload the unzipped plugin here
4. Once finished login into your WP Admin and go to Admin > Plugins
5. Activate the plugin.


After installation and activation of plugin go to settings >> "Guest Author Settings" Menu .

Select the post types , in which you want to display the authors.

Then Go to "Guest Author" post types and add authors details here.

== Frequently Asked Questions ==

1.  How to add Authors Details
  
	Go To Admin Dashbaord  >> Guest Author
	Click on Add New and add all details of authors.

2. Is it possible to upload author images

	Yes, You can upload author image from the author details page

3. How to display the author details on right side bar of the page?
  
	Use shortcode [guest_author], to display author details.
	
4. Can we style the author box based on our theme?

	Yes, we have done only some basic styles, you can style it based on theme, we have provided proper ids, and classes for every details.



== Changelog ==


= 1.0 - 2019-10-24  

- First version