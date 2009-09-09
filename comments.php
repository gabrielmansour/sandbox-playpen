<?php
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
  	die ('Please do not load this page directly. Thanks!');
?>
			<div id="comments">
<?php
if ( post_password_required() ) : ?>
			<div class="nopassword"><?php _e( 'This post is protected. Enter the password to view any comments.', 'sandbox' ) ?></div>
		</div><!-- .comments -->
<?php
	return;
endif;
?>
<?php if ( have_comments() ) : ?>
<?php global $sandbox_comment_alt ?>

<?php // Number of pings and comments
foreach ( array('comment'=>0,'pings'=>0) as $type => $null)
  $number_of_[$type] = count($GLOBALS["wp_query"]->comments_by_type[$type]);

?>
<?php if ( $number_of_['comment'] ) : ?>
<?php $sandbox_comment_alt = 0 ?>

    <div id="comments-list" class="comments">
    	<h3><?php printf($number_of_['comment'] > 1 ? __('<span>%d</span> Comments', 'sandbox') : __('<span>One</span> Comment', 'sandbox'), $number_of_['comment']) ?></h3>

    	<ol>
        <?php wp_list_comments('type=comment') ?>
    	</ol>
    </div><!-- #comments-list .comments -->

<?php endif; // REFERENCE: if ( $number_of_['comments'] ) ?>
<?php if ( $number_of_['pings'] ) : ?>
<?php $sandbox_comment_alt = 0 ?>

				<div id="trackbacks-list" class="comments">
					<h3><?php printf($number_of_['pings'] > 1 ? __('<span>%d</span> Trackbacks', 'sandbox') : __('<span>One</span> Trackback', 'sandbox'), $number_of_['pings']) ?></h3>

					<ol>
          	<?php wp_list_comments('type=pings') ?>
					</ol>
				</div><!-- #trackbacks-list .comments -->

<?php endif // REFERENCE: if ( $number_of_['pings'] ) ?>
<?php endif // REFERENCE: if ( have_comments() ) ?>
<?php if ( comments_open() ) : ?>
<?php $req = get_option('require_name_email'); // Checks if fields are required. Thanks, Adam. ;-) ?>

      <div id="respond">
      	<h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>
	
      	<div class="cancel-comment-reply">
        	<?php cancel_comment_reply_link(); ?>
        </div>


<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
					<p id="login-req"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'sandbox'),
					wp_login_url(get_permalink()) ) ?></p>

<?php else : ?>
					<div class="formcontainer">	
						<form id="commentform" action="<?php bloginfo('wpurl') ?>/wp-comments-post.php" method="post">

<?php if ( is_user_logged_in() ) : ?>
							<p id="login"><?php printf( __( '<span class="loggedin">Logged in as <a href="%1$s" title="Logged in as %2$s">%3$s</a>.</span> <span class="logout"><a href="%4$s" title="Log out of this account">Log out?</a></span>', 'sandbox' ),
								get_bloginfo('wpurl') . '/wp-admin/profile.php',
								esc_attr( $user_identity ),
								esc_html( $user_identity ),
								wp_logout_url(get_permalink()) ) ?></p>

<?php else : ?>

							<p id="comment-notes"><?php _e( 'Your email is <em>never</em> shared.', 'sandbox' ) ?> <?php if ($req) _e( 'Required fields are marked <span class="required">*</span>', 'sandbox' ) ?></p>

							<div class="form-label"><label for="author"><?php _e( 'Name', 'sandbox' ) ?></label> <?php if ($req) _e( '<span class="required">*</span>', 'sandbox' ) ?></div>
							<div class="form-input"><input id="author" name="author" class="text<?php if ($req) echo ' required" aria-required="true' ?>" type="text" value="<?php echo esc_attr($comment_author) ?>" size="30" maxlength="50" tabindex="3" /></div>

							<div class="form-label"><label for="email"><?php _e( 'Email', 'sandbox' ) ?></label> <?php if ($req) _e( '<span class="required">*</span>', 'sandbox' ) ?></div>
							<div class="form-input"><input id="email" name="email" class="text<?php if ($req) echo ' required" aria-required="true'; ?>" type="text" value="<?php echo esc_attr($comment_author_email) ?>" size="30" maxlength="50" tabindex="4" /></div>

							<div class="form-label"><label for="url"><?php _e( 'Website', 'sandbox' ) ?></label></div>
							<div class="form-input"><input id="url" name="url" class="text" type="text" value="<?php echo esc_attr($comment_author_url) ?>" size="30" maxlength="50" tabindex="5" /></div>

<?php endif // REFERENCE: * if ( is_user_logged_in() ) ?>

							<div class="form-label"><label for="comment"><?php _e( 'Comment', 'sandbox' ) ?></label></div>
							<div class="form-textarea"><textarea id="comment" name="comment" class="text required" cols="45" rows="8" tabindex="6"></textarea></div>

							<div class="form-submit"><input id="submit" name="submit" class="button" type="submit" value="<?php _e( 'Post Comment', 'sandbox' ) ?>" tabindex="7" />
							  <?php comment_id_fields(); ?>
							</div>

							<div class="form-option"><?php do_action( 'comment_form', $post->ID ) ?></div>

						</form><!-- #commentform -->
					</div><!-- .formcontainer -->
<?php endif // REFERENCE: if ( get_option('comment_registration') && !is_user_logged_in() ) ?>

				</div><!-- #respond -->
<?php endif // REFERENCE: if ( comments_open() ) ?>

			</div><!-- #comments -->
