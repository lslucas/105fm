<?php

class Hotel extends Eloquent {

	public function lists()
	{
		return $this->has_many('List');
	}

}
