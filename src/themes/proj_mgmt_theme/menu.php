<?php
defined('ABSPATH') OR exit;
/**
 * @package WordPress
 * @subpackage WP-Skeleton
 */
?>
</div>
</div>
<div class="super-container logo-menu-wrapper">
	<div class="container">
		<div class="four columns alpha projmgmt-logo">
			<div class="logo">
				<a href="<?php bloginfo('url'); ?>"> <img src="<?php echo get_theme_mod('site_logo'); ?>" /></a>
			</div>
		</div>
		<div class="eight columns alpha pm-container">
			<?php wp_nav_menu(array('theme_location' => 'pmNav')); ?>
		</div>
	</div>
</div>
<div class="super-container page-wrapper">
	<div class="container">