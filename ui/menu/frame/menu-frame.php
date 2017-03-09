<?php
namespace ui\menu\frame;

function init_menu()
{

	function regist_css()
	{
		wp_register_style(
			'menu/common.css', 
			plugins_url("/css/menu/common.css", __FILE__),
			array(),
			"1.0"
			 
		);
		
		wp_enqueue_style('menu/common.css');

		wp_register_style(
			'customer_search.css', 
			plugins_url("/css/customer_search.css", __FILE__),
			array(),
			"0.006"
			 
		);
		
		wp_enqueue_style('customer_search.css');
		
		wp_enqueue_style('manage_common.css');

		wp_register_style(
			'manage_common.css', 
			plugins_url("/css/manage_common.css", __FILE__),
			array(),
			"0.002"
		);
		
		wp_enqueue_style('manage_common.css');
	}

	add_action('wp_enqueue_scripts', 'regist_css');

}

?>