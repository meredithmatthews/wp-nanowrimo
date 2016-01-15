<?php
/*
based on Hello Dolly 1.6
*/

function hello_nano_get_line() {
	/** These are motivational phrases and threats */
	$thelines = "Allons-y!
Have you killed a character recently?
Edit later!
You should be writing.
Remeber, you're working on draft zero.
Every time you procrastinate your novel, God pokes a badger with a spoon.
When in doubt, add ninjas.
You'll never have the chance to make it perfect if you don't get it done first.
	";

	// Here we split it into lines
	$thelines = explode( "\n", $thelines );

	// And then randomly choose a line
	return wptexturize( $thelines[ mt_rand( 0, count( $thelines ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later
function hello_nano() {
	$chosen = hello_nano_get_line();
	echo "<p id='hello-nano'>$chosen</p>";
}

// We need some CSS to position the paragraph
function hello_nano_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#hello-nano {
		float: $x;
	    padding: 8px;
	    margin: 5px;
	    font-size: 11px;
	    max-width: 120px;
	    border: 1px solid #eee;
	    border-radius: 9px;
	    font-weight: 700;
	}
	</style>
	";
}

add_action( 'admin_head', 'hello_nano_css' );

?>
