<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cache library ported from Kohana PHP framework 
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
class CI_Cache {

	var $default_expire = 3600;

	var $default_driver = 'file';
	var $driver;

	var $default_conf;
	var $conf;

	function CI_Cache($driver='', $config = array()) {

		if($driver != '')
			$this->default_driver = strtolower($driver);

		require(APPPATH."config/cache.php");

		$this->default_conf = $cache;
		$this->conf = $config;

		$config = array_merge($this->default_conf, $this->conf);

		$driver_path = BASEPATH."cache/drivers/".$this->default_driver.EXT;
		require_once($driver_path);

		$class_name = "CI_Cache_".ucfirst($this->default_driver);

		$this->driver = new $class_name($config[$this->default_driver]);

		log_message('debug', "Cache Class Initialized");
	}

	/**
	 * Retrieve a value based on an id
	 */
	function get($id, $default = NULL) {

		$id = $this->sanitize_id($id);
		return $this->driver->get($id, $default = NULL);
	}

	/**
	 * Find cache entries based on a tag
	 */
	function find($tag) {

		if(!method_exists($this->driver,'find')) {

			show_error('Find method is not compatible with '.$this->default_driver.' cache driver.');
		}
		
		return $this->driver->find($tag);
	}

	/**
	 * Set a value based on an id. Optionally add tags.
	 */
	function set($id, $data, $lifetime = false) {

		$id = $this->sanitize_id($id);
		if(!$lifetime)
			$lifetime = isset($this->config['default_expire']) ? $this->config['default_expire'] : $this->default_expire;

		return $this->driver->set($id, $data, $lifetime);
	}

	/**
	 * Set a value based on an id. Optionally add tags.
	 */
	function set_with_tags($id, $data, $lifetime = false, $tags = NULL) {

		if(!method_exists($this->driver,'set_with_tags')) {

			show_error('set_with_tags method is not compatible with '.$this->default_driver.' cache driver.');
		}
		
		$id = $this->sanitize_id($id);
		if(!$lifetime)
			$lifetime = isset($this->config['default_expire']) ? $this->config['default_expire'] : $this->default_expire;

		return $this->driver->set_with_tags($id, $data, $lifetime,$tags);
	}

	/**
	 * Delete cache entries based on a id
	 */
	function delete($id) {

		$id = $this->sanitize_id($id);
		return $this->driver->delete($id);
	}

	/**
	 * Delete cache entries based on a tag
	 */
	function delete_tag($tag) {

		if(!method_exists($this->driver,'delete_tag')) {

			show_error('delete_tag method is not compatible with '.$this->default_driver.' cache driver.');
		}

		return $this->driver->delete_tag($tag);
	}

	/**
	 * Delete all cache entries
	 */
	function delete_all() {

		return $this->driver->delete_all();
	}

	/**
	 * Garbage collection method that cleans any expired
	 * cache entries from the cache.
	 */
	function garbage_collect() {

		if(!method_exists($this->driver,'garbage_collect')) {

			show_error('garbage_collect method is not compatible with selected cache driver.');
		}

		return $this->driver->garbage_collect();
	}

	/**
	 * Replaces troublesome characters with underscores.
	 * @param   string   id of cache to sanitize
	 * @return  string
	 */
	function sanitize_id($id) {

		// Change slashes and spaces to underscores
		return str_replace(array('/', '\\', ' '), '_', $id);
	}
}
// End Cache