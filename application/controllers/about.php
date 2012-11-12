<?php

class About_Controller extends Base_Controller {

	public function action_index()
	{
		return View::make('about.index', array(
	        'sidenav' => array(
	            array(
	                'url' => 'home',
	                'name' => 'Home',
	                'active' => false
	            ),
	            array(
	                'url' => 'about',
	                'name' => 'About',
	                'active' => true
	            )
	        )
	    ));
	}

}
