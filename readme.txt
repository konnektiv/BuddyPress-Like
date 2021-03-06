=== BuddyPress Like ===
Contributors: darrenmeehan, cherbst
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZAJLLEJDBHAWL
Tags: buddypress, like, rate, thumbs, post, button, vote
Requires at least: WordPress 3.8, BuddyPress 1.5
Tested up to: WordPress 4.4, BuddyPress 2.4
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gives users the ability to 'like' content across your BuddyPress enabled site.

== Information about this fork ==

This fork adds the following new features:

* Store total like count for posts into post meta for orderby
* Support Like button on bbPress Topics & Replies
* Save likes in a seperate table

== Description ==

Gives users the ability to 'like' content across your BuddyPress enabled site.

== Installation ==

= Automatic Installation =
1. Ensure BuddyPress is installed and activated
2. From inside your WordPress administration panel, visit 'Plugins -> Add New'
3. Search for `BuddyPress Like` and find this plugin in the results and press 'Install'
4. Press 'Activate Plugin'

= Manual Installation =

1. Upload `buddypress-like` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==
1. Screenshot of what the like button looks like by default on activity
2. Screenshot of settings available in admin settings

== Changelog ==
= 0.4 =
- Now supports liking blog posts
- Also includes support for notifications
- Added screenshots


= 0.3 =
- Improved privacy when liking in groups
- Improved usage of text strings in move to help translation
- Moved bp_like_remove_favourites() from scripts.php to settings.php
- Implemented Like button is different templates
- Changed Option: Post to activity stream default setting is now off
- No longer posting update when someone likes a comment
- Now enqeueing scripts through recommended wp_enqueue_scripts
- Removed jQuery UI as themes should include this if needed
- Add <span></span> around like count - similar to comment count in BuddyPress
- Added <small></small> around display of who likes updates
- Fixes applied to AJAX
- Tested with WordPress 4.4 and BuddyPress 2.4

= 0.2.2 =
- Fixed output for when three people like an activity
- removed inline comment at top of bplike.js
- added term variables to array bplikeTerms. Thanks to vasikgreif (https://wordpress.org/support/profile/vasikgreif)

= 0.2.1 =
* Added changelog.txt
* Added LICENCE.txt
* Added check for BuddyPress 1.5 to bplike_init() in  bp-like-loader.php
* moved admin.php to /admin folder
* renamed bp-like.dev.js to bp-like.js
* implemented bp_get_activity_type() in button-functions.php
* tidied up scripts.php. Thanks to vasikgreif (https://wordpress.org/support/profile/vasikgreif)

= 0.2.0 =
* Added jQuery UI again.

= 0.1.9 =
* Renamed bp-like.dev.js to bp-like.js
* Fixed parameters for wp_register_script(). Thanks to https://profiles.wordpress.org/ryanhellyer
* Fixed PHP notice when a comment is liked. Thanks to https://profiles.wordpress.org/jasonthoele

= 0.1.8 =
* Various fixes, thanks to BronsonQuick (https://github.com/BronsonQuick)

= 0.1.7 =
* No longer posts to activity feed when user likes post in a group.

= 0.1.6 =
* Fixed bug when displaying number of people who liked.
* Fixed bug with jQuery not working after loading more statuses.

= 0.1.5 =
* Removed favorite/unfavorite button on activity items using jQuery.
* Added function: view_who_likes().
* Added hook: view_who_likes, will be adding more.
* Added function bp_like_get_num_likes() to return number of likes of an item.
* Tidied up jQuery, now properly using no conflict mode, functions split up.
* Fixed activity filter bug where custom text for 'Blog Post Likes' was not called.
* Moved Settings Page to under "Settings" tab in Admin, previously was under legacy BuddyPress tab.
* New donate link.
* Organised functions into different files, no more having one massive file!
* Function added: bp_like_post_to_stream() with some code clean up inside
* Tidied up bp_like_list_scripts() function, properly registering and enqueuing the scripts.
* Removed like visibility, more changes on this to come.

= 0.1.1 =
* Fixed errors in readme.txt
* Started formating code to meet WordPress code Standards
* Add in View Likes, until some bugs are fixed.
* View Likes should now be working in comments.
* Minified JavaScript.
* Several other small fixes.

= 0.1.0 =
* Tidied up Admin Panel.
* Removed bp_like_insert_head() as it's not needed anymore thanks to BuddyPress' theme compatibility.
* Added bp_like_users_who_like() function to output the users who liked an item.
* Removed "View Likes" button, instead showing who liked each post.

= 0.0.9 =
* Bug fixed: updates deprecated WordPress functions.

= 0.0.8 =
* New feature: blog posts can now be liked.
* New feature: you can no show an excerpt of the liked content.
* Option added: disable posting likes to the activity stream.
* Option added: show avatars of likers instead of names.
* Bug fixed: activity updates of likes are now deleted when the item is unliked.
* Bug fixed: plugin would break if the Friends component was disabled.

= 0.0.7 =
* Fixes a couple of major bugs
* Bug fixed: Posts, drafts etc would not be saved, giving error "You do not have permission to do that."
* Bug fixed: Could not save 'Likers Visibility' options from the BuddyPress Like settings screen.

= 0.0.6 =
* Fully localised.
* Adds options to customise the messages displayed to users.

= 0.0.5 =
* Fixes a bug when a user tries to view likes when they have no friends.
* Inserts the 'View likes' button if the user is the first to like an item.

= 0.0.4 =
* Adds options for the visibility of 'likers' via the admin panel.

= 0.0.3 =
* Fixed a bug affecting installs where WP isn’t in the root of the site.

= 0.0.1 =
* Initial release.

== Upgrade Notice ==

= 0.3 =
Bug fixes, tested with WP 4.4 and BP 2.4 - See changelog.txt for more details.

= 0.2.0 =
jQuery UI added back, which is required for some themes.

= 0.1.9 =
Some small fixes.

= 0.1.8 =
jQuery bug is now fixed, tested with latest WordPress and BuddyPress.

= 0.1.7 =
No longer posts statuses when something is liked in a group. Also includes some JQuery fixes.

= 0.1.5 =
Many fixes, but still only suitable for testing. Settings moved to Setting->BuddyPress Like. Can now like comments properly and remove the favourite button.

= 0.1.1 =
A few awesome fixes! Comments should now work properly.

= 0.0.8 =
The biggest update yet! Lots of new features, including the ability to like blog posts. Recommended for all users.

= 0.0.7 =
Important upgrade! Fixes a couple of major bugs affecting saving posts, drafts etc (giving error "You do not have permission to do that.") and the saving of 'Likers Visibility' options

= 0.0.6 =
Now with translation support, as well as options to customise the messages displayed to users.

= 0.0.5 =
Important upgrade for 0.0.4 users! Fixes a bug when a user tries to view likes when they have no friends.

= 0.0.4 =
Upgrading allows you to choose what information about the 'likers' of an item is shown.

= 0.0.3 =
Upgrade if you're installation is not in the root of the domain.
