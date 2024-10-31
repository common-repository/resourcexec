<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Html_View_Table_HC_MVC extends Html_View_Element_HC_MVC
{
	protected $striped = TRUE;
	protected $cell_styles = array();

	protected $header = array();
	protected $rows = array();
	protected $footer = array();

	private $collapse_action = FALSE;

	public function set_striped( $striped = TRUE )
	{
		$this->striped = $striped;
		return $this;
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
	public function set_footer( $footer )
	{
		$this->footer = $footer;
		return $this;
	}
	public function footer()
	{
		return $this->footer;
	}
	public function set_rows( $rows )
	{
		$this->rows = $rows;
		return $this;
	}
	public function rows()
	{
		return $this->rows;
	}

	public function add_cell_style()
	{
		$args = func_get_args();
		$style = array_shift($args);
		$this->cell_styles[ $style ] = $args;
		return $this;
	}

	public function cell_styles()
	{
		return $this->cell_styles;
	}

	protected function _render_cell( $content, $tag = 'td' )
	{
		$out = $this->make('/html/view/element')->tag($tag);
		$out->add( $content );
		return $out;
	}

	protected function _render_row()
	{
		$out = $this->make('/html/view/element')->tag('tr');
		$out->add_style('border', 'bottom');

		return $out;
	}

	protected function _render_tbody()
	{
		$out = $this->make('/html/view/element')->tag('tbody');
		return $out;
	}

	public function generate_row( $row )
	{
		$header = $this->header();
		$col_count = count($header);
		$cell_styles = $this->cell_styles();
		$normal_cell_styles = $cell_styles;

		$tr = $this->_render_row();

		for( $ii = 0; $ii < $col_count; $ii++ ){
			$v = array_shift($row);
			$td = $this->_render_cell( $v );

			reset( $normal_cell_styles );
			foreach( $normal_cell_styles as $style => $style_args ){
				call_user_func_array( array($td, 'add_style'), array_merge(array($style), $style_args) );
			}

			$tr->add( $td );
		}
		return $tr;
	}

	function render()
	{
		$header = $this->header();

		$col_count = count($header);
		$rows = $this->rows();

		$has_action_row = FALSE;
		if( count($rows) && (count($rows[0])  > $col_count) ){
			$has_action_row = TRUE;
		}
		$has_action_row = FALSE;

	// prerender
		foreach( $header as $k => $v ){
			$header[$k] = '' . $v;
		}

		foreach( $rows as $rid => $row ){
			foreach( $row as $k => $v ){
				$rows[$rid][$k] = '' . $v;
			}
		}

		$full_out = $this->make('/html/view/element')->tag('table');

		$out = $this->_render_tbody()
			;

		$attr = $this->attr();
		foreach( $attr as $k => $v ){
			$full_out->add_attr($k, $v);
		}

		$cell_styles = $this->cell_styles();
		$normal_cell_styles = $cell_styles;

	// header
		$tr = $this->_render_row();

		if( $has_action_row ){
			if( $this->collapse_action ){
				$td = $this->_render_cell( '&nbsp;', 'th' );
				reset( $normal_cell_styles );
				foreach( $normal_cell_styles as $style => $style_args ){
					call_user_func_array( array($td, 'add_style'), array_merge(array($style), $style_args) );
				}
				$td
					->add_attr('style', 'width: 1em;')
					;
				$tr->add( $td );
			}
		}

		foreach( $header as $k => $v ){
			$td = $this->_render_cell( $v, 'th' );

			reset( $normal_cell_styles );
			foreach( $normal_cell_styles as $style => $style_args ){
				call_user_func_array( array($td, 'add_style'), array_merge(array($style), $style_args) );
			}
			$td
				// ->add_style('font-size', -1)
				->add_style('font-size', +1)
				->add_style('font-style', 'regular')
				;

			$tr->add( $td );
		}

		$tr
			->add_style('border', 'bottom')
			->add_style('border-color', 'gray')
			;

		$full_out->add( $tr );

	// rows
		$rri = 0;
		foreach( $rows as $rid => $row ){
			$rri++;
			$tr = $this->_render_row();

			if( $this->striped ){
				if( $rri % 2 ){
					$tr
						->add_style('bg-color', 'lightsilver')
						->add_style('border', 'bottom')
						;
				}
				else {
					$tr
						->add_style('bg-color', 'white')
						->add_style('border', 'bottom')
						;
				}
			}

			$action_row = NULL;
			// if( count($row) > $col_count ){
			if( $has_action_row ){
				$action_row = array_pop($row);
			}

			if( $has_action_row ){
				if( $this->collapse_action ){
					$action_trigger = $this->make('/html/view/element')->tag('a')
						->add_attr('href', '#')
						->add( $this->make('/html/view/icon')->icon('caret-down') )
						->add_style('btn')
						->add_style('btn-submit', 1, 0)
						->add_attr('class', 'hcj2-collapse-next')
						;
					$td = $this->_render_cell($action_trigger);
					reset( $normal_cell_styles );
					foreach( $normal_cell_styles as $style => $style_args ){
						call_user_func_array( array($td, 'add_style'), array_merge(array($style), $style_args) );
					}
					$tr->add( $td );
				}
			}

			if( ! $header ){
				$col_count = count($row);
			}
			for( $ii = 0; $ii < $col_count; $ii++ ){
				$v = array_shift($row);
				$td = $this->_render_cell( $v );

				reset( $normal_cell_styles );
				foreach( $normal_cell_styles as $style => $style_args ){
					call_user_func_array( array($td, 'add_style'), array_merge(array($style), $style_args) );
				}

				$tr->add( $td );
			}

		// action row addon
			if( $action_row ){
				$tr2 = $this->_render_row();
				if( $this->striped ){
					if( $rri % 2 ){
						$tr2->add_style('bg-color', 'lightsilver');
					}
					else {
						$tr2->add_style('bg-color', 'white');
					}
				}

				$td2_pre = $this->_render_cell('&nbsp;');
				$td2 = $this->_render_cell( $action_row );
				$td2
					->add_attr('colspan', $col_count)
					;

				if( $this->collapse_action ){
					reset( $normal_cell_styles );
					foreach( $normal_cell_styles as $style => $style_args ){
						call_user_func_array( array($td2_pre, 'add_style'), array_merge(array($style), $style_args) );
						call_user_func_array( array($td2, 'add_style'), array_merge(array($style), $style_args) );
					}
				}
				else {
					$td2
						->add_style('padding', 'b1', 'x1')
						;
				}

				if( $this->collapse_action ){
					$tr2
						->add( $td2_pre )
						;
					$tr2
						->add_attr('class', 'hcj2-collapse')
						;
				}
				else {
					$td2
						->add_style('font-size', -1)
						->add_style('mute', 2)
						;
					
				}

				$tr2
					->add( $td2 )
					;
			}

			if( $action_row ){
				// $out->add( $tr );
				// $out->add( $tr2 );
			// wrap it in tbody
				$tbody = $this->_render_tbody()
					->add_attr('class', 'hcj2-collapse-panel')
					->add_style('border', 'top', 'bottom')
					;

				$tbody
					->add( $tr )
					->add( $tr2 )
					;
				$out->add( $tbody );
			}
			else {
				$out->add( $tr );
				// $tbody = $this->_render_tbody()
					// ->add_attr('class', 'hcj2-ajax-container')
					// ->add_attr('style', 'border: red 1px solid;')
					// ;
				// $tbody
					// ->add( $tr )
					// ;
				// $out->add( $tbody );
				// $out->add( $tr );
			}
		}

	// additional
		$children = $this->children();
		foreach( $children as $child ){
			$out->add( $child );
		}

	// footer
		$footer = $this->footer();
		if( $footer ){
			$tr = $this->_render_row();

			reset( $footer );
			foreach( $footer as $k => $v ){
				$td = $this->_render_cell( $v, 'td' );

				reset( $normal_cell_styles );
				foreach( $normal_cell_styles as $style => $style_args ){
					call_user_func_array( array($td, 'add_style'), array_merge(array($style), $style_args) );
				}
				$td
					// ->add_style('font-size', -1)
					->add_style('font-size', +1)
					// ->add_style('font-style', 'regular')
					;
				$tr->add( $td );
			}

			$tr
				->add_style('border', 'top')
				->add_style('border-color', 'gray')
				;
			$out->add( $tr );
		}

		$full_out
			->add( $out )
			;

		$full_out
			->add_attr('style', 'border-collapse: collapse;')
			// ->add_style('border')
			;

		return $full_out;
	}
}