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

    // only logged in users can like
    if ( ! is_user_logged_in() ) {
        return;
    }

    // do not allow liking of like activities
    if ( bp_get_activity_type() == 'activity_liked' || bp_get_activity_type() == 'blogpost_liked' ) {
        return;
    }

    $bp = buddypress();
    $activity_obj = new BP_Activity_Activity( bp_get_activity_id() );

    $post_type = false;

    if ( $activity_obj->type == 'new_blog_post' ) {
        $post_type = 'post';
    } elseif ( $activity_obj->type == 'bbp_topic_create' ) {
        $post_type = 'topic';
    } elseif ( $activity_obj->type == 'bbp_reply_create' ) {
        $post_type = 'reply';
    } else if ( ! empty( $bp->activity->track ) && false !== array_search( $activity_obj->type, array_keys( $bp->activity->track ) ) ) {
        $post_type = $bp->activity->track[$activity_obj->type]->post_type;
    }

    if ( $post_type && ( !( $settings = bp_like_get_settings('bp_like_post_types') ) ||
        !in_array($post_type, $settings ) ) ) {
        return;
    }

    $type = 'activity_update';
    $id = bp_get_activity_id();

    if ( $post_type ) {
	    $type = 'blog_post';

	    // bbpress uses the secondary_item_id for the forum
	    if ( $activity_obj->component == 'bbpress' ) {
		    $id = $activity_obj->item_id;
	    } else {
		    $id = $activity_obj->secondary_item_id;
        }
    }

    $vars = bp_like_get_template_vars( $id, $type );
    extract( $vars );

   ?>
    <a class="button bp-primary-action <?php echo $classes ?>"
        id="bp-like-activity-<?php echo $id; ?>"
        title="<?php echo $title ?>" data-like-type="<?php echo $type ?>">
        <span class="like-text"><?php echo bp_like_get_text( 'like' ); ?></span>
        <span class="unlike-text"><?php echo bp_like_get_text( 'unlike' ); ?></span>
        <span class="like-count"><?php echo ( $liked_count ? $liked_count : '' ) ?></span>
    </a>
    <?php

    // Checking if there are users who like item.
    view_who_likes( $id, $type );

}
