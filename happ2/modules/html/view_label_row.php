<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Html_View_Label_Row_HC_MVC extends Html_View_Element_HC_MVC
{
	protected $label = NULL;
	protected $content = array();
	protected $content_static = FALSE;
	protected $error = FALSE;

	function set_error( $error )
	{
		$this->error = $error;
		return $this;
	}
	function error()
	{
		return $this->error;
	}
	function set_label( $label )
	{
		$this->label = $label;
		return $this;
	}
	function label()
	{
		return $this->label;
	}
	function set_content( $content )
	{
		$this->content = $content;

		if( is_object($content) ){
			if( $observe = $content->observe() ){
				$this
					->add_attr('data-hc-observe', $observe)
					;
			}
		}
		return $this;
	}
	function content()
	{
		$return = $this->content;
		if( ! is_array($return) ){
			$return = array( $return );
		}
		return $return;
	}

	function set_content_static( $content_static = TRUE )
	{
		$this->content_static = $content_static;
		return $this;
	}
	function content_static()
	{
		return $this->content_static;
	}

	function render()
	{
		$error = $this->error();
		$label = $this->label();
		$content = $this->content();

		if( $observe = $this->observe() ){
			$this
				->add_attr('data-hc-observe', $observe)
				;
		}

		$div = $this->make('view/grid')
			->add_style('margin', 'b2')
			// ->add_style('border')
			;

		$attr = $this->attr();
		foreach( $attr as $k => $v ){
			$div->add_attr( $k, $v );
		}

		$content_holder = $this->make('view/element')->tag('div')
			->add_style('display', 'block')
			;
		if( $this->content_static() ){
			// $content_holder->add_style('form-control-static');
		}

		if( $error ){
			$content_holder
				->add_style('form-error')
				;
		}

		foreach( $content as $cont ){
			$content_holder->add( $cont );
		}

		if( $label == '-nolabel-' ){
			$div->add(
				'content',
				$content_holder,
				12
				);
		}
		else {
			$label_c = '';
			if( $label ){
				$label_c = $this->make('view/element')->tag('div' )
					->add( $label )
					->add_style('margin', 'r3')

					// ->add_attr('class', 'hc-form-label')
					->add_style('text-align', 'sm-right')
					// ->add_style('font-style', 'bold')

					->add_style('font-size', -1)
					// ->add_style('margin', '')
					// ->add_attr('style', 'line-height: 1.5em;')
					->add_style('mute')
					;
			}

			$div->add(
				'label',
				$label_c,
				2
				);

			$div->add(
				'content',
				$content_holder,
				8
				);
		}

		return $div;
	}
}