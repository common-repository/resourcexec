<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Conf_Controller_Update_HC_MVC extends _HC_MVC
{
	function route_index( $tab = '' )
	{
		$args = hc2_parse_args( func_get_args() );
		$tab = isset($args['tab']) ? $args['tab'] : '';

		$config_loader = $this->make('/app/lib/config-loader');
		$app_settings = $this->make('/app/lib/settings');

		$fields = $config_loader->get('settings');
		$tabs = $this->make('controller')
			->run('get-tabs', $fields)
			;

		$tab_keys = array_keys($tabs);
		if( ! $tab ){
			$tab = $tab_keys[0];
		}

		$this_fields = $tabs[$tab];
		$form = $this->make('controller')
			->run('form', $tab)
			;

		foreach( $this_fields as $fn => $flabel ){
			if( $fn == '_label' ){
				continue;
			}

			$f = $fields[ $fn ];
			$defaults[$fn] = $app_settings->get($fn);
		}

		$post = $this->make('/input/lib')->post();
		$form->grab( $post );
		$values = $form->values();

		reset( $this_fields );
		foreach( $this_fields as $fn => $flabel ){
			if( $fn == '_label' ){
				continue;
			}
			if( array_key_exists($fn, $values) ){
				if( is_array($values[$fn]) OR strlen($values[$fn]) ){
					$app_settings->set( $fn, $values[$fn] );
				}
			}
		}

		$model = $this->make('model');
		$model->run('save');

	// redirect back
		$redirect_to = $this->make('/html/view/link')
			->to('')
			->href()
			;

		return $this->make('/http/view/response')
			->set_redirect($redirect_to) 
			;
	}
}