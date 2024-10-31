<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Form_RB_HC_MVC extends _HC_Form
{
	public function _init()
	{
		$this
			->set_input( 'name',
				$this->make('/form/view/text')
					->set_label( HCM::__('Name') )
					->add_attr('size', 32)

					->add_validator( $this->make('/validate/required') )
				)
			->set_input( 'description',
				$this->make('/form/view/textarea')
					->set_label( HCM::__('Description') )
						->add_attr('cols', 40)
						->add_attr('rows', 3)
				)
			;

		return $this;
	}
}