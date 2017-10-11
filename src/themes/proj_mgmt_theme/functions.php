<?php 
defined('ABSPATH') OR exit;
/**
 * @package WordPress
 * @subpackage WP-Skeleton
 */

// drag and drop menu support
register_nav_menu( 'pmNav', 'Project Management Nav' );

//Apply do_shortcode() to widgets so that shortcodes will be executed in widgets
add_filter('widget_text', 'do_shortcode');

//Add jquery Library
if (!is_admin()) add_action("wp_enqueue_scripts", "ecs87_jquery_enqueue", 11);
function ecs87_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", false, null);
   wp_enqueue_script('jquery');   
}

//Adds Customizer functinality
function ecs87_customize_register( $wp_customize ){
	require_once( get_stylesheet_directory() . '/includes/customizer.php' );
}
add_action( 'customize_register', 'ecs87_customize_register' );

function filter_tasks_by_taxonomies( $post_type, $which ) {
	if ( 'task' !== $post_type )
		return;
	$taxonomies = array( 'task_clients' );
	foreach ( $taxonomies as $taxonomy_slug ) {
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;
    $terms = get_terms(array('taxonomy' => $taxonomy_slug,'hide_empty' => false));  
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Show All Companies', 'text_domain' ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				((isset($_GET[$taxonomy_slug]) && ($_GET[$taxonomy_slug] == $term->slug )) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}
}
add_action( 'restrict_manage_posts', 'filter_tasks_by_taxonomies' , 10, 2);

//this function and hook sends a email to users and the posts' author whenever a new comment is posted on a task
function comments_email_trigger( $comment_ID, $comment_approved ) {
  if( 1 === $comment_approved ) {
    $comment_author_email = get_comment_author_email( $comment_ID );
    $get_user = get_user_by('email', $comment_author_email);
    $comment_obj = get_comment($comment_ID);
		$args = array (
			'post_type' => 'task',
			'p' => $comment_obj->comment_post_ID,
		);
		$loop = new WP_Query($args);
		if ($loop->have_posts()){
			while ($loop->have_posts()) : $loop->the_post();
				$user_assignees = get_post_meta(get_the_id(), 'multi_user_select', false );
				foreach ($user_assignees as $user_assignee) {
					var_viewer($user_assignee);
					var_viewer($get_user->data->ID);
					var_viewer($get_user->data->user_email);
					if ($user_assignee == $get_user->data->ID) { }
					else {
						$get_user_assignee = get_user_by('id', $user_assignee);
						mail($get_user_assignee->data->user_email, 'New Messages/Comments', 'There are new messages/comments at: '.get_the_permalink($comment_obj->comment_post_ID), $headers = 'From: relayer@'.$_SERVER['SERVER_NAME']);
					}
				}
				$author_of_post_email = get_the_author_meta('user_email');
				mail($author_of_post_email, 'New Messages/Comments', 'There are new messages/comments at: '.get_the_permalink($comment_obj->comment_post_ID), $headers = 'From: relayer@'.$_SERVER['SERVER_NAME']);
			endwhile;
		}
		wp_reset_query();
  }
}
add_action( 'comment_post', 'comments_email_trigger', 10, 2 );

//these functions and hooks send a email to a user whenever they are added or removed from a task
function action_pre_post_update( $post_id, $data ) {
	if (get_post_meta($post_id, 'multi_user_select', false )) {
		$GLOBALS['user_assignees_before'] = get_post_meta($post_id, 'multi_user_select', false );
		function my_project_updated_send_email( $post_id ) {
			$user_assignees_after = get_post_meta($post_id, 'multi_user_select', false );
			$users_removed_from_task = array_diff($GLOBALS['user_assignees_before'], $user_assignees_after);
			$users_added_to_task = array_diff($user_assignees_after, $GLOBALS['user_assignees_before']);
			foreach ($users_removed_from_task as $user_removed_from_task) {
				$get_user_assignee = get_user_by('id', $user_removed_from_task);
				mail($get_user_assignee->data->user_email, 'Removed from task', 'You have been removed from a task: '.get_the_permalink($post_id), $headers = 'From: relayer@'.$_SERVER['SERVER_NAME']);
			}
			foreach ($users_added_to_task as $user_added_to_task) {
				$get_user_assignee = get_user_by('id', $user_added_to_task);
				mail($get_user_assignee->data->user_email, 'Added to task', 'You have been added to a task: '.get_the_permalink($post_id), $headers = 'From: relayer@'.$_SERVER['SERVER_NAME']);
			}
		}
		add_action( 'save_post', 'my_project_updated_send_email' );
	}
};
add_action( 'pre_post_update', 'action_pre_post_update', 10, 2 );

//edit instead of submit if request comes from specific page
add_filter( 'gform_entry_id_pre_save_lead', 'update_timesheet_entry', 10, 2 );
function update_timesheet_entry( $entry_id, $form ) {
	global $post;
	if($_SERVER["REDIRECT_URL"]=="/timesheet-review/"){
		$update_entry_id = $_GET['entry'];
		$url = strtok($_SERVER["REQUEST_URI"],'?');
		header("Location: ".$url);
		return $update_entry_id ? $update_entry_id : $entry_id;
	}
}

include('includes/custom_login_functions.php');
include('includes/general_functions.php');
include('includes/tinymce_functions.php');
include('includes/dynamic_client_populate_gform.php');
include('includes/cpt_functions.php'); 
?>