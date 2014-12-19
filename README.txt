=== Plugin Name ===
Contributors: _silver
Tags: widget, notes, sidebar, notification, news, events, tweet, twitter
Requires at least: 3.5
Tested up to: 4.1
Stable tag: 0.1.3
License: GPLv2 or later


WP Notes Widget adds a 'sticky note' style widget to your Wordpress site. Customize the look for your needs. 

== Description ==

Posts and pages have their own characteristics and uses, but sometimes there is a need to display important, very short, time sensitive text which don't really fit into a post or page. WP Notes Widget fills this gap. The visual design is similar to real sticky notes which adds to the effective communication of the message.    

To further enhance the functionality of WP Notes Widget you can install these great plugins:

[Post Expirator](https://wordpress.org/plugins/post-expirator/) by Aaron Axelsen
	
[Post Types Order](https://wordpress.org/plugins/post-types-order/) by Nsp Code

You can also take advantage of some built in Wordpress functionality which you may not have explored yet:

* 'post dating' notes so that they only appear once a certain date and time has been reached

WP Notes Widget has also been designed to work with [WPML](http://wpml.org/). 
	
Some possible uses include:

* a store (online and/or 'brick and mortar') displaying notifications about new products, sales, or holiday hours
* a recreational facility displaying information about new programs, sales, holiday hours
* displaying important deadlines in various contexts


== Installation ==

1. Download plugin from Wordpress plugin repository
2. Activate the plugin through the 'Plugins' menu in WordPress (upon activiation some sample notes will be created)
3. On the main Wordpress admin menu, go to 'Notes'
4. You can either leave the sample notes published or move them to the trash.
5. Create/replace/adjust the available notes to your needs (similar to creating pages or posts).
3. Go to 'Appearance > Widgets' in the Wordpress Admin (after logging in)
4. Select 'WP Notes Widget' from the selection of available widgets. Drag it to your desired widget area.
5. Configure the look of the WP Notes Widget to your needs. You can choose the text color, background color, and thumb tack color.
6. Select "I will use my own CSS styles for WP Notes Widget" if you will be using your own CSS styles (for advanced users)
7. Select "Use my theme's widget wrapper for WP Notes Widget" if you would like to use the generic wrapper your theme uses for all widgets, in a given widget area. Depending on what the widget wrapper does (adds padding, margins, borders, etc) WP Notes Widget may or may not look better with this option checked. Experiment and see what looks best with your theme. Be sure to test at different screen widths.   
8. The plugin is now set to display all of the published notes, ordered by their 'order' field and then by date.  

== Frequently Asked Questions ==

= What is the best way to customize the look (CSS) of WP Notes Widget? =

Select the "I will use my own CSS styles for WP Notes Widget" option on the widget configuration page. This will disable all built in WP Notes Widget styles. You can take a look at public/less/wp-notes-public.less to view the LESS file used to generate the CSS file used on the front end of the website. This may be helpful when creating your own styles. You can add your own styles to the style.css file in your active theme folder, or another file if your theme does not use style.css for theme styles.  


== Screenshots ==

1. This shows what fields and options are available when editing a single note. Similar to a posts.
2. This shows the listing of all of the notes in the system. Similar to posts. 
3. This shows the widget controls on the widget admin page.
4. The show what the front end of the website looks like using the configuration specified. The layout will naturally differ depending on what theme is being used. 


== Changelog ==

= 0.1.1.2 =
* Minor adjustments to default CSS

= 0.1.1 =
* Added option to include theme's widget wrapper (before_widget and after_widget)
* Cleaned up efficiency of code in widget class

= 0.1 =
* Initial version



