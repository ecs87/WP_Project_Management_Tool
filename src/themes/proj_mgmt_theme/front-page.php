<?php
defined('ABSPATH') OR exit;
/**
 * @package WordPress
 * @subpackage WP-Skeleton
**/
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
					<div class="entry-content">
						<?php if( has_post_thumbnail() ){
							the_post_thumbnail('featured-image');
						}?>
						<?php 
							$args = array(
								'post_type' => 'task',
								'posts_per_page' => -1,
								'orderby' => 'meta_value',
								'meta_key' => 'task_deadline_date',
								'order' => 'ASC',	
							);
							$loop = new WP_Query($args);
							if ($loop->have_posts()){
								while ($loop->have_posts()) : $loop->the_post();
									$deadline_date = get_post_meta(get_the_id(), 'task_deadline_date', true );
									$user_assignees = get_post_meta(get_the_id(), 'multi_user_select', false );
									foreach ($user_assignees as $user_assignee) {
										if ($user_assignee == get_current_user_id()) {
											echo '<div class="tatm-holder">';
												if (get_post_meta( get_the_id(), 'close_task_select', true ) == "Yes") 
													echo '<a class="client-list-nonadmin" href="'.get_the_permalink().'"><b>Closed/Completed: </b>'.get_the_title().'</a>';
												else
													echo '<a class="client-list-nonadmin" href="'.get_the_permalink().'">'.get_the_title().'</a>';
												echo 'Deadline Date: '.$deadline_date;
											echo '</div>';
										}
									}
								endwhile;
							}
							wp_reset_query();
						?>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- #main -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div>

<?php get_footer(); ?>