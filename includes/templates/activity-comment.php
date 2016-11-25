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

    if ( is_user_logged_in() ) {
        $vars = bp_like_get_template_vars( bp_get_activity_comment_id(), 'activity_comment' );
        extract( $vars );

        ?>
        <a href="#" class="acomment-reply bp-primary-action <?php echo $classes ?>" id="bp-like-activity-<?php echo bp_get_activity_comment_id(); ?>" title="<?php echo $title ?>">
            <span class="like-text"><?php echo bp_like_get_text( 'like' ); ?></span>
            <span class="unlike-text"><?php echo bp_like_get_text( 'unlike' ); ?></span>
            <span class="like-count"><?php echo ( $liked_count ? $liked_count : '' ) ?></span>
        </a>
        <?php
    }
}
