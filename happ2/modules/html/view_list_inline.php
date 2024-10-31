<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
include_once( dirname(__FILE__) . '/view_container.php' );
class Html_View_List_Inline_HC_MVC extends Html_View_Container_HC_MVC
{
	protected $gutter = 2; // from 0 to 3
	protected $separated = 0; // from 0 to 1

	public function set_gutter( $gutter )
	{
		$this->gutter = $gutter;
		return $this;
	}
	public function gutter()
	{
		return $this->gutter;
	}

	public function set_separated( $separated = 1 )
	{
		$this->separated = $separated;
		return $this;
	}
	public function separated()
	{
		return $this->separated;
	}

	public function render()
	{
		$items = $this->children();
		if( ! $items ){
			return;
		}

		$gutter = $this->gutter();
		$separated = $this->separated();

		$render_items = array();
		$ii = 0;
		foreach( $items as $item ){
			$item2 = $this->make('view/element')->tag('div')
				->add($item)
				;

			$item2
				->add_style('inline', 'sm')
				;

			if( $gutter && ($gutter > 1) ){
				$item2
					// ->add_style('padding', 'y' . ($gutter - 1))
					;
			}

			$margin = array();
			if( $separated ){
				$margin[] = 'b2-xs';
			}

			if( $ii ){
				if( $separated ){
					$item2
						->add_style( 'border', 'left-sm' )
						;
				}

				if( $gutter ){
					$item2
						->add_style( 'padding', 'x' . $gutter . '-sm' )
						;
				}
			}
			else {
				if( $gutter ){
					$margin[] = 'r' . $gutter . '-sm';
				}
			}

			if( $margin ){
				$margin_args = array_merge( array('margin'), $margin );
				call_user_func_array( array($item2, 'add_style'), $margin_args );
			}

			$render_items[] = $item2;
			$ii++;
		}

		$out = $this->make('view/element')->tag('div');
		$attr = $this->attr();

		foreach( $attr as $k => $v ){
			$out
				->add_attr( $k, $v )
				;
		}

		$out
			->add( parent::render($render_items) )
			;
		return $out;
	}
}