<?php	
// Link to Custom Stylesheet
function login_css() {
    wp_enqueue_style( 'login_css', get_template_directory_uri() . '/stylesheets/login.css' );
}
add_action('login_head', 'login_css');

// Change where logo links 
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

