<?php
/**
 * @package WordPress
 * @subpackage WP-Skeleton
 */

get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title ?>

<div class="twelve columns alpha">
	<div id="primary" class="full-width">
		<div id="content">
			<div class="main content">
				<?php get_template_part( 'loop', 'archive' );?>
			</div><!-- #main -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div>
   
<?php get_footer(); ?>