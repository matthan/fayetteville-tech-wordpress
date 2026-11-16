<?php
/*
Plugin Name: Donation Thermometer
Plugin URI: http://rhewlif.xyz/thermometer
Description: Displays customisable thermometers for tracking donations using the shortcode <code>[thermometer raised=?? target=??]</code>. Shortcodes for raised/target/percentage text values are also available for posts/pages/text widgets: <code>[therm_r]</code> / <code>[therm_t]</code> / <code>[therm_%]</code>.
Version: 2.0.2
Author: Henry Patton
Author URI: http://rhewlif.xyz
License: GPL3

Copyright 2018  Henry Patton  (email : hp@rhewlif.xyz)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

defined('ABSPATH') or die('Access denied');

define('THERMFOLDER', basename( dirname(__FILE__) ) );
define('THERM_ABSPATH', trailingslashit( str_replace("\\","/", WP_PLUGIN_DIR . '/' . THERMFOLDER ) ) );
require_once plugin_dir_path(__FILE__) . 'includes/therm_svg.php';
require_once plugin_dir_path(__FILE__) . 'includes/therm_widget_setup.php';

// Specify Hooks/Filters
add_action('admin_init', 'thermometer_init_fn' );
add_action('admin_menu', 'thermometer_add_page_fn');
add_action( 'wp_dashboard_setup', array('Thermometer_dashboard_widget', 'therm_widget_init'));
 
 
function set_plugin_meta_dt($links, $file) {
    $plugin = plugin_basename(__FILE__);
    // create link
    if ($file == $plugin) {
		return array_merge(
			$links,
			array( (sprintf( '<a href="options-general.php?page=%s">%s</a>', 'thermometer-settings', __('Settings') ) ),
			  sprintf('<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8NVX34E692T34">%s</a>', __('Buy the author a coffee') ) )
		);
	}
    return $links;
}
add_filter( 'plugin_row_meta', 'set_plugin_meta_dt', 10, 2 );

// Register settings
function thermometer_init_fn(){
	if( false == get_option( 'thermometer_options' ) ) {  
		add_option( 'thermometer_options' );
	} // end if

	
	add_settings_section('thermometer_section', '', 'section_text_fn', 'thermometer_options');
	register_setting('thermometer_options', 'thermometer_options', 'thermometer_options_validate' );
	add_settings_field('target_string', 'Target value', 'target_string_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('raised_string', 'Raised value', 'raised_string_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('colour_picker1', 'Fill colour', 'fill_colour_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('chkbox1', 'Show percentage?', 'setting_chk1_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('colour_picker2', 'Percentage text colour', 'text_colour_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('chkbox2', 'Show target?', 'setting_chk2_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('colour_picker3', 'Target text colour', 'target_colour_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('targetlabels', 'Show sub-targets?', 'setting_chk4_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('colour_picker5', 'Sub-target text colour', 'subtarget_colour_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('chkbox3', 'Show amount raised?', 'setting_chk3_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('colour_picker4', 'Raised text colour', 'raised_colour_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('currency', 'Currency', 'setting_dropdown_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('trailing', 'Currency symbol follows value?', 'setting_trailing_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('thousands', 'Thousands separator', 'setting_thousands_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('color_ramp', 'Color ramp', 'color_ramp_fn', 'thermometer_options', 'thermometer_section');
	add_settings_field('tick_align', 'Tick alignment', 'tick_align_fn', 'thermometer_options', 'thermometer_section');
}

// Add sub page to the Settings Menu
function thermometer_add_page_fn() {
	$page = add_options_page('Thermometer Settings', 'Thermometer', 'administrator', 'thermometer-settings', 'options_page_fn');
	add_action( 'admin_print_styles-' . $page, 'my_admin_scripts' );
}

function thermometer_help_init() {
	add_settings_section('therm_help_section','','help_section_text_fn','thermometer-help');	
} 
add_action( 'admin_init', 'thermometer_help_init' );
function thermometer_preview_init() {
	add_settings_section('therm_preview_section','','preview_section_text_fn','thermometer-preview');	
} 
add_action( 'admin_init', 'thermometer_preview_init' );

$defaults = array('colour_picker1'=>'#d7191c', 'chkbox1'=>'true', 'colour_picker2'=>'#000000', 'chkbox2'=>'true', 'colour_picker3'=>'#000000', 'chkbox3'=>'true', 'colour_picker4'=>'#000000',
					  'currency'=>'£','target_string'=>'500', 'raised_string'=>'250', 'thousands'=>', (comma)', 'trailing'=>'false', 'tick_align'=>'right',
					  'color_ramp'=>'#d7191c; #fdae61; #abd9e9; #2c7bb6', 'targetlabels'=>'true', 'colour_picker5'=>'#8a8a8a');

$options = wp_parse_args( get_option('thermometer_options',$defaults), $defaults);

// Define default option settings when activate
function therm_activation() {
	set_transient( 'therm_activation_notice', true, 5 );
}
//add_action('admin_notices', 'therm_shortcode_notice');


/*function therm_deactivation(){
}
*/
function therm_uninstall(){
	delete_option('thermometer_options');
}

//register_activation_hook(__FILE__, 'therm_activation');
//register_deactivation_hook(__FILE__, 'therm_deactivation');
register_uninstall_hook(__FILE__, 'therm_uninstall');

function my_admin_scripts() {
    wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
    $coloursjs = plugin_dir_url( __FILE__ ) . 'colours.js';
    wp_enqueue_script( 'options_page_fn', $coloursjs , array( 'farbtastic', 'jquery' ) );
    wp_enqueue_style( 'thermStylesheet' );
}

if (!is_admin())
  add_filter('widget_text', 'do_shortcode', 11);

// ************************************************************************************************************
 

// Display the admin options page
function options_page_fn() {
	require_once plugin_dir_path(__FILE__) . 'includes/therm_settings.php';
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h1>Donation Thermometer Settings</h1>
		<?php
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'settings';
		?>
		
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('options-general.php?page=thermometer-settings&tab=settings');?>">Settings</a>
			<a class="nav-tab <?php echo $active_tab == 'preview' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('options-general.php?page=thermometer-settings&tab=preview');?>">Preview</a>
			<a class="nav-tab <?php echo $active_tab == 'help' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('options-general.php?page=thermometer-settings&tab=help');?>">Help</a>
		</h2>
		
		
		<form action="options.php" method="post">
		
		<?php
		if( $active_tab == 'settings' ) {
			settings_fields('thermometer_options');
			do_settings_sections('thermometer_options');
			submit_button();
		}
		elseif ( $active_tab == 'preview' ) {	
			settings_fields( 'thermometer-preview' ); 
			do_settings_sections( 'thermometer-preview' );
		}
		else{	
			settings_fields( 'thermometer-help' ); 
			do_settings_sections( 'thermometer-help' );
		}?>
		
		</form>
	</div>
<?php
}

require_once plugin_dir_path(__FILE__) . 'includes/therm_shortcode.php';


/* Display a notice that can be dismissed */

function therm_shortcode_notice() {
	if( get_transient( 'therm_activation_notice' ) ){
?>
        <div class="notice-info notice is-dismissible"><p>
        <p>Thanks for upgrading to the latest version of the Donation Thermometer plugin.
				  This major update brings many new features, including a switch from raster to vector-based (SVG) graphics,
				  options for multiple categories/targets, and a new shortcode (<code>therm_&#37;</code>).
				  These changes will help your pages load faster and provide a better-looking thermometer image.</p> 
				  <p>Check out the help section on the 
				  
				  <?php echo sprintf( '<a href="options-general.php?page=%s">%s</a>', 'thermometer-settings', __('settings'));?>
		
				  page for more info.
					Technical issues can be raised with me at the <a href="https://wordpress.org/support/plugin/donation-thermometer" target="_blank">
								plugin help forum</a>.</p>
        </p></div><?php
		delete_transient( 'therm_activation_notice' );
	}
}

?>