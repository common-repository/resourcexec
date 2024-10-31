<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
include_once( dirname(__FILE__) . '/view_list.php' );
class Html_View_Sidebar_HC_MVC extends Html_View_List_HC_MVC
{
	public function _init()
	{
		$this
			// ->add_style('margin', 'l1')
			// ->set_separated(1)
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
						->admin()
						->add_style('block-link')
						->add_style('margin', 'b1')
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