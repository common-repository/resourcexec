<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Icons_Dashicons_Html_View_Icon_HC_MVC extends Html_View_Element_HC_MVC
{
	private $convert = array(
		'cog'		=> 'admin-generic',
		'user'		=> 'admin-users',
		'times'		=> 'dismiss',
		'status'	=> 'post-status',
		'list'		=> 'editor-ul',
		'history'	=> 'book',
		'exclamation'	=> 'warning',
		'printer'		=> 'media-text',

		'purchase'		=> 'products',
		'sale'			=> 'cart',
		'inventory'		=> 'admin-page',
	);

	public function extend_render($icon, $params, $src)
	{
	// <span class="oi oi-icon-name" title="icon name" aria-hidden="true"></span>

		$icon = isset($this->convert[$icon]) ? $this->convert[$icon] : $icon;
		if( $icon && strlen($icon) ){
			if( substr($icon, 0, 1) == '&' ){
				$return = $this->make('/html/view/element')->tag('span')
					->add( $icon )
					// ->add_style('padding', 'x1')
					->add_style('margin', 'r1', 'l1')
					->add_style('char')
					;
			}
			else {
				$return = $this->make('/html/view/element')->tag('i');
				$return
					->add_attr('class', array('dashicons', 'dashicons-' . $icon, 'hc-dashicons'))
					;
			}
		}

		$attr = $src->attr();
		foreach( $attr as $k => $v ){
			$return->add_attr( $k, $v );
		}
		return $return;
	}
}