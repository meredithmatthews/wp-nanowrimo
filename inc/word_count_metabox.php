<?php 

// Create target word count meta box

add_action('add_meta_boxes', 'cp_wc_register_meta_box');

function cp_wc_register_meta_box() {
	add_meta_box('cp-wc-meta-box', 'Target Word Count', 'cp_wc_meta_box', 'entry', 'side', 'high');
}

function cp_wc_meta_box() {
	$cpwcmetaval = get_post_meta(get_the_id(), 'wc_target', true);
	echo 'At least: <input type="number" style="width: 60px" min="0" max="100000" step="10" name="cpwc" value="' . $cpwcmetaval . '" /> words.
	<br />Posts that fall short will appear with a red word count in the post list.';
}

//add actions to save current word count and target as custom fields

add_action('wp_insert_post', 'cp_wc_save_field');

function cp_wc_save_field($post_id) {
	
	if(isset($_POST['cpwc'])):
		$cpwc_got_meta = (int)$_POST['cpwc'];
	endif;
	
	if(isset($cpwc_got_meta)):
		$post_object = get_post( $post_id );
		$fltrcpwccontent = str_replace(']]>', ']]&gt;', apply_filters('the_content', $post_object->post_content));
		$words = str_word_count(strip_tags(str_replace(array('&#8217;','’','-',' - ','\'',''),'',$fltrcpwccontent)));
		update_post_meta($post_id, 'wc_the_word_count', $words);
		if($cpwc_got_meta>0):	
			update_post_meta($post_id, 'wc_target', $cpwc_got_meta);
		else:
			delete_post_meta($post_id, 'wc_target');
		endif;
	endif;
}


?>