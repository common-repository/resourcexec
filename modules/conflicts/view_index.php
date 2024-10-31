<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Conflicts_View_Index_RB_HC_MVC extends _HC_MVC
{
	public function render( $entries )
	{
		$return = $this->run('prepare-view', $entries );
		return $return;
	}

	public function prepare_view( $entries )
	{
		$return = $this->make('/html/view/list');
		return $return;
	}
}