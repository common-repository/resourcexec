<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class App_View_Resource_Select_RB_HC_MVC extends _HC_Form
{
	public function render()
	{
		$api = $this->make('/http/lib/api')
			->request('/api/resources')
			->get()
			;
		$resources = $api->response();

		$uri = $this->make('/http/lib/uri');
		$rid = $uri->arg('resource');
		$p = $this->make('/resources/presenter');

		$uri = $this->make('/http/lib/uri');
		$current_slug = $uri->slug();
		$current_slug = '/' . $current_slug;

		$out = $this->make('/html/view/select-links');

	// all
		$title = ' - ' . HCM::__('All Resources') . ' - ';
		$to = $this->make('/html/view/link')
			->to($current_slug, array('--resource' => NULL))
			->href();
			;
		$out
			->add_option( 0, $title, $to )
			;

		foreach( $resources as $r ){
			$to = $this->make('/html/view/link')
				->to($current_slug, array('--resource' => $r['id']))
				->href();
				;

			if( ! $to ){
				continue;
			}

			$p->set_data( $r );
			$out
				->add_option( $r['id'], $p->present_title(), $to )
				;
		}

		if( $rid ){
			$out->set_selected( $rid );
		}

		return $out;
	}
}