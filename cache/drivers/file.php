<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /* 
 * Cache File Driver ported from Kohana PHP framework 
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
class CI_Cache_File {

	var $cache_dir;
	/**
	 * Constructs the file cache driver
	 *
	 * @param   array    config 
	 * @throws  Cache_Exception
	 */
	function CI_Cache_File($config = array()) {

		$this->cache_dir = $config['cache_dir']."/";

		if(!file_exists($this->cache_dir)) {

			mkdir($this->cache_dir,0777, TRUE);
			chmod($this->cache_dir,0777);
		}

		// If the defined directory is a file, get outta here
		if (!is_dir($this->cache_dir) and file_exists($this->cache_dir))
		{
			show_error('Unable to create cache directory as a file already exists');
		}

		// Check the write status of the directory
		if (! is_really_writable($this->cache_dir))
		{
			show_error('Unable to write to the cache directory');
		}
	}

	function filename($string) {

		return sha1($string).'.json';
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

		$filename = $this->cache_dir.$this->filename($id);

		if(!file_exists($filename)) {

			return false;
		}
		
		// Open the file and extract the json
		$json = file_get_contents($filename);

		// Decode the json into PHP object
		$data = json_decode($json);

		// Test the expiry
		if ($data->expiry < time())
		{
			// Delete the file
			$this->delete($id);

			// Return default value
			return false;
		}
		else
		{
			return ($data->type === 'string') ? $data->payload : unserialize($data->payload);
		}
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

		$type = is_string($data) ? 'string' : 'object';
		$data = json_encode((object) array(
			'payload'  => ($type === 'string') ? $data : serialize($data),
			'expiry'   => time() + $lifetime,
			'type'     => $type
		));

		$result = file_put_contents($this->cache_dir.$this->filename($id), $data);
		
		if($result) {
		
			chmod($this->cache_dir.$this->filename($id),0777);
		}
		
		return $result;
	}

	/**
	 * Delete a cache entry based on id
	 * 
	 * @param   string   id to remove from cache
	 * @return  boolean
	 */
	function delete($id) {

		return $this->_delete($this->cache_dir.$this->filename($id));
	}
	
	/**
	 * Delete a cache entry based on filename
	 * 
	 * @param   string   id to remove from cache
	 * @return  boolean
	 */
	function _delete($filename) {

		if(file_exists($filename))
			return unlink($filename);
		else
			return false;
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

		$fe =& get_instance();
		$fe->load->helper("file");
		$files = get_filenames($this->cache_dir);

		foreach($files as $file) {

			$this->_delete($this->cache_dir.$file);
		}

		return true;
	}
}
