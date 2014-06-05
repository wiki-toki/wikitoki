<?php /* Template Name: Actividades */ ?>

<?php get_header(); ?>

	<?php do_action( 'spacious_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php // get_template_part( 'content', 'page' ); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php do_action( 'spacious_before_post_content' ); ?>
					<div class="entry-content clearfix">
						<?php the_content(); ?>
						<?php
							wp_link_pages( array( 
							'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'spacious' ),
							'after'             => '</div>',
							'link_before'       => '<span>',
							'link_after'        => '</span>'
							) );
						?>
					</div>
					<footer class="entry-meta-bar clearfix">	        			
						<div class="entry-meta clearfix">
							 	<?php edit_post_link( __( 'Edit', 'spacious' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					</footer>
					<?php
					do_action( 'spacious_after_post_content' );
					 ?>
					<?php //Loop though Actividades
					$args = array(
					 'post_type' => 'actividad', //sets posts type
						);
					if ( $paged > 1 ) {
					 $args['paged'] = $paged;
						}
 
					$my_query = new WP_Query($args);

					if ($my_query->have_posts() ) : 
					$count = 0;
					while ( $my_query->have_posts()) : $my_query->the_post(); 
					$count++;
					if ( $count == 1 ) { echo "<div class='row'>"; } ?>
					
					<?php global $wp_query;
					$wp_query->in_the_loop = true;
					?>		
						<div id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>	>
							<?php include("loop.box.php")?>
						</div>
					<?php if ( $count == 3 ) { echo "</div><!-- .row --><hr>"; $count = 0; }?>
					<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
					<?php endif; ?>
				</article>

				<?php /*
					do_action( 'spacious_before_comments_template' );
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();					
	      		do_action ( 'spacious_after_comments_template' ); */
				?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	
	<?php spacious_sidebar_select(); ?>

	<?php do_action( 'spacious_after_body_content' ); ?>

<?php get_footer(); ?>
