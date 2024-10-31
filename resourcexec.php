<?php
/*
 * Plugin Name: ResourcExec
 * Plugin URI: http://www.resourcexec.com/
 * Description: Resource booking, resource scheduling, staff management, employee planning plugin.
 * Version: 1.0.2
 * Author: hitcode.com
 * Author URI: http://www.hitcode.com/
 * Text Domain: resourcexec
 * Domain Path: /languages/
*/

if (! defined('ABSPATH')) exit; // Exit if accessed directly

if( file_exists(dirname(__FILE__) . '/db.php') ){
	$nts_no_db = TRUE;
	include_once( dirname(__FILE__) . '/db.php' );
	$happ_path = NTS_DEVELOPMENT2;
}
else {
	$happ_path = dirname(__FILE__) . '/happ2';
}

include_once( $happ_path . '/lib-wp/hcWpBase6.php' );

register_uninstall_hook( __FILE__, array('Resourcexec1', 'uninstall') );

class Resourcexec1 extends hcWpBase6
{
	public function __construct()
	{
		parent::__construct(
			array('resourcexec', 'rb'),	// app
			__FILE__				// path
			);

		add_action(	'init', array($this, '_this_init') );
		add_action( 'admin_print_styles', array($this, 'print_styles') );
		add_action( 'wp_enqueue_scripts', array($this, 'print_styles') );
	}

	public function _this_init()
	{
		$this->hcapp_start();
	}

	static function uninstall( $prefix = 'resourcexec', $watch_other = array() )
	{
		$prefix = 'resourcexec';
		$watch_other = array('resourcexec-pro.php');
		hcWpBase6::uninstall( $prefix, $watch_other );
	}
}

$rsx = new Resourcexec1();