<?php
/**
 * BuddyPress Like - Activty Update Button
 *
 * This function is used to display the BuddyPress Like button on updates in the activity stream
 *
 * @package BuddyPress Like
 *
 */

/*
 * bplike_activity_update_button()
 *
 * Outputs Like/Unlike button for activity updates.
 *
 */
function bplike_activity_update_button() {

    if ( is_user_logged_in() ) {
      if ( bp_get_activity_type() !== 'activity_liked' && bp_get_activity_type() != 'blogpost_liked' ) {
        $vars = bp_like_get_template_vars( bp_get_activity_id(), 'activity_update' );
        extract( $vars );

       ?>
        <a class="button bp-primary-action <?php echo $classes ?>"
            id="bp-like-activity-<?php echo bp_get_activity_id(); ?>"
            title="<?php echo $title ?>">
            <span class="like-text"><?php echo bp_like_get_text( 'like' ); ?></span>
            <span class="unlike-text"><?php echo bp_like_get_text( 'unlike' ); ?></span>
            <span class="like-count"><?php echo ( $liked_count ? $liked_count : '' ) ?></span>
        </a>
        <?php

        // Checking if there are users who like item.
        view_who_likes( bp_get_activity_id(), 'activity_update' );
      }
    }
}
