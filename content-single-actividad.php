<?php
//Sets the variables
$post_id = $post->ID;
$prefixact = '_act_';
$tit = get_the_title();
$place = get_post_meta( $post_id, $prefixact.'place', true );
$time = get_post_meta( $post_id, $prefixact.'time', true );
$dateinit = get_post_meta( $post_id, $prefixact.'date-init', true );
$dateend = get_post_meta( $post_id, $prefixact.'date-end', true );
$organizer = get_post_meta( $post_id, $prefixact.'organizador', true );
$numero_asistentes = get_post_meta( $post_id, $prefixact.'numero-asistentes', true );
$relacion_barrio = get_post_meta( $post_id, $prefixact.'relacion-barrio', true );
$relacion_ayuntamiento = get_post_meta( $post_id, $prefixact.'relacion-ayuntamiento', true );
$activity_summary = get_post_meta( $post_id, $prefixact.'resumen-actividad', true );
$entries = get_post_meta( get_the_ID(), $prefixact . 'mas_info_url', true );
$the_content = get_the_content();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'spacious_before_post_content' ); ?>
	<div class="entry-content clearfix">
		<div>
			<?php
				echo "<p><strong>".__('Activity data','wikitoki')."</strong><br>";
				if ( $tit!= '' ) echo __('What','wikitoki').": ".$tit."<br>";
				if ( $place != '' ) echo __('Place','wikitoki').": ". $place."<br>";
				if ( $time != '' ) echo __('Hour','wikitoki').": ".$time."<br>";
				if ( $dateinit != '' ) echo __('Start date','wikitoki').": ".date( 'd/M/Y', $dateinit )."<br>";
				if ( $dateend!= '') echo __('End date','wikitoki').": ".date( 'd/M/Y', $dateend )."<br>";
				echo __('Type','wikitoki').": ". get_the_term_list( $post->ID, 'tipo-actividad', ' ', ', ', '' )."<br>";
				echo __('Organized by','wikitoki').": ". $organizer."<br>";
				if ( $numero_asistentes != '' ) echo __('Number of people','wikitoki').": ".$numero_asistentes."<br>";
				echo "</p>";
			?>
		</div>
		<?php
			//Displays content
			if (empty($activity_summary)) { // if activity summary is empty, display only content (announcement)
				the_content();
			} else { // if activity summary is written, display it first!
				echo "<h2>".__('Resumen de la actividad','wikitoki')."</h2>";
				echo wikitoki_get_wysiwyg_output( $prefixact.'resumen-actividad', $post_id );
				echo "<h2>".__('Activity announcement','wikitoki')."</h2>";
				the_content();
			}
			
			//Extended information
			if ( !empty($relacion_barrio) || !empty($relacion_ayuntamiento) || !empty($entries) )
				echo "<h2>".__('Extended information','wikitoki')."</h2>";
			
			if ( !empty($entries) ) {
				echo "<h3>".__('Links with related information','wikitoki')."</h3>";
				foreach ( $entries as $key => $entry ) {
						$url_text = $url = '';
						if ( isset( $entry['url_text'] ) )
								$url_text = $entry['url_text'];
						if ( isset( $entry['url'] ) )
								$url = $entry['url'];
						echo "<a href='". $url ."'>". $url_text ."</a><br>";
				}
			}
			
			if ( $relacion_barrio != '' ) echo "<h3>".__('Relationship with the neighborhood','wikitoki')."</h3>".$relacion_barrio;
			if ( $relacion_ayuntamiento != '' ) echo "<h3>".__('Relation with topics promoted by the Municipality','wikitoki')."</h3>".$relacion_ayuntamiento;
			if ( $relacion_barrio != '' || $relacion_ayuntamiento != '' || $entries != '') echo "<hr>";

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

	<footer class="entry-meta-bar clearfix" style="margin-bottom: 20px;">
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
