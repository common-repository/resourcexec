<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Conflicts_View_Overlap_RB_HC_MVC extends _HC_MVC
{
	public function extend_prepare_view( $return, $args )
	{
		$entries = array_shift($args);
		if( ! (isset($entries['overlap']) && $entries['overlap']) ){
			return $return;
		}
		$my = $entries['overlap'];

		$my_return = $this->make('/html/view/list')
			->add_style('margin', 'b2')
			;

		$p = $this->make('/bookings/view/widget')
			->new_window()
			;
		$t = $this->make('/app/lib')->run('time');

		if( $my['bookings'] ){
			$this_subreturn = $this->make('/html/view/list')
				->add_style('margin', 'b1', 'l3', 't1')
				;
			foreach( $my['bookings'] as $booking ){
				$this_subreturn
					->add(
						$p->run('render-compact', $booking)
							->add_style('margin', 'b1')
						)
					;
			}
			$my_return->add( $this_subreturn );
		}

		$title = $this->make('/html/view/element')->tag('a')
			->add( HCM::__('Overlap') )
			->add_style('color', 'red')
			;
		$my_return = $this->make('/html/view/collapse')
			->set_title( $title )
			->set_content( $my_return )
			->add_style('box')
			->add_style('border-color', 'red')
			;

		$return->add( $my_return );
		return $return;
	}
}