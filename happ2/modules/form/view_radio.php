<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Form_View_Radio_HC_MVC extends HC_Form_Input2
{
	protected $options = array();
	protected $more = array();
	protected $holder = NULL;
	protected $inline = FALSE;
	protected $one_input = FALSE;

	public function set_options( $options )
	{
		foreach( $options as $k => $v ){
			$this->add_option( $k, $v );
		}
		return $this;
	}

	public function always_label()
	{
		return TRUE;
	}

	function add_option( $value, $label = NULL, $more = '' )
	{
		$this->options[$value] = $label;
		if( $more ){
			$this->more[$value] = $more;
		}
		return $this;
	}
	function options()
	{
		return $this->options;
	}
	function more()
	{
		return $this->more;
	}

	function set_inline( $inline = TRUE )
	{
		$this->inline = $inline;
		return $this;
	}
	function inline()
	{
		return $this->inline;
	}

	function set_one_input( $one_input = TRUE )
	{
		$this->one_input = $one_input;
		return $this;
	}
	function one_input()
	{
		return $this->one_input;
	}

	public function set_holder( $holder )
	{
		$this->holder = $holder;
		return $this;
	}
	public function holder()
	{
		return $this->holder;
	}

	function render()
	{
		$readonly = $this->readonly();
		$options = $this->options();
		$more = $this->more();
		$value = $this->value();
		$inline = $this->inline();

		$el = $this->holder();
		if( ! ($el && is_object($el) && method_exists($el, 'add')) ){
			$el = $this->make('/html/view/element')->tag('div')
				;
		}

		if( $readonly ){
			$value = isset($options[$value]) ? $options[$value] : '';
			$el = $this->make('/html/view/element')->tag('span')
				->add_attr( 'id', $this->id() )
				->add_style('form-control-static')
				->add( $value );
				;
		}
		else {
			foreach( $options as $value => $label ){
				$wrap_el = $this->make('/html/view/element')->tag('label')
					->add_attr('style', 'padding-left: 0;')
					->add_style('nowrap')
					;

				$one_input = $this->one_input();

				if( ($one_input && (count($options) > 0)) OR (count($options) > 1) ){
					$sub_el = $this->make('/html/view/element')->tag('input')
						->add_attr('type', 'radio')
						->add_attr('name', $this->name())
						->add_attr('id', $this->id())
						->add_attr('value', $value)
						;

					$sub_el->add_attr('class', 'hcj2-radio-more-info');
					if( $value == $this->value() ){
						$sub_el->add_attr('checked', 'checked');
					}
				}
				else {
					$sub_el = $this->make('/html/view/element')->tag('input')
						->add_attr('type', 'hidden')
						->add_attr('name', $this->name())
						->add_attr('id', $this->id())
						->add_attr('value', $value)
						;
				}

				$attr = $this->attr();
				foreach( $attr as $k => $v ){
					$sub_el->add_attr($k, $v);
				}

				$wrap_el->add( $sub_el );
				if( $label !== NULL ){
					$wrap_el->add( $label );
				}

				if( isset($more[$value]) ){
					$this_more = $this->make('/html/view/element')->tag('div')
						->add_attr('class', 'hcj2-radio-info')
						->add( $more[$value] )
						->add_style('margin', 'l3')
						;
					$wrap_el->add( $this_more );
				}

				if( $inline ){
					$wrap_el
						->add_style('padding', 2)
						->add_style('inline')
						;
				}
				else {
					$wrap_el
						->add_style('display', 'block')
						->add_attr('style', 'padding: 0 0;')
						;
				}
				$el->add( $wrap_el );
			}
		}

		$el = $this->make('/html/view/element')->tag('span')
			->add_style('padding', 'x2')
			->add_style('border')
			->add_style('rounded')
			->add_style('inline')
			->add( $el )
			;

		$return = $this->decorate( $el );
		return $return;
	}
}
