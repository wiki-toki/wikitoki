<?php
$categories = get_the_category();
$separator = '&nbsp;';
$output = '';
$post_id = $post->ID;

$prefixact = '_act_';
$tit = get_the_title();
$place = get_post_meta( $post_id, $prefixact.'place', true );
$time = get_post_meta( $post_id, $prefixact.'time', true );
$dateinit = get_post_meta( $post_id, $prefixact.'date-init', true );
$organizer = get_post_meta( $post_id, $prefixact.'organizador', true );
$post_excerpt = get_the_excerpt();
?>

<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
<?php if (has_post_thumbnail()) :
		echo "<div class='size-thumbnail' style='margin:0 10px 10px 0;width:120px;float:left;'>";
		the_post_thumbnail( 'thumbnail' );
		echo "</div>";
	else:
		//echo '<img width="150" src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/thumbnail-default.png" />';
	endif; ?>
</a>
<h4>
	<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
</h4>
<div>
	<?php
		echo date( 'd/M/Y', $dateinit );
		echo " ". $organizer."<br>";
		echo $post_excerpt;
	?>
</div>
