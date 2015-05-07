<?php /* Template Name: Orbita */ ?>

<?php get_header(); ?>

	<?php do_action( 'spacious_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h2 id="arch-urbanism"><?php _e( 'Architecture and Urbanism', 'my-text-domain' ); ?></h2>
					<?php // Get RSS Feed(s)
					include_once( ABSPATH . WPINC . '/feed.php' );
					$number_posts = 6;

					// Get a SimplePie feed object from the specified feed source.
					$rss = fetch_feed( 'http://www.rssmix.com/u/8134253/rss.xml' );
					$maxitems = 0;
					if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
						// Figure out how many total items there are, but limit it to 5. 
						$maxitems = $rss->get_item_quantity( $number_posts ); 

						// Build an array of all the items, starting with element 0 (first element).
						$rss_items = $rss->get_items( 0, $maxitems );
					endif; ?>
					
					<ul>
						<?php if ( $maxitems == 0 ) : ?>
							<li><?php _e( 'No items', 'my-text-domain' ); ?></li>
						<?php else : ?>
							<?php // Loop through each feed item and display each item as a hyperlink. ?>
							<?php foreach ( $rss_items as $item ) : ?>
							  <li>
						      <a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>">
						          <?php echo esc_html( $item->get_title() ); ?>
						      </a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
					
					<h2 id="sust"><?php _e( 'Sustainability', 'my-text-domain' ); ?></h2>
					<?php // Get RSS Feed(s)
					include_once( ABSPATH . WPINC . '/feed.php' );

					// Get a SimplePie feed object from the specified feed source.
					$rss = fetch_feed( 'http://www.rssmix.com/u/8134255/rss.xml' );
					$maxitems = 0;
					if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
						// Figure out how many total items there are, but limit it to 5. 
						$maxitems = $rss->get_item_quantity( $number_posts ); 

						// Build an array of all the items, starting with element 0 (first element).
						$rss_items = $rss->get_items( 0, $maxitems );
					endif; ?>
					
					<ul>
						<?php if ( $maxitems == 0 ) : ?>
							<li><?php _e( 'No items', 'my-text-domain' ); ?></li>
						<?php else : ?>
							<?php // Loop through each feed item and display each item as a hyperlink. ?>
							<?php foreach ( $rss_items as $item ) : ?>
							  <li>
						      <a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>">
						          <?php echo esc_html( $item->get_title() ); ?>
						      </a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>

				<h2 id="art"><?php _e( 'Art and culture', 'my-text-domain' ); ?></h2>
					<?php // Get RSS Feed(s)
					include_once( ABSPATH . WPINC . '/feed.php' );

					// Get a SimplePie feed object from the specified feed source.
					$rss = fetch_feed( 'http://www.rssmix.com/u/8134256/rss.xml' );
					$maxitems = 0;
					if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
						// Figure out how many total items there are, but limit it to 5. 
						$maxitems = $rss->get_item_quantity( $number_posts ); 

						// Build an array of all the items, starting with element 0 (first element).
						$rss_items = $rss->get_items( 0, $maxitems );
					endif; ?>
					
					<ul>
						<?php if ( $maxitems == 0 ) : ?>
							<li><?php _e( 'No items', 'my-text-domain' ); ?></li>
						<?php else : ?>
							<?php // Loop through each feed item and display each item as a hyperlink. ?>
							<?php foreach ( $rss_items as $item ) : ?>
							  <li>
						      <a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>">
						          <?php echo esc_html( $item->get_title() ); ?>
						      </a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>

				<h2 id="collab"><?php _e( 'Colaboratorio', 'my-text-domain' ); ?></h2>
					<?php // Get RSS Feed(s)
					include_once( ABSPATH . WPINC . '/feed.php' );

					// Get a SimplePie feed object from the specified feed source.
					$rss = fetch_feed( 'http://www.rssmix.com/u/8134259/rss.xml' );
					$maxitems = 0;
					if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
						// Figure out how many total items there are, but limit it to 5. 
						$maxitems = $rss->get_item_quantity( $number_posts ); 

						// Build an array of all the items, starting with element 0 (first element).
						$rss_items = $rss->get_items( 0, $maxitems );
					endif; ?>
					
					<ul>
						<?php if ( $maxitems == 0 ) : ?>
							<li><?php _e( 'No items', 'my-text-domain' ); ?></li>
						<?php else : ?>
							<?php // Loop through each feed item and display each item as a hyperlink. ?>
							<?php foreach ( $rss_items as $item ) : ?>
							  <li>
						      <a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>">
						          <?php echo esc_html( $item->get_title() ); ?>
						      </a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</article>	
		</div><!-- #content -->
	</div><!-- #primary -->
	
<?php get_footer(); ?>
