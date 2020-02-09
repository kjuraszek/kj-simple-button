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

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
		add_action( 'wp_footer' , array($this, 'kj_simple_button_append_button') );
    }

	public static function getInstance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}
	
    public function enqueue_scripts() {
        wp_enqueue_style('KJ_Simple_Floating_Button', plugins_url('assets/css/style.css', __FILE__), null, '');
	}
	
	public function kj_simple_button_append_button(){
		echo '<!-- #kj-simple-button -->';
		echo '<a href="#" id="kj-simple-button">KJ</a>';
	}

}

	
$KJ_Simple_Floating_Button = KJ_Simple_Floating_Button::getInstance();

?>