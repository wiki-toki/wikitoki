<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
$post_id = $post->ID;
$prefixact = '_act_';
$tit = get_the_title();
$place = get_post_meta( $post_id, $prefixact.'place', true );
$time = get_post_meta( $post_id, $prefixact.'time', true );
$dateinit = get_post_meta( $post_id, $prefixact.'date-init', true );
$dateinit_format = strtotime($dateinit);
$dateend = get_post_meta( $post_id, $prefixact.'date-end', true );
$dateend_format = strtotime($dateend);
$organizer = get_post_meta( $post_id, $prefixact.'organizador', true );
$numero_asistentes = get_post_meta( $post_id, $prefixact.'numero-asistentes', true );
$relacion_barrio = get_post_meta( $post_id, $prefixact.'relacion-barrio', true );
$relacion_ayuntamiento = get_post_meta( $post_id, $prefixact.'relacion-ayuntamiento', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'spacious_before_post_content' ); ?>
	<div class="entry-content clearfix">
		<div>
			<?php
				echo "<p><strong>Datos de la actividad</strong><br>";
				if ( $tit!= '' ) echo "Qu&eacute;: ".$tit."<br>";
				if ( $place != '' ) echo "Lugar: ". $place."<br>";
				if ( $time != '' ) echo "Hora: ".$time."<br>";
				if ( $dateinit != '' ) echo "Cu&aacute;ndo: ".date( 'd/M/Y', $dateinit_format )."<br>";
				if ($dateend!= '') echo "Fecha cierre: ".date( 'd/M/Y', $dateend_format )."<br>";
				echo "Tipo: ". get_the_term_list( $post->ID, 'tipo-actividad', ' ', ', ', '' )."<br>";
				echo "Organiza: ". $organizer."<br>";
				if ( $numero_asistentes != '' ) echo "N&uacute;mero de asistentes: ".$numero_asistentes."<br>";
				echo "</p>";
			?>
		</div>
		<?php
			the_content();
			
			echo '<h3>Informaci&oacute;n extendida</h3>';
			$entries = get_post_meta( get_the_ID(), $prefixact . 'mas_info_url', true );
			foreach ( (array) $entries as $key => $entry ) {
					$url_text = $url_text = '';
					if ( isset( $entry['url_text'] ) )
						  $url_text = $entry['url_text'];
					if ( isset( $entry['url'] ) )
						  $url = $entry['url'];
					echo '<a href="' .$url. '">' .$url_text. '</a><br>'; 
			}
			
			if ( $relacion_barrio != '' ) echo "<h4>Relaci&oacute;n con el barrio</h4>".$relacion_barrio;
			if ( $relacion_ayuntamiento != '' ) echo "<h4>Relaci&oacute;n las actividades ha tenido con temas promovidos por el Ayuntamiento</h4>".$relacion_ayuntamiento;
			

			$spacious_tag_list = get_the_tag_list( '', '&nbsp;&nbsp;&nbsp;&nbsp;', '' );
			if( !empty( $spacious_tag_list ) ) {
				?>
				<div class="tags">
					<?php
					_e( 'Tagged on: ', 'spacious' ); echo $spacious_tag_list;
					?>
				</div>
				<?php
			}

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
			<span class="by-author author vcard"><a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
			<span class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></span>
			<?php if( has_category() ) { ?>
       		<span class="category"><?php the_category(', '); ?></span>
       	<?php } ?>
				<?php if ( comments_open() ) { ?>
       		<span class="comments"><?php comments_popup_link( __( 'No Comments', 'spacious' ), __( '1 Comment', 'spacious' ), __( '% Comments', 'spacious' ), '', __( 'Comments Off', 'spacious' ) ); ?></span>
       	<?php } ?>
       	<?php edit_post_link( __( 'Edit', 'spacious' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	</footer>
	<?php
	do_action( 'spacious_after_post_content' );
   ?>
</article>
