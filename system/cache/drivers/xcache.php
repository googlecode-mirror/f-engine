<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cache Xcache Driver ported from Kohana PHP framework 
 * 
 * Requires Xcache
 * http://xcache.lighttpd.net/
 * 
 * F-engine:
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @since		Version 0.5
 */
class CI_Cache_Xcache {

	/**
	 * Check for existence of the APC extension
	 *
	 * @param  array     configuration
	 * @throws  Cache_Exception
	 */
	function CI_Cache_Xcache() {

		if ( ! extension_loaded('xcache'))
		{
			show_error('PHP Xcache extension is not available.');
		}
	}

	/**
	 * Retrieve a value based on an id
	 *
	 * @param   string   id 
	 * @param   string   default [Optional] Default value to return if id not found
	 * @return  mixed
	 */
	function get($id, $default = NULL) {

		return (($data = xcache_get($id)) === NULL) ? $default : $data;
	}

	/**
	 * Set a value based on an id. Optionally add tags.
	 * To use this method xcache.var_size has to be bigger than 0 in xcache.ini
	 * 
	 * @param   string   id 
	 * @param   string   data 
	 * @param   integer  lifetime [Optional]
	 * @return  boolean
	 */
	function set($id, $data, $lifetime) {

		return xcache_set($id, $data, $lifetime);
	}

	/**
	 * Delete a cache entry based on id
	 *
	 * @param   string   id 
	 * @param   integer  timeout [Optional]
	 * @return  boolean
	 */
	function delete($id) {

		return xcache_unset($id);
	}

	/**
	 * Delete all cache entries
	 * To use this method xcache.admin.enable_auth has to be Off in xcache.ini
	 *
	 * @return  void
	 */
	function delete_all() {

		xcache_clear_cache(XC_TYPE_PHP, 0);
	}
}
