<?php 
/**
 * Theme Index Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
?>

<?php get_header(); ?>

	<?php do_action( 'spacious_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<?php
			$args = array(
				'post_type' => array( 'post', 'actividad' )
				);
			$my_query = new WP_Query($args);
			?>			
			<?php if ( $my_query->have_posts() ) : ?>

				<?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>

					<?php
					if ( get_post_type() == 'actividad') {
						get_template_part( 'content', get_post_type() ); 
					} else {
						get_template_part( 'content', get_post_format() ); 
					}
						?>

				<?php endwhile; ?>

				<?php get_template_part( 'navigation', 'none' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'none' ); ?>
				
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	
	<?php spacious_sidebar_select(); ?>
	
	<?php do_action( 'spacious_after_body_content' ); ?>

<?php get_footer(); ?>



