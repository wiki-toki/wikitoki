<?php
/*
Template Name: Users list simple
*/
get_header(); ?>

<?php
$users_per_page = 30;
$args = array(
	'number' => $users_per_page,
);

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
	
	<h2><a href="<?php echo get_author_posts_url( $author_ID); ?>"><?php echo $auth_username ?></a></h2>
	<p>
		Web: <a href="<?php echo $author->user_url; ?>"><?php echo $author->user_url; ?></a><br>
		<?php echo $desc. "\n";?>
	</p>
<?php
}
?>
<?php get_footer(); ?>
