<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Msgbus_Controller_Message_RB_HC_MVC extends _HC_MVC
{
	public function extend_message( $return, $params, $model )
	{
		$msg = NULL;
		$msg_key = NULL;
		$error = NULL;

		if( $return ){
			if( $model->exists() ){
				$changes = $model->changes();
				if( $changes ){
					$p = $this->make('/resources/presenter')
						->set_data( $model->to_array() )
						;
					if( array_key_exists('id', $changes) ){
						$msg = HCM::__('Resource added');
						$msg_key = 'resource-add-' . $model->id();
					}
					else {
						$msg = HCM::__('Resource updated');
						$msg_key = 'resource-update-' . $model->id();
					}
					$msg .= ': ' . $p->present_title();
				}
			}
			else {
				$msg = HCM::__('Resource deleted');
				$msg_key = 'resource-delete-' . $model->id();
			}
		}
		else {
			$error = $model->errors();
		}

		$msgbus = $this->make('/msgbus/lib');
		if( $msg ){
			$msgbus->add('message', $msg, $msg_key);
		}
		if( $error ){
			$msgbus->add('error', $error, $msg_key);
		}
	}
}