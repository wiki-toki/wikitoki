<?php get_header(); ?>

<?php do_action( 'spacious_before_body_content' ); ?>
	
	<div id="primary">
		<div id="content" class="clearfix">
			<!-- This sets the $curauth variable -->

			<?php
			$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
			$author_ID = $curauth->ID;
			$user_login = $curauth->user_login;
			$author_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $author_ID ) );
			//print_r ($author_meta);
			$tit = $author_meta['first_name'];
			$desc = nl2br($author_meta['description']);
			$desc_eu = nl2br($author_meta['description_eu']);
			$desc_en = nl2br($author_meta['description_en']);
			$feed = $author_meta['feed'];
			$twitter = $author_meta['twitter'];
			$facebook = $author_meta['facebook'];
			?>
			<?php //Makes description available in every language
			if (function_exists('pll_current_language')) { //Checks if function to check language exists
					$current_lang = pll_current_language(); //gets current language
					if ( $current_lang == "eu" ) { //uses the appropriate description
						$desc = ($desc_eu != "") ? $desc_eu  : $desc; //if it is not translated it is displayed in Spanish
					} else if ( $current_lang == "en"  || $desc_en != "" ) {
						$desc = ($desc_eu != "") ? $desc_eu  : $desc;
					} else { //in Spanish
					}
			} else {
					echo "IMAP functions are not available.<br />\n";
			}
			?>
			<?php echo get_wp_user_avatar($author_ID, 150); ?>
			<h2><?php echo $curauth->nickname; ?></h2>
			<dl>
					<dt>Website</dt>
					<dd><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></dd>
					<dt>Feed</dt>
					<dd><a href="<?php echo $feed; ?>"><?php echo $feed; ?></a></dd>
					<dt>Twitter</dt>
					<dd><a href="<?php echo $twitter; ?>">@<?php echo $twitter; ?></a></dd>
					<dt>Facebook</dt>
					<dd><a href="<?php echo $facebook; ?>"><?php echo $facebook; ?></a></dd>
					<dt>Profile</dt>
					<dd><?php echo $desc; ?></dd>
			</dl>

			<h2>Posts de <?php echo $curauth->nickname; ?> en Wikitoki.org:</h2>

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
			
			<?php
			//Displays groups where the user belongs
			//gets the terms in the user-group taxonomy
			//Only displays information if user belongs to a group
			$user_groups = wp_get_object_terms($author_ID, 'user-group');
			if(!empty($user_groups) && !is_wp_error( $user_groups )){
					
					echo "<h2>Grupos a los que pertenece</h2>";
					echo '<ul>';
					foreach($user_groups as $user_group){
						$usergroup_slug = strtolower (str_replace(" ","-",$user_group->name));
						echo '<li><a href="/author/'.$usergroup_slug.'">'.$user_group->name.'</a></li>'; //TODO it would be better to dynamically generate the link (not hardcode ur)
					}
					echo '</ul>';
			}
			?>


			<h2><?php
			//Lists posts in feed from users website
			_e( 'Posts de', 'wikitoki' ); ?> <?php echo $curauth->nickname; ?> <?php _e( 'en su blog', 'wikitoki' ); ?>.</h2>
			 
			<?php // Get RSS Feed(s)
			// code from http://www.wpbeginner.com/wp-tutorials/how-to-display-any-rss-feed-on-your-wordpress-blog/
			include_once( ABSPATH . WPINC . '/feed.php' );
			 
			// Get a SimplePie feed object from the specified feed source.
			$rss = fetch_feed( $feed );
			 
			if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
			 
					// Figure out how many total items there are, but limit it to 5. 
					$maxitems = $rss->get_item_quantity( 5 ); 
			 
					// Build an array of all the items, starting with element 0 (first element).
					$rss_items = $rss->get_items( 0, $maxitems );
			 
			endif;
			?>
			 
			<ul>
					<?php if ( $maxitems == 0 ) : ?>
						  <li><?php _e( 'No items', 'my-text-domain' ); ?></li>
					<?php else : ?>
						  <?php // Loop through each feed item and display each item as a hyperlink. ?>
						  <?php foreach ( $rss_items as $item ) : ?>
						      <li>
						          <a href="<?php echo esc_url( $item->get_permalink() ); ?>"
						              title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>">
						              <?php echo esc_html( $item->get_title() ); ?>
						          </a>
						      </li>
						  <?php endforeach; ?>
					<?php endif; ?>
			</ul>

			<?php
			//Lists all the users that have the slug of this user we are displaying now as taxonomy user-group
			$args = '';
			$tax_slug = "user-group";
			$term_slug = $user_login; //uses the user_login of the user as term of the taxonomy
			$term_object = get_term_by('slug',$term_slug,$tax_slug);
			
			if(!empty($term_object)){ //checks if there is no term for that taxonomy
				$userids = get_objects_in_term( $term_object->term_id, $tax_slug );
				$args['include'] = $userids;
				$wp_user_query = new WP_User_Query($args);
				$authors = $wp_user_query->get_results();
				
				if(!empty($authors) && !is_wp_error( $authors)){
					echo "<h2>Personas que pertenecen a este grupo</h2>";
					foreach ( $authors as $auth ) {
						$author_ID = $auth->ID;
						$author_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $author_ID ) );
						$author = get_userdata($author_ID); //array with all the user data
						$auth_username = $author->user_nicename;
						?>
						<div>
							<div style="float:left;margin:10px"><?php echo get_wp_user_avatar($author_ID, 40); ?></div>
							<h4><a href="<?php echo get_author_posts_url( $author_ID); ?>"><?php echo $auth_username ?></a></h4>
						</div>
						<hr>
					<?php
					}
				}
			}
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
	
	<?php spacious_sidebar_select(); ?>
	
	<?php do_action( 'spacious_after_body_content' ); ?>

<?php get_footer(); ?>
