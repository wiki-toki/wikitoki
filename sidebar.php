<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
?>

<div id="secondary">
			<aside id="actividades" class="widget">
				<?php
					do_action( 'spacious_after_post_content' );
					 ?>
					<?php 
					if (is_home()){
					//Loop through Actividades
					echo '<h3 class="widget-title"><span>Actividades</span></h3>';
					$args = array(
						'post_type' => 'actividad', //sets posts type
						'meta_key'  => '_act_date-init',
						'orderby'  => 'meta_value_num',
						'order'     => 'DESC',
						'posts_per_page'=>	3,
						'meta_query' => array(
							array(
								'key' => '_act_date-init',
								'value' => time(),
								'compare' => '>=', //for today or in the future
								),
							),
						);
 
					$my_query = new WP_Query($args);

					if ($my_query->have_posts() ) : 
					while ( $my_query->have_posts()) : $my_query->the_post(); 
					
					global $wp_query; $wp_query->in_the_loop = true; ?>		
						<div id="post-<?php the_ID(); ?>" <?php post_class(''); ?> style="clear:left;margin:0 0 10px 0;">
							<?php include("loop.box.horizontal.php")?>
						</div>
					<?php endwhile; else: ?>
					<p><?php //_e('Sorry, no posts matched your criteria.'); ?></p>
					<?php endif; ?>
					<?php echo '<p><a href="actividades">Ver m&aacute;s actividades</a></h3></p>'; ?>
					<?php } ?>
			</aside>
	<?php do_action( 'spacious_before_sidebar' ); ?>
		<?php 
			if( is_page_template( 'page-templates/contact.php' ) ) {
				$sidebar = 'spacious_contact_page_sidebar';
			}
			else {
				$sidebar = 'spacious_right_sidebar';
			}
		?>

		<?php if ( ! dynamic_sidebar( $sidebar ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h1 class="widget-title"><?php _e( 'Archives', 'spacious' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h1 class="widget-title"><?php _e( 'Meta', 'spacious' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; ?>
	<?php do_action( 'spacious_after_sidebar' ); ?>
</div>
