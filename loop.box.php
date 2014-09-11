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
$dateinit_format = strtotime($dateinit);
$organizer = get_post_meta( $post_id, $prefixact.'organizador', true );
?>

<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
<?php if (has_post_thumbnail()) :
		echo "<div class='size-thumbnail' style='margin:0 0 10px 0;'>";
		the_post_thumbnail( 'thumbnail', array('class' => 'img-responsive') );
		echo "</div>";
	else:
		//echo '<img width="150" src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/thumbnail-default.png" />';
	endif; ?>
</a>
<h4>
	<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
</h4>
<div>
	<span class="label "><?php echo get_the_term_list( $post->ID, 'tipo-actividad', ' ', ', ', '' ); ?></span><br>
	<?php
		echo "Qu&eacute;: ".$tit."<br>";
		if ( $time != '' ) echo "Hora: ".$time."<br>";
		echo "Cu&aacute;ndo: ".date( 'd/M/Y', $dateinit_format );
		echo "<br>Lugar: ". $place;
		if (!empty($dateend)) {echo "<br>Fecha cierre: ". $dateend;}
		echo "<br>Organiza: ". $organizer."<br><br>";
	?>
</div>
		<?php
			if($categories){
				foreach($categories as $category) {
					$output .= '<a href="'.get_category_link( $category->term_id ).'"title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" ><span class="label">'.$category->cat_name.'</span></a> '; //removed the ".$separator"
				}
			echo trim($output, $separator);
			}	
		?>
