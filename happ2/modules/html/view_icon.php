<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Html_View_Icon_HC_MVC extends Html_View_Element_HC_MVC
{
	private $icon = NULL;

	public function icon( $icon = NULL )
	{
		$config_loader = $this->make('/app/lib/config-loader');

		$icon_for = $config_loader->get('icons');
		if( isset($icon_for[$icon]) ){
			$icon = $icon_for[$icon];
		}
		$this->icon = $icon;
		return $this;
	}

	public function render()
	{
		switch( $this->icon ){
			case 'spinner':
				$return = $this->icon('cog')
					->run('render')
					->add_style('spin')
					;
				$return = $this->make('view/icon')->icon('spin')
					->run('render')
					->add_style('margin', 0)
					->add_style('padding', 0)
					;
					
				$return = $this->make('view/element')->tag('div')
					->add( $return )
					->add_style('spin')
					->add_style('display', 'inline-block')
					->add_style('margin', 0)
					->add_style('padding', 0)
					;

				// echo $return;
				// exit;
				break;

			default:
				$return = $this->icon;
		}



	// should be extended by concrete icon modules
		return $return;
	}
}
