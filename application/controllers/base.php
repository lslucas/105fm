<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}


	public function __construct()
	{
		//Assets
		Asset::add('jquery', 'js/jquery-1.8.2.min.js');
		Asset::add('bootstrap-js', 'js/bootstrap.min.js');
		Asset::add('bootstrap-css', 'css/bootstrap.min.css');
		Asset::add('style', 'css/style.css');
		Asset::add('js', 'js/scripts.js');
		parent::__construct();
	}

	/**
	*
	*	generates short hash ID for a given model
	*	
	*	@param model $model
	*	@return $hash
	*
	*/

	public function generateHash(&$model)
	{
		$hash = new hashids( 'ja438f4rt45t' );
  		return $hash->encrypt($model->count(), $model->count() + 1);
	}

}