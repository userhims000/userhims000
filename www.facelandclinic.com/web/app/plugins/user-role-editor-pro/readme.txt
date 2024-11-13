=== User Role Editor Pro ===
Contributors: Vladimir Garagulya (https://www.role-editor.com)
Tags: user, role, editor, security, access, permission, capability
Requires at least: 4.4
Tested up to: 5.3
Stable tag: 4.54
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

User Role Editor WordPress plugin makes user roles and capabilities changing easy. Edit/add/delete WordPress user roles and capabilities.

== Description ==

User Role Editor WordPress plugin allows you to change user roles and capabilities easy.
Just turn on check boxes of capabilities you wish to add to the selected role and click "Update" button to save your changes. That's done. 
Add new roles and customize its capabilities according to your needs, from scratch of as a copy of other existing role. 
Unnecessary self-made role can be deleted if there are no users whom such role is assigned.
Role assigned every new created user by default may be changed too.
Capabilities could be assigned on per user basis. Multiple roles could be assigned to user simultaneously.
You can add new capabilities and remove unnecessary capabilities which could be left from uninstalled plugins.
Multi-site support is provided.

== Installation ==

Installation procedure:

1. Deactivate plugin if you have the previous version installed.
2. Extract "user-role-editor-pro.zip" archive content to the "/wp-content/plugins/user-role-editor-pro" directory.
3. Activate "User Role Editor Pro" plugin via 'Plugins' menu in WordPress admin menu. 
4. Go to the "Settings"-"User Role Editor" and adjust plugin options according to your needs. For WordPress multisite URE options page is located under Network Admin Settings menu.
5. Go to the "Users"-"User Role Editor" menu item and change WordPress roles and capabilities according to your needs.

In case you have a free version of User Role Editor installed: 
Pro version includes its own copy of a free version (or the core of a User Role Editor). So you should deactivate free version and can remove it before installing of a Pro version. 
The only thing that you should remember is that both versions (free and Pro) use the same place to store their settings data. 
So if you delete free version via WordPress Plugins Delete link, plugin will delete automatically its settings data. Changes made to the roles will stay unchanged.
You will have to configure lost part of the settings at the User Role Editor Pro Settings page again after that.
Right decision in this case is to delete free version folder (user-role-editor) after deactivation via FTP, not via WordPress.

== Changelog ==

= [4.54] 25.11.2019 =
* Core version: 4.52.1
* New: Multisite: "Network Admin->Users->User Role Editor->Network Update" URE Pro uses by default the main blog as a source of add-ons settings to replicate for all network. New custom filter 'ure_get_addons_source_blog' allows to use as a source blog any other existing subsite. Filter accepts single parameter - main blog ID by default. User this filter to return ID of blog/subsite which you wish to use as a source of add-ons settings for all other subsites.
* Fix: PHP Notice: Undefined variable: post_id in /wp-content/plugins/user-role-editor-pro/pro/includes/classes/content-view-restrictions-editor.php on line 150

= [4.53] 14.11.2019 =
* Core version: 4.52.1
* New: Navigation menus admin access add-on: Block access to the navigation (front-end) menus under "Appearance->Menu" for selected role.
* Core version was updated to 4.52.1
* Update: URE requires PHP version 5.6.
* ure_cpt_editor_roles filter was added. It takes 2 parameters: array $roles with 1 element 'administrator' by default and $post_type with post type name string. Add other role(s) to which you wish automatically add all user capabilities for custom post type $post_type. URE updates roles this way before opening "Users->User Role Editor" page.
* Update: New own URE Pro user capability 'ure_nav_menus_access' was added. It allows to manage what front-end menus will be available for selected role.


Full list of changes is available in changelog.txt file.
