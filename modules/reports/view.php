<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Reports_View_RB_HC_MVC extends _HC_MVC
{
	public function render( $report, $reports )
	{
		$out = $this->make('/html/view/container');

		$submenu = $this->make('/html/view/list-inline')
			->add_style('margin', 'b2')
			;

	// add resource dropdown
		$resource_select = $this->make('/app/view/resource-select');
		$submenu->add(
			'resource-select',
			$resource_select
			);

	// report select
		$report_select = $this->make('/html/view/select-links');

		foreach( $reports as $rtab => $r ){
			$tabs[$rtab] = $r->title();
		}

		foreach( $reports as $rtab => $r ){
			$to = $this->make('/html/view/link')
				->to('', array('--report' => $rtab))
				->href();
				;
			if( $to ){
				$rlabel = $r->title();
				$report_select
					->add_option( $rtab, $rlabel, $to )
					;
			}
		}

		$submenu->add(
			'report-select',
			$report_select
			);
	
		$out->add('submenu', $submenu);
		$out->add('report', $report);

		return $out;
	}
}