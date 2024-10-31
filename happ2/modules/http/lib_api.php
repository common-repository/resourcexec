<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
// this is a class to call our rest api internally, as if it's done through http
class Http_Lib_Api_HC_MVC extends _HC_MVC
{
	private $route = NULL;
	private $body = NULL;
	private $status_code = NULL;
	private $params = array();

	public function request( $route )
	{
		$this->route = $route;
		return $this;
	}

	public function add_param()
	{
		$ps = func_get_args();
		foreach( $ps as $p ){
			$this->params[] = $p;
		}
		return $this;
	}

	public function get( $params = NULL )
	{
		$params = $this->params;

		list( $controller, $method ) = $this->app->route( $this->route );
		$method = 'get';

		$args = array();
		if( $params ){
			// $args[] = $params;
			$args = $params;
		}

		$mvc = $this->make( $controller );
		$out = $this->app->run( $mvc, $method, $args );

		$this->status_code = $out->status_code();

		if( substr($this->status_code, 0, 1) != '4' ){
			$body = $out->view();
			$body = json_decode( $body, TRUE );
			$this->body = $body;
			
		}

		// if( $this->status_code == '404' ){
			// $return = $this->make('/html/view/404');
			// echo $return;
			// return $this;
			// exit;
		// }


		$this->params = array();
		return $this;
	}

// add
	public function post( $input = NULL )
	{
		if( $input !== NULL ){
			$input = json_encode( $input );
		}

		list( $controller, $method ) = $this->app->route( $this->route );
		$method = 'post';

		$args = array();
		if( $input ){
			$args[] = $input;
		}

		$mvc = $this->make( $controller );
		$out = $this->app->run( $mvc, $method, $args );

		$this->status_code = $out->status_code();
		$body = $out->view();

		if( $this->status_code == '404' ){
			$return = $this->make('/html/view/404');
			echo $return;
			exit;
		}

		$body = json_decode( $body, TRUE );
		$this->body = $body;

		return $this;
	}

// update
	public function put( $params = NULL, $input = NULL )
	{
		list( $controller, $method ) = $this->app->route( $this->route );
		$method = 'put';

		$args = array();
		$args[] = $params;
		if( $input !== NULL ){
			$input = json_encode( $input );
		}
		$args[] = $input;

		$mvc = $this->make( $controller );
		$out = $this->app->run( $mvc, $method, $args );

		$this->status_code = $out->status_code();
		$body = $out->view();
		$body = json_decode( $body, TRUE );
		$this->body = $body;

		return $this;
	}

	public function delete( $params = NULL )
	{
		list( $controller, $method ) = $this->app->route( $this->route );
		$method = 'delete';

		$args = array();
		if( $params ){
			$args[] = $params;
		}
		$mvc = $this->make( $controller );
		$out = $this->app->run( $mvc, $method, $args );

		$this->status_code = $out->status_code();
		$body = $out->view();
		if( $body ){
			$body = json_decode( $body, TRUE );
			$this->body = $body;
		}

		return $this;
	}

	public function response()
	{
		return $this->body;
	}

	public function response_code()
	{
		return $this->status_code;
	}

	public function url()
	{
		$uri = $this->make('/http/lib/uri');
		$params = $this->params;
		$return = $uri->url( $this->route, $params );

		return $return;
	}
}