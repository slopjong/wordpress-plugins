=== Quick Scheduled Access ===
Contributors: slopjong
Tags: future, scheduled, admin, menu, post, page, post_type, shortcut, slopjong
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.1
Tested up to: 3.5
Stable tag: 1.0
Version: 1.0

Adds a link to Scheduled under the Posts, Pages, and other custom post type sections in the admin menu.


== Description ==

This plugin allows you one click access to the scheduled posts, pages or other post types via the main admin menu. Use the main admin menu to go to the section you want (i.e. "Posts"), then click the "Scheduled" link to list what you have scheduled.

In addition, the plugin shows the number of the current scheduled posts/pages (or other types) in the link. "Scheduled (5)" would indicate that there are five scheduled items of a certain post type.

The plugin hides the "Scheduled" link when no posts/pages have been scheduled. See the Filters section for how to override this behavior.

Also, the menu item only appears for users who have the capability to edit posts of that post type.

Links: [Plugin Homepage](http://slopjong.de) | [Author Homepage](http://slopjong.de)


== Installation ==

1. Unzip `quick-scheduled-access.zip` inside the `/wp-content/plugins/` directory (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress


== Screenshots ==

1. A screenshot of the main admin menu (with the menu expanded) showing the Scheduled link (with pending scheduled counts for both posts and pages).
2. A screenshot of the main admin menu (collapsed) showing the Scheduled link (with count) when hovering over "Posts"


== Frequently Asked Questions ==

= Why don't I see a "Scheduled" link in my menu after activating the plugin? =

Does that post type have any scheduled?  By default, the plugin does NOT display the scheduled link if no  are present for that post type.  This behavior can be overridden (see the Filters section).

= Why don't you show the "Scheduled" link for post types that don't have any scheduled items? =

Like the Posts and Pages admin tables in WordPress, the default behavior of the plugin is to not show the Scheduled link if none are present for the post type since there isn't anything meaningful to link to.  Bear in mind that the behavior can be overridden (see the Filters section).


== Filters ==

The plugin is further customizable via two filters. Typically, these customizations would be put into your active theme's functions.php file, or used by another plugin.

= slop_quick_scheduled_access_post_types =

The 'slop_quick_scheduled_access_post_types' filter allows you to customize the list of post_types for which a 'Scheduled' link will be shown.  By default, a 'Scheduled' link will be shown for all public post types, which includes the default post types of 'post' and 'page'.  If other post types have been added to your site, they will also automatically be taken into consideration.  If you want to explicitly add or remove particular post types, use this filter.

Arguments:

* $post_types (array): Array of post type objects

Example:

`
add_filter( 'slop_quick_scheduled_access_post_types', 'my_qda_mods' );
function my_qda_mods( $post_types ) {
    $acceptable_post_types = array();
    foreach ( $post_types as $post_type ) {
        // Don't show the Scheduled link for 'event' post type
        if ( !in_array( $post_type->name, array( 'event' ) ) ) // More post types can be added to this array
            $acceptable_post_types[] = $post_type;
    }
    return $acceptable_post_types;
}
`

= slop_quick_scheduled_access_show_if_empty =

The 'slop_quick_scheduled_access_show_if_empty' filter allows you to customize whether the 'Scheduled' link will appear for a post type _when that post type currently has no scheduled items_.

Arguments:

* $show (bool): The default boolean indicating if the Scheduled link should be shown if the post type does not have any scheduled items. Default is false.
* $post_type_name (string): The post_type name
* $post_type (object): The post_type object

Example:

`
// Show the link to Scheduled even if no scheduled items exist for the post type.
add_filter( 'slop_quick_scheduled_access_show_if_empty', '__return_true' );
`


== Changelog ==

= 1.0 =
* Initial release
