<?php  #namespace Helper;

class Helper {

	/**
	 * Obtain actual subdomain
	 * @return string or null; return a subdomain
	 */
	public static function getSubdomain()
	{
		$_subdomain = explode('.', $_SERVER['SERVER_NAME']);
		$_subdomain = $_subdomain[0];
		$subdomain = (in_array($_subdomain, array('techtravel', 'www', 'ww')) ? null : $_subdomain);
		return $subdomain;
	}

	/**
	 * Check if is a valid subdomain
	 * @return boolean true or false
	 */
	public static function isValidSubdomain()
	{
		if (!Helper::getSubdomain())
			return false;

		$ctmQuery = DB::table('customer')->where('ctm_techtravelSubdomain', '=', Helper::getSubdomain())->count();

		if ($ctmQuery==0)
			return false;
		else
			return true;
	}

}
