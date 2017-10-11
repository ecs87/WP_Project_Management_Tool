<?php
defined('ABSPATH') OR exit;
/**
 * @package WordPress
 * @subpackage WP-Skeleton
 */
get_template_part( 'isUserLoggedIn' );
get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title
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
							if( has_post_thumbnail() )
								the_post_thumbnail('featured-image');
							//task deadline
							$deadline_date = get_post_meta(get_the_id(), 'task_deadline_date', true );
							echo '<div class="single-task-deadline"><p>Deadline: '.$deadline_date.'</p></div>';
							//users assigned to the task
							$assigned_users = get_post_meta(get_the_id(), 'multi_user_select', false );
							echo '<div class="single-task-assignedUsers">
								Assigned Users: </br>';
								foreach ($assigned_users as $assigned_user) {
									$assigned_user = get_user_by('id', $assigned_user);
									echo $assigned_user->data->user_nicename.'</br>';
								}
								echo '</br>';
							echo '</div>';
							//task description/content
							the_content();
							//attachments
							$task_files = get_post_meta(get_the_id(), 'multi_file_upldr', false );
							if ($task_files) {
								echo '<div class="single-task-fileList">
									Attachments: </br>';
									foreach ($task_files[0] as $task_file) {
										echo '<div class="single-task-file">
											<a href="'.$task_file.'">'.$task_file.'</a>
										</div>';
									}
								echo '</div>';
							}
							edit_post_link( __( 'Edit', 'themename' ), '<span class="edit-link">', '</span>' );
							//task chat/comments
							comments_template();	
						?>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- #main -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div>

<?php get_footer(); ?>