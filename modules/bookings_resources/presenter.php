<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_Presenter_RB_HC_MVC extends _HC_MVC_Model_Presenter
{
	public function present_resources()
	{
		$resources = $this->data('resources');
		$many = 5;

		if( $resources ){
			if( count($resources) > $many ){
/* translators: 1 Resource, 12 Resources */
				$return = sprintf( HCM::_n('%d Resource', '%d Resources', count($resources)), count($resources) );
			}
			else {
				$return = array();

				$p = $this->make('/resources/presenter');
				while( $resource = array_shift($resources) ){
					$p->set_data( $resource );
					$return[] = $p->present_title();
				}
				$return = join(', ', $return);
			}
		}
		else {
			$return = $this->make('/html/view/element')->tag('span')
				// ->add( $this->make('/html/view/icon')->icon('exclamation') )
				->add( HCM::__('No Resources Assigned') )
				->add_style('color', 'maroon')
				;
		}
		return $return;
	}
}