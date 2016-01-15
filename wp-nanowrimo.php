<?php
/*
Plugin Name: WP-NaNoWriMo
Plugin URI: http://meredithmatthews.net/
Description: A set of tools useful for NaNo participants
Version: 1.0
Author: Meredith Matthews
Author URI: http://meredithmatthews.net/
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/* inspirational nonsense for the writer in dash-widget*/
include( plugin_dir_path( __FILE__ ) . 'inc/hello_nano.php'); 

/* dashboard widget, with instructions, wordcount, hello_nano */
include( plugin_dir_path( __FILE__ ) . 'inc/nano_dash_widget.php'); 

/* registers the entry custom post type, also modifies the title of the entry archive page to show the novel title. WP-REST compatible */
include( plugin_dir_path( __FILE__ ) . 'inc/cpt.php'); 

/* builds custom column for entries, includes class for individual entry word counts and functionality */
include( plugin_dir_path( __FILE__ ) . 'inc/cpt_column.php');

/* builds wordcount metabox in entries, and saves targets and wordcounts as custom fields */
include( plugin_dir_path( __FILE__ ) . 'inc/word_count_metabox.php');

/* builds the widget, displays novel, word counts, custom title */
include( plugin_dir_path( __FILE__ ) . 'inc/nano_widget.php');

/* plugin options page. Currently has one option */
include( plugin_dir_path( __FILE__ ) . 'inc/nano_settings.php');

/* allows plugin to inject it's own page template, so we can display WP-REST-generated content */
include( plugin_dir_path( __FILE__ ) . 'inc/page_templater.php');


// add entry wordcounts to entry titles
add_filter( 'the_title', 'ta_modified_post_title');
function ta_modified_post_title ($title) {
  if ( in_the_loop() && !is_page() ) {
	$title_word_count = get_post_custom_values('wc_the_word_count');
	if($title_word_count) {
		$title = $title.' (Word Count: '.$title_word_count[0].')';
	}
  }
  return $title;
}

// Get the total NaNo Wordcount
function get_total_wordcount($allposts) {
    $total = 0;
	foreach ( $allposts as $post ) : setup_postdata($post);
        $post_id = $post->ID;
        $fields = get_post_custom($post_id);    // all keys for post as values of array
        if ($fields) {
			
            foreach ($fields as $key => $value) {
                if ($key == 'wc_the_word_count') {             
                    $total += $value[0];
                }
            }
        }
    endforeach; wp_reset_postdata();
    return $total;
}

//enqueue all the things
function enqueue_my_scripts() {

    wp_register_script('angularjs', plugin_dir_url( __FILE__ ) . 'bower_components/angular/angular.min.js');
    wp_register_script('angularjs-route', plugin_dir_url( __FILE__ ) . 'bower_components/angular-route/angular-route.min.js');
    wp_register_script('angularjs-sanitize', plugin_dir_url( __FILE__ ) . 'bower_components/angular-sanitize/angular-sanitize.min.js');
    wp_register_script('angularjs-slick', plugin_dir_url( __FILE__ ) . 'bower_components/angular-slick/dist/slick.min.js');
    wp_register_script('my-jquery', plugin_dir_url( __FILE__ ) . 'bower_components/jquery/dist/jquery.min.js');
    wp_enqueue_script('my-scripts', plugin_dir_url( __FILE__ ) . 'js/scripts.js', 
        array( 'my-jquery', 'angularjs', 'angularjs-route', 'angularjs-sanitize', 'angularjs-slick' ));

    wp_enqueue_script('wp-service', plugin_dir_url( __FILE__ ) . 'js/WPService.js');

    wp_localize_script('my-scripts', 'myLocalized',
        array(
            'partials' => trailingslashit( plugin_dir_url( __FILE__ ) ) . 'partials/',
            'nonce' => wp_create_nonce( 'wp_rest' )
            )
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_my_scripts' );

?>