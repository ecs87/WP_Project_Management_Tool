<?php
// Include & setup custom metabox and fields
require_once( 'init.php' );

$prefix = '_cmb_'; // start with an underscore to hide fields from custom fields list

add_action( 'cmb2_admin_init', 'yourprefix_register_demo_metabox' );
function yourprefix_register_demo_metabox() {
	$cmb_sitemap = new_cmb2_box( array(
		'id'            => $prefix . 'site_map',
		'title'         => esc_html__( 'Site Map', 'cmb2' ),
		'object_types'  => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	));
	$cmb_sitemap->add_field( array(
		'name'       => esc_html__( 'Exclude', 'cmb2' ),
		'id'         => $prefix . 'sitemap_checkbox',
		'type'       => 'checkbox',
	));
	//--------------------------------------------Special Stuff------------------------------------------------------
	$mstar_MI_menu_query = get_nav_menu_locations();
	if (in_array('0', $mstar_MI_menu_query)) {} //If there are no menu items assigned, this stops the PHP errors on the dashboard
	else if (($mstar_MI_menu_query = get_nav_menu_locations() ) && isset( $mstar_MI_menu_query)) {
		foreach ($mstar_MI_menu_query as $mstar_MI_menu_output => $key) {
			$mstar_MI_get_menu = wp_get_nav_menu_object($mstar_MI_menu_query[$mstar_MI_menu_output]);
			$mstar_MI_menu_name = $mstar_MI_get_menu->name;
			$mstar_MI_menu_items = wp_get_nav_menu_items($mstar_MI_get_menu->term_id);
			foreach ($mstar_MI_menu_items as $key => $mstar_MI_menu_item) {
				$test[$mstar_MI_menu_item->ID] = $mstar_MI_menu_item->title.': '.$mstar_MI_menu_name;
			}
		}
	}
	else {}
	
	$users = get_users();
	foreach ($users as $key => $user) {
		//echo ($user->data->user_login);
		//var_viewer($user->data->user_email);
		//var_viewer($user->data->ID);
		$user_array[$user->data->user_login] = esc_html__($user->data->user_login, 'cmb2');
	}

	//----------------------------------------------------------------------------------------------------------------
	$cmb_closeTheTask = new_cmb2_box( array(
		'id'            => $prefix . 'close_task',
		'title'         => esc_html__( 'Close/Complete the task?', 'cmb2' ),
		'object_types'  => array( 'task' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	));
	$cmb_closeTheTask->add_field( array(
		'name'       => esc_html__( 'Closed/Completed:', 'cmb2' ),
		'id'         => $prefix . 'close_task_select',
		'type'       => 'select',
		'options'          => array(
			'No'   => __( 'No', 'cmb2' ),
			'Yes' => __( 'Yes', 'cmb2' ),
		),
		'show_option_none' => false,
		'column'     => true,
	));
	
	$cmb_taskDeadline = new_cmb2_box( array(
		'id'            => $prefix . 'task_deadline',
		'title'         => esc_html__( 'Deadline', 'cmb2' ),
		'object_types'  => array( 'task' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	));
	$cmb_taskDeadline->add_field(array(
		'name'       => esc_html__( 'Date:', 'cmb2' ),
		'id'   => $prefix . 'task_deadline_date',
		'type' => 'text_date',
		// 'date_format' => 'Y-m-d',
	));
	/*
	$cmb_HSS = new_cmb2_box( array(
		'id'            => $prefix . 'hover_state_select',
		'title'         => esc_html__( 'Hover State Select', 'cmb2' ),
		'object_types'  => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	));
	$cmb_HSS->add_field( array(
		'name'       => esc_html__( 'Test Select', 'cmb2' ),
		'id'         => $prefix . 'test_select',
		'type'       => 'select',
		'options' => $test
	));
	*/
	$cmb_taxCompSelect = new_cmb2_box( array(
		'id'            => $prefix . 'tasks_taxonomy_client_select',
		'title'         => esc_html__( 'Client that this task belongs to', 'cmb2' ),
		'object_types'  => array( 'task' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	));
	$cmb_taxCompSelect->add_field( array(
		'name'       => esc_html__( 'Client', 'cmb2' ),
		'id'         => $prefix . 'tasks_taxonomy_client_radio',
		'type'       => 'taxonomy_select',
		'taxonomy' => 'task_clients',
	));
	
	$cmb_multiFileULDR = new_cmb2_box(array(
		'id'            => $prefix . 'multi_file_uploader',
		'title'         => __( 'File uploader', 'cmb2' ),
		'object_types'  => array( 'task' ), // Post type
	));
	$cmb_multiFileULDR->add_field(array(
		'name'         => __( 'Select file(s) to upload', 'cmb2' ),
		'desc'         => __( 'Upload or add multiple images/attachments.', 'cmb2' ),
		'id'           => $prefix . 'multi_file_upldr',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	));

	$cmb_multiUserSel = new_cmb2_box(array(
		'id'            => $prefix . 'multi_users',
		'title'         => __( 'Select user(s) for task', 'cmb2' ),
		'object_types'  => array( 'task' ), // Post type
	));
	$cmb_multiUserSel->add_field( array(
		'name'          => __( 'User(s):', 'cmb2' ),
		'id'            => $prefix . 'multi_user_select',
		'type'          => 'user_ajax_search',
		'multiple'      => true,
		//'limit'      	=> 5,
		//'query_args'	=> array(
			//'role__not_in'		=> array( 'Administrator', 'Editor' ),
		//)
	));
}
