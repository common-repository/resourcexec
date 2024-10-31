<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Agenda_View_RB_HC_MVC extends _HC_MVC
{
	public function render( $bookings )
	{
		$t = $this->make('/app/lib')->run('time');

		$out = $this->make('/html/view/container');

		$report_view = $this->make('/html/view/list')
			->add_style('margin', 't2')
			;

		foreach( $bookings as $date => $bks ){
			$t->setDateDb( $date );
			$date_view = $t->formatDateFull();
			$date_view = $this->make('/html/view/element')->tag('h3')
				->add( $date_view )
				->add_style('margin', 'b1')
				;
			$report_view
				->add( $date_view )
				;

			$bookings_view = $this->make('/html/view/list')
				->add_style('margin', 'l3')
				;

			$w = $this->make('/bookings/view/widget')
				->add_link_arg('--back', 'agenda')
				;

			foreach( $bks as $booking ){
				$booking_view = $w->run('render', $booking, $date);
				$booking_view
					->add_style('margin', 'b2')
					;
				$bookings_view->add( $booking_view );
			}

			$report_view
				->add( $bookings_view )
				;
		}

		$date_nav = $this->make('/html/view/date-nav');
		$resource_select = $this->make('/app/view/resource-select');

		$navbar = $this->make('/html/view/list-inline')
			->set_separated(1)
			->add_attr('style', 'vertical-align: top;')
			;

		$navbar
			->add('resournce-select', 
				$resource_select
					->run('render')
					// ->add_attr('style', 'vertical-align: top;')
				)
			->add('date-nav',
				$date_nav
					->run('render')
					// ->add_attr('style', 'vertical-align: top;')
				)
			;

		$out->add('navbar', $navbar );
		$out->add('report', $report_view );

		return $out;
	}
}