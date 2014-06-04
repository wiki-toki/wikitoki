<?php 
// extra fields in user profile
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

	function extra_user_profile_fields( $user ) {
 		$extra_fields = array(
			array(
				'name' => 'Contacto',
				'label' => 'contacto'
			),
		);
		$extra_textareas = array(
			array(
				'name' => 'Otra info',
				'label' => 'info',
			),
		);
	?>

		<h3><?php _e("Informacion", "blank"); ?></h3>
		<table class="form-table">

	<?php foreach ( $extra_textareas as $extra_field ) { ?>	
		<tr>
		<th><label for="<?php echo $extra_field['label']; ?>"><?php echo $extra_field['name']; ?></label></th>
		<td>
			<textarea name="<?php echo $extra_field['label']; ?>" id="<?php echo $extra_field['label']; ?>" rows="5" cols="30"><?php echo esc_attr( get_the_author_meta( $extra_field['label'], $user->ID ) ); ?></textarea><br />
		</td>
		</tr>

	<?php } ?>

		</table>

		<h3><?php _e("Contacto", "blank"); ?></h3>
		<table class="form-table">

	<?php foreach ( $extra_fields as $extra_field ) { ?>	
		<tr>
		<th><label for="<?php echo $extra_field['label']; ?>"><?php echo $extra_field['name']; ?></label></th>
		<td>
			<input type="text" name="<?php echo $extra_field['label']; ?>" id="<?php echo $extra_field['label']; ?>" value="<?php echo esc_attr( get_the_author_meta( $extra_field['label'], $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
		</tr>

	<?php } ?>

		</table>
<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
 
function save_extra_user_profile_fields( $user_id ) {
 
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
 		$extra_fields = array(
			array(
				'name' => 'Contacto',
				'label' => 'contacto'
			),
			array(
				'name' => 'Otra info',
				'label' => 'info',
			),
		);

	foreach ( $extra_fields as $extra_field ) {	
		update_user_meta( $user_id, $extra_field['label'], $_POST[$extra_field['label']] );
	}

}
