<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Wordpress_Layout_View_Full_HC_MVC extends _HC_MVC
{
	public function extend_body( $body )
	{
	// assets
		$assets = $this->make('/layout/view/assets');
		$css = $assets->run('css');
		$js = $assets->run('js');

		$check = array('dashicons');
		foreach( $css as $handle => $src ){
			if( in_array($handle, $check) ){
				wp_enqueue_style( $handle );
			}
			else {
				wp_enqueue_style( 'hc2-' . $handle, $src );
			}
		}

		$check = array('jquery', 'backbone', 'underscore', 'jquery-ui-sortable');
		foreach( $js as $handle => $src ){
			if( in_array($handle, $check) ){
				wp_enqueue_script( $handle );
			}
			else {
				wp_enqueue_script( 'hc2-' . $handle, $src );
			}
		}
		return $body;
	}
}