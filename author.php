<?php get_header(); ?>

<?php do_action( 'spacious_before_body_content' ); ?>
	
	<div id="primary">
		<div id="content" class="clearfix">
			<!-- This sets the $curauth variable -->

			<?php
			$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
			$author_ID = $curauth->ID;
			$author_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $author_ID ) );
			//print_r ($author_meta);
			$tit = $author_meta['first_name'];
			$desc = nl2br($author_meta['description']);
			$feed = $author_meta['feed'];
			$twitter = $author_meta['twitter'];
			$facebook = $author_meta['facebook'];
			?>

			<h2>Sobre: <?php echo $curauth->nickname; ?></h2>
			<dl>
					<dt>Website</dt>
					<dd><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></dd>
					<dt>Feed</dt>
					<dd><?php echo $feed; ?></dd>
					<dt>Twitter</dt>
					<dd><?php echo $twitter; ?></dd>
					<dt>Facebook</dt>
					<dd><?php echo $facebook; ?></dd>
					<dt>Profile</dt>
					<dd><?php echo $desc; ?></dd>
			</dl>

			<h2>Posts de <?php echo $curauth->nickname; ?>:</h2>

			<ul>
			<!-- The Loop -->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<li>
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
						<?php the_title(); ?></a>,
						<?php the_time('d M Y'); ?> in <?php the_category('&');?>
				</li>
			<?php endwhile; else: ?>
					<p><?php _e('No posts by this author.'); ?></p>
			<?php endif; ?>
			<!-- End Loop -->
			</ul>

		</div><!-- #content -->
	</div><!-- #primary -->
	
	<?php spacious_sidebar_select(); ?>
	
	<?php do_action( 'spacious_after_body_content' ); ?>

<?php get_footer(); ?>
