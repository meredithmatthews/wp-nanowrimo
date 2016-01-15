<?php 

//style column width

add_action('admin_head', 'cpwc_column_style');

function cpwc_column_style() {
	echo '<style>.column-cpwordcount { width: 60px; }</style>';
}

//register column

add_filter('manage_entry_posts_columns', 'cp_wc_column_filter');
add_action('manage_entry_posts_custom_column', 'cp_wc_column_action', 10, 2);


//define column

function cp_wc_column_filter($label) {
	$label['cpwordcount'] = 'Words';
    return $label;
}

function cp_wc_column_action($column_name, $current_post_id) {
	if($column_name == 'cpwordcount'):
		$cpwcpost = new CPWordCount($current_post_id,true);
		$thetarget = $cpwcpost->target_count();
		echo $cpwcpost->word_count(true,$thetarget);
	endif;
}

// build column wordcount

class CPWordCount {//this object represents the word count of a single post.
	public static $id;
	public static $words;
	public static $target = false;
	function __construct($postid, $inloop=true) {}

	function word_count($style = false, $target) {
		$cpwccontent = apply_filters('the_content', get_the_content());
		$fltrcpwccontent = str_replace(']]>', ']]&gt;', $cpwccontent);
		$words = str_word_count(strip_tags(str_replace(array('&#8217;','’','-',' - ','\'',''),'',$fltrcpwccontent)));

	if($style && $target>$words):
			$percent = $this->target_completion(true,$words,$target);
			return '<span style="color:rgb(255,' . $percent . ',' . $percent . ');">' . $words . '</span>';
		else:
			return $words;
		endif;
	}

	function target_count() {
		$target = false;
		$metafield = get_post_meta(get_the_id(),'wc_target',true);
		if($metafield != '' && $metafield != null):
			$target = (int)$metafield;
			if($target>0):
				return (int)$metafield;
			endif;
		endif;
	}
	
	function target_completion($int = false,$words,$target) {
		if($target):
			$complete = (int)((($words/$target)*100)+0.50);
		endif;
		if($int):
			return $complete;
		elseif($target):
			return $complete . '%';
		else:
			return $complete;
		endif;
	}
}

?>
