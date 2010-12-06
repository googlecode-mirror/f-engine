<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /* 
 * Cache APC Driver ported from Kohana PHP framework 
 * 
 * Requires APC
 * http://pecl.php.net/package/APC
 * 
 * F-engine:
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @since		Version 0.5
 * 
 * Kohana:
 * @package    Kohana
 * @category   Cache
 * @author     Kohana Team
 * @copyright  (c) 2009-2010 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class CI_Cache_Eaccelerator{

	/**
	 * Check for existence of the APC extension 
	 *
	 * @param  array     configuration
	 * @throws Cache_Exception
	 */
	function CI_Cache_Eaccelerator() {

		if ( ! extension_loaded('apc'))
		{
			show_error('PHP APC extension is not available.');
		}
	}

	/**
	 * Retrieve a cached value entry by id.
	 *
	 * @param   string   id of cache to entry
	 * @param   string   default value to return if cache miss
	 * @return  mixed
	 * @throws  Cache_Exception
	 */
	function get($id, $default = NULL) {

		return (($data = eaccelerator_get($id)) === FALSE) ? $default : $data;
	}

	/**
	 * Set a value to cache with id and lifetime
	 * 
	 * @param   string   id of cache entry
	 * @param   string   data to set to cache
	 * @param   integer  lifetime in seconds
	 * @return  boolean
	 */
	function set($id, $data, $lifetime = NULL) {

		return eaccelerator_put($id, $data, $lifetime);
	}

	/**
	 * Delete a cache entry based on id
	 *
	 * @param   string   id to remove from cache
	 * @return  boolean
	 */
	function delete($id) {

		return eaccelerator_rm($id);
	}

	/**
	 * Delete all cache entries.
	 * 
	 * Beware of using this method when
	 * using shared memory cache systems, as it will wipe every
	 * entry within the system for all clients.
	 *
	 * @return  boolean
	 */
	function delete_all() {

		return eaccelerator_clean();
	}
}