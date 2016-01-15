<?php

// Adds NaNo_Widget widget.

class NaNo_Widget extends WP_Widget {

	// construction area
	function __construct() {
		parent::__construct(
			'nano_Widget', // Base ID
			__( 'WP-NaNoWriMo Widget', 'wp-nanowrimo' ), // Name
			array( 'description' => __( 'Display your book, word counts, and more', 'wp-nanowrimo' ), ) // Args
		);
	}

	// spoof a nav menu linking to the novel, by name
	private function nano_widget_menu() {
		echo '
		<nav id="nano-navigation" class="main-navigation" role="navigation">
			<div class="menu-main-menu-container">
				<ul id="menu-main-menu" class="nav-menu">
					<li id="menu-item-nano" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-nano">
						<a href="'.site_url( '/entry/', '' ).'">'.esc_attr( get_option('nano_novel_title') ).' Entries</a>
					</li>
				</ul>
			</div>
		</nav>';
	}


	//display widget. include spoofed menu, custom title, word count, word goal
	public function widget( $args, $instance ) {
		$this->nano_widget_menu();
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		} else { 
			echo $args['before_title'] . apply_filters( 'widget_title', 'My NaNo Stats' ). $args['after_title'];
		}
		$allpostargs = array(
			'post_status' => array('publish'),
			'post_type' => 'entry',
			'posts_per_page' => -1,
		);
		$allposts = get_posts($allpostargs);
		$totalwordcount = get_total_wordcount($allposts);
		echo '<h2>Total Wordcount: </h2>';
		echo $totalwordcount; 
		echo '<h2>Remaining Wordcount: </h2>';
		$math = 50000 - $totalwordcount;
		echo $math;
		
		echo $args['after_widget'];

	}

	// widget form
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}


	// Sanitize widget form values as they are saved.
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} 

// Register widget with WordPress.
function register_NaNo_Widget() {
    register_widget( 'NaNo_Widget' );
}
add_action( 'widgets_init', 'register_NaNo_Widget' );

?>