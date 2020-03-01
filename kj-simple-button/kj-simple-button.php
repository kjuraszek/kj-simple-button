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
		"kj_simple_button_height_value" => 90, 
		"kj_simple_button_height_unit" => "px", 
		"kj_simple_button_width_value" => 90, 
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
		"kj_simple_button_line_height_value" => 16, 
		"kj_simple_button_line_height_unit" => "px",
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
		"kj_simple_button_href_value" => "#", 
		"kj_simple_button_rel_value" => "", 
		"kj_simple_button_target_value" => "", 
		"kj_simple_button_content_value" => "");
		
		
    public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
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
		fwrite($handle, "\tline-height: " . $this->kj_simple_button_get_option('kj_simple_button_line_height_value', false) . $this->kj_simple_button_get_option('kj_simple_button_line_height_unit', false) . ";\n");
		
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
		fwrite($handle, "}\n");
		
		fclose($handle);
	}

    public function enqueue_scripts() {
		wp_enqueue_style('KJ_Simple_Floating_Button', plugins_url('assets/css/style.css', __FILE__), null, '');
		wp_enqueue_style('KJ_Simple_Floating_Button_custom', plugins_url('assets/css/custom-style.css', __FILE__), null, '');
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
		
		register_setting( 'kjSettingsPage', 'kj_simple_button_settings' );
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
			'kj_simple_button_line_height', 
			__( 'Line height', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_line_height_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_padding', 
			__( 'Padding', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_padding_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
		);
		add_settings_field( 
			'kj_simple_button_margin', 
			__( 'Margin', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_margin_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_style' 
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
			'kj_simple_button_kjSettingsPage_section_misc' 
		);
		add_settings_field( 
			'kj_simple_button_target_field', 
			__( 'Target', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_target_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_misc' 
		);
		add_settings_field( 
			'kj_simple_button_content_field', 
			__( 'Content', 'kj-simple-button' ), 
			array($this, 'kj_simple_button_content_field_render'), 
			'kjSettingsPage', 
			'kj_simple_button_kjSettingsPage_section_misc' 
		);
	}

	public function kj_simple_button_height_field_render(  ) { 

		$height = $this->kj_simple_button_get_option('kj_simple_button_height_value', false);
		$height_unit = $this->kj_simple_button_get_option('kj_simple_button_height_unit', false);
		
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_height_value]'  min='0' step='0.1'value=<?php echo $height; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_height_unit]'> 
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
		<select name='kj_simple_button_settings[kj_simple_button_width_unit]'> 
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
		<input type='number' name='kj_simple_button_settings[kj_simple_button_horizontal_position_value]' min='0' step='0.1' value=<?php echo $position_value;
; ?>>
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
		<input type='number' name='kj_simple_button_settings[kj_simple_button_vertical_position_value]' min='0' step='0.1' value=<?php echo $position_value;
; ?>>
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
		<input type='number' name='kj_simple_button_settings[kj_simple_button_font_size_value]' min='0' step='0.1' value=<?php echo $font_size;
; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_font_size_unit]'> 
			<option value='px' <?php selected( $font_size_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $font_size_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $font_size_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $font_size_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Font size</em></p>
		<?php

	}
	
	public function kj_simple_button_line_height_field_render(  ) { 


		$line_height = $this->kj_simple_button_get_option('kj_simple_button_line_height_value', false);
		$line_height_unit = $this->kj_simple_button_get_option('kj_simple_button_line_height_unit', false);
		?>
		<input type='number' name='kj_simple_button_settings[kj_simple_button_line_height_value]' min='0' step='0.1' value=<?php echo $line_height;
; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_line_height_unit]'> 
			<option value='px' <?php selected( $line_height_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $line_height_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $line_height_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $line_height_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Line height</em></p>
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
		<input type='number' name='kj_simple_button_settings[kj_simple_button_padding_top_value]' min='0' step='0.1' value=<?php echo $padding_top;
; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_padding_top_unit]'> 
			<option value='px' <?php selected( $padding_top_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $padding_top_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $padding_top_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $padding_top_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Padding top</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_padding_right_value]' min='0' step='0.1' value=<?php echo $padding_right;
; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_padding_right_unit]'> 
			<option value='px' <?php selected( $padding_right_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $padding_right_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $padding_right_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $padding_right_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Padding right</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_padding_bottom_value]' min='0' step='0.1' value=<?php echo $padding_bottom;
; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_padding_bottom_unit]'> 
			<option value='px' <?php selected( $padding_bottom_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $padding_bottom_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $padding_bottom_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $padding_bottom_unit, 'rem' ); ?>>rem</option>
		</select>
		<p><em>Padding botton</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_padding_left_value]' min='0' step='0.1' value=<?php echo $padding_left;
; ?>>
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
		<input type='number' name='kj_simple_button_settings[kj_simple_button_margin_top_value]' min='0' step='0.1' value=<?php echo $margin_top;
; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_margin_top_unit]'> 
			<option value='px' <?php selected( $margin_top_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $margin_top_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $margin_top_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $margin_top_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $margin_top_unit, 'auto' ); ?>>auto</option>
		</select>
		<p><em>Margin top</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_margin_right_value]' min='0' step='0.1' value=<?php echo $margin_right;
; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_margin_right_unit]'> 
			<option value='px' <?php selected( $margin_right_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $margin_right_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $margin_right_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $margin_right_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $margin_right_unit, 'auto' ); ?>>auto</option>
		</select>
		<p><em>Margin right</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_margin_bottom_value]' min='0' step='0.1' value=<?php echo $margin_bottom;
; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_margin_bottom_unit]'> 
			<option value='px' <?php selected( $margin_bottom_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $margin_bottom_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $margin_bottom_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $margin_bottom_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $margin_bottom_unit, 'auto' ); ?>>auto</option>
		</select>
		<p><em>Margin bottom</em></p><br>
		
		<input type='number' name='kj_simple_button_settings[kj_simple_button_margin_left_value]' min='0' step='0.1' value=<?php echo $margin_left;
; ?>>
		<select name='kj_simple_button_settings[kj_simple_button_margin_left_unit]'> 
			<option value='px' <?php selected( $margin_left_unit, 'px' ); ?>>px</option>
			<option value='%' <?php selected( $margin_left_unit, '%' ); ?>>%</option>
			<option value='em' <?php selected( $margin_left_unit, 'em' ); ?>>em</option>
			<option value='rem' <?php selected( $margin_left_unit, 'rem' ); ?>>rem</option>
			<option value='auto' <?php selected( $margin_left_unit, 'auto' ); ?>>auto</option>
		</select>
		<p><em>Margin left</em></p><br>
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