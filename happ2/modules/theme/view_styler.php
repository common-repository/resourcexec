<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Theme_View_Styler_HC_MVC extends _HC_MVC
{
	public function apply( $args, $src )
	{
		if( method_exists($src, 'styles') ){
			$styles = $src->styles();
			$classes = $this->style( $styles );
			if( $classes ){
				$src->add_attr('class', $classes);
			}
		}
	}

	public function style( $styles )
	{
		$classes = array();
		foreach( $styles as $style => $args ){
			$method = str_replace( '-', '_', $style );
			$this_classes = call_user_func_array( array($this, $method), $args );

			if( ! is_array($this_classes) ){
				$this_classes = array($this_classes);
			}
			if( $this_classes ){
				$classes = array_merge( $classes, $this_classes );
			}
		}
		return $classes;
	}

	function form_control_static()
	{
		$return = array('hc-form-control-static');
		return $return;
	}

	public function spin()
	{
		$return = array('hc-spin');
		return $return;
	}

	function table( $more = array() )
	{
		$return = array('hc-table');

		if( $more && (! is_array($more)) ){
			$more = array($more);
		}
		foreach( $more as $mr ){
			switch( $mr ){
				case 'border':
					$return[] = 'hc-table-light';
					break;
			}
		}
		return $return;
	}

	public function tab_link()
	{
		$return = $this->run('style',
			array(
				'padding'	=> array('x2', 'y2'),
				'margin'	=> array(0),
				// 'nowrap'	=> array(),
				'display'	=> array('inline-block'),
				'rounded'	=> array(),
				'font-style'	=> array('decoration-none-hover'),
				'bg-color'		=> array('silver-hover'),
				)
			);
		return $return;
	}

	public function block_link()
	{
		$return = $this->run('style',
			array(
				// 'font-size'	=> array(-1),
				'padding'	=> array('x2', 'y2'),
				'nowrap'	=> array(),
				'display'	=> array('block'),
				'rounded'	=> array(),
				'font-style'	=> array('decoration-none-hover'),
				'bg-color'		=> array('silver-hover'),
				)
			);
		return $return;
	}

	public function char()
	{
		$return = array('hc-char');
		return $return;
	}

	public function block_info()
	{
		$return = $this->run('style',
			array(
				'padding'	=> array('y2'),
				'nowrap'	=> array(),
				'display'	=> array('block'),
				'rounded'	=> array(),
				)
			);
		return $return;
	}

	function btn()
	{
		$return = array('hc-btn');
		return $return;
	}

	function btn_submit( $padding_x = 2, $padding_y = NULL )
	{
		if( $padding_y === NULL ){
			$padding_y = $padding_x;
		}

		$return = $this->run('style',
			array(
				'padding'	=> array( 'x' . $padding_x, 'y' . $padding_y ),
				'rounded'	=> array(),
				'border'	=> array(),
				)
			);
		return $return;
	}

	function badge()
	{
		$return = $this->run('style',
			array(
				'font-size'	=> array(-1),
				'padding'	=> array('x2', 'y1'),
				'display'	=> array('inline-block'),
				'rounded'	=> array(),
				'nowrap'	=> array(),

				'color'			=> array('white'),
				'bg-color'		=> array('gray'),
				)
			);
		return $return;
	}

	function label()
	{
		$return = $this->run('style',
			array(
				'font-size'	=> array(-1),
				'padding'	=> array('x2', 'y1'),
				'rounded'	=> array(),
				'nowrap'	=> array(),

				'color'			=> array('white'),
				'bg-color'		=> array('gray'),
				)
			);
		return $return;
	}

	function inline( $when = '' )
	{
		$class = 'hc-inline-block';
		if( $when ){
			$class .= '-' . $when;
		}
		$return = array($class);
		return $return;
	}

	function grid( $gutter = 0 )
	{
		$return = array();
		$return[] = 'hc-clearfix';
		if( $gutter ){
			$return[] = 'hc-mxn' . $gutter;
		}
		return $return;
	}

	function col( $scale, $width, $offset = 0, $gutter = NULL, $right = 0 )
	{
		$class = array();

		$manual = FALSE;
		$check_manual = array('%', 'em', 'px', 'rem');
		/* check if width contains %% then we need to set it manually */
		foreach( $check_manual as $check ){
			if( substr($width, -strlen($check)) == $check ){
				$manual = TRUE;
				break;
			}
		}

		switch( $scale ){
			case 'xs':
				$class = array('hc-col');
				if( ! $manual ){
					$class[] = 'hc-col-' . $width;
				}
				if( $right ){
					$class[] = 'hc-col-right';
				}
				break;
			case 'sm':
				$class = array('hc-sm-col');
				if( ! $manual ){
					$class[] = 'hc-sm-col-' . $width;
				}
				if( $right ){
					$class[] = 'hc-sm-col-right';
				}
				break;
			case 'md':
				$class = array('hc-md-col');
				if( ! $manual ){
					$class[] = 'hc-md-col-' . $width;
				}
				if( $right ){
					$class[] = 'hc-md-col-right';
				}
				break;
			case 'lg':
				$class = array('hc-lg-col');
				if( ! $manual ){
					$class[] = 'hc-ld-col-' . $width;
				}
				if( $right ){
					$class[] = 'hc-ld-col-right';
				}
				break;
		}

		if( $manual ){
			$el->add_attr('style', 'width: ' . $width . ';');
		}
		if( $offset ){
			$el->add_attr('style', 'margin-left: ' . $offset . ';');
		}

		if( $gutter ){
			$class[] = 'hc-px' . $gutter;
		}
		return $class;
	}

	function form_control()
	{
		$return = array('hc-field');
		return $return;
	}

	function border( $where = '' )
	{
		$where = func_get_args();
		if( ! $where ){
			$where = array('');
		}
		if( ! is_array($where) ){
			$where = array( $where );
		}

		$return = array();
		foreach( $where as $this_where ){
			if( $this_where === 0 ){
				$this_where = 'none';
			}
			$class = $this_where ? 'hc-border-' . $this_where : 'hc-border';
			$return[] = $class;
		}
		return $return;
	}

	function rounded()
	{
		$return = array('hc-rounded');
		return $return;
	}

	function box( $padding = 2, $border = 1 )
	{
		$style = array(
			'padding'	=> array($padding),
			'rounded'	=> array(),
			'display'	=> array('block'),
			);
		if( $border ){
			$style['border'] = array();
		}

		$return = $this->run('style', $style);
		return $return;
	}

	function display( $how )
	{
		$return = array('hc-' . $how);
		return $return;
	}

/* xs, sm, md, lg */
	function visible( $when )
	{
		$return = array('hc-' . $when . '-' . 'show');
		return $return;
	}
	function show( $when )
	{
		$return = array('hc-' . $when . '-' . 'show');
		return $return;
	}
	function hidden( $when )
	{
		$return = array('hc-' . $when . '-' . 'hide');
		return $return;
	}
	function hide( $when )
	{
		$return = array('hc-' . $when . '-' . 'hide');
		return $return;
	}

/* from 1 to 3 */
	function mute( $change = 2 )
	{
		$return = array('hc-muted-' . $change);
		return $return;
	}

	function font_style( $style = 'italic' ) // italic, bold, caps, regular, underline
	{
		$return = array('hc-' . $style);
		return $return;
	}

/* from -2 to +2 */
	function font_size( $change_size = 0 )
	{
		$size = 3 + $change_size;
		$return = array('hc-fs' . $size);
		return $return;
	}

/* from 0 to 3, or x1, y2 etc */
	function padding( $scale = 1 )
	{
		$scale = func_get_args();
		if( ! $scale ){
			$scale = array(1);
		}

		$return = array();
		foreach( $scale as $sc ){
			$return[] = 'hc-p' . $sc;
		}
		return $return;
	}

	function margin( $scale = 1 )
	{
		$scale = func_get_args();
		if( ! $scale ){
			$scale = array(1);
		}

		$return = array();
		foreach( $scale as $sc ){
			$return[] = 'hc-m' . $sc;
		}
		return $return;
	}

	function closer( $no_float = FALSE )
	{
		if( $no_float ){
			$return = array('hc-close-nofloat');
		}
		else {
			$return = array('hc-close');
		}
		return $return;
	}

	function left()
	{
		$class = $when ? 'hc-left-' . $when : 'hc-left';
		$return = array($class);
		return $return;
	}
	function right( $when = NULL )
	{
		$class = $when ? 'hc-right-' . $when : 'hc-right';
		$return = array($class);
		return $return;
	}

	function text_align( $how )
	{
		$return = array('hc-align-' . $how);
		return $return;
	}

	function nowrap()
	{
		$return = array('hc-nowrap');
		return $return;
	}

	function color( $color )
	{
		$return = array('hc-' . $color);
		return $return;
	}
	function bg_color( $color )
	{
		$return = array('hc-bg-' . $color);
		return $return;
	}
	function border_color( $color )
	{
		$return = array('hc-border-' . $color);
		return $return;
	}
	/* up to 4 */
	function bg_lighten( $scale = 1 )
	{
		$return = array('hc-bg-lighten-' . $scale);
		return $return;
	}
	/* up to 4 */
	function bg_darken( $scale = 1 )
	{
		$return = array('hc-bg-darken-' . $scale);
		return $return;
	}
	function form_error()
	{
		$return = $this->run('style',
			array(
				'color'	=> array('red'),
				)
			);
		return $return;
	}

	function btn_success()
	{
		$style = array(
			'btn'			=> array(),
			'btn-submit'	=> array(),
			'color'			=> array('white'),
			'bg-color'		=> array('green'),
			'border-color'		=> array('green'),
			);
		$return = $this->style($style);
		return $return;
	}

	function btn_primary()
	{
		$style = array(
			'btn'			=> array(),
			'btn-submit'	=> array(),
			'color'			=> array('white'),
			'bg-color'		=> array('blue'),
			);
		$return = $this->style($style);
		return $return;
	}

	function btn_secondary()
	{
		$style = array(
			'btn'			=> array(),
			'btn-submit'	=> array(),
			'bg-color'		=> array('silver'),
			);
		$return = $this->style($style);
		return $return;
	}

	function btn_disabled()
	{
		$style = array(
			'mute'			=> array(),
			);
		$return = $this->style($style);
		return $return;
	}

	function btn_danger()
	{
		$style = array(
			'btn'			=> array(),
			'btn-submit'	=> array(),
			'border-color'	=> array('red'),
			'color'			=> array('red'),
			);
		$return = $this->style($style);
		return $return;
	}
}