<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * F-engine
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.2
 * @filesource
 */
require('CI_URI.php');
class CI_URI extends URI {

	var $params = array();

	/**
	 * Constructor
	 *
	 * Simply globalizes the $RTR object.  The front
	 * loads the Router class early on so it's not available
	 * normally as other classes are.
	 *
	 * @access	public
	 */		
	function __construct()
	{
		parent::__construct();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Fetch a URI "routed" Params
	 *
	 * This function returns the re-routed URI segment (assuming routing rules are used)
	 * based on the number provided.  If there is no routing this function returns the
	 * same result as $this->segment()
	 *
	 * @access	public
	 * @param	integer
	 * @param	bool
	 * @return	string
	 */
	function param($n, $no_result = FALSE)
	{
		return ( ! isset($this->params[$n])) ? $no_result : $this->params[$n];
	}

	// --------------------------------------------------------------------

}
// END URI Class

/* End of file URI.php */