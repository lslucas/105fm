<?php

class Login_Controller extends Base_Controller
{
	public $restfull = true;


	public function action_index()
	{
		$this->logRequest();
		return View::make('login.form');
	}


	public function post_authenticate()
	{

	}


	public function get_user()
	{
		$user_id = Input::get('id');
	}


	public function post_user()
	{
		$email = Input::get('email');
		$password = Input::get('password');
		//Create a new User
		$user = User::create($email, $password);
	}
}