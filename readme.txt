=== Button Widget ===
Contributors: mahdiyazdani, mypreview
Tags: button, widget, callout, call to action
Donate link: https://www.mypreview.one
Requires at least: 5.0
Tested up to: 5.3.1
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple customizable button widget for your sidebars.

== Description ==
A simple customizable button widget for your sidebars to allow users take actions, and make choices, with a single tap.

**Translators & Non-English Speakers**

Translators are welcome to contribute to the plugin. Please use the [WordPress translation website](https://translate.wordpress.org/projects/wp-plugins/button-widget "WordPress translation website").

**Get Involved**

Want to contribute? Here's the [GitHub development repository](https://github.com/mypreview/button-widget "GitHub development repository").

**Free Support**

All support is handled via a dedicated support forum, available at [Community Forums](https://wordpress.org/support/plugin/button-widget "Community Forums"). Please head out there to open a new topic, in case you have any questions.

**Support this plugin**

Don't forget to rate this plugin [5 shining stars](https://wordpress.org/support/plugin/button-widget/reviews/ "5 shining stars") if you like it, thanks!

== Installation ==
= Minimum Requirements =

* PHP 7.2 or greater is recommended
* MySQL 5.6 or greater is recommended

= Automatic installation =

Automatic installation is the easiest option — WordPress will handles the file transfer, and you won’t need to leave your web browser. To do an automatic install of the plugin, log in to your WordPress dashboard, navigate to the Plugins menu, and click “Add New.”
 
In the search field type “Button Widget,” then click “Search Plugins.” Once you’ve found us,  you can view details about it such as the point release, rating, and description. Most importantly of course, you can install it by! Click “Install Now,” and WordPress will take it from there.

= Manual installation =

Manual installation method requires downloading the plugin plugin and uploading it to your web server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation "Manual plugin installation").

= Updating =

Automatic updates should work smoothly, but we still recommend you back up your site.

== Frequently Asked Questions ==
= How do I use the plugin? =
1. Log into your WordPress website and navigate to Appearance » Widgets.
2. Locate the Button widget and drag it to the sidebar area where you wish it to appear.
3. Click the down arrow in the upper right corner to expand the widget’s interface.
4. Then click the Save button to save the widget’s customization.
5. Preview the site. You should now see the added button widget is visible.

= How do I customize the button’s appearance? =
Although the button text and background color can be edited, the widget adapts your theme’s default button style with adding the `button` class name to the output markup. You may modify it using the following filter:
`
function prefix_custom_button_widget_classname( $classname ) {
	$classname = 'custom-class-name';
	return (string) $classname;
} 
add_filter( 'button_widget_classname', 'prefix_button_widget_classname', 10, 1 );
`
= I need help customizing this plugin? =
I am a full-stack developer with over five years of experience in WordPress theme and plugin development and customization. I would love to have the opportunity to discuss your project with you.
[Hire me at UpWork &#8594;](https://www.upwork.com/o/profiles/users/_~016ad17ad3fc5cce94/ "Mahdi Yazdani Freelancer Profile")

== Screenshots ==
1. Widget settings interface

== Changelog ==
= 1.0.0 =
* Initial release.