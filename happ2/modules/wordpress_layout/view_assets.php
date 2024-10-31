<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Wordpress_Layout_View_Assets_HC_MVC extends _HC_MVC
{
	/* sets full url for assets files */
	public function extend_setpath( $array )
	{
		if( defined('NTS_DEVELOPMENT2') && NTS_DEVELOPMENT2 ){
			$assets_dir = NTS_DEVELOPMENT2 . '/assets';
			$localhost = defined('NTS_LOCALHOST') ? NTS_LOCALHOST : 'localhost';
			$assets_web_dir = 'http://' . $localhost . '/wp/wp-content/plugins/';
		}
		else {
			$assets_dir = dirname(__FILE__) . '/../../../../assets';
			$assets_web_dir = plugins_url('', realpath( $assets_dir . '/..' )) . '/';
		}

		$keys = array_keys( $array );
		foreach( $keys as $k ){
			$full_href = $array[$k];
			if( ! HC_Lib2::is_full_url($full_href) ){
				$full_href = $assets_web_dir . $full_href;
				$array[$k] = $full_href;
			}
		}
		return $array;
	}

	public function extend_css( $params )
	{
		if( isset($params['hc']) ){
			$params['hc'] = str_replace('/hc.css', '/hc-wp.css', $params['hc']);
		}

		$unset = array('reset', 'style', 'form', 'font');
		reset( $unset );
		foreach( $unset as $k ){
			if( isset($params[$k]) ){
				unset($params[$k]);
			}
		}

		return $params;
	}
}