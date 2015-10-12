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
					$desc_eu = nl2br($author_meta['description_eu']);
					$desc_en = nl2br($author_meta['description_en']);
					$feed = $author_meta['feed'];
					$website = $author->user_url;
					$remove_this = array("http://","https://","www.");
					$website_stripped = str_replace($remove_this, "", $website); //removes "http://","https://","www." from website display
					
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
					<div >
						<div style="float:left;margin:10px"><?php echo get_wp_user_avatar($author_ID, 80); ?></div>
						<h2><a href="<?php echo get_author_posts_url( $author_ID); ?>"><?php echo $author->nickname; ?></a></h2>
						<div style="margin-left:100px;">
							<p>
							Web: <a href="<?php echo $website; ?>"><?php echo $website_stripped; ?></a><br>
							<?php echo $desc. "\n"; ?>
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
