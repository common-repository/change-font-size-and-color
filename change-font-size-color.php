<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.topinfosoft.com/about
 * @since             1.0.1
 * @package           Change_Font_Size_Color
 *
 * @wordpress-plugin
 * Plugin Name:       Change font size and color
 * Plugin URI:        http://www.topinfosoft.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.1
 * Author:            Top Infosoft
 * Author URI:        http://www.topinfosoft.com/about
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       change-font-size-color
 * Domain Path:       /languages
 */


/*
1. show menu at admin
2. color picker
3. create database
*/
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CHANGE_FONT_SIZE_COLOR_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-change-font-size-color-activator.php
 */
function activate_change_font_size_color() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-change-font-size-color-activator.php';
	Change_Font_Size_Color_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-change-font-size-color-deactivator.php
 */
function deactivate_change_font_size_color() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-change-font-size-color-deactivator.php';
	Change_Font_Size_Color_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_change_font_size_color' );
register_deactivation_hook( __FILE__, 'deactivate_change_font_size_color' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-change-font-size-color.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */



//############################## create database //##############################
// create custom database
global $wvd_db_version;
$wcfsColor_db_version = '1.0';


function wcfsDb()
{

global $wpdb;
global $wvd_db_version;
$wvd_table_name = $wpdb->prefix . 'font_color';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $wvd_table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		h1_size varchar(55) DEFAULT '' NOT NULL,
		h2_size varchar(55) DEFAULT '' NOT NULL,
		h3_size varchar(55) DEFAULT '' NOT NULL,
		h4_size varchar(55) DEFAULT '' NOT NULL,
		p_size varchar(55) DEFAULT '' NOT NULL,
		label_size varchar(55) DEFAULT '' NOT NULL,
		link_size varchar(55) DEFAULT '' NOT NULL,
		h1_color varchar(55) DEFAULT '' NOT NULL,
		h2_color varchar(55) DEFAULT '' NOT NULL,
		h3_color varchar(55) DEFAULT '' NOT NULL,
		h4_color varchar(55) DEFAULT '' NOT NULL,
		p_color varchar(55) DEFAULT '' NOT NULL,
		label_color varchar(55) DEFAULT '' NOT NULL,
		link_color varchar(55) DEFAULT '' NOT NULL,		
		link_hovercolor varchar(55) DEFAULT '' NOT NULL,		
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
    add_option('wvd_db_version', $wvd_db_version);

    $wpdb->query($wpdb->prepare("DELETE FROM $wvd_table_name"));
        $wpdb->insert($wvd_table_name,
            array(
                // 'ip' => UserInfo::get_ip(),
                'h1_size' => 12,
                'h2_size' => 12,
                'h3_size' => 12,
                'h4_size' => 12,
                'p_size' => 12,
                'label_size' => 12,
                'link_size' => 12,
                'h1_color' => '#000000',
                'h2_color' => '#000000',
                'h3_color' => '#000000',
                'h4_color' => '#000000',
                'p_color' => '#000000',
                'label_color' => '#000000',
                'link_color' => '#000000',
                'link_hovercolor' => '#000000')
        );


}
// register hook
register_activation_hook(__FILE__, 'wcfsDb');

//############################## create database //##############################


// insert to table
function wcfs_colorPickerInsert()
{
    global $wpdb;
    // if (!current_user_can('manage_options')) {
    //     wp_die(__('You do not have sufficient permissions to access this page.'));
    // }
    // include plugin_dir_path(__FILE__) . 'includes/UserInfo.php';
if(isset($_POST['submit']))
{
    $wvd_table_name = $wpdb->prefix . 'font_color';
if (!isset($_POST['colorfontstyle'])) die("<br><br>Hmm .. looks like you didn't send any credentials.. No CSRF for you! ");
if (!wp_verify_nonce($_POST['colorfontstyle'],'colorfont-style')) die("<br><br>Hmm .. looks like you didn't send any credentials.. No CSRF for you! ");
    $wpdb->query($wpdb->prepare("DELETE FROM $wvd_table_name"));
        $wpdb->insert($wvd_table_name,
            array(
            	// 'ip' => UserInfo::get_ip(),
            	'h1_size' => sanitize_text_field($_POST['h1size']),
            	'h2_size' => sanitize_text_field($_POST['h2size']),
            	'h3_size' => sanitize_text_field($_POST['h3size']),
            	'h4_size' => sanitize_text_field($_POST['h4size']),
            	'p_size' => sanitize_text_field($_POST['psize']),
            	'label_size' => sanitize_text_field($_POST['labelsize']),
            	'link_size' => sanitize_text_field($_POST['linksize']),
            	'h1_color' => sanitize_text_field($_POST['h1color']),
            	'h2_color' => sanitize_text_field($_POST['h2color']),
            	'h3_color' => sanitize_text_field($_POST['h3color']),
            	'h4_color' => sanitize_text_field($_POST['h4color']),
            	'p_color' => sanitize_text_field($_POST['pcolor']),
            	'label_color' => sanitize_text_field($_POST['labelcolor']),
            	'link_color' => sanitize_text_field($_POST['linkcolor']),
            	'link_hovercolor' => sanitize_text_field($_POST['linkhovercolor']))
        );
}
}
// wcfs_colorPickerInsert();
// register_activation_hook(ini, 'wcfs_colorPickerInsert');
add_action ( 'admin_init', 'wcfs_colorPickerInsert');


function wcfs_showstyle()
{
global $wpdb;
$wvd_table_name = $wpdb->prefix . 'font_color';
$results = $wpdb->get_results("SELECT * FROM $wvd_table_name");
foreach ($results as $row) {
?>
<style type="text/css">
h1{font-size: <?php echo esc_html($row->h1_size); ?>px !important; color: <?php echo esc_html($row->h1_color); ?> !important;}
h2{font-size: <?php echo esc_html($row->h2_size); ?>px !important; color: <?php echo esc_html($row->h2_color); ?> !important;}
h3{font-size: <?php echo esc_html($row->h3_size); ?>px !important; color: <?php echo esc_html($row->h3_color); ?> !important;}
h4{font-size: <?php echo esc_html($row->h4_size); ?>px !important; color: <?php echo esc_html($row->h4_color); ?> !important;}
p{font-size: <?php echo esc_html($row->p_size); ?>px !important; color: <?php echo esc_html($row->p_color); ?> !important;}
label{font-size: <?php echo esc_html($row->label_size); ?>px !important; color: <?php echo esc_html($row->label_color); ?> !important;}
a{font-size: <?php echo esc_html($row->link_size); ?>px !important; color: <?php echo esc_html($row->link_color); ?> !important;}
a:hover{color: <?php echo esc_html($row->link_hovercolor); ?> !important;}
</style>
<?php
}
}
add_action('wp_head', 'wcfs_showstyle');

function run_change_font_size_color() {

	$plugin = new Change_Font_Size_Color();
	$plugin->run();

}
run_change_font_size_color();


//############################## 1 show menu at admin //##############################
add_action('admin_menu', 'wcfs_changefontColorandSizeMenu');
function wcfs_changefontColorandSizeMenu()
{
    add_options_page('Change Font Size and Color', 'Font Size & Color', 'manage_options', 'change-font-size-color', 'wcfs_plugin_options');
}

//############################## color picker //##############################
// Wordpress function 1
add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
// first check that $hook_suffix is appropriate for your admin page
wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'wcfs-colorpicker', plugins_url('admin/js/cfzc-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

// color picket 2
// <label>H1 Color</label><input type="text" name="h1color" value="#bada55" class="my-color-field" data-default-color="#effeff">

// color picket 3
// goto admin/js/cfzc-script.js
//############################## color picker //##############################






function wcfs_plugin_options()
{
?>
<style type="text/css">
.myWrap{width:90%; background-color: #fff; padding: 10px 20px 20px 20px;}
.myInput{background-color: white; border:none; border-radius:3px; font-size:12px; padding: 6px 10px; border: 1px solid}
.myWrap label{min-width: 80px;display: inline-block;}
.myWrap input[type="number"]{margin-right: 30px;}	
</style>
<div class="wrap">
<div class="myWrap">
<h2>Change font size and color</h2>
<p>You can change any text size and color for below options. This can override existing styling of theme.</p>
<form method="post">
<input name="colorfontstyle" type="hidden" value="<?php echo wp_create_nonce('colorfont-style'); ?>" />
    <?php 
    global $wpdb;
    $wvd_table_name = $wpdb->prefix . 'font_color';
    $results = $wpdb->get_results("SELECT * FROM $wvd_table_name");
    foreach ($results as $row) {
         ?>
<div>
<label>H1 Size</label><input type="number" name="h1size" value="<?php echo esc_attr($row->h1_size); ?>">
<label>H1 Color</label><input type="text" name="h1color" value="<?php echo esc_attr($row->h1_color); ?>" id="h1color" data-default-color="#effeff">
</div>
<div>
<label>H2 Size</label><input type="number" name="h2size" value="<?php echo esc_attr($row->h2_size); ?>">
<label>H2 Color</label><input type="text" name="h2color" value="<?php echo esc_attr($row->h2_color); ?>" id="h2color" data-default-color="#effeff">
</div>
<div>
<label>H3 Size</label><input type="number" name="h3size" value="<?php echo esc_attr($row->h3_size); ?>">
<label>H3 Color</label><input type="text" name="h3color" value="<?php echo esc_attr($row->h3_color); ?>" id="h3color" data-default-color="#effeff">
</div>
<div>
<label>H4 Size</label><input type="number" name="h4size" value="<?php echo esc_attr($row->h4_size); ?>">
<label>H4 Color</label><input type="text" name="h4color" value="<?php echo esc_attr($row->h4_color); ?>" id="h4color" data-default-color="#effeff">
</div>
<div>
<label>P Size</label><input type="number" name="psize" value="<?php echo esc_attr($row->p_size); ?>">
<label>P Color</label><input type="text" name="pcolor" value="<?php echo esc_attr($row->p_color); ?>" id="pcolor" data-default-color="#effeff">
</div>
<div>
<label>Label Size</label><input type="number" name="labelsize" value="<?php echo esc_attr($row->label_size); ?>">
<label>Lable Color</label><input type="text" name="labelcolor" value="<?php echo esc_attr($row->label_color); ?>" id="labelcolor" data-default-color="#effeff">
</div>
<div>
<label>Link Size</label><input type="number" name="linksize" value="<?php echo esc_attr($row->link_size); ?>">
<label>Link Color</label><input type="text" name="linkcolor"  value="<?php echo esc_attr($row->link_color); ?>" id="linkcolor" data-default-color="#effeff">
<label>Link Hover Color</label>
<input type="text" name="linkhovercolor" id="linkhovercolor" data-default-color="#effeff" value="<?php echo esc_attr($row->link_hovercolor); ?>">
</div>

<input type="submit" name="submit" value="Save Changes" class="myInput" onClick="window.location.reload()">
<?php 
}
 ?>
</form>
</div>
</div>
<?php }