<?php
// create custom plugin settings menu
add_action('admin_menu', 'wp_nanowrimo_create_menu');

function wp_nanowrimo_create_menu() {

	//create new top-level menu
	add_options_page('WP-NaNoWriMo Settings', 'WP-NaNoWriMo', 'manage_options', 'plugin', 'wp_nanowrimo_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_wp_nanowrimo_settings' );
}


function register_wp_nanowrimo_settings() {
	//register our settings
	register_setting( 'wp_nanowrimo-settings-group', 'nano_novel_title' );
}

//settings form
function wp_nanowrimo_settings_page() { ?>
    <div class="wrap">
    <h2>WP-NaNoWriMo</h2>

    <p>Thanks for trying WP-NaNoWriMo! A method for suggesting awesome new features will be added soon.</p> 

    <form method="post" action="options.php">
        <?php settings_fields( 'wp_nanowrimo-settings-group' ); ?>
        <?php do_settings_sections( 'wp_nanowrimo-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Novel Title</th>
            <td><input type="text" name="nano_novel_title" value="<?php echo esc_attr( get_option('nano_novel_title') ); ?>" /></td>
            </tr>
        </table>
        
        <?php submit_button(); ?>

    </form>
    </div>
<?php } ?>