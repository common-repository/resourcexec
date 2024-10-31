<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Msgbus_Lib_HC_MVC extends _HC_MVC
{
	protected $msg = array();

	public function single_instance()
	{
	}

	public function add( $type, $text, $key = NULL )
	{
		if( ! isset($this->msg[$type]) ){
			$this->msg[$type] = array();
		}
		if( $key === NULL ){
			$this->msg[$type][] = $text;
		}
		else {
			$this->msg[$type][$key] = $text;
		}
	}

	public function get( $type = NULL )
	{
		if( $type !== NULL ){
			$return = isset($this->msg[$type]) ? $this->msg[$type] : NULL;
			return $return;
		}
		else {
			return $this->msg;
		}
	}
}