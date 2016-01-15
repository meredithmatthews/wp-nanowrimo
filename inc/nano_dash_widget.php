<?php

//add dashboard widget

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
 
function my_custom_dashboard_widgets() {
	
	global $wp_meta_boxes;
	wp_add_dashboard_widget('custom_help_widget', 'WP-NaNoWriMo Beta', 'custom_dashboard_help');
}

function custom_dashboard_help() {
	
		hello_nano();
		$allpostargs = array(
			'post_status' => array('publish'),
			'post_type' => 'entry',
			'posts_per_page' => -1,
		);
		$allposts = get_posts($allpostargs);
		$totalwordcount = get_total_wordcount($allposts);
		echo '<h2>Total Word Count: '.$totalwordcount.'</h2>';
		echo '<p>todo: instructions and possibly RSS feed here</p>';
}

?>