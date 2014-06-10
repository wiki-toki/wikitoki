<?php
/*
Template Name: Users list simple
*/
get_header(); ?>


<div id="primary">
	<div id="content" class="clearfix">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php do_action( 'spacious_before_post_content' ); ?>
			<div class="entry-content clearfix">
				<?php if (have_posts()) : while (have_posts()) : the_post();?>
					<?php the_content(); ?>	
				<?php endwhile; endif;?>
				<?php
				$users_per_page = 30;
				$args = array(
					'number' => $users_per_page,
				);

				//Query users by taxonomy user-type that is Colectivo
				$tax_slug = "user-type";
				$term_slug = 'colectivo';
				$term_object = get_term_by('slug',$term_slug,$tax_slug);
				$userids = get_objects_in_term( $term_object->term_id, $tax_slug );
				$args['include'] = $userids;

				$wp_user_query = new WP_User_Query($args);

				$authors = $wp_user_query->get_results();

				foreach ( $authors as $auth ) {
					$author_ID = $auth->ID;

					$author_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $author_ID ) );
					//print_r ($author_meta);
					$author = get_userdata($author_ID); //array with all the user data
					$auth_username = $author->user_login;
					$tit = $author_meta['first_name'];
					$desc = nl2br($author_meta['description']);
					$feed = $author_meta['feed'];
					?>
					<div >
						<div style="float:left;margin:10px"><?php echo get_wp_user_avatar($author_ID, 80); ?></div>
						<h2><a href="<?php echo get_author_posts_url( $author_ID); ?>"><?php echo $author->nickname; ?></a></h2>
						<div style="margin-left:100px;">
							<p>
							Web: <a href="<?php echo $author->user_url; ?>"><?php echo $author->user_url; ?></a><br>
							<?php echo $desc. "\n";?>
							</p>
						</div>
						<hr>
					</div>

				<?php
				}
				?>
			</div>
		</article>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
