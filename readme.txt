=== Advanced Term Fields: Colors ===
Contributors: dbmartin
Tags: termmeta, term_meta, term, meta, metadata, taxonomy, colors
Requires at least: 4.4
Tested up to: 4.4.2
Stable tag: 0.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily assign colors for categories, tags, and custom taxonomy terms. Term meta, color coded!

== Description ==

**Advanced Term Fields: Colors** extends the Advanced Term Fields framework to give users the ability to easily add and manage colors (through custom term meta) for any category, tag, or custom taxonomy.

Easily sort and manage your color-coded terms!

= Usage =

This is an extension of the **Advanced Term Fields** framework.  To use, the Advanced Term Fields plugin must be installed on your project.

You can find the plugin here: [Advanced Term Fields](https://wordpress.org/plugins/advanced-term-fields/)

= Check Out Other Extensions =

* [Advanced Term Fields: Icons](https://wordpress.org/plugins/advanced-term-fields-icons/) Color-code your terms!
* [Advanced Term Fields: Featured Images](https://wordpress.org/plugins/advanced-term-fields-featured-images/) Featured images for terms!

== Installation ==

= From the WordPress.org plugin repository: =

* [Download](https://wordpress.org/plugins/advanced-term-fields-colors/) and install using the built in WordPress plugin installer.
* Activate in the "Plugins" area of your admin by clicking the "Activate" link.
* No further setup or configuration is necessary.

= From GitHub: =

* Download the [latest stable version](https://github.com/dboutote/Advanced-Term-Fields-Colors/archive/master.zip).
* Extract the zip folder to your plugins directory.
* Activate in the "Plugins" area of your admin by clicking the "Activate" link.
* No further setup or configuration is necessary.


== FAQ ==

= Where can I find documentation? =

The plugin's official page: http://darrinb.com/advanced-term-fields-colors

= Does this plugin depend on any others? =

Yes, this plugin is an extension of the Advanced Term Fields framework.  You'll need to install that plugin to handle all base functionality.

It can be found here: [Advanced Term Fields](https://wordpress.org/plugins/advanced-term-fields/)

= Does this create/modify/destroy database tables? =

This leverages the term meta capabilities added in WordPress 4.4.  No database modifications needed!

== Screenshots ==

1. Custom column on the Tag List Table.
2. Select your color using the native WordPress color picker.
3. Accessible from the Quick Edit form
4. Color picker on the Edit Tag screen.


== Changelog ==

= 0.1.2 =
* Added `$meta_slug` property for localizing js files and HTML attributes for form fields.
* Added check for update functionaliy to test for latest version.
* Changed meta field key to protected.
* Removed final keyword from Adv_Term_Fields_Icons class.

= 0.1.1 =
* Added function to clear color picker on ajax form submit when adding tags.

= 0.1.0 =
* Initial release
