<?php
defined('ABSPATH') OR exit;
/**
 * @package WordPress
 * @subpackage WP-Skeleton
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' />
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1' />
    
<title><?php wp_title('|',true,'right'); echo get_bloginfo('description'); ?></title>

<!-- Mobile Specific Metas
================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/stylesheets/base.css">
<link rel="stylesheet" href= "<?php echo get_template_directory_uri(); ?>/style.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/stylesheets/layout.css">

<!-- Favicons
================================================== -->
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">

<!-- Fonts
================================================== -->
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">

<?php wp_head(); ?>        
</head>

<script type="text/javascript">
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>

<body <?php body_class(); ?>><!-- the Body  -->