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
require('CI_Loader.php');
class CI_Loader extends Loader {

	/**
	 * Constructor
	 *
	 * Sets the path to the view files and gets the initial output buffering level
	 *
	 * @access	public
	 */
	function CI_Loader()
	{	
		$this->_ci_is_php5 = (floor(phpversion()) >= 5) ? TRUE : FALSE;
		$this->_ci_view_path = APPPATH.'views/';
		$this->_ci_ob_level  = ob_get_level();
				
		log_message('debug', "Loader Class Initialized");
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

	function f_view($file, $index, $data=array(),$wrapper = '', $return = FALSE) {

		if(!file_exists(APPPATH.'mvconf/'.$file.EXT))
			show_error('Unable to load requested file: '.APPPATH.'mvconf/'.$file.EXT);

		require(APPPATH.'mvconf/'.$file.EXT);
		foreach($conf[$index] as $key=> $val) {

			if($val == "")	unset($conf[$index][$key]);
		}

		if($wrapper == '') {
			$wrapper = isset($conf["wrapper"]) ? $conf[$index]["wrapper"] : "wrapper";
		}

		$this->view($wrapper, array_merge($conf[$index], $data), $return);	
	}

	function masterview($view, $data=array(),$extra = 'default', $return = FALSE) {

		if(!file_exists(APPPATH.'config/masterview'.EXT))
			show_error('Unable to load requested file: '.APPPATH.'config/masterview'.EXT);

		if(!is_array($extra)) {
		
			$index = $extra;		
		}	
			
		require(APPPATH.'config/masterview'.EXT);
		foreach($conf[$index] as $key=> $val) {

			if($val == "")	unset($conf[$index][$key]);
		}

		if(!isset($wrapper)) {
			$wrapper = isset($conf["wrapper"]) ? $conf[$index]["wrapper"] : "wrapper";
		}

		$data["view"] = $view;
		$this->view($wrapper, array_merge($conf[$index], $data), $return);	
	}
	
}
/* End of file Loader.php */