<?php
defined('ABSPATH') OR exit;
/**
 * Template Name: Timesheet Admin Page
 * @package WordPress
 * @subpackage WP-Skeleton
 */
get_template_part( 'isUserLoggedIn' );
get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title

if ($_GET['ajax']) {
	if ($_GET['delGFFromID']) {
		/* we do NOT want users to be able to send malicious AJAX requests to delete other users timesheet
		   so we resolve this by getting the current user and comparing that to the entry that they're trying to delete
		   if it's not the same, we deny them access (admin check was added here because admins need this capability */
		$entry = RGFormsModel::get_lead($_GET['delGFFromID']);
		$current_user = wp_get_current_user();
		if ($current_user->display_name != $entry[get_theme_mod('gform_task_user')] && !current_user_can('manage_options'))
			die();
  	else
  		GFFormsModel::delete_lead($_GET['delGFFromID']);
  }
}
?>

<div class="twelve columns alpha">
	<div id="primary" class="full-width">
		<div id="content">
				<div class="main"> 
				<?php the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
						<header class="entry-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header><!-- .entry-header -->
						<div class="entry-content">
							<?php 
								if( has_post_thumbnail() ){ the_post_thumbnail('featured-image'); }
								the_content();
								$gforms_target_id	= get_theme_mod( 'gform_target_id' );
								$entry_array = (GFFormsModel::get_leads($gforms_target_id));
								
								echo '<select class="entry-client">
									<option value=""></option>';
									$terms = get_terms(array(
									  'taxonomy' => 'task_clients',
									  'hide_empty' => false,
									));   
									$choices = array();
									foreach ( $terms as $term ) {
										echo '<option value="'.$term->name.'">'.$term->name.'</option>';
									}
								echo '</select>';
								if (current_user_can('manage_options')) { //current user is admin, show userSelect dropdown
									echo '<select class="entry-owner">
										<option value=""></option>';
										foreach ($entry_array as $timesheet_entry) {
											echo '<option value="'.$timesheet_entry[get_theme_mod('gform_task_user')].'">'.$timesheet_entry[get_theme_mod('gform_task_user')].'</option>';
										}
									echo '</select>';
								}
								echo '<input class="timesheet-date-picker" type="date" name="PMTdatePicker">';
								
								echo '<div class="timesheet-legend">';
									echo '<div class="two columns">';
										echo 'Client Name';
									echo '</div>';
									echo '<div class="two columns">';
										echo 'Date task was performed';
									echo '</div>';
									echo '<div class="two columns">';
										echo 'Start time';
									echo '</div>';
									echo '<div class="two columns">';
										echo 'End time';
									echo '</div>';
									echo '<div class="two columns">';
										echo 'Minutes';
									echo '</div>';
									echo '<div class="two columns">';
										echo 'Task description';
									echo '</div>';
									echo '<div style="clear: both"></div>'; //since all the columns float the timesheet-item div won't have proper height. This clears the floats and fixes it.
								echo '</div>';
								echo '<div class="timesheet-holder">';
									foreach ($entry_array as $timesheet_entry) {
										$current_user = wp_get_current_user();
										if (current_user_can('manage_options')) { /* is admin, show everything */ }
										else if ($current_user->display_name != $timesheet_entry[get_theme_mod('gform_task_user')]) { continue; }
										$timesheet_timestamp = "";
										$customizer_pull_startDate = get_theme_mod('gform_start_date_id');
										$customizer_pull_startTime = get_theme_mod('gform_start_time_id');
										if (strpos($timesheet_entry[$customizer_pull_startTime], 'pm') !== false) {
											$twelve_hr_to_24 = date("H:i:s", strtotime($timesheet_entry[get_theme_mod('gform_start_time_id')]));
											$timesheet_timestamp = strtotime("$timesheet_entry[$customizer_pull_startDate] $twelve_hr_to_24");
										}
										else {
											$timesheet_timestamp = strtotime("$timesheet_entry[$customizer_pull_startDate] $timesheet_entry[$customizer_pull_startTime]");
										}
										echo '<div id="'.$timesheet_timestamp.'" class="timesheet-item timesheet-entry-id-'.$timesheet_entry['id'].' timesheet-owner-'.$timesheet_entry[get_theme_mod('gform_task_user')].'">';
											echo '<div class="two columns">';
												echo $timesheet_entry[get_theme_mod('gform_company_name_id')]; //company name
											echo '</div>';
											echo '<div class="two columns">';
												echo $timesheet_entry[get_theme_mod('gform_start_date_id')]; //date task was performed
											echo '</div>';
											echo '<div class="two columns">';
												echo $timesheet_entry[get_theme_mod('gform_start_time_id')]; //start time
											echo '</div>';
											echo '<div class="two columns">';
												echo $timesheet_entry[get_theme_mod('gform_end_time_id')];
											echo '</div>';
											echo '<div class="two columns">';
												$date = get_theme_mod('gform_start_date_id');
												$end_time = get_theme_mod('gform_end_time_id');
												$start_time = get_theme_mod('gform_start_time_id');
												echo round((strtotime("$timesheet_entry[$date] $timesheet_entry[$end_time]") - strtotime("$timesheet_entry[$date] $timesheet_entry[$start_time]")) / 60); //minutes
											echo '</div>';
											echo '<div class="two columns">';
												echo $timesheet_entry[get_theme_mod('gform_task_description_id')]; //task description
											echo '</div>';
											echo '<div class="twelve columns">';
												echo '<form action="#gform_wrapper_'.$gforms_target_id.'">';
													echo '<input type="hidden" name="entry" value="'.$timesheet_entry["id"].'">';
													echo '<input type="submit" class="timesheet-edit-entry" value="Edit Entry" id="tee-'.$timesheet_entry["id"].'" />';
												echo '</form>';
												echo '<button class="timesheet-del-entry" id="tde-'.$timesheet_entry["id"].'">Remove Entry</button>';
											echo '</div>';
											echo '<div style="clear: both"></div>'; //since all the columns float the timesheet-item div won't have proper height. This clears the floats and fixes it.
										echo '</div>';
									}
								echo '</div>';
							?>
							<?php
							  $entry_id = $_GET['entry'];
							  //grab the entry values via the GF API
							  if ($entry_id) {
								  $entry = GFAPI::get_entry($entry_id);
									$date = get_theme_mod('gform_start_date_id');
									$end_time = get_theme_mod('gform_end_time_id');
									$start_time = get_theme_mod('gform_start_time_id');
									$client = get_theme_mod('gform_company_name_id');
									$description = get_theme_mod('gform_task_description_id');
								  gravity_form($gforms_target_id, false, false, false, array(
								  	'timesheet_client'=>$entry[$client],
								  	'timesheet_date'=>$entry[$date], 
								  	'timesheet_start_time'=>$entry[$start_time], 
								  	'timesheet_end_time'=>$entry[$end_time], 
								  	'timesheet_task_description'=>$entry[$description]
								  ), false);
								}
							?>
						</div><!-- .entry-content -->
					</article><!-- #post-<?php the_ID(); ?> -->
				</div><!-- #main -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div>

<?php get_footer(); ?>