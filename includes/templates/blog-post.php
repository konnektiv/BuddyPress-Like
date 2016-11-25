<?php
/**
 * BuddyPress Like - Blog Post Button
 *
 * This function is used to display the BuddyPress Like button on blog posts on the WordPress site.
 *
 * @package BuddyPress Like
 *
 */
/*
 * bplike_blog_post_button()
 *
 * Outputs Like/Unlike button for blog posts.
 *
 */
function bplike_blog_post_button( $content ) {
    global $post;

    if (!is_singular($post->post_type) || !bp_like_get_settings('bp_like_post_types') ||
        !in_array($post->post_type, bp_like_get_settings('bp_like_post_types')))
        return $content;

    if ( is_user_logged_in() ) {
        $vars = bp_like_get_template_vars( get_the_ID(), 'blog_post' );
        extract( $vars );
        ob_start();

        ?><a href="#" class="blogpost <?php echo $classes; ?>" id="bp-like-blogpost-<?php echo get_the_ID(); ?>" title="<?php echo $title; ?>">
                <span class="like-text"><?php echo bp_like_get_text( 'like' ); ?></span>
                <span class="unlike-text"><?php echo bp_like_get_text( 'unlike' ); ?></span>
				<span class="like-count"><?php echo ( $liked_count ? $liked_count : '' ) ?></span>
         	</a>
        <?php

        view_who_likes( get_the_ID(), 'blog_post');

		$content .= ob_get_clean();

        // do not show like button twice
        remove_filter('the_content', 'bplike_blog_post_button');
	}
	return $content;
}
add_filter('the_content', 'bplike_blog_post_button');
