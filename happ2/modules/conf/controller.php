<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Conf_Controller_HC_MVC extends _HC_MVC
{
	function route_index()
	{
		$args = hc2_parse_args( func_get_args() );
		$tab = isset($args['tab']) ? $args['tab'] : '';

		$config_loader = $this->make('/app/lib/config-loader');
		$fields = $config_loader->get('settings');

		$tabs = $this->run('get-tabs', $fields);

		$tab_keys = array_keys($tabs);
		if( ! $tab ){
			$tab = $tab_keys[0];
		}

		$form = $this->run('form', $tab);

		return $this->run('prepare-view', $tab, $form);
	}

	public function defaults( $tab )
	{
		$defaults = array();

		$config_loader = $this->make('/app/lib/config-loader');
		$app_settings = $this->make('/app/lib/settings');

		$fields = $config_loader->get('settings');

		$tabs = $this->run('get-tabs', $fields);
		$this_fields = $tabs[$tab];

		foreach( $this_fields as $fk => $fn ){
			if( $fk == '_label'){
				continue;
			}
			$defaults[$fn] = $app_settings->get($fn);
		}

		return $defaults;
	}

	public function form( $tab )
	{
		$config_loader = $this->make('/app/lib/config-loader');
		$app_settings = $this->make('/app/lib/settings');

		$fields = $config_loader->get('settings');
		$tabs = $this->run('get-tabs', $fields);

		$this_fields = $tabs[$tab];
		$form = new _HC_Form;
		$defaults = $this->run('defaults', $tab);

		foreach( $this_fields as $fk => $fn ){
			if( $fk == '_label'){
				continue;
			}

			$f = $fields[ $fk ];
			$defaults[$fn] = $app_settings->get($fn);

			$input = $this->make('/form/view/' . $f['type']);

			switch( $f['type'] ){
				case 'dropdown':
					$input->set_options( $f['options'] );
					if( count($f['options']) < 2 ){
						$input->set_readonly();
					}
					break;

				case 'radio':
					$input->set_options( $f['options'] )->set_inline();
					if( count($f['options']) < 2 ){
						$input->set_readonly();
					}
					break;

				case 'checkbox_set':
					$input->set_options( $f['options'] );

					if( isset($f['dependencies']) ){
						$input->set_dependencies( $f['dependencies'] );
					}
					if( isset($f['inline']) ){
						$input->set_inline($f['inline']);
					}
					if( count($f['options']) < 2 ){
						$input->set_readonly();
					}
					break;
			}

			if( isset($f['label']) ){
				$input->set_label($f['label']);
			}

			$form->set_input( 
				$fn,
				$input
				);
		}
		$form->set_values( $defaults );
		return $form;
	}

	public function prepare_view( $tab, $form )
	{
		$config_loader = $this->make('/app/lib/config-loader');
		$fields = $config_loader->get('settings');
		$tabs = $this->run('get-tabs', $fields);
		// $tab_keys = array_keys($tabs);
		// if( ! $tab ){
			// $tab = $tab_keys[0];
		// }

		$view = $this->make('view')
			->run('render', $form)
			;

		$header = $this->make('view/header');
		$menubar = $this->make('view/menubar')
			->run('render', $tabs, array($tab))
			;

		$view = $this->make('/layout/view/content-header-menubar')
			->set_content( $view )
			->set_header( $header )
			->set_menubar( $menubar )
			;
		$view = $this->make('/layout/view/body')
			->set_content($view)
			;
		return $this->make('/http/view/response')
			->set_view($view)
			;
	}

	public function get_tabs( $fields ){
		$tabs = array();
		foreach( $fields as $fn => $f ){
			$this_tab = 'core';
			if( strpos($fn, ':') !== FALSE ){
				list( $this_tab, $this_short_fn ) = explode( ':', $fn );
			}
			$this_tab = str_replace('_', '-', $this_tab);

			if( ! isset($tabs[$this_tab])){
				$tabs[$this_tab] = array();
			}

			if( $this_short_fn == '_label' ){
				$tabs[$this_tab][$this_short_fn] = $f;
			}
			else {
				$tabs[$this_tab][$fn] = $fn;
			}
		}

	// remove those without labels
		$check = array_keys($tabs);
		foreach( $check as $tab ){
			if( ! isset($tabs[$tab]['_label']) ){
				unset( $tabs[$tab] );
			}
		}

		return $tabs;
	}
}