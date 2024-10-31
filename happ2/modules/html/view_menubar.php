<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
include_once( dirname(__FILE__) . '/view_list_inline.php' );
class Html_View_Menubar_HC_MVC extends Html_View_List_Inline_HC_MVC
{
	public function _init()
	{
		$this
			// ->add_style('margin', 'l1')
			->set_separated(1)
			;
		return $this;
	}

	public function render()
	{
		$items = $this->children();
		$keys = array_keys($items);

		foreach( $keys as $k ){
			if( is_object($items[$k]) ){
				if( method_exists($items[$k], 'add_style') ){
					$items[$k]
						->add_style('tab-link')
						;
				}
				if( method_exists($items[$k], 'admin') ){
					$items[$k]
						->admin()
						;
				}
			}
		}

		$this->set_children( $items );
		return parent::render();
	}
}