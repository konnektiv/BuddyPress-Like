<?php
/**
 * BuddyPress Like - BBP Reply Button
 *
 * This function is used to display the BuddyPress Like button on bbp replies on the WordPress site.
 *
 * @package BuddyPress Like
 *
 */
/*
 * bplike_bbp_reply_button()
 *
 * Outputs Like/Unlike button for bbp replies.
 *
 */
function bplike_bbp_reply_button() {
    global $post;

    if ( ! is_user_logged_in() ) {
        return;
    }

    if (!bp_like_get_settings('bp_like_post_types') ||
        !in_array($post->post_type, bp_like_get_settings('bp_like_post_types')))
        return;

    $vars = bp_like_get_template_vars( get_the_ID(), 'bbp_reply' );
    extract( $vars );

    ?>
        <a class="bbp-reply <?php echo $classes ?>" id="bp-like-bbp-reply-<?php echo get_the_ID(); ?>"
           title="<?php echo $title; ?>" data-like-type="bbp_reply">
            <span class="like-text"><?php echo bp_like_get_text( 'like' ); ?></span>
            <span class="unlike-text"><?php echo bp_like_get_text( 'unlike' ); ?></span>
            <span class="like-count"><?php echo ( $liked_count ? $liked_count : '' ) ?></span>
        </a>
    <?php

    view_who_likes( get_the_ID(), 'bbp_reply');

}
add_action('bbp_theme_after_reply_content', 'bplike_bbp_reply_button');
