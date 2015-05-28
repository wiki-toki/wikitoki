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
					<?php //Loop through Actividades
					$args = array(
						'post_type' => 'actividad', //sets posts type
						'meta_key'  => '_act_date-init',
						'orderby'  => 'meta_value_num',
						'order'     => 'DESC',
						'posts_per_page'=>	-1,
						'meta_query' => array(
							array(
                'key' => '_act_date-init',
                'value' => time(),
                'compare' => '>=', //for today or in the future
		            ),
        			),
						);
					if ( $paged > 1 ) {
					 $args['paged'] = $paged;
						}
 
					$my_query = new WP_Query($args);
					$wp_count = $my_query->post_count; //The number of posts being displayed

					if ($my_query->have_posts() ) :
					echo "<h2>".__('Next Activities','wikitoki')."</h2>";
					$count = 0;
					while ( $my_query->have_posts()) : $my_query->the_post();
					$count++;
					if ( $count == 1 || $count % 3 == 1 ) { echo "<div class='row'>"; } ?>
					
					<?php global $wp_query;
					$wp_query->in_the_loop = true;
					?>
						<div id="post-<?php the_ID(); ?>" <?php post_class('box col-md-4'); ?>>
							<?php include("loop.box.php");?>
						</div>
					<?php if ( $count % 3 == 0 || $count == $wp_count ) { echo "</div><!-- .row -->"; }?>
					<?php endwhile; else: ?>
					<p><?php //_e('Sorry, no posts matched your criteria.'); ?></p>
					<?php endif; ?>
					
					<?php echo "<h2>".__('Activities archive','wikitoki')."</h2>"; ?>
					<?php //Loop through Actividades
					$args = array(
						'post_type' => 'actividad', //sets posts type
						'meta_key'  => '_act_date-init',
						'orderby'  => 'meta_value_num',
						'order'     => 'DESC',
						'meta_query' => array(
							array(
                'key' => '_act_date-init',
                'value' => time(),
                'compare' => '<', //before today
		            ),
        			),
						);
					if ( $paged > 1 ) {
					 $args['paged'] = $paged;
						}
 
					$my_query = new WP_Query($args);
					$wp_count = $my_query->post_count; //The number of posts being displayed

					if ($my_query->have_posts() ) : 
					$count = 0;
					while ( $my_query->have_posts()) : $my_query->the_post(); 
					$count++;
					if ( $count == 1 || $count % 3 == 1 ) { echo "<div class='row'>"; } ?>
					
					<?php global $wp_query;
					$wp_query->in_the_loop = true;
					?>		
						<div id="post-<?php the_ID(); ?>" <?php post_class('box col-md-4'); ?>>
							<?php include("loop.box.php")?>
						</div>
					<?php if ( $count % 3 == 0 || $count == $wp_count ) { echo "</div><!-- .row -->"; }?>
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
	
	<div id="secondary">
			<aside id="actividades" class="widget">
					<?php 
					//Loop through Actividades
					echo '<h2 class="widget-title">'.__('Periodical activities','wikitoki').'</h2>';
					$args = array(
						'post_type' => 'actividad', //sets posts type
						'meta_key'  => '_act_permanente',
						'meta_value' => 'sí',
						'orderby'  => 'meta_value_num',
						'order'     => 'DESC',
						'posts_per_page'=>	-1,
						);
 
					$my_query = new WP_Query($args);

					if ($my_query->have_posts() ) : 
					while ( $my_query->have_posts()) : $my_query->the_post(); 
					
					global $wp_query; $wp_query->in_the_loop = true; ?>		
						<div id="post-<?php the_ID(); ?>" <?php post_class(''); ?> style="clear:left;margin:0 0 10px 0;">
							<?php include("loop.box.horizontal.php")?>
						</div>
					<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
					<?php endif; ?>
			</aside>
	</div>
<?php get_footer(); ?>
