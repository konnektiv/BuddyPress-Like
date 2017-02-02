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
    $forum_topic_actions = array(
        'new_forum_topic',
        'new_forum_post',
    );

    if ( $activity_obj->type == 'new_blog_post' ) {
        $post_type = 'post';
    } elseif ( false !== array_search( $activity_obj->type, $forum_topic_actions ) ) {
        $post_type = 'topic';
    } else if ( ! empty( $bp->activity->track ) && false !== array_search( $activity_obj->type, array_keys( $bp->activity->track ) ) ) {
        $post_type = $bp->activity->track[$activity_obj->type]->post_type;
    }

    if ( $post_type && ( !( $settings = bp_like_get_settings('bp_like_post_types') ) ||
        !in_array($post_type, $settings ) ) ) {
        return;
    }

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
