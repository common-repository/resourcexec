<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Html_View_Select_Links_HC_MVC extends Html_View_Element_HC_MVC
{
	protected $options = array();
	protected $selected = NULL;

	public function add_option( $key, $label, $link )
	{
		$this->options[ $key ] = array( $label, $link );
	}
	public function options()
	{
		return $this->options;
	}

	public function set_selected( $selected )
	{
		$this->selected = $selected;
		return $this;
	}
	public function selected()
	{
		return $this->selected;
	}

	public function render_readonly()
	{
		$return = NULL;

		$options = $this->options();
		$selected = $this->selected();
		if( $selected === NULL ){
			$keys = array_keys($options);
			$selected = array_shift($keys);
		}

		if( isset($options[$selected]) ){
			$option = $options[$selected];
			list( $label, $link ) = $option;
			$return = $this->make('view/element')->tag('span')
				->add( $label )
				// ->add_style('btn')
				->add_style('padding', 2)
				->add_style('border')
				->add_style('rounded')
				->add_style('display', 'inline-block')
				;
		}

		return $return;
	}

	public function render()
	{
		$readonly = $this->readonly();
		if( $readonly ){
			return $this->run('render-readonly');
		}

		$options = $this->options();
		if( count($options) <= 1 ){
			return $this->run('render-readonly');
		}

		$return = $this->make('/html/view/element')->tag('select')
			// ->add_attr( 'id', $this->id() )
			// ->add_attr( 'name', $this->name() )
			->add_style('form-control')
			->add_attr('onchange', 'if (this.value) window.location.href=this.value')
			;

		$selected = $this->selected();

		reset( $options );
		foreach( $options as $key => $option ){
			list( $label, $link ) = $option;

			$option = $this->make('/html/view/element')->tag('option');
			$option->add_attr( 'value', $link );
			$option->add( $label );

			if( $selected == $key ){
				$option->add_attr( 'selected', 'selected' );
			}
			$return->add( $option );
		}

		$attr = $this->attr();
		foreach( $attr as $k => $v ){
			$return->add_attr($k, $v);
		}
		return $return;
	}
}