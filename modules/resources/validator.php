<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Validator_RB_HC_MVC extends _HC_Validator
{
	public function prepare( $values )
	{
		$return = array();
		$id = isset($values['id']) ? $values['id'] : NULL;

		$return['name'] = array(
			'required'	=> array( $this->make('/validate/required') ),
			'maxlen'	=> array( $this->make('/validate/maxlen'), 100 ),
			'unique'	=> array( $this->make('/validate/unique'), 'resources', 'name', $id )
			);

		return $return;
	}
}