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
			$feed = $author_meta['feed'];
			$twitter = $author_meta['twitter'];
			$facebook = $author_meta['facebook'];
			?>
			<?php echo get_wp_user_avatar($author_ID, 150); ?>
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
