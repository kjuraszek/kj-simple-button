<?php

/*
Plugin Name: Simple Floating Button
Plugin URI: https://portfolio.kjuraszek.pl
Description: Simple floating button.
Version: 0.1
Author: Krzysztof Juraszek
Author URI: https://portfolio.kjuraszek.pl
License: GPL-3.0+
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
Text Domain: kj-simple-button
*/

class KJ_Simple_Floating_Button {
	
	static $instance = false;
	static $default_options = array(
		"kj_simple_button_btn_active" => 1, 
		"kj_simple_button_advanced_mode" => 0, 
		"kj_simple_button_height_value" => 100, 
		"kj_simple_button_height_unit" => "px", 
		"kj_simple_button_width_value" => 100, 
		"kj_simple_button_width_unit" => "px",
		"kj_simple_button_horizontal_position" => "left", 
		"kj_simple_button_horizontal_position_value" => 0,  
		"kj_simple_button_horizontal_position_unit" => "px",
		"kj_simple_button_vertical_position" => "bottom", 
		"kj_simple_button_vertical_position_value" => 0,  
		"kj_simple_button_vertical_position_unit" => "px",
		"kj_simple_button_text_align_value" => "center", 
		"kj_simple_button_font_size_value" => 12, 
		"kj_simple_button_font_size_unit" => "px",
		"kj_simple_button_font_family_main" => "Arial Black",
		"kj_simple_button_font_family_fallback" => "sans-serif",
		"kj_simple_button_font_color" => "#ffffff",
		"kj_simple_button_background_color" => "#2d2d2d",
		"kj_simple_button_line_height_value" => 16, 
		"kj_simple_button_line_height_unit" => "px",
		"kj_simple_button_opacity_value" => 1,
		
		"kj_simple_button_padding_top_value" => 5,
		"kj_simple_button_padding_top_unit" => "px",
		"kj_simple_button_padding_right_value" => 5,
		"kj_simple_button_padding_right_unit" => "px",
		"kj_simple_button_padding_bottom_value" => 5,
		"kj_simple_button_padding_bottom_unit" => "px",
		"kj_simple_button_padding_left_value" => 5,
		"kj_simple_button_padding_left_unit" => "px",
		
		"kj_simple_button_margin_top_value" => 5,
		"kj_simple_button_margin_top_unit" => "px",
		"kj_simple_button_margin_right_value" => 5,
		"kj_simple_button_margin_right_unit" => "px",
		"kj_simple_button_margin_bottom_value" => 5,
		"kj_simple_button_margin_bottom_unit" => "px",
		"kj_simple_button_margin_left_value" => 5,
		"kj_simple_button_margin_left_unit" => "px",
		
		"kj_simple_button_border_value" => 0,
		"kj_simple_button_border_unit" => "px",
		"kj_simple_button_border_style" => "solid",
		"kj_simple_button_border_color" => "#d8e2ff",
		
		"kj_simple_button_border_radius_top_left_value" => 0,
		"kj_simple_button_border_radius_top_left_unit" => "px",
		"kj_simple_button_border_radius_top_right_value" => 0,
		"kj_simple_button_border_radius_top_right_unit" => "px",
		"kj_simple_button_border_radius_bottom_right_value" => 0,
		"kj_simple_button_border_radius_bottom_right_unit" => "px",
		"kj_simple_button_border_radius_bottom_left_value" => 0,
		"kj_simple_button_border_radius_bottom_left_unit" => "px",
		
		"kj_simple_button_resolution_max_575" => 1,
		"kj_simple_button_resolution_min_576" => 1,
		"kj_simple_button_resolution_min_768" => 1,
		"kj_simple_button_resolution_min_992" => 1,
		"kj_simple_button_resolution_min_1200" => 1,
		
		"kj_simple_button_transition_duration" => 0,
		"kj_simple_button_transition_timing_function" => "linear",
		"kj_simple_button_transition_delay" => 0,
		
		"kj_simple_button_hover_font_color_change" => 0,
		"kj_simple_button_hover_font_color" => "#ffffff",
		"kj_simple_button_hover_background_color_change" => 0,
		"kj_simple_button_hover_background_color" => "#2d2d2d",
		"kj_simple_button_hover_opacity_change" => 0,
		"kj_simple_button_hover_opacity_value" => 1,
		"kj_simple_button_hover_border_change" => 0,
		"kj_simple_button_hover_border_value" => 0,
		"kj_simple_button_hover_border_unit" => "px",
		"kj_simple_button_hover_border_style" => "solid",
		"kj_simple_button_hover_border_color" => "#d8e2ff",

		
		"kj_simple_button_href_value" => "#", 
		"kj_simple_button_rel_value" => "", 
		"kj_simple_button_target_value" => "", 
		"kj_simple_button_content_value" => "",
		"kj_simple_button_disabled_posts" => "");
		
		
    public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'kj_simple_button_enqueue_scripts') );
		add_action( 'admin_enqueue_scripts', array( $this, 'kj_simple_button_admin_enqueue_scripts') );
		add_action( 'admin_menu', array($this, 'kj_simple_button_add_admin_menu') );
		add_action( 'admin_init', array($this, 'kj_simple_button_settings_init') );
		add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), array($this, 'kj_simple_button_add_plugin_page_settings_link') );
		add_action( 'update_option_kj_simple_button_settings' , array($this, 'kj_simple_button_update_stylesheet') , 10 , 3);
		add_action( 'wp_footer' , array($this, 'kj_simple_button_append_button') );
		$this->plugin_options = get_option( "kj_simple_button_settings" );
    }

	public static function getInstance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}
	
	public static function kj_simple_button_activate() {
		register_uninstall_hook(__FILE__, array('KJ_Simple_Floating_Button', 'kj_simple_button_uninstall' ));
		if(!file_exists( plugin_dir_path(__FILE__) . "assets/css/custom-style.css" )){
			$handle = fopen(plugin_dir_path(__FILE__) . "assets/css/custom-style.css", "w");
			$creation_date = date('Y-m-d H:i:s', strtotime(current_time('mysql')));
			$css_header = <<< EOD
/* THIS FILE IS GENERATED AUTOMATICALLY VIA PLUGIN, DO NOT EDIT */
/* GENERATED: $creation_date */
EOD;
			fwrite($handle, $css_header);
			fclose($handle);
		}
		$default_options = self::$default_options;
		$current_options = $this->plugin_options;
		if(isset($current_options) && (!empty($current_options))){
			if(!empty(array_diff_key($default_options, $current_options))){
				foreach($default_options as $key => $value){
					if(!isset($current_options[$key])){
						$current_options[$key] = $value;
					}
				}
				update_option( "kj_simple_button_settings", $current_options );
			}
		} else {
			add_option( "kj_simple_button_settings" , $default_options);
		}
		
		
	}

	public static function kj_simple_button_uninstall() {
		delete_option( "kj_simple_button_settings" );
	}

	public function kj_simple_button_update_stylesheet() {
		$this->plugin_options = get_option( "kj_simple_button_settings" );
		$browser_prefixes = array("-webkit-", "-moz-", "-ms-", "-o-", "");
		$handle = fopen(plugin_dir_path(__FILE__) . "assets/css/custom-style.css", "w");
		$creation_date = date('Y-m-d H:i:s', strtotime(current_time('mysql')));
		$css_header = <<< EOD
/* THIS FILE IS GENERATED AUTOMATICALLY VIA PLUGIN OPTIONS, DO NOT EDIT */
/* GENERATED: $creation_date */
a#kj-simple-button{\n
EOD;
		fwrite($handle, $css_header);
		$height_css = "\theight: " . ($this->kj_simple_button_get_option('kj_simple_button_height_unit', false) === "auto" ? "" : $this->kj_simple_button_get_option('kj_simple_button_height_value', false)) . $this->kj_simple_button_get_option('kj_simple_button_height_unit', false) . ";\n";
		fwrite($handle, $height_css);
		$width_css = "\twidth: " . ($this->kj_simple_button_get_option('kj_simple_button_width_unit', false) === "auto" ? "" : $this->kj_simple_button_get_option('kj_simple_button_width_value', false)) . $this->kj_simple_button_get_option('kj_simple_button_width_unit', false) . ";\n";
		fwrite($handle, $width_css);
		
		fwrite($handle, "\t" . $this->kj_simple_button_get_option('kj_simple_button_horizontal_position', false) . ": " . $this->kj_simple_button_get_option('kj_simple_button_horizontal_position_value', false) . $this->kj_simple_button_get_option('kj_simple_button_horizontal_position_unit', false) . ";\n");
		fwrite($handle, "\t" . $this->kj_simple_button_get_option('kj_simple_button_vertical_position', false) . ": " . $this->kj_simple_button_get_option('kj_simple_button_vertical_position_value', false) . $this->kj_simple_button_get_option('kj_simple_button_vertical_position_unit', false) . ";\n");
		fwrite($handle, "\ttext-align: " . $this->kj_simple_button_get_option('kj_simple_button_text_align_value', false) . ";\n");
		
		fwrite($handle, "\tfont-size: " . $this->kj_simple_button_get_option('kj_simple_button_font_size_value', false) . $this->kj_simple_button_get_option('kj_simple_button_font_size_unit', false) . ";\n");
		fwrite($handle, "\tfont-family: '" . $this->kj_simple_button_get_option('kj_simple_button_font_family_main', false) . "', " . $this->kj_simple_button_get_option('kj_simple_button_font_family_fallback', false) . ";\n");
		
		fwrite($handle, "\tcolor: " . $this->kj_simple_button_get_option('kj_simple_button_font_color', false) . ";\n");
		fwrite($handle, "\tbackground: " . ($this->kj_simple_button_get_option('kj_simple_button_background_color', true) === "" ? "none" : $this->kj_simple_button_get_option('kj_simple_button_background_color', true)) . ";\n");
		
		fwrite($handle, "\tline-height: " . $this->kj_simple_button_get_option('kj_simple_button_line_height_value', false) . $this->kj_simple_button_get_option('kj_simple_button_line_height_unit', false) . ";\n");
		
		fwrite($handle, "\topacity: " . $this->kj_simple_button_get_option('kj_simple_button_opacity_value', false) . ";\n");

		fwrite($handle, "\tpadding-top: " . $this->kj_simple_button_get_option('kj_simple_button_padding_top_value', false) . $this->kj_simple_button_get_option('kj_simple_button_padding_top_unit', false) . ";\n");
		fwrite($handle, "\tpadding-right: " . $this->kj_simple_button_get_option('kj_simple_button_padding_right_value', false) . $this->kj_simple_button_get_option('kj_simple_button_padding_right_unit', false) . ";\n");
		fwrite($handle, "\tpadding-bottom: " . $this->kj_simple_button_get_option('kj_simple_button_padding_bottom_value', false) . $this->kj_simple_button_get_option('kj_simple_button_padding_bottom_unit', false) . ";\n");
		fwrite($handle, "\tpadding-left: " . $this->kj_simple_button_get_option('kj_simple_button_padding_left_value', false) . $this->kj_simple_button_get_option('kj_simple_button_padding_left_unit', false) . ";\n");

		$margin_top_css = "\tmargin-top: " . ($this->kj_simple_button_get_option('kj_simple_button_margin_top_unit', false) === "auto" ? "" : $this->kj_simple_button_get_option('kj_simple_button_margin_top_value', false)) . $this->kj_simple_button_get_option('kj_simple_button_margin_top_unit', false) . ";\n";
		fwrite($handle, $margin_top_css);
		$margin_right_css = "\tmargin-right: " . ($this->kj_simple_button_get_option('kj_simple_button_margin_right_unit', false) === "auto" ? "" : $this->kj_simple_button_get_option('kj_simple_button_margin_right_value', false)) . $this->kj_simple_button_get_option('kj_simple_button_margin_right_unit', false) . ";\n";
		fwrite($handle, $margin_right_css);
		$margin_bottom_css = "\tmargin-bottom: " . ($this->kj_simple_button_get_option('kj_simple_button_margin_bottom_unit', false) === "auto" ? "" : $this->kj_simple_button_get_option('kj_simple_button_margin_bottom_value', false)) . $this->kj_simple_button_get_option('kj_simple_button_margin_bottom_unit', false) . ";\n";
		fwrite($handle, $margin_bottom_css);
		$margin_left_css = "\tmargin-left: " . ($this->kj_simple_button_get_option('kj_simple_button_margin_left_unit', false) === "auto" ? "" : $this->kj_simple_button_get_option('kj_simple_button_margin_left_value', false)) . $this->kj_simple_button_get_option('kj_simple_button_margin_left_unit', false) . ";\n";
		fwrite($handle, $margin_left_css);
		$border_css = "\tborder: " . $this->kj_simple_button_get_option('kj_simple_button_border_value', false) . $this->kj_simple_button_get_option('kj_simple_button_border_unit', false) . " " . $this->kj_simple_button_get_option('kj_simple_button_border_style', false). " " . $this->kj_simple_button_get_option('kj_simple_button_border_color', true) . ";\n";
		fwrite($handle, $border_css);
		$border_radius_css = "\tborder-radius: " . $this->kj_simple_button_get_option('kj_simple_button_border_radius_top_left_value', false) . $this->kj_simple_button_get_option('kj_simple_button_border_radius_top_left_unit', false) . " " . $this->kj_simple_button_get_option('kj_simple_button_border_radius_top_right_value', false) . $this->kj_simple_button_get_option('kj_simple_button_border_radius_top_right_unit', false) . " " . $this->kj_simple_button_get_option('kj_simple_button_border_radius_bottom_right_value', false) . $this->kj_simple_button_get_option('kj_simple_button_border_radius_bottom_right_unit', false) . " " . $this->kj_simple_button_get_option('kj_simple_button_border_radius_bottom_left_value', false) . $this->kj_simple_button_get_option('kj_simple_button_border_radius_bottom_left_unit', false) . ";\n";
		fwrite($handle, $border_radius_css);
		
		$transition_css = "";
		foreach($browser_prefixes as $b){
			$transition_css .= "\t" . $b ."transition: all " . $this->kj_simple_button_get_option('kj_simple_button_transition_duration', false) . "s " . $this->kj_simple_button_get_option('kj_simple_button_transition_timing_function', false) . " " . $this->kj_simple_button_get_option('kj_simple_button_transition_delay', false) . "s;\n";
		}

		fwrite($handle, $transition_css);
		
		fwrite($handle, "}\n");
		
		
		if($this->kj_simple_button_get_option('kj_simple_button_hover_font_color_change', true) === '1' || $this->kj_simple_button_get_option('kj_simple_button_hover_background_color_change', true) === '1' || $this->kj_simple_button_get_option('kj_simple_button_hover_opacity_change', true) === '1' || $this->kj_simple_button_get_option('kj_simple_button_hover_border_change', true) === '1' ){
			$hover_css = "a#kj-simple-button:hover{\n";
			if($this->kj_simple_button_get_option('kj_simple_button_hover_font_color_change', true) === '1'){
				$hover_css .= "\tcolor: " . $this->kj_simple_button_get_option('kj_simple_button_hover_font_color', false) . ";\n";
			}
			if($this->kj_simple_button_get_option('kj_simple_button_hover_background_color_change', true) === '1'){
				$hover_css .= "\tbackground: " . ($this->kj_simple_button_get_option('kj_simple_button_hover_background_color', true) === "" ? "none" : $this->kj_simple_button_get_option('kj_simple_button_hover_background_color', true)) . ";\n";
			}
			if($this->kj_simple_button_get_option('kj_simple_button_hover_opacity_change', true) === '1'){
				$hover_css .= "\topacity: " . $this->kj_simple_button_get_option('kj_simple_button_hover_opacity_value', false) . ";\n";
			}
			if($this->kj_simple_button_get_option('kj_simple_button_hover_border_change', true) === '1'){
				$hover_css .=  "\tborder: " . $this->kj_simple_button_get_option('kj_simple_button_hover_border_value', false) . $this->kj_simple_button_get_option('kj_simple_button_hover_border_unit', false) . " " . $this->kj_simple_button_get_option('kj_simple_button_hover_border_style', false). " " . $this->kj_simple_button_get_option('kj_simple_button_hover_border_color', true) . ";\n";
			}
			$hover_css .= "}\n";
			fwrite($handle, $hover_css);
		} 


		$resolutions_css = 
'@media (max-width:575px){a#kj-simple-button{display:'. (($this->kj_simple_button_get_option('kj_simple_button_resolution_max_575', true) === '1')?"block":"none").";}}\n".
'@media (min-width:576px){a#kj-simple-button{display:'. (($this->kj_simple_button_get_option('kj_simple_button_resolution_min_576', true) === '1')?"block":"none").";}}\n".
'@media (min-width:768px){a#kj-simple-button{display:'. (($this->kj_simple_button_get_option('kj_simple_button_resolution_min_768', true) === '1')?"block":"none").";}}\n".
'@media (min-width:992px){a#kj-simple-button{display:'. (($this->kj_simple_button_get_option('kj_simple_button_resolution_min_992', true) === '1')?"block":"none").";}}\n".
'@media (min-width:1200px){a#kj-simple-button{display:'. (($this->kj_simple_button_get_option('kj_simple_button_resolution_min_1200', true) === '1')?"block":"none").";}}\n";
		fwrite($handle, $resolutions_css);
		
		

		fclose($handle);
	}

    public function kj_simple_button_enqueue_scripts() {
		wp_enqueue_style('KJ_Simple_Floating_Button', plugins_url('assets/css/style.css', __FILE__), null, '');
		wp_enqueue_style('KJ_Simple_Floating_Button_custom', plugins_url('assets/css/custom-style.css', __FILE__), null, '');

	}
	
	public function kj_simple_button_admin_enqueue_scripts() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script('KJ_Simple_Floating_Button_admin_js', plugins_url('admin/js/admin.js', __FILE__), array('jquery', 'wp-color-picker' ));
	}
	
	public function kj_simple_button_add_admin_menu(  ) { 
		add_options_page( 'KJ Simple Button', 'KJ Simple Button', 'manage_options', 'kj_simple_button', array($this, 'kj_simple_button_options_page') );
	}
	
	public function kj_simple_button_add_plugin_page_settings_link( $plugin_links ) {
		$plugin_links[] = '<a href="' .
			admin_url( 'options-general.php?page=kj_simple_button' ) .
			'">' . __('Settings') . '</a>';
		return $plugin_links;
	}

	public function kj_simple_button_append_button(){
		global $post;
		$current_options = $this->plugin_options;
		
		$disabled_ids = explode(",", $current_options['kj_simple_button_disabled_posts']);
		if(!isset($current_options['kj_simple_button_btn_active']) || $current_options['kj_simple_button_btn_active'] !== '1' || (isset($post) && in_array($post->ID, $disabled_ids))){
			return false;
		}
		echo '<!-- #kj-simple-button -->';
		echo '<a ';
		echo !empty($this->kj_simple_button_get_option('kj_simple_button_href_value', true)) ? 'href="' . $this->kj_simple_button_get_option('kj_simple_button_href_value', true) . '" ' : '' ;
		echo !empty($this->kj_simple_button_get_option('kj_simple_button_rel_value', true)) ? 'rel="' . $this->kj_simple_button_get_option('kj_simple_button_rel_value', true) . '" ' : '' ;
		echo !empty($this->kj_simple_button_get_option('kj_simple_button_target_value', true)) ? 'target="' . $this->kj_simple_button_get_option('kj_simple_button_target_value', true) . '" ' : '' ;
		echo 'id="kj-simple-button" >';
		echo !empty($this->kj_simple_button_get_option('kj_simple_button_content_value', true)) ? $this->kj_simple_button_get_option('kj_simple_button_content_value', true) : '' ;
		echo '</a>';
	}

	public function kj_simple_button_get_option($option_name, $empty) {
		$default_options  = self::$default_options;
		$current_options = $this->plugin_options;
		if(isset($current_options[$option_name]) && ($empty || strval($current_options[$option_name]) === "0" || !empty($current_options[$option_name]))){ 
			return $current_options[$option_name];
		} elseif(!$empty) {
			return $default_options[$option_name];
		} else {
			return "";
		}
	}

	public function kj_simple_button_settings_init(  ) {
			
		$current_options = $this->plugin_options;
		$advanced_mode_class = (!isset($current_options['kj_simple_button_advanced_mode']) || $current_options['kj_simple_button_advanced_mode'] !== '1') ? 'hidden advanced-option' : 'advanced-option';
		
		register_setting( 
		'kjSettingsPage', 
		'kj_simple_button_settings',
		array($this, 'kj_simple_button_settings_validation')
		);
		add_settings_section(
			'kj_simple_button_kjSettingsPage_section_main', 
			__( 'Main settings', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_settings_section_callback'), 
			'kjSettingsPage'
		);
		
		add_settings_field( 
			'kj_simple_button_btn_active_field', 
			__( 'Button activated', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_btn_active_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_main' 
		);
		add_settings_field( 
			'kj_simple_button_advanced_mode_field', 
			__( 'Advanced mode', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_advanced_mode_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_main'
		);
		add_settings_section(
			'kj_simple_button_kjSettingsPage_section_style', 
			__( 'Style settings', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_settings_section_callback'), 
			'kjSettingsPage'
		);

		add_settings_field( 
			'kj_simple_button_height_field', 
			__( 'Height', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_height_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_width_field', 
			__( 'Width', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_width_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_horizontal_position', 
			__( 'Horizontal position', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_horizontal_position_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_vertical_position', 
			__( 'Vertical position', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_vertical_position_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_text_align', 
			__( 'Text align', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_text_align_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_font_size', 
			__( 'Font size', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_font_size_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_font_family', 
			__( 'Font family', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_font_family_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_font_color', 
			__( 'Font color', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_font_color_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_background_color', 
			__( 'Background color', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_background_color_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_line_height', 
			__( 'Line height', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_line_height_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_opacity', 
			__( 'Opacity', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_opacity_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_padding', 
			__( 'Padding', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_padding_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_margin', 
			__( 'Margin', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_margin_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_border', 
			__( 'Border', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_border_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_border_radius', 
			__( 'Border radius', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_border_radius_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_resolutions', 
			__( 'Resolutions', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_resolutions_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_transition_field', 
			__( 'Transition', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_transition_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_hover_field', 
			__( 'Style on hover', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_hover_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style',
			array('class' => $advanced_mode_class) 
		);
		add_settings_section(
			'kj_simple_button_kjSettingsPage_section_misc', 
			__( 'Miscellaneous settings', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_settings_section_callback'), 
			'kjSettingsPage'
		);
		add_settings_field( 
			'kj_simple_button_href_field', 
			__( 'Href', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_href_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_misc' 
		);
		add_settings_field( 
			'kj_simple_button_rel_field', 
			__( 'Rel', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_rel_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_misc',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_target_field', 
			__( 'Target', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_target_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_misc',
			array('class' => $advanced_mode_class) 
		);
		add_settings_field( 
			'kj_simple_button_content_field', 
			__( 'Content', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_content_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_misc' 
		);
		add_settings_field( 
			'kj_simple_button_disabled_posts_field', 
			__( 'Disabled posts', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_disabled_posts_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_misc',
			array('class' => $advanced_mode_class) 
		);
	}
	
	function kj_simple_button_btn_active_field_render(  ) { 
	
		$btn_active = $this->kj_simple_button_get_option('kj_simple_button_btn_active', true);

		?>
		<p><label><input type='checkbox' name='kj_simple_button_settings[kj_simple_button_btn_active]' <?php checked( $btn_active, 1 ); ?> value='1'>
		Enable or disable button.</label></p>
		
		<?php

	}
	
	function kj_simple_button_advanced_mode_field_render(  ) { 
	
		$advanced_mode = $this->kj_simple_button_get_option('kj_simple_button_advanced_mode', true);

		?>
		<p><label><input type='checkbox' name='kj_simple_button_settings[kj_simple_button_advanced_mode]' <?php checked( $advanced_mode, 1 ); ?> value='1'>
		Advanced mode (show/hide some settings).</label></p>
		
		<?php

	}


	public function kj_simple_button_height_field_render(  ) { 

		$height = $this->kj_simple_button_get_option('kj_simple_button_height_value', false);
		$height_unit = $this->kj_simple_button_get_option('kj_simple_button_height_unit', false);
		
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_height_value]'  min='0' step='0.1' value=<?php echo $height; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_height_unit]' class='select_with_auto_option' select-for='height'> 
			<option value='px' <?php selected( $height_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $height_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $height_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $height_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $height_unit, 'auto' ); ?>>auto</option>
		</select>
		<p><em>Height of a button</em></p>
		<?php

	}

	public function kj_simple_button_width_field_render(  ) { 

		$width = $this->kj_simple_button_get_option('kj_simple_button_width_value', false);
		$width_unit = $this->kj_simple_button_get_option('kj_simple_button_width_unit', false);
		
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_width_value]' min='0' step='0.1' value=<?php echo $width; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_width_unit]' class='select_with_auto_option' select-for='width'> 
			<option value='px' <?php selected( $width_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $width_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $width_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $width_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $width_unit, 'auto' ); ?>>auto</option>
		</select>
		<p><em>Width of a button</em></p>
		<?php

	}

	public function kj_simple_button_horizontal_position_field_render(  ) { 


		$position = $this->kj_simple_button_get_option('kj_simple_button_horizontal_position', false);
		$position_value = $this->kj_simple_button_get_option('kj_simple_button_horizontal_position_value', false);
		$position_unit = $this->kj_simple_button_get_option('kj_simple_button_horizontal_position_unit', false);
		
		?>
		<select name='kj_simple_button_settings[kj_simple_button_horizontal_position]'> 
			<option value='left' <?php selected( $position, 'left' ); ?>>left</option>
			<option value='right' <?php selected( $position, 'right' ); ?>>right</option>
		</select>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_horizontal_position_value]' min='0' step='0.1' value=<?php echo $position_value; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_horizontal_position_unit]'> 
			<option value='px' <?php selected( $position_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $position_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $position_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $position_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Horizontal position of a button</em></p>
		<?php

	}
	
	public function kj_simple_button_vertical_position_field_render(  ) { 


		$position = $this->kj_simple_button_get_option('kj_simple_button_vertical_position', false);
		$position_value = $this->kj_simple_button_get_option('kj_simple_button_vertical_position_value', false);
		$position_unit = $this->kj_simple_button_get_option('kj_simple_button_vertical_position_unit', false);
		
		?>
		<select name='kj_simple_button_settings[kj_simple_button_vertical_position]'> 
			<option value='top' <?php selected( $position, 'top' ); ?>>top</option>
			<option value='bottom' <?php selected( $position, 'bottom' ); ?>>bottom</option>
		</select>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_vertical_position_value]' min='0' step='0.1' value=<?php echo $position_value; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_vertical_position_unit]'> 
			<option value='px' <?php selected( $position_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $position_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $position_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $position_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Vertical position of a button</em></p>
		<?php

	}
	
	public function kj_simple_button_text_align_field_render(  ) { 

		$text_align = $this->kj_simple_button_get_option('kj_simple_button_text_align_value', false);
		
		?>
		<select name='kj_simple_button_settings[kj_simple_button_text_align_value]'> 
			<option value='left' <?php selected( $text_align, 'left' ); ?>>left</option>
			<option value='right' <?php selected( $text_align, 'right' ); ?>>right</option>
			<option value='center' <?php selected( $text_align, 'center' ); ?>>center</option>
			<option value='justify' <?php selected( $text_align, 'justify' ); ?>>justify</option>
		</select>
		<p><em>Text align</em></p>
		<?php

	}
	
	public function kj_simple_button_font_size_field_render(  ) { 


		$font_size = $this->kj_simple_button_get_option('kj_simple_button_font_size_value', false);
		$font_size_unit = $this->kj_simple_button_get_option('kj_simple_button_font_size_unit', false);
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_font_size_value]' min='0' step='0.1' value=<?php echo $font_size; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_font_size_unit]'> 
			<option value='px' <?php selected( $font_size_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $font_size_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $font_size_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $font_size_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Font size</em></p>
		<?php

	}
	
	
	public function kj_simple_button_font_family_field_render(  ) { 


		$font_family_main = $this->kj_simple_button_get_option('kj_simple_button_font_family_main', false);
		$font_family_fallback = $this->kj_simple_button_get_option('kj_simple_button_font_family_fallback', false);
		?>
		
		<select name='kj_simple_button_settings[kj_simple_button_font_family_main]'> 
			<option value='Arial' <?php selected( $font_family_main, 'Arial' ); ?>>Arial</option>
			<option value='Arial Black' <?php selected( $font_family_main, 'Arial Black' ); ?>>Arial Black</option>
			<option value='Roboto' <?php selected( $font_family_main, 'Roboto' ); ?>>Roboto</option>
			<option value='Times New Roman' <?php selected( $font_family_main, 'Times New Roman' ); ?>>Times New Roman</option>
			<option value='Times' <?php selected( $font_family_main, 'Times' ); ?>>Times</option>
			<option value='Courier New' <?php selected( $font_family_main, 'Courier New' ); ?>>Courier New</option>
			<option value='Courier' <?php selected( $font_family_main, 'Courier' ); ?>>Courier</option>
			<option value='Verdana' <?php selected( $font_family_main, 'Verdana' ); ?>>Verdana</option>
			<option value='Georgia' <?php selected( $font_family_main, 'Georgia' ); ?>>Georgia</option>
			<option value='Palatino' <?php selected( $font_family_main, 'Palatino' ); ?>>Palatino</option>
			<option value='Garamond' <?php selected( $font_family_main, 'Garamond' ); ?>>Garamond</option>
			<option value='Impact' <?php selected( $font_family_main, 'Impact' ); ?>>Impact</option>
			<option value='Comic Sans MS' <?php selected( $font_family_main, 'Comic Sans MS' ); ?>>Comic Sans MS</option>
		</select>
		<p><em>Main font</em></p><br>
		<select name='kj_simple_button_settings[kj_simple_button_font_family_fallback]'> 
			<option value='cursive' <?php selected( $font_family_fallback, 'cursive' ); ?>>cursive</option>
			<option value='fantasy' <?php selected( $font_family_fallback, 'fantasy' ); ?>>fantasy</option>
			<option value='monospace' <?php selected( $font_family_fallback, 'monospace' ); ?>>monospace</option>
			<option value='serif' <?php selected( $font_family_fallback, 'serif' ); ?>>serif</option>
			<option value='sans-serif' <?php selected( $font_family_fallback, 'sans-serif' ); ?>>sans-serif</option>
		</select>
		<p><em>Fallback font</em></p><br>
		<?php

	}
	
	public function kj_simple_button_font_color_field_render(  ) { 


		$font_color = $this->kj_simple_button_get_option('kj_simple_button_font_color', false);

		?>
		<input type='text' name='kj_simple_button_settings[kj_simple_button_font_color]' class="kj_simple_button_color_picker" data-default-color="#ffffff" value="<?php echo $font_color; ?>">
		<p><em>Font color</em></p><br>
		
		<?php

	}
	
	public function kj_simple_button_background_color_field_render(  ) { 


		$background_color = $this->kj_simple_button_get_option('kj_simple_button_background_color', true);

		?>
		<input type='text' name='kj_simple_button_settings[kj_simple_button_background_color]' class="kj_simple_button_color_picker" data-default-color="#2d2d2d"  value="<?php echo $background_color; ?>">
		<p><em>Background color (leave empty for no background)</em></p><br>
		
		<?php

	}
	
	public function kj_simple_button_line_height_field_render(  ) { 


		$line_height = $this->kj_simple_button_get_option('kj_simple_button_line_height_value', false);
		$line_height_unit = $this->kj_simple_button_get_option('kj_simple_button_line_height_unit', false);
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_line_height_value]' min='0' step='0.1' value=<?php echo $line_height; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_line_height_unit]'> 
			<option value='px' <?php selected( $line_height_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $line_height_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $line_height_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $line_height_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Line height</em></p>
		<?php

	}
	
	public function kj_simple_button_opacity_field_render(  ) { 


		$opacity = $this->kj_simple_button_get_option('kj_simple_button_opacity_value', false);
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_opacity_value]' min='0' step='0.1' max='1.0' value=<?php echo $opacity; ?>>
		<p><em>Opacity</em></p>
		<?php

	}
	
	public function kj_simple_button_padding_field_render(  ) { 


		$padding_top = $this->kj_simple_button_get_option('kj_simple_button_padding_top_value', false);
		$padding_top_unit = $this->kj_simple_button_get_option('kj_simple_button_padding_top_unit', false);
		$padding_right = $this->kj_simple_button_get_option('kj_simple_button_padding_right_value', false);
		$padding_right_unit = $this->kj_simple_button_get_option('kj_simple_button_padding_right_unit', false);
		$padding_bottom = $this->kj_simple_button_get_option('kj_simple_button_padding_bottom_value', false);
		$padding_bottom_unit = $this->kj_simple_button_get_option('kj_simple_button_padding_bottom_unit', false);
		$padding_left = $this->kj_simple_button_get_option('kj_simple_button_padding_left_value', false);
		$padding_left_unit = $this->kj_simple_button_get_option('kj_simple_button_padding_left_unit', false);
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_padding_top_value]' min='0' step='0.1' value=<?php echo $padding_top; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_padding_top_unit]'> 
			<option value='px' <?php selected( $padding_top_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $padding_top_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $padding_top_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $padding_top_unit, 'rem' ); ?>>rem</option>
		</select> <a class="button-secondary button-set-for-all" button-for="padding" >Set this value for all</a>
		<p><em>Padding top</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_padding_right_value]' min='0' step='0.1' value=<?php echo $padding_right; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_padding_right_unit]'> 
			<option value='px' <?php selected( $padding_right_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $padding_right_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $padding_right_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $padding_right_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Padding right</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_padding_bottom_value]' min='0' step='0.1' value=<?php echo $padding_bottom; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_padding_bottom_unit]'> 
			<option value='px' <?php selected( $padding_bottom_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $padding_bottom_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $padding_bottom_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $padding_bottom_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Padding botton</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_padding_left_value]' min='0' step='0.1' value=<?php echo $padding_left; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_padding_left_unit]'> 
			<option value='px' <?php selected( $padding_left_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $padding_left_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $padding_left_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $padding_left_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Padding left</em></p><br>
		<?php

	}
	
	public function kj_simple_button_margin_field_render(  ) { 


		$margin_top = $this->kj_simple_button_get_option('kj_simple_button_margin_top_value', false);
		$margin_top_unit = $this->kj_simple_button_get_option('kj_simple_button_margin_top_unit', false);
		$margin_right = $this->kj_simple_button_get_option('kj_simple_button_margin_right_value', false);
		$margin_right_unit = $this->kj_simple_button_get_option('kj_simple_button_margin_right_unit', false);
		$margin_bottom = $this->kj_simple_button_get_option('kj_simple_button_margin_bottom_value', false);
		$margin_bottom_unit = $this->kj_simple_button_get_option('kj_simple_button_margin_bottom_unit', false);
		$margin_left = $this->kj_simple_button_get_option('kj_simple_button_margin_left_value', false);
		$margin_left_unit = $this->kj_simple_button_get_option('kj_simple_button_margin_left_unit', false);
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_margin_top_value]' step='0.1' value=<?php echo $margin_top; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_margin_top_unit]' class='select_with_auto_option' select-for='margin_top'> 
			<option value='px' <?php selected( $margin_top_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $margin_top_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $margin_top_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $margin_top_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $margin_top_unit, 'auto' ); ?>>auto</option>
		</select> <a class="button-secondary button-set-for-all" button-for="margin" >Set this value for all</a>
		<p><em>Margin top</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_margin_right_value]' step='0.1' value=<?php echo $margin_right; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_margin_right_unit]' class='select_with_auto_option' select-for='margin_right'> 
			<option value='px' <?php selected( $margin_right_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $margin_right_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $margin_right_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $margin_right_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $margin_right_unit, 'auto' ); ?>>auto</option>
		</select>
		<p><em>Margin right</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_margin_bottom_value]' step='0.1' value=<?php echo $margin_bottom; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_margin_bottom_unit]' class='select_with_auto_option' select-for='margin_bottom'> 
			<option value='px' <?php selected( $margin_bottom_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $margin_bottom_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $margin_bottom_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $margin_bottom_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $margin_bottom_unit, 'auto' ); ?>>auto</option>
		</select>
		<p><em>Margin bottom</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_margin_left_value]' step='0.1' value=<?php echo $margin_left; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_margin_left_unit]' class='select_with_auto_option' select-for='margin_left'> 
			<option value='px' <?php selected( $margin_left_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $margin_left_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $margin_left_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $margin_left_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $margin_left_unit, 'auto' ); ?>>auto</option>
		</select>
		<p><em>Margin left</em></p><br>
		<?php

	}
	
	public function kj_simple_button_border_field_render(  ) { 


		$border_value = $this->kj_simple_button_get_option('kj_simple_button_border_value', false);
		$border_unit = $this->kj_simple_button_get_option('kj_simple_button_border_unit', false);
		$border_style = $this->kj_simple_button_get_option('kj_simple_button_border_style', false);
		$border_color = $this->kj_simple_button_get_option('kj_simple_button_border_color', true);

		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_border_value]' min='0' step='0.1' value=<?php echo $border_value; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_border_unit]'> 
			<option value='px' <?php selected( $border_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $border_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $border_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $border_unit, 'rem' ); ?>>rem</option>
		</select>
		
		<select name='kj_simple_button_settings[kj_simple_button_border_style]'> 
			<option value='dotted' <?php selected( $border_style, 'dotted' ); ?>>dotted</option>
			<option value='dashed' <?php selected( $border_style, 'dashed' ); ?>>dashed</option>
			<option value='solid' <?php selected( $border_style, 'solid' ); ?>>solid</option>
			<option value='double' <?php selected( $border_style, 'double' ); ?>>double</option>
			<option value='groove' <?php selected( $border_style, 'groove' ); ?>>groove</option>
			<option value='ridge' <?php selected( $border_style, 'ridge' ); ?>>ridge</option>
			<option value='inset' <?php selected( $border_style, 'inset' ); ?>>inset</option>
			<option value='outset' <?php selected( $border_style, 'outset' ); ?>>outset</option>
			<option value='none' <?php selected( $border_style, 'none' ); ?>>none</option>
			<option value='hidden' <?php selected( $border_style, 'hidden' ); ?>>hidden</option>
		</select>
		<input type='text' name='kj_simple_button_settings[kj_simple_button_border_color]' class="kj_simple_button_color_picker" data-default-color="#d8e2ff"  value="<?php echo $border_color; ?>">
		<p><em>Border styling</em></p><br>
		
		<?php

	}
	
	public function kj_simple_button_border_radius_field_render(  ) { 


		$border_radius_top_left = $this->kj_simple_button_get_option('kj_simple_button_border_radius_top_left_value', false);
		$border_radius_top_left_unit = $this->kj_simple_button_get_option('kj_simple_button_border_radius_top_left_unit', false);
		$border_radius_top_right = $this->kj_simple_button_get_option('kj_simple_button_border_radius_top_right_value', false);
		$border_radius_top_right_unit = $this->kj_simple_button_get_option('kj_simple_button_border_radius_top_right_unit', false);
		$border_radius_bottom_right = $this->kj_simple_button_get_option('kj_simple_button_border_radius_bottom_right_value', false);
		$border_radius_bottom_right_unit = $this->kj_simple_button_get_option('kj_simple_button_border_radius_bottom_right_unit', false);
		$border_radius_bottom_left = $this->kj_simple_button_get_option('kj_simple_button_border_radius_bottom_left_value', false);
		$border_radius_bottom_left_unit = $this->kj_simple_button_get_option('kj_simple_button_border_radius_bottom_left_unit', false);
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_border_radius_top_left_value]' min='0' step='0.1' value=<?php echo $border_radius_top_left; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_border_radius_top_left_unit]'> 
			<option value='px' <?php selected( $border_radius_top_left_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $border_radius_top_left_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $border_radius_top_left_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $border_radius_top_left_unit, 'rem' ); ?>>rem</option>
		</select> <a class="button-secondary button-set-for-all" button-for="border-radius" >Set this value for all</a>
		<p><em>Border radius top left</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_border_radius_top_right_value]' min='0' step='0.1' value=<?php echo $border_radius_top_right; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_border_radius_top_right_unit]'> 
			<option value='px' <?php selected( $border_radius_top_right_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $border_radius_top_right_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $border_radius_top_right_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $border_radius_top_right_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Border radius top right</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_border_radius_bottom_right_value]' min='0' step='0.1' value=<?php echo $border_radius_bottom_right; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_border_radius_bottom_right_unit]'> 
			<option value='px' <?php selected( $border_radius_bottom_right_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $border_radius_bottom_right_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $border_radius_bottom_right_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $border_radius_bottom_right_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Border radius bottom right</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_border_radius_bottom_left_value]' min='0' step='0.1' value=<?php echo $border_radius_bottom_left; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_border_radius_bottom_left_unit]'> 
			<option value='px' <?php selected( $border_radius_bottom_left_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $border_radius_bottom_left_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $border_radius_bottom_left_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $border_radius_bottom_left_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Border radius bottom left</em></p><br>
		
		<?php

	}
	
	function kj_simple_button_resolutions_field_render(  ) { 
	
		$resolution_max_575 = $this->kj_simple_button_get_option('kj_simple_button_resolution_max_575', true);
		$resolution_min_576 = $this->kj_simple_button_get_option('kj_simple_button_resolution_min_576', true);
		$resolution_min_768 = $this->kj_simple_button_get_option('kj_simple_button_resolution_min_768', true);
		$resolution_min_992 = $this->kj_simple_button_get_option('kj_simple_button_resolution_min_992', true);
		$resolution_min_1200 = $this->kj_simple_button_get_option('kj_simple_button_resolution_min_1200', true);

		?>
		<p><label><input type='checkbox' name='kj_simple_button_settings[kj_simple_button_resolution_max_575]' <?php checked( $resolution_max_575, 1 ); ?> value='1'>
		Button visible on screen width <strong>less than 576px.</strong></label></p><br>
		<p><label><input type='checkbox' name='kj_simple_button_settings[kj_simple_button_resolution_min_576]' <?php checked( $resolution_min_576, 1 ); ?> value='1'>
		Button visible on screen width <strong>greater or equal than 576px and less than 768px.</strong></label></p><br>
		<p><label><input type='checkbox' name='kj_simple_button_settings[kj_simple_button_resolution_min_768]' <?php checked( $resolution_min_768, 1 ); ?> value='1'>
		Button visible on screen width <strong>greater or equal than 768px and less than 992px.</strong></label></p><br>
		<p><label><input type='checkbox' name='kj_simple_button_settings[kj_simple_button_resolution_min_992]' <?php checked( $resolution_min_992, 1 ); ?> value='1'>
		Button visible on screen width <strong>greater or equal than 992px and less than 1200px.</strong></label></p><br>
		<p><label><input type='checkbox' name='kj_simple_button_settings[kj_simple_button_resolution_min_1200]' <?php checked( $resolution_min_1200, 1 ); ?> value='1'>
		Button visible on screen width <strong>greater or equal than 1200px.</strong></label></p><br>
		<?php

	}
	
	public function kj_simple_button_transition_field_render(  ) { 
		
		$duration = $this->kj_simple_button_get_option('kj_simple_button_transition_duration', false);
		$timing_function = $this->kj_simple_button_get_option('kj_simple_button_transition_timing_function', false);
		$delay = $this->kj_simple_button_get_option('kj_simple_button_transition_delay', false);
		
		?>

		<input type='number' name='kj_simple_button_settings[kj_simple_button_transition_duration]' min='0' step='0.1' value=<?php echo $duration; ?>>s 
		<select name='kj_simple_button_settings[timing_function]'> 
			<option value='ease' <?php selected( $timing_function, 'ease' ); ?>>ease</option>
			<option value='linear' <?php selected( $timing_function, 'linear' ); ?>>linear</option>
			<option value='ease-in' <?php selected( $timing_function, 'ease-in' ); ?>>ease-in</option>
			<option value='ease-out' <?php selected( $timing_function, 'ease-out' ); ?>>ease-out</option>
			<option value='ease-in-out' <?php selected( $timing_function, 'ease-in-out' ); ?>>ease-in-out</option>
		</select>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_transition_delay]' min='0' step='0.1' value=<?php echo $delay; ?>>s 

		<p><em>Transition duration[s], timing function and delay[s]. Set <strong>duration = 0</strong> for no transition.</em></p>
		<?php

	}
	
	public function kj_simple_button_hover_field_render(  ) { 

		$font_color_change = $this->kj_simple_button_get_option('kj_simple_button_hover_font_color_change', true);
		$font_color = $this->kj_simple_button_get_option('kj_simple_button_hover_font_color', false);
		$background_color_change = $this->kj_simple_button_get_option('kj_simple_button_hover_background_color_change', true);
		$background_color = $this->kj_simple_button_get_option('kj_simple_button_hover_background_color', true);
		$opacity_change = $this->kj_simple_button_get_option('kj_simple_button_hover_opacity_change', true);
		$opacity = $this->kj_simple_button_get_option('kj_simple_button_hover_opacity_value', false);
		
		$border_change = $this->kj_simple_button_get_option('kj_simple_button_hover_border_change', true);
		$border_value = $this->kj_simple_button_get_option('kj_simple_button_hover_border_value', false);
		$border_unit = $this->kj_simple_button_get_option('kj_simple_button_hover_border_unit', false);
		$border_style = $this->kj_simple_button_get_option('kj_simple_button_hover_border_style', false);
		$border_color = $this->kj_simple_button_get_option('kj_simple_button_hover_border_color', true);
		?>
		
		<div class="hover_group_parent">
		<input type='text' name='kj_simple_button_settings[kj_simple_button_hover_font_color]' class='hover_font_color kj_simple_button_color_picker' data-default-color='#ffffff' value='<?php echo $font_color; ?>'>
		<label><input class="checkbox-change-hover" type='checkbox' name='kj_simple_button_settings[kj_simple_button_hover_font_color_change]' <?php checked( $font_color_change, 1 ); ?> value='1'>Change on hover</label>
		<p><em>Font color</em></p><br>
		</div>
		<div class="hover_group_parent">
		<input type='text' name='kj_simple_button_settings[kj_simple_button_hover_background_color]' class="hover_background_color kj_simple_button_color_picker" data-default-color="#2d2d2d"  value="<?php echo $background_color; ?>">
		<label><input class="checkbox-change-hover" type='checkbox' name='kj_simple_button_settings[kj_simple_button_hover_background_color_change]' <?php checked( $background_color_change, 1 ); ?> value='1'>Change on hover</label>
		<p><em>Background color (leave empty for no background)</em></p><br>
		</div>
		<div class="hover_group_parent">		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_hover_opacity_value]' class='hover_opacity'  min='0' step='0.1' max='1.0' value=<?php echo $opacity; ?>>
		<label><input class='checkbox-change-hover' type='checkbox' name='kj_simple_button_settings[kj_simple_button_hover_opacity_change]' <?php checked( $opacity_change, 1 ); ?> value='1'>Change on hover</label>
		<p><em>Opacity</em></p><br>
		</div>
		<div class="hover_group_parent">
		<input type='number' name='kj_simple_button_settings[kj_simple_button_hover_border_value]'  class='hover_border' min='0' step='0.1' value=<?php echo $border_value; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_hover_border_unit]' class='hover_border'> 
			<option value='px' <?php selected( $border_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $border_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $border_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $border_unit, 'rem' ); ?>>rem</option>
		</select>
		
		<select name='kj_simple_button_settings[kj_simple_button_hover_border_style]' class='hover_border'> 
			<option value='dotted' <?php selected( $border_style, 'dotted' ); ?>>dotted</option>
			<option value='dashed' <?php selected( $border_style, 'dashed' ); ?>>dashed</option>
			<option value='solid' <?php selected( $border_style, 'solid' ); ?>>solid</option>
			<option value='double' <?php selected( $border_style, 'double' ); ?>>double</option>
			<option value='groove' <?php selected( $border_style, 'groove' ); ?>>groove</option>
			<option value='ridge' <?php selected( $border_style, 'ridge' ); ?>>ridge</option>
			<option value='inset' <?php selected( $border_style, 'inset' ); ?>>inset</option>
			<option value='outset' <?php selected( $border_style, 'outset' ); ?>>outset</option>
			<option value='none' <?php selected( $border_style, 'none' ); ?>>none</option>
			<option value='hidden' <?php selected( $border_style, 'hidden' ); ?>>hidden</option>
		</select>
		<input type='text' name='kj_simple_button_settings[kj_simple_button_hover_border_color]' class="hover_border kj_simple_button_color_picker" data-default-color="#d8e2ff"  value="<?php echo $border_color; ?>">
		<label><input class="checkbox-change-hover" type='checkbox' name='kj_simple_button_settings[kj_simple_button_hover_border_change]' <?php checked( $border_change, 1 ); ?> value='1'>Change on hover</label>
		<p><em>Border styling</em></p><br>
		</div>
		
		<?php

	}

	public function kj_simple_button_href_field_render(  ) { 

		$href = $this->kj_simple_button_get_option('kj_simple_button_href_value', true);
		
		?>
		<input type='text' name='kj_simple_button_settings[kj_simple_button_href_value]' value="<?php echo $href; ?>"> (leave empty if don't need this)

		<p><em>Href attribute, eg. <strong>https://google.com</strong></em></p>
		<?php

	}
	
	public function kj_simple_button_rel_field_render(  ) { 

		$rel = $this->kj_simple_button_get_option('kj_simple_button_rel_value', true);
		
		?>
		<input type='text' name='kj_simple_button_settings[kj_simple_button_rel_value]' value="<?php echo $rel; ?>"> (leave empty if don't need this)

		<p><em>Rel attribute, eg. <strong>noindex</strong></em></p>
		<?php

	}
	
	public function kj_simple_button_target_field_render(  ) { 

		$target = $this->kj_simple_button_get_option('kj_simple_button_target_value', true);
		
		?>
		<input type='text' name='kj_simple_button_settings[kj_simple_button_target_value]' value="<?php echo $target; ?>"> (leave empty if don't need this)
		<p><em>Target attribute, eg. <strong>_blank</strong></em></p>
		<?php

	}

	public function kj_simple_button_content_field_render(  ) { 

		$content = $this->kj_simple_button_get_option('kj_simple_button_content_value', true);
		
		?>
		<input type='text' name='kj_simple_button_settings[kj_simple_button_content_value]' value="<?php echo $content; ?>"> (leave empty if don't need this)
		<p><em>Text inside button, eg. <strong>Check this out!</strong></em></p>
		<?php

	}
	
	public function kj_simple_button_disabled_posts_field_render(  ) { 

		$disabled_posts = $this->kj_simple_button_get_option('kj_simple_button_disabled_posts', true);
		
		?>
		<input type='text' name='kj_simple_button_settings[kj_simple_button_disabled_posts]' value="<?php echo $disabled_posts; ?>"> (leave empty if don't need this)
		<p><em>Don't show button on posts with these IDs (separated with commas), eg. <strong>10,16,103</strong></em></p>
		<?php

	}

	public function kj_simple_button_settings_validation($input) {
		$default_options  = self::$default_options;
		$can_be_empty = array(
			"kj_simple_button_background_color",
			"kj_simple_button_border_color",
			"kj_simple_button_hover_background_color",
			"kj_simple_button_hover_border_color",
			"kj_simple_button_href_value", 
			"kj_simple_button_rel_value", 
			"kj_simple_button_target_value", 
			"kj_simple_button_content_value",
			"kj_simple_button_disabled_posts"
		);
		$option_types = array(
			"kj_simple_button_btn_active" => "checkbox", 
			"kj_simple_button_advanced_mode" => "checkbox", 
			"kj_simple_button_height_value" => "number_non_negative", 
			"kj_simple_button_height_unit" => "text", 
			"kj_simple_button_width_value" => "number_non_negative", 
			"kj_simple_button_width_unit" => "text",
			"kj_simple_button_horizontal_position" => "text", 
			"kj_simple_button_horizontal_position_value" => "number_non_negative",  
			"kj_simple_button_horizontal_position_unit" => "text",
			"kj_simple_button_vertical_position" => "text", 
			"kj_simple_button_vertical_position_value" => "number_non_negative",  
			"kj_simple_button_vertical_position_unit" => "text",
			"kj_simple_button_text_align_value" => "text", 
			"kj_simple_button_font_size_value" => "number_non_negative", 
			"kj_simple_button_font_size_unit" => "text",
			"kj_simple_button_font_family_main" => "text",
			"kj_simple_button_font_family_fallback" => "text",
			"kj_simple_button_font_color" => "color",
			"kj_simple_button_background_color" => "color",
			"kj_simple_button_line_height_value" => "number_non_negative", 
			"kj_simple_button_line_height_unit" => "text",
			"kj_simple_button_opacity_value" => "number_opacity",
			
			"kj_simple_button_padding_top_value" => "number_non_negative",
			"kj_simple_button_padding_top_unit" => "text",
			"kj_simple_button_padding_right_value" => "number_non_negative",
			"kj_simple_button_padding_right_unit" => "text",
			"kj_simple_button_padding_bottom_value" => "number_non_negative",
			"kj_simple_button_padding_bottom_unit" => "text",
			"kj_simple_button_padding_left_value" => "number_non_negative",
			"kj_simple_button_padding_left_unit" => "text",
			
			"kj_simple_button_margin_top_value" => "number",
			"kj_simple_button_margin_top_unit" => "text",
			"kj_simple_button_margin_right_value" => "number",
			"kj_simple_button_margin_right_unit" => "text",
			"kj_simple_button_margin_bottom_value" => "number",
			"kj_simple_button_margin_bottom_unit" => "text",
			"kj_simple_button_margin_left_value" => "number",
			"kj_simple_button_margin_left_unit" => "text",
			
			"kj_simple_button_border_value" => "number_non_negative",
			"kj_simple_button_border_unit" => "text",
			"kj_simple_button_border_style" => "text",
			"kj_simple_button_border_color" => "color",
			
			"kj_simple_button_border_radius_top_left_value" => "number_non_negative",
			"kj_simple_button_border_radius_top_left_unit" => "text",
			"kj_simple_button_border_radius_top_right_value" => "number_non_negative",
			"kj_simple_button_border_radius_top_right_unit" => "text",
			"kj_simple_button_border_radius_bottom_right_value" => "number_non_negative",
			"kj_simple_button_border_radius_bottom_right_unit" => "text",
			"kj_simple_button_border_radius_bottom_left_value" => "number_non_negative",
			"kj_simple_button_border_radius_bottom_left_unit" => "text",
			
			"kj_simple_button_resolution_max_575" => "checkbox",
			"kj_simple_button_resolution_min_576" => "checkbox",
			"kj_simple_button_resolution_min_768" => "checkbox",
			"kj_simple_button_resolution_min_992" => "checkbox",
			"kj_simple_button_resolution_min_1200" => "checkbox",
			
			"kj_simple_button_transition_duration" => "number_non_negative",
			"kj_simple_button_transition_timing_function" => "text",
			"kj_simple_button_transition_delay" => "number_non_negative",
			
			"kj_simple_button_hover_font_color_change" => "checkbox",
			"kj_simple_button_hover_font_color" => "color",
			"kj_simple_button_hover_background_color_change" => "checkbox",
			"kj_simple_button_hover_background_color" => "color",
			"kj_simple_button_hover_opacity_change" => "checkbox",
			"kj_simple_button_hover_opacity_value" => "number_opacity",
			"kj_simple_button_hover_border_change" => "checkbox",
			"kj_simple_button_hover_border_value" => "number_non_negative",
			"kj_simple_button_hover_border_unit" => "text",
			"kj_simple_button_hover_border_style" => "text",
			"kj_simple_button_hover_border_color" => "color",

			
			"kj_simple_button_href_value" => "text", 
			"kj_simple_button_rel_value" => "text", 
			"kj_simple_button_target_value" => "text", 
			"kj_simple_button_content_value" => "text",
			"kj_simple_button_disabled_posts" => "text"
		);
		$empty_values = array();
		$bad_values = array();
		$validated_input = array();
		foreach($input as $option=>$value){
			if(array_key_exists($option, $default_options )){
				if(empty($value) && (string)$value !==  "0" && !in_array($option, $can_be_empty)){
					array_push($empty_values, str_replace("kj_simple_button_", "", $option));
					$validated_input[$option] = $default_options[$option];
				} else {

					if(array_key_exists($option, $option_types )){
						if($option_types[$option] === "checkbox"){
							if($value === "1"){
								$validated_input[$option] = $value;
							} else {
								$validated_input[$option] = $default_options[$option];
								array_push($bad_values, str_replace("kj_simple_button_", "", $option));
							}
						} else if($option_types[$option] === "number_opacity"){
							if(is_numeric($value) && $value >= 0 && $value <= 1){
								$validated_input[$option] = $value;
							} else {
								$validated_input[$option] = $default_options[$option];
								array_push($bad_values, str_replace("kj_simple_button_", "", $option));
							}
						} else if($option_types[$option] === "number_non_negative"){
							if(is_numeric($value) && $value >= 0){
								$validated_input[$option] = $value;
							} else {
								$validated_input[$option] = $default_options[$option];
								array_push($bad_values, str_replace("kj_simple_button_", "", $option));
							}
						} else if($option_types[$option] === "number"){
							if(is_numeric($value)){
								$validated_input[$option] = $value;
							} else {
								$validated_input[$option] = $default_options[$option];
								array_push($bad_values, str_replace("kj_simple_button_", "", $option));
							}
						} else if($option_types[$option] === "color"){
							if (preg_match( '/^#[a-f0-9]{6}$/i', $value)){
								$validated_input[$option] = $value;
							} else {
								$validated_input[$option] = $default_options[$option];
								array_push($bad_values, str_replace("kj_simple_button_", "", $option));
							}
							
						} else if($option_types[$option] === "text"){
							$validated_input[$option] = $value;
						} 
					}
					
				}
			}
		}
		
		add_settings_error(
				'kj_simple_button_errors',
				esc_attr( 'settings_updated_success' ),
				"Settings saved!",
				"success"
			);
		
		if(count($empty_values) > 0 || count($bad_values) > 0  ){
			if(count($empty_values) > 0){
				$empty_values_message = "<p>" . "These options were empty, default values have been set: " . implode(", ", $empty_values) . ".</p>";
			} else {
				$empty_values_message = "";
			}
			if(count(bad_values) > 0){
				$bad_values_message = "<p>" . "These options had wrong values, default values have been set: " . implode(", ", $bad_values) . ".</p>";
			} else {
				$bad_values_message = "";
			}
			
			add_settings_error(
				'kj_simple_button_errors',
				esc_attr( 'settings_updated_error' ),
				$empty_values_message . $bad_values_message,
				"error"
			);
		}

		return $validated_input;
	} 
	
	public function kj_simple_button_settings_section_callback(  ) { 
		// callback
		echo __( '', 'kj-simple-button' );

	}

	public function kj_simple_button_options_page() {
		
		?>
		<form action='options.php' method='post'>

			<h2>KJ Simple Button</h2>
			<?php
			settings_fields( 'kjSettingsPage' );
			do_settings_sections( 'kjSettingsPage' );
			submit_button();
			
			?>

		</form>
		<?php

	}

}

	
$KJ_Simple_Floating_Button = KJ_Simple_Floating_Button::getInstance();
register_activation_hook(__FILE__, array('KJ_Simple_Floating_Button', 'kj_simple_button_activate'));

?>