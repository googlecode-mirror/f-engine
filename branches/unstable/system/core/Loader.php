<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * F-engine
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.6
 * @filesource
 */
require('CI_Loader.php');
class CI_Loader extends Loader {

	/**
	 * Constructor
	 *
	 * Sets the path to the view files and gets the initial output buffering level
	 *
	 * @access	public
	 */
	function __construct()
	{	
		parent::__construct();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Load View
	 *
	 * This function is used to load a "view" file.  It has three parameters:
	 *
	 * 1. The name of the "view" file to be included.
	 * 2. An associative array of data to be extracted for use in the view.
	 * 3. TRUE/FALSE - whether to return the data or load it.  In
	 * some cases it's advantageous to be able to return data so that
	 * a developer can process it in some way.
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	void
	 */
	function view($view, $vars = array(), $return = FALSE)
	{
		return $this->_ci_load(array('_ci_view' => $view.'_view', '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}

	function masterview($view, $data=array(),$extra = 'default', $return = FALSE) {

		define('MASTERVIEW', TRUE);
		if(!file_exists(FCPATH.'config/masterview'.EXT))
			show_error('Unable to load requested file: '.FCPATH.'config/masterview'.EXT);

		if(!is_array($extra)) {

			$index = $extra;		
		}	

		require(FCPATH.'config/masterview'.EXT);
		foreach($conf[$index] as $key=> $val) {

			if($val == "")	unset($conf[$index][$key]);
		}

		if(!isset($wrapper)) {
			$wrapper = isset($conf[$index]["wrapper"]) ? $conf[$index]["wrapper"] : "wrapper";
		}

		$data = array_merge($conf[$index], $data);

		if(!function_exists("public_data")) {

			$fe =& get_instance();
			$fe->load->helper("url");
		}

		/*** set javascript files and ajax events ***/
		if(isset($data["js"]) and count($data["js"]) > 0) {

			require(FCPATH.'config/config'.EXT);

			if(!is_array($data["js"]))	$data["js"] = array($data["js"]);

			if(isset($config['compact']['js']) and $config['compact']['js'] == true) {

				$external_js = array();
				$local_js = array();
				$tmp_js = array();

				$i=0;
				foreach($data["js"] as $item) {

					if(strstr($item,"#")) {

						$external_js[$i] = str_replace("#",public_data("js")."/",$item);

					} elseif(preg_match("/^(https?:\/\/)?[a-z\-_]*\.[a-z\.]{0,6}\/.*\.js/i", $item)) {

						$external_js[$i] = $item;

					} else {

						if(isset($local_js[$i-1])) {

							$local_js[$i-1] .= ",".$item;
							continue;

						} else {

							$local_js[$i] = $item;
						}
					}
					$i++;
				} //endforeach

				if(count($external_js) > 0) {

					$data["js"] = array(
						"remote" => $external_js,
						"local" => $local_js
					);
				} else {

					$data["js"] = array(
						"local" => $local_js
					);
				}
			} else {

				$data["js"] = array(
					"local" => $data["js"]
				);
			}
		}

		$data["view"] = $view;
		$this->view($wrapper, $data, $return);	
	}

	function cache ($driver = '', $conf = array(), $return = false) {

		// Grab the super object
		$CI =& get_instance();

		// Do we even need to load the database class?
		if (class_exists('CI_Cache') AND $return == false AND isset($CI->cache) AND is_object($CI->cache))
		{
			return FALSE;
		}

		require_once(BASEPATH.'cache/cache'.EXT);

		// Load the DB class
		if($return) {

			return new CI_Cache($driver, $conf);

		} else {

			// Initialize the cache variable.  Needed to prevent   
			// reference errors with some configurations
			$CI->cache = '';
			$CI->cache = new CI_Cache($driver, $conf);		
		}
	}
}
/* End of file Loader.php */