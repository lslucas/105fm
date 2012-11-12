<?php

class Customer_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
	{
		// code here..
		$status = array('inactive-icon', 'active-icon');
		$statusURL = array('activate', 'deactivate');

		$customer = new Customer();
	    
		return View::make('customer.index')->with('customers', $customer->get())
			   ->with('status', $status)
			   ->with('statusURL', $statusURL);

	}

	public function get_new()
	{
		// code here..
		return View::make('customer.new');
	}

	public function put_new()
	{

		$customer = new Customer();
		$customer->slug = Input::get('name') . '-' . ($customer->count() + 1);
		$customer->active = 0;
		
		$customer->hash_id = $this->generateHash($customer);

		
		$customer->fill(Input::get());

		if($customer->save()):
			
			return View::make('customer.new')
				   ->with('response', array('msg' =>'Customer succesfully saved ! Yeah !', 'info' => 'alert alert-success'));
		else:
			return View::make('customer.new')
				   ->with('response', array('msg' =>'Oops , not saved !', 'info' => 'alert alert-error')); 

		endif;
	}

	public function get_update($hash_id)
	{

		$customer = new Customer;
		return View::make('customer.update')
			   ->with('customer', $customer->where('hash_id', $hash_id)->first())
			   ->with('hash_id', $hash_id);
	}

	public function put_update($hash_id)
	{

		$customer = new Customer();
		$customer = $customer->where('hash_id', $hash_id)->first();
	

		$customer->fill(Input::get());
		
		if($customer->save()):
			
			return View::make('customer.update')
				     ->with('response', array('msg' =>'Customer succesfully saved ! Yeah !', 'info' => 'alert alert-success'))
				     ->with('hash_id', $hash_id)
				     ->with('customer', $customer);
		else:

			return View::make('customer.update')
				     ->with('response', array('msg' =>'Oops , not saved !', 'info' => 'alert alert-error'))
				     ->with('slug', $hash_id)
				     ->with('customer', $customer); 
		endif;

	}

	public function delete_delete($id)
	{
		// code here..
		$customer = new Customer();
		$customer->__set('_id', new MongoId($id));

		if($customer->remove()):
			return json_encode(array('error' => 0));
		else:
			return json_encode(array('error' => 1));
		endif;
	
	}

	public function action_status()
	{
		// code here..

		return View::make('customer.status');
	}

	public function action_login()
	{
		$this->logRequest();
		return View::make('customer.login');
	}

	public function post_deactivate($id)
	{
		$customer = new Customer();

		return json_encode(
				array(
					'success' =>$customer->where('hash_id', $id)->first()->set('active', 0)->save(),
			   		'msg' => preg_replace('/\_Controller/', '', get_class()) . ' succesfully dectivated'
			   		)
			   );
	}

	public function post_activate($id)
	{
		$customer = new Customer();
		
		return json_encode(
				array(
					'success' =>$customer->where('hash_id', $id)->first()->set('active', 1)->save(),
			   		'msg' => preg_replace('/\_Controller/', '', get_class()) . ' succesfully activated'
			   		)
			   );
	}


}
