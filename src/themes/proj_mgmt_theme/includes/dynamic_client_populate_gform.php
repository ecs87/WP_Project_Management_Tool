<?php
$gforms_target_id	= get_theme_mod( 'gform_target_id' );
add_filter( 'gform_pre_render_'.$gforms_target_id, 'populate_clients' );
add_filter( 'gform_pre_validation_'.$gforms_target_id, 'populate_clients' );
add_filter( 'gform_pre_submission_filter_'.$gforms_target_id, 'populate_clients' );
add_filter( 'gform_admin_pre_render_'.$gforms_target_id, 'populate_clients' );
function populate_clients( $form ) {
	foreach ( $form['fields'] as &$field ) {
    if ( $field->type != 'select' || strpos( $field->cssClass, 'populate-clients' ) === false ) {
			continue;
    }
    $terms = get_terms(array(
	    'taxonomy' => 'task_clients',
	    'hide_empty' => false,
		));   
    $choices = array();
    foreach ( $terms as $term ) {
			$choices[] = array( 'text' => $term->name, 'value' => $term->name );
    }
    $field->placeholder = 'Select a Client';
    $field->choices = $choices;
	}
	return $form;
}
?>