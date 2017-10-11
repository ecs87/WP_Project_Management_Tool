<?php
defined('ABSPATH') OR exit;
/**
 * Template Name: Clients Archive Page
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
						<?php if( has_post_thumbnail() ){
							the_post_thumbnail('featured-image');
						}?>
						<?php 
							the_content();
							$taxonomy_obj = get_taxonomy( 'task_clients' );
							$taxonomy_name = $taxonomy_obj->labels->name;
					    $terms = get_terms(array('taxonomy' => 'task_clients','hide_empty' => false));  
					    foreach ($terms as $term) {
					    	if ($term->count != 0) {
					    		echo '<h3 class="client-title-holder cth-has-tasks">'.$term->name.'</h3>';	
					    	}
					    	else
					    		echo '<h3 class="client-title-holder">'.$term->name.'</h3>';
					    	//echo '<div>'.$term->count.'</div>';
					    	//echo '<div>'.$term->term_id.'</div>';
					    	if ($term->count != 0) {
					    		echo '<div class="client-task-holder">';
						    		$args = array(
										'post_type' => 'task',
										'tax_query' => array(
									    array(
										    'taxonomy' => 'task_clients',
										    'field' => 'id',
										    'terms' => $term->term_id
									     )
										  )
										);
										$loop = new WP_Query($args);
										if ($loop->have_posts()){
											while ($loop->have_posts()) : $loop->the_post();
												if (get_post_meta( get_the_id(), 'close_task_select', true ) == "Yes")
													echo '<a class="client-list-nonadmin" href="'.get_the_permalink().'"><b>Closed/Completed: </b>'.get_the_title().'</a>';
												else 
													echo '<a class="client-list-nonadmin" href="'.get_the_permalink().'">'.get_the_title().'</a>';
											endwhile;
										}
										wp_reset_query();
									echo '</div>';
				    		}
					    }
					    //var_viewer($terms);
						?>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- #main -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div>

<?php get_footer(); ?>