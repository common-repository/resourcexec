<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Calendar_View_RB_HC_MVC extends _HC_MVC
{
	public function render_week( $resources, $dates, $bookings )
	{
		$t = $this->make('/app/lib')->run('time');

		$out = $this->make('/html/view/container');

		$date_nav = $this->make('/html/view/date-nav');
		$date_nav->set_enabled( array('week') );

		$navbar = $this->make('/html/view/list-inline')
			->set_separated(1)
			->add_attr('style', 'vertical-align: top;')
			->add_style('margin', 'b2')
			;

		$navbar
			->add('date-nav',
				$date_nav
					->run('render')
					// ->add_attr('style', 'vertical-align: top;')
				)
			;

		$out->add('navbar', $navbar );

		$table = $this->make('/html/view/table')
			->set_striped( FALSE )
			->add_cell_style('padding', 'x2', 'y2')
			->add_cell_style('border')
			->add_cell_style('text-align', 'center')
			// ->add_cell_style('col', 'xs', '12.5%')
			->add_attr('style', 'table-layout: fixed;')
			;

		$ROWS = array();

		$row = array();
		$row[] = '';
		foreach( $dates as $date ){
			$t->setDateDb( $date );
			$date_view = $this->make('/html/view/list')
				->add( $t->formatWeekdayShort() )
				->add( $t->formatDate() )
				;
			$row[] = $date_view;
		}
		$ROWS[] = $row;

		$pr = $this->make('/resources/presenter');
		$w = $this->make('/bookings/view/widget')
			->add_link_arg('--back', 'calendar')
			;

		foreach( $resources as $r ){
			$this_rid = $r['id'];
			$row = array();
			$pr->set_data( $r );
			$row[] = $pr->present_title();

			reset( $dates );
			foreach( $dates as $date ){
				$cell = $this->make('/html/view/container');

			// current bookings
				if( isset($bookings[$date]) ){
					foreach( $bookings[$date] as $booking ){
						if( ! isset($booking['resources'][$this_rid]) ){
							continue;
						}
						$booking_view = $w->run('render', $booking, $date, $r);
						$booking_view
							->add_style('margin', 'b2')
							;
						$cell->add( $booking_view );
					}
				}

			// add booking
				$link = $this->make('/html/view/link')
					->to('/bookings/new', array('-date' => $date, '-resource' => $this_rid, '--back' => 'calendar'))
					->add( $this->make('/html/view/icon')->icon('plus') )
					->add_attr('title', HCM::__('New Booking'))
					// ->add( HCM::__('New Booking') )
					->add_style('block-link')
					->add_style('font-size', +2)
					->add_style('mute')
					->add_style('font-style', 'decoration-none')
					;

				$cell->add( $link );

				$row[] = $cell;
			}

			$ROWS[] = $row;
		}
		$table->set_rows( $ROWS );
		
		$out->add('calendar', $table);
		
		
		
		return $out;
	}
}