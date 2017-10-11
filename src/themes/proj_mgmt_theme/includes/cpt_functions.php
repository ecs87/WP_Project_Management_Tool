<?php
/***************** 
* Custom Post Type Generator
*****************/

include('cmb2/meta-tate.php');

$cpt_holder[]	= array('Task', 'Tasks', 'task', array( 'title', 'editor', 'revisions', 'comments' ), true, true, 'dashicons-welcome-write-blog' );

add_action( 'init', 'ecs87_create_post_type', 10, 1);
function ecs87_create_post_type() {
	global $cpt_holder;
	foreach ($cpt_holder as $cpt) {
		register_post_type( $cpt[2],				   
			array(
				'labels' => array(
				'name' => $cpt[1],
				'singular_name' => $cpt[0],
				'add_new' => 'Add New ' .$cpt[0],
				'add_new_item' => 'Add New ' .$cpt[0],
				'edit_item' => 'Edit ' .$cpt[0],
				'new_item' => 'New ' .$cpt[0],
				'view_item' => 'View ' .$cpt[0],
				'search_items' => 'Search ' .$cpt[1],
				'not_found' => 'No ' .$cpt[1]. ' found',
				),
			'public' => true,
			'has_archive' => true,
			'supports' => $cpt[3],
			//'hierarchical' => $cpt[5],
			'menu_icon' => $cpt[6],
			'exclude_from_search' => !$cpt[4], // this is opposite, important
			'publicly_queryable' => $cpt[5],	
			
			)
		);	
	}
}

/*****************
* Custom Taxonomy
*****************/
add_action( 'init', 'ecs87_build_taxonomies', 0 );  

function ecs87_build_taxonomies() {  
	register_taxonomy (  
		'task_clients',
		'task',
		array (
			'hierarchical' => true,  
			'label' => 'Client List',  
			'query_var' => true,  
			'rewrite' => true,
			'meta_box_cb' => false
		)
	);
}
