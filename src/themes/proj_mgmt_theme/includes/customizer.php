<?php
// Remove unwanted areas
$wp_customize->remove_section('nav');
$wp_customize->remove_section('static_front_page');

//FOR PROJECT MANAGEMENT
$wp_customize->add_section ( 'gforms-selection', array(
    'title'       => __('Logo & GForms Selection'),
    'priority' => 100,
  )
);
//Image 1
$wp_customize->add_setting ('site_logo',
  array ( 'default'    => '', 'type'       => 'theme_mod', )
);
$wp_customize->add_control (
  new WP_Customize_Image_Control (
    $wp_customize,
    'logo_img_for_site',
    array (
      'label'    => __('Site logo'),
      'section'  => 'gforms-selection',
      'settings' => 'site_logo',
      'priority' => 140,
    )
  )
);
$wp_customize->add_setting('gform_target_id');
$wp_customize->add_control('gform_target_id', array(
    'label'      => __('Gravity Form ID with the timesheet form'),
    'section'    => 'gforms-selection',
    'type'  	 => 'text',
    'priority' 	=> 150,
));
$wp_customize->add_setting('gform_company_name_id');
$wp_customize->add_control('gform_company_name_id', array(
    'label'      => __('Gravity Field ID with the client name'),
    'section'    => 'gforms-selection',
    'type'  	 => 'text',
    'priority' 	=> 150,
));
$wp_customize->add_setting('gform_start_date_id');
$wp_customize->add_control('gform_start_date_id', array(
    'label'      => __('Gravity Field ID with the Date'),
    'section'    => 'gforms-selection',
    'type'  	 => 'text',
    'priority' 	=> 150,
));
$wp_customize->add_setting('gform_start_time_id');
$wp_customize->add_control('gform_start_time_id', array(
    'label'      => __('Gravity Field ID with the start time'),
    'section'    => 'gforms-selection',
    'type'  	 => 'text',
    'priority' 	=> 150,
));
$wp_customize->add_setting('gform_end_time_id');
$wp_customize->add_control('gform_end_time_id', array(
    'label'      => __('Gravity Field ID with the end time'),
    'section'    => 'gforms-selection',
    'type'  	 => 'text',
    'priority' 	=> 150,
));
$wp_customize->add_setting('gform_task_description_id');
$wp_customize->add_control('gform_task_description_id', array(
    'label'      => __('Gravity Field ID with the task description'),
    'section'    => 'gforms-selection',
    'type'  	 => 'text',
    'priority' 	=> 150,
));
$wp_customize->add_setting('gform_task_user');
$wp_customize->add_control('gform_task_user', array(
    'label'      => __('Gravity Field ID with the tasks user'),
    'section'    => 'gforms-selection',
    'type'  	 => 'text',
    'priority' 	=> 150,
));

function example_sanitize_integer( $input ) {
	if( is_numeric( $input ) ) {
		return intval( $input );
	}
}

