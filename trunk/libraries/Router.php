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

// ------------------------------------------------------------------------

require('CI_Router.php');
class CI_Router extends Router {
	
	/**
	 * Constructor
	 *
	 * Runs the route mapping function.
	 */
	function CI_Router()
	{
		$this->config =& load_class('Config');
		$this->uri =& load_class('URI');
		$this->_set_routing();
		log_message('debug', "Router Class Initialized");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set the route mapping
	 *
	 * This function determines what should be served based on the URI request,
	 * as well as any "routes" that have been set in the routing config file.
	 *
	 * @access	private
	 * @return	void
	 */
	function _set_routing()
	{		
		// Are query strings enabled in the config file?
		// If so, we're done since segment based URIs are not used with query strings.
		if ($this->config->item('enable_query_strings') === TRUE AND isset($_GET[$this->config->item('controller_trigger')]))
		{
			$this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));

			if (isset($_GET[$this->config->item('function_trigger')]))
			{
				$this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
			}
			
			return;
		}
		
		// Load the routes.php file.
		@include(APPPATH.'config/routes'.EXT);
		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
		unset($route);

		// Set the default controller so we can display it in the event
		// the URI doesn't correlated to a valid controller.
		$this->default_controller = ( ! isset($this->routes['default_controller']) OR $this->routes['default_controller'] == '') ? FALSE : strtolower($this->routes['default_controller']);
		
		// Fetch the complete URI string
		$this->uri->_fetch_uri_string();
	
		// Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
		if ($this->uri->uri_string == '')
		{
			if ($this->default_controller === FALSE)
			{
				show_error("Unable to determine what should be displayed. A default route has not been specified in the routing file.");
			}
			
			$path = explode('/',$this->default_controller);

			if(count($path) > 1) {
				
				$this->set_class($path[count($path)-1]);
				unset($path[count($path)-1]);
				$this->set_directory(implode('/',$path));
				
			} else {

				$this->set_class($path[count($path)-1]);
			}
			
			// re-index the routed segments array so it starts with 1 rather than 0
			$this->uri->_reindex_segments();
			
			log_message('debug', "No URI present. Default controller set.");
			return;
		}
		unset($this->routes['default_controller']);
		
		// Do we need to remove the URL suffix?
		$this->uri->_remove_url_suffix();
		
		// Compile the segments into an array
		$this->uri->_explode_segments();
		
		// Parse any custom routing that may exist
		$this->_parse_routes();		
		
		// Re-index the segment array so that it starts with 1 rather than 0
		$this->uri->_reindex_segments();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Set the Route
	 *
	 * This function takes an array of URI segments as
	 * input, and sets the current class/method
	 *
	 * @access	private
	 * @param	array
	 * @param	bool
	 * @return	void
	 */
	function _set_request($segments = array())
	{
		if (count($segments) == 0)	return;

		//$segments = array_map("strtolower", $segments);
		$this->uri->rsegments = $segments;

		if(count($segments) == 1) {
	
			//is the controller in a subfolder?
			if(file_exists(APPPATH.'controllers/'.$segments[0].'/'.$segments[0].EXT)) {
				
				$this->set_class($segments[0]);
				$this->set_directory($segments[0]);

			} else {

				$this->set_class($segments[0]);
			}
			
		} else {
			
			$dir = array();
			$segNum = count($segments);
			$lastParam;
			
			//walk the segments until we find the controller file
			for($i=0 ; $i < $segNum ; $i++) {
				
				$dir[] = $currentParam = array_shift($segments);

				//existe un directorio que coincide con el segmento y dentro hay un archivo con el mismo nombre
				if (isset($segments[0]) && file_exists(APPPATH.'controllers/'.implode('/',$dir).'/'.$segments[0].EXT)) {

					$this->set_directory(implode('/',$dir));
					$this->set_class($segments[0]);
					unset($segments[0]);
					$this->uri->params = $segments;
					break;

				//existe un directorio que coincide con el segmento
				} elseif(isset($segments[0]) && file_exists(APPPATH.'controllers/'.implode('/',$dir).'/'.$segments[0])) {

					continue;

				// exite un archivo que coincide con el segmento
				} elseif( file_exists(APPPATH.'controllers/'.implode('/',$dir).EXT)) {
						
					array_pop($dir);
					$this->set_directory(implode('/',$dir));
					$this->set_class($currentParam);
					$this->uri->params = $segments;
					break;

				} elseif (file_exists(APPPATH.'controllers/'.implode('/',$dir).'/'.$currentParam.EXT) ) {
					
					$this->set_directory(implode('/',$dir));
					$this->set_class($currentParam);
					$this->uri->params = $segments;		
					break;
				}
			}
		}
	}

	// --------------------------------------------------------------------
	/**
	 *  Set the method name
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */	
	function set_method($method)
	{
		$this->method = $method;
	}
	
	function set_directory($dir)
	{
		$this->directory = str_replace(".",'',$dir).'/';
	}

}
// END Router Class