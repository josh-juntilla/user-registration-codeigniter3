<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User
{
	public function __get($var)
	{
		return get_instance()->$var;
	}

	/**
	 * Check user if logged in
 	 *
 	 * @return bool
	 */
	public function isLoggedIn()
	{
		if(!empty($this->session->userdata('email'))) {
			
			return true;
		}

		return false;
	}
}