<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Html_View_Top_Menu_HC_MVC extends Html_View_Element_HC_MVC
{
	protected $current;

	public function single_instance()
	{
	}

	public function set_current( $current )
	{	
		$this->current = $current;
		return $this;
	}

	public function render()
	{
		$out = $this->make('view/element')->tag('div')
			->add_style('margin', 'b2')
			->add_style('rounded')
			;

		$out
			->add_style('bg-color', 'darkgray')
			->add_style('color', 'silver')
			// ->add_style('bg-color', 'fuchsia')
			// ->add_style('color', 'white')
			;

		$children = $this->children();
		$uri = $this->make('/http/lib/uri');

		foreach( $children as $child ){
			if( is_object($child) && method_exists($child, 'add_style') ){
				$child
					->add_style('btn')
					->add_style('padding', 'x2', 'y3')
					->add_style('margin', 'r2')
					;

				if( method_exists($child, 'href') ){
					$href = $child->href();
					$this_slug = $uri->get_slug_from_url( $href );

				// active
					if( 
						( $this_slug == $this->current )
						OR
						(
							( substr($this->current, 0, strlen($this_slug)) == $this_slug ) &&
							( substr($this->current, strlen($this_slug), 1) == '/' )
						)
					){
						$child
							->add_style('bg-color', 'black')
							->add_style('color', 'silver')
							;
					}
				}
			}
			$out->add( $child );
		}

		return $out;
	}
}