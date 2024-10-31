<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
include_once( dirname(__FILE__) . '/view_container.php' );
class Html_View_Form_HC_MVC extends Html_View_Container_HC_MVC
{
	private $method = 'post';
	private $form = NULL;
	private $route = NULL;
	protected $ajax = FALSE;

	// private $id = '';

	function __construct()
	{
		parent::__construct();
		$this->id = 'nts_' . hc_random();
	}

	public function set_ajax( $ajax = TRUE )
	{
		$this->ajax = $ajax;
		return $this;
	}

	public function set_route( $route )
	{
		$this->route = $route;
		return $this;
	}

	function id()
	{
		return $this->id;
	}

	public function set_form( $form )
	{
		$this->form = $form;
		return $this;
	}

	public function form()
	{
		return $this->form;
	}

	public function set_method( $method )
	{
		$this->method = $method;
		return $this;
	}
	public function method()
	{
		return $this->method;
	}

	function render()
	{
		// no form tag
		if( $this->ajax ){
			$action = $this->attr('action');

			$out = $this->make('view/element')->tag('div')
				->add_attr('id', $this->id())
				->add_attr('class', 'hcj2-observe' )
				->add_attr('class', 'hcj2-ajax-form' )
				->add_attr('data-action', $action )
				;
			// $out
				// ->add(
					// $this->make('/form/view/hidden')
						// ->set_name('route')
						// ->set_value($this->route)
					// )
				// ;
		}
		elseif( $this->route ){
			$out = $this->make('view/element')->tag('div')
				->add_attr('id', $this->id())
				->add_attr('class', 'hcj2-observe' )
				;
			$out
				->add(
					$this->make('/form/view/hidden')
						->set_name('route')
						->set_value($this->route)
					)
				;
		}
		else {
			$out = $this->make('view/element')->tag('form')
				->add_attr('method', $this->method())
				->add_attr('accept-charset', 'utf-8')
				->add_attr('id', $this->id())
				->add_attr('class', 'hcj2-observe' )
				;
		}

		$attr = $this->attr();
		foreach( $attr as $k => $v ){
			$out->add_attr( $k, $v );
		}

		if( $this->form ){
			$orphan_errors = $this->form->orphan_errors();
			if( $orphan_errors ){
				$errors = $this->make('view/list');

				foreach( $orphan_errors as $k => $v ){
					$view = $v;
					if( $k != '_' ){
						$view = $k . ': ' . $view;
					}
					$errors->add($view);
				}

				$errors = $this->make('view/element')->tag('div')
					->add( $errors )
					->add_style('bg-lighten', 4)
					->add_style('padding', 2)
					;

				$errors = $this->make('view/element')->tag('div')
					->add( $errors )
					->add_style('bg-color', 'red')
					->add_style('box', 0, 0)
					->add_style('margin', 'b3')
					;
				$out->add( $errors );
			}
		}

		$out->add( parent::render() );
		return $out;
	}
}