<?php // DO NOT DELETE THE NEXT FEW LINES

if ( post_password_required() ) 
{
	echo '<p class="nopassword">This post is password protected. Enter the password to view any comments.</p>';
	return;
}

global $wp;
?>

<!-- You can start editing here. -->
<div id="commentblock">
	<?php if ( have_comments() ) : ?>
	   <?php if( !comments_open() && !array_key_exists("cpage", $wp->query_vars) ) { ?>
			<p>Comments are now closed.&nbsp; Feel free to <a href="&#x6d;&#97;&#105;&#108;&#x74;&#111;:&#99;&#x70;o&#105;&#x72;&#x69;e&#x72;&#64;&#103;&#x6d;&#x61;&#x69;&#x6c;&#x2e;&#99;&#111;&#x6d;&amp;subject=<?php echo urlencode(get_the_title())?>">email me</a>, if you have something to say!&nbsp; 
			<a href="<?php the_permalink()?>comment-page-1/#commentlist">View past comments &raquo;</a></p>
		<?php } else if ( !array_key_exists("cpage", $wp->query_vars) ) { ?>
			<p><?php comments_number('No comments yet', '1 comment', '% comments' );?>.&nbsp;
			<a href="<?php the_permalink()?>comment-page-1/#commentlist">View comments or leave your own &raquo;</a>
			</p>			
		<?php } else { ?>

		<p id="comments"><?php comments_number('No comments', '1 comment', '% comments' );?> to <em><?php the_title(); ?></em></p>

		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>

		<div id="commentlist">
			<a name="commentlist"></a>
			<ul>
			<?php wp_list_comments('max_depth=5&avatar_size=50'); ?>
			</ul>
		</div>

		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>

		<?php } ?>
		
	<?php elseif( !array_key_exists("cpage", $wp->query_vars) ) : // this is displayed if there are no comments so far ?>
		<?php if ('open' == $post->comment_status) : // if comments are open, but there are none ?>
			<p>No comments yet.  <a href="<?php the_permalink()?>comment-page-1/#respond">You could be the first! &raquo;</a></p>			
		<?php else : // comments are closed ?>
			<p><?php _e('<em>Responses are closed for this post.</em>'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ('open' == $post->comment_status && array_key_exists("cpage", $wp->query_vars)) : ?>
		<div id="respond">
			<a name="respond"></a>
			<h3><?php comment_form_title( 'Leave a comment', 'Leave a response to %s' ); ?></h3>

			<div class="cancel-comment-reply">
				<small><?php cancel_comment_reply_link(); ?></small>
			</div>

			<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
				<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
			<?php else : ?>
				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
					<?php if ( $user_ID ) : ?>
						<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
					<?php else : ?>
						<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /><label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small></label></p>
						<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /><label for="email"><small>Mail (will not be published) <?php if ($req) echo "(required)"; ?></small></label></p>
						<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /><label for="url"><small>Website</small></label></p>
					<?php endif; ?>

					<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->

					<p><textarea name="comment" id="comment" cols="60%" rows="10" tabindex="4"></textarea></p>
					<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Response" /><?php comment_id_fields(); ?></p>
					<?php do_action('comment_form', $post->ID); ?>
				</form>

			<?php endif; // If registration required and not logged in ?>
		</div>

	<?php endif; // if you delete this the sky will fall on your head ?>

</div> <!-- end commentblock-->

