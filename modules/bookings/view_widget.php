<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_View_Widget_RB_HC_MVC extends _HC_MVC
{
	protected $new_window = FALSE;
	protected $add_link_args = array();

	public function new_window( $new_window = TRUE )
	{
		$this->new_window = $new_window;
		return $this;
	}

	public function add_link_arg( $k, $v )
	{
		$this->add_link_args[ $k ] = $v;
		return $this;
	}

	public function render_compact( $booking )
	{
		$details = $this->prepare_view($booking);
		return $this->_render( $booking, $details );
	}

	public function render( $booking, $date = NULL, $resource = NULL )
	{
		$details = $this->run('prepare-view', $booking, $date, $resource);
		return $this->_render( $booking, $details, $date, $resource );
	}

	protected function _render( $booking, $details, $date = NULL, $resource = NULL )
	{
		if( $date ){
			list( $dura_qty, $dura_units ) = explode(' ', $booking['duration']);
			if( in_array($dura_units, array('minutes', 'hours')) ){
				unset($details['date']);
			}
		}

		$return = $this->make('/html/view/element')->tag('div')
			->add_style('box')
			->add_style('text-align', 'left')
			;

		$label_view = array();
		if( isset($details['time']) && strlen($details['time']) ){
			$time_view = $details['time'];
			if( isset($details['date']) ){
				$time_view = '[' . $time_view . ']';
			}
			$label_view[] = $time_view;
			unset($details['time']);
		}
		if( isset($details['date']) ){
			$date_view = $details['date'];
			$label_view[] = $date_view;
			unset($details['date']);
		}
		$label_view = join(' ', $label_view);

		$link_args = array();
		$link_args['id'] = $booking['id'];
		foreach( $this->add_link_args as $k => $v ){
			if( ! isset($link_args[$k]) ){
				$link_args[$k] = $v;
			}
		}

		$label_view = $this->make('/html/view/link')
			->to('/bookings/zoom', $link_args)
			->add( $label_view )
			->always_show()
			;

		$id_view = $this->make('/html/view/element')->tag('span')
			->add('id:' . $booking['id'])
			->add_style('font-size', -1)
			->add_style('mute')
			;
		$label_view .= ' ' . $id_view;

		if( isset($details['conflicts']) && $details['conflicts'] ){
			$label_view = $details['conflicts'] . $label_view;
			unset( $details['conflicts'] );
			$return
				->add_style('border-color', 'red')
				;
		}

		array_unshift( $details, $label_view );
		// $details['label'] = $label_view;

		$list = $this->make('/html/view/list')
			->add_style('nowrap')
			;
		foreach( $details as $k => $v ){
			$v_striped = strip_tags( $v );
			$detail = $this->make('/html/view/element')->tag('span')
				->add( $v )
				->add_attr('title', $v_striped)
				;
			$list->add( $detail );
		}

		$return->add( $list );
		return $return;
	}

	public function prepare_view( $booking, $date = NULL, $resource = NULL )
	{
		$return = array();

		$p = $this->make('/bookings/presenter');
		$p->set_data( $booking );

		// $label_view = $this->make('/html/view/link')
			// ->to('/bookings/zoom', $booking['id'])
			// ->add( $p->present_title_id() )
			// ->always_show()
			// ;
		// $return['label'] = $label_view;

		$return['time'] = $p->present_time();
		$return['date'] = $p->present_date();

		return $return;
	}
}