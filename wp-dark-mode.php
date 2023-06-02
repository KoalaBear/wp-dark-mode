<?php
/**
* Plugin Name: WP Automatic Dark Mode
* Plugin URI: https://github.com/KoalaBear/
* Description: This plugin would automatically display your website in dark mode when browsed through supported browsers which are being used by OS's in dark mode.
* Version: 1.0
* Author: KoalaBear Developments
* Author URI: https://github.com/KoalaBear/
**/

// create custom plugin settings menu
add_action('admin_menu', 'wp_dark_mode_create_menu');

function wp_dark_mode_create_menu() {

	//create new top-level menu
	add_menu_page('WP Dark Mode', 'Dark Mode', 'administrator', __FILE__, 'wp_dark_mode_settings_page' , 'dashicons-lightbulb' );

	//call register settings function
	add_action( 'admin_init', 'register_wp_dark_mode_settings' );
}


function register_wp_dark_mode_settings() {
	//register our settings
	register_setting( 'wp-dark-mode-settings-group', 'background_color_wpdark' );
	register_setting( 'wp-dark-mode-settings-group', 'text_color_wpdark' );
	register_setting( 'wp-dark-mode-settings-group', 'link_color_wpdark' );
	register_setting( 'wp-dark-mode-settings-group', 'link_visited_wpdark');
}

function wp_dark_mode_settings_page() {
?>
<div class="wrap">
<h1>WP Dark Mode</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'wp-dark-mode-settings-group' ); ?>
    <?php do_settings_sections( 'wp-dark-mode-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Background Color</th>
        <td><input type="text" name="background_color_wpdark" class="color-field" placeholder="#fff" value="<?php echo esc_attr( get_option('background_color_wpdark') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Text Color</th>
        <td><input type="text" name="text_color_wpdark" class="color-field" placeholder="#fff" value="<?php echo esc_attr( get_option('text_color_wpdark') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Link Color</th>
        <td><input type="text" name="link_color_wpdark" class="color-field" placeholder="#fff" value="<?php echo esc_attr( get_option('link_color_wpdark') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Visited Link Color*</th>
        <td><input type="text" name="link_visited_wpdark" class="color-field" placeholder="#fff" value="<?php echo esc_attr( get_option('link_visited_wpdark') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
<style> a { color: #01a3a4; } </style>
<p style="font-weight: bold;">Made with <span style="color:#f368e0">❤</span> by the <a href="https://github.com/KoalaBear/">KoalaBear</a></p>
</div>
<?php }
add_action('wp_head', 'wp_dark_custom_style');

function wp_dark_custom_style()
{
 echo "<style> @media (prefers-color-scheme: dark) {
 	body {
 		background-color: " . esc_attr(get_option('background_color_wpdark')) . ";
 		color: " . esc_attr(get_option('text_color_wpdark')) . " !important;
 		}
 	body a {
 		color: " . esc_attr(get_option('link_color_wpdark')) . "
 	}

 	body a:visited {
 		color:" . esc_attr(get_option('link_color_wpdark')) . " !important;
 	}

 	</style>";
}

add_action( 'admin_enqueue_scripts', 'wptuts_add_color_picker' );
function wptuts_add_color_picker( $hook ) {
 
    if( is_admin() ) { 
     
        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}
?>