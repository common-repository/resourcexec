<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Agenda_Resources_View_Resources_Zoom_Menubar_RB_HC_MVC extends _HC_MVC
{
	public function extend_render( $menubar, $args, $src )
	{
		$resource = array_shift( $args );

		$menubar->add(
			'agenda',
			$this->make('/html/view/link')
				->to('/agenda', array('--resource' => $resource['id']))
				->add( $this->make('/html/view/icon')->icon('calendar') )
				->add( HCM::__('Agenda') )
			);
		return $menubar;
	}
}