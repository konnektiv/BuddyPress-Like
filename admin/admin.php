<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * bp_like_add_admin_page_menu()
 *
 * Adds "BuddyPress Like" to the main BuddyPress admin menu.
 *
 */
function bp_like_add_admin_page_menu() {
    add_submenu_page(
            'options-general.php' , 'BuddyPress Like' , 'BuddyPress Like' , 'manage_options' , 'bp-like-settings' , 'bp_like_admin_page'
    );
}
add_action( 'admin_menu' , 'bp_like_add_admin_page_menu' );

/**
 * bp_like_admin_page_verify_nonce()
 *
 * When the settings form  is submitted, verifies the nonce to ensure security.
 *
 */
function bp_like_admin_page_verify_nonce() {
    if ( isset( $_POST['_wpnonce'] ) && isset( $_POST['bp_like_updated'] ) ) {
        $nonce = $_REQUEST['_wpnonce'];
        if ( ! wp_verify_nonce( $nonce , 'bp-like-admin' ) ) {
            wp_die( __( 'You do not have permission to do that.' ) );
        }
    }
}
add_action( 'init' , 'bp_like_admin_page_verify_nonce' );

function bp_like_admin_add_glance_item( $items = array() ) {

    $likes = BPLIKE_LIKES::get_total_likes();
    $text = _n( '%s Like', '%s Likes', $likes,  'buddypress-like' );
    $text = sprintf( $text, number_format_i18n( $likes ) );
    $items[] = '<style>#dashboard_right_now li span.bp-likes:before {
        content: "\f529";
    }</style><span class="bp-likes">' . $text . '</span>';

    return $items;
}
add_filter( 'dashboard_glance_items', 'bp_like_admin_add_glance_item', 10, 1 );

/**
 * bp_like_admin_page()
 *
 * Outputs the admin settings page.
 *
 */
function bp_like_admin_page() {
    global $current_user;

    wp_get_current_user();

    /* Update our options if the form has been submitted */
    if ( isset( $_POST['_wpnonce'] ) && isset( $_POST['bp_like_updated'] ) ) {

        /* Add each text string to the $strings_to_save array */
        $strings_to_save = array();

        foreach ( $_POST as $key => $value ) {
            if ( preg_match( "/text_string_/i" , $key ) ) {
                if ( ! empty( $value ) )
                    $strings_to_save[str_replace( 'bp_like_admin_text_string_' , '' , $key )] = stripslashes( $value );
            }
        }

        /* Now actually save the data to the options table */
        update_site_option(
            'bp_like_settings' , array(
            'post_to_activity_stream'  => isset( $_POST['bp_like_admin_post_to_activity_stream'] ) ? $_POST['bp_like_admin_post_to_activity_stream'] : null,
            'show_excerpt'             => isset( $_POST['bp_like_admin_show_excerpt'] ) ? $_POST['bp_like_admin_show_excerpt'] : null,
            'excerpt_length'           => isset( $_POST['bp_like_admin_excerpt_length'] ) ? (int) $_POST['bp_like_admin_excerpt_length'] : null,
            'text_strings'             => $strings_to_save,
            'translate_nag'            => bp_like_get_settings( 'translate_nag' ),
            'remove_fav_button'        => isset( $_POST['bp_like_remove_fav_button'] ) ? $_POST['bp_like_remove_fav_button'] : null,
            'enable_blog_post_support' => isset( $_POST['enable_blog_post_support'] ) ? $_POST['enable_blog_post_support'] : null,
            'bp_like_post_types'       => isset( $_POST['bp_like_post_types'] ) ? $_POST['bp_like_post_types'] : array(),
            'bp_like_toggle_button'    => isset( $_POST['bp_like_toggle_button'] ) ? $_POST['bp_like_toggle_button'] : null,
            'enable_notifications'     => isset( $_POST['enable_notifications'] ) ? $_POST['enable_notifications'] : null,
            )
        );

        // initialize post like count totals
        if ( isset( $_POST['enable_blog_post_support'] ) && $_POST['enable_blog_post_support'] == 1 && isset( $_POST['bp_like_post_types'] ) ) {
            $posts = get_posts(array(
                'post_type' 	 => $_POST['bp_like_post_types'],
                'posts_per_page' => -1,
                'meta_query'	 => array(
                    array(
                        'key'	   => 'bp_liked_count_total',
                        'compare'  => 'NOT EXISTS'
                    )
                )
            ));
            foreach($posts as $post){
                bp_like_init_like_count_total($post->ID, $post, false);
            }
        }

        /* Let the user know everything's cool */
        echo '<div class="updated"><p><strong>';
        _e( 'Settings saved.' , 'wordpress' );
        echo '</strong></p></div>';
    }

    $text_strings = bp_like_get_settings( 'text_strings' );
    $title = __( 'BuddyPress Like' );
    ?>
    <style type="text/css">
        table input { width: 100%; }
        table label { display: block; }
    </style>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('select.name-or-avatar').change(function() {
                var value = jQuery(this).val();
                jQuery('select.name-or-avatar').val(value);
            });
        });
    </script>

    <div class="wrap">
        <h1><?php echo esc_html( $title ); ?></h1>
        <form action="" method="post">
            <input type="hidden" name="bp_like_updated" value="updated">

            <table class="form-table" id="bp-like-admin" style="max-width:650px;float:left;">
                <tr valign="top">
                    <th scope="row"><?php _e( 'Posting Settings' , 'buddypress-like' ); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e( 'Posting Settings' , 'buddypress-like' ); ?></span>
                            </legend>
                            <input type="checkbox" id="bp_like_admin_post_to_activity_stream" name="bp_like_admin_post_to_activity_stream" value="1"<?php if ( bp_like_get_settings( 'post_to_activity_stream' ) == 1 ) echo ' checked="checked"' ?>>
                            <label for="bp_like_admin_post_activity_updates">
                                <?php _e( "Post an activity update when something is liked" , 'buddypress-like' ); ?>
                            </label>
                            <p class="description"><?php echo __( 'e.g. ' ) . $current_user->display_name . __( " liked Darren's activity. " ); ?></p>
                            <br />

                            <input type="checkbox" id="bp_like_admin_show_excerpt" name="bp_like_admin_show_excerpt" value="1"<?php if ( bp_like_get_settings( 'show_excerpt' ) == 1 ) echo ' checked="checked"' ?>>
                            <label for="bp_like_admin_show_excerpt"><?php _e( "Show a short excerpt of the activity that has been liked." , 'buddypress-like' ); ?></label>
                            <p>Limit to <input type="text" maxlength="3" style="width: 40px" value="<?php echo bp_like_get_settings( 'excerpt_length' ); ?>" name="bp_like_admin_excerpt_length" /> characters.</p>

                        </fieldset>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Remove Favorite Button' , 'buddypress-like' ); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e( 'Remove Favorite Button' , 'buddypress-like' ); ?></span>
                            </legend>
                            <input type="checkbox" id="bp_like_remove_fav_button" name="bp_like_remove_fav_button" value="1" <?php if ( bp_like_get_settings( 'remove_fav_button' ) == 1 ) { echo ' checked="checked" '; } ?>>
                            <label for="bp_like_remove_fav_button">
                                <?php _e( "Remove the BuddyPress favorite button from activity." , 'buddypress-like' ); ?>
                            </label>
                            <p class="description"><?php echo __( " Currently only uses jQuery to remove the buttons." , "buddypress-like" ); ?></p>
                            <br />
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Toggle button' , 'buddypress-like' ); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e( 'Toggle Like Button' , 'buddypress-like' ); ?></span>
                            </legend>
                            <input type="checkbox" id="bp_like_toggle_button" name="bp_like_toggle_button" value="1" <?php if ( bp_like_get_settings( 'bp_like_toggle_button' ) == 1 ) { echo ' checked="checked" '; } ?>>
                            <label for="bp_like_toggle_button">
                                <?php _e( "Toggle like/unlike button text on mouse over." , 'buddypress-like' ); ?>
                            </label>
                            <p class="description"><?php echo __( "Instead of showing the 'unlike' text when a user has liked an item, show the 'like' text and toggle to the 'unlike' text on mouse over." , "buddypress-like" ); ?></p>
                            <br />
                        </fieldset>
                    </td>
                </tr>
                 <tr valign="top">
                     <th scope="row"><?php _e( 'Blog Post Support' , 'buddypress-like' ); ?></th>
                     <td>
                         <fieldset>
                             <legend class="screen-reader-text">
                                 <span><?php _e( 'Enable Blog Post Support' , 'buddypress-like' ); ?></span>
                             </legend>
                             <input type="checkbox" id="enable_blog_post_support" name="enable_blog_post_support" value="1" <?php if ( bp_like_get_settings( 'enable_blog_post_support' ) == 1 ) { echo ' checked="checked" '; } ?>>
                             <label for="enable_blog_post_support">
                                 <?php _e( "Display the like button at the bottom of your blog posts." , 'buddypress-like' ); ?>
                             </label>
                             <br />
                         </fieldset>
                     </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Post types' , 'buddypress-like' ); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e( 'Post types to show like button' , 'buddypress-like' ); ?></span>
                            </legend>
                            <p class="description"><?php _e( "Choose Post types on which to show the like button:" , "buddypress-like" ); ?></p>
                            <?php $post_types = get_post_types(array( 'public' => true ));

                            foreach ( $post_types as $post_type ) { ?>
                                <?php $object = get_post_type_object( $post_type ); ?>
                                <label for="bp_like_post_type_<?php echo $post_type ?>">
                                    <input type="checkbox" name="bp_like_post_types[]"
                                       value="<?php echo $post_type ?>"
                                       id="bp_like_post_type_<?php echo $post_type ?>"
                                       <?php checked(true, in_array($post_type, bp_like_get_settings('bp_like_post_types'))) ?>>&nbsp
                                    <?php echo $object->labels->singular_name ?>
                                </label><br>
                            <?php } ?>
                        </fieldset>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><?php _e( 'Notifications' , 'buddypress-like' ); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e( 'Enable Notifications', 'buddypress-like' ); ?></span>
                            </legend>
                            <input type="checkbox" id="enable_notifications" name="enable_notifications" value="1" <?php if ( bp_like_get_settings( 'enable_notifications' ) == 1 ) { echo ' checked="checked" '; } ?>>
                            <label for="enable_notifications">
                                <?php _e( "Enable notifications.", 'buddypress-like' ); ?>
                            </label>
                            <br />
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top">
                  <th scope="row">
                    <p class="submit">
                      <input class="button-primary" type="submit" name="bp-like-admin-submit" id="bp-like-admin-submit" value="<?php _e( 'Save Changes' , 'wordpress' ); ?>"/>
                    </p>
                  </th>
                </tr>
            </table>

            <div id="bplike-about" style="float:right; background:#fff;max-width:300px;padding:20px;margin-bottom:30px;">
                <h3>About</h3>
                <p><strong>Version: <?php echo BP_LIKE_VERSION; ?></strong></p>
                <div class="inside">

                    <p>Gives users the ability to 'like' content across your BuddyPress enabled site.</p>

                    <p>Available for free on <a href="http://wordpress.org/plugins/buddypress-like/">WordPress.org</a>.</p>

                    <h4>Want to help?</h4>
                    <ul>
                        <li><a href="https://wordpress.org/support/view/plugin-reviews/buddypress-like?filter=5">Give 5 stars on WordPress.org</a></li>
                        <li>Development takes place publicly on <a href="https://github.com/Darrenmeehan/BuddyPress-Like">Github</a>. Is there any issues or bugs you have?</li>
                        <li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZAJLLEJDBHAWL"><strong>Donate</strong></a></li>
                    </ul>

                    <h4>Need help?</h4>
                    <ul><li>Ask on the <a href="http://wordpress.org/support/plugin/buddypress-like">WordPress.org forum</a></li></ul>

                </div>
            </div>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e( 'Custom Messages' , 'buddypress-like' ); ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e( 'Custom Messages' , 'buddypress-like' ); ?></span>
                            </legend>
                            <label for="bp_like_admin_post_activity_updates">
    <?php _e( "Change what messages are shown to users. For example, they can 'love' or 'dig' items instead of liking them." , "buddypress-like" ); ?>
                            </label>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <table class="widefat fixed" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col" id="default" class="column-name" style="width: 43%;"><?php _e( 'Default' , 'buddypress-like' ); ?></th>
                        <th scope="col" id="custom" class="column-name" style=""><?php _e( 'Custom' , 'buddypress-like' ); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="2" id="default" class="column-name"></th>
                    </tr>
                </tfoot>
                <tbody>
    <?php foreach ( bp_like_get_default_text_strings() as $key => $string ) : ?>
                    <tr valign="top">
                        <th scope="row" style="width:400px;"><label for="bp_like_admin_text_string_<?php echo $key; ?>"><?php echo htmlspecialchars( $string ); ?></label></th>
                        <td><input name="bp_like_admin_text_string_<?php echo $key; ?>" id="bp_like_admin_text_string_<?php echo $key; ?>" value="<?php echo ( isset($text_strings[$key]) ? htmlspecialchars( $text_strings[$key] ) : '' ); ?>" class="regular-text" type="text"></td>
                    </tr>
    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="submit">
                <input class="button-primary" type="submit" name="bp-like-admin-submit-bottom" id="bp-like-admin-submit-bottom" value="<?php _e( 'Save Changes' , 'wordpress' ); ?>"/>
            </p>
    <?php wp_nonce_field( 'bp-like-admin' ) ?>
        </form>
    </div>
    <?php
}
