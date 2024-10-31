<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Layout_View_Content_Header_Menubar_HC_MVC extends _HC_MVC
{
	private $content = NULL;
	private $header = NULL;
	private $menubar = NULL;

	public function set_content( $content )
	{
		$this->content = $content;
		return $this;
	}
	public function content()
	{
		return $this->content;
	}
	public function set_header( $header )
	{
		$this->header = $header;
		return $this;
	}
	public function header()
	{
		return $this->header;
	}
	public function set_menubar( $menubar )
	{
		$this->menubar = $menubar;
		return $this;
	}
	public function menubar()
	{
		return $this->menubar;
	}

	public function render()
	{
		$header = (string) $this->header();
		if( strlen($header) ){
			// $header = $this->make('/html/view/element')->tag('h1')
				// ->add( $header )
				// ->add_style('margin', 0, 't2')
				// ->add_style('padding', 0, 'y2')
				// ;
			$header = $this->make('/html/view/element')->tag('div')
				->add( $header )
				->add_style('margin', 0, 't2')
				->add_style('padding', 'b2')
				->add_style('border', 'bottom')
				;
		}

		$menubar = $this->menubar();

		if( is_object($menubar) && method_exists($menubar, 'children') && ($menubar_items = $menubar->children()) ){
			$menubar = $this->make('/html/view/menubar')
				->set_children( $menubar_items )
				;
		}

		if( is_object($menubar) && method_exists($menubar, 'render') ){
			$menubar = $menubar->run('render');
			if( is_object($menubar) && method_exists($menubar, 'children') && ($menubar_items = $menubar->children()) ){
				$menubar = $this->make('/html/view/menubar')
					->set_children( $menubar_items )
					;
			}
		}

		$menubar = (string) $menubar;
		if( strlen($menubar) ){
			$menubar = $this->make('/html/view/element')->tag('div')
				->add( $menubar )
				->add_style('padding', 'y2')
				// ->add_style('padding', 0)
				->add_style('border', 'bottom')
				;
		}

		$content = $this->make('/html/view/element')->tag('div')
			->add( $this->content() )
			->add_style('padding', 'y2')
			// ->add_style('padding', 3)
			// ->add_style('border')
			// ->add_style('rounded')
			;

		$out = $this->make('/html/view/container');
		if( $header ){
			$out->add( 'header', $header );
		}
		if( $menubar ){
			$out->add( 'menubar', $menubar );
		}

		$out->add( 'content', $content );
		return $out;
	}
}