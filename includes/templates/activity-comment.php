<?php
/**
 * BuddyPress Like - Activty Comment Button
 *
 * This function is used to display the BuddyPress Like button on comments in the activity stream
 *
 * @package BuddyPressLike
 *
 */

/*
 * bplike_activity_comment_button()
 *
 * Outputs Like/Unlike button for activity comments.
 *
 */
function bplike_activity_comment_button() {

    $liked_count = 0;

    if ( is_user_logged_in() ) {

		$liked_count = count(  BPLIKE_LIKES::get_likers(bp_get_activity_comment_id(), 'activity_comment') );

        if ( ! bp_like_is_liked( bp_get_activity_comment_id(), 'activity_comment', get_current_user_id() ) ) { ?>
            <a href="#" class="acomment-reply bp-primary-action like <?php if (bp_like_get_settings('bp_like_toggle_button')) echo 'toggle'; ?>" id="like-activity-<?php echo bp_get_activity_comment_id(); ?>" title="<?php echo bp_like_get_text( 'like_this_item' ); ?>"><?php
               echo bp_like_get_text( 'like' ); ?>
        <?php } else { ?>
            <a href="#" class="acomment-reply bp-primary-action unlike <?php if (bp_like_get_settings('bp_like_toggle_button')) echo 'toggle'; ?>" id="unlike-activity-<?php echo bp_get_activity_comment_id(); ?>" title="<?php echo bp_like_get_text( 'unlike_this_item' ); ?>">
                <?php if (bp_like_get_settings('bp_like_toggle_button')) { ?>
                    <span class="like-text"><?php echo bp_like_get_text( 'like' ); ?></span>
                <?php } ?>
                <span class="unlike-text"><?php echo bp_like_get_text( 'unlike' ); ?></span>
        <?php } ?>
                <span class="like-count"><?php echo ( $liked_count ? $liked_count : '' ) ?></span>
            </a>
        <?php
    }
}
