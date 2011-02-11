<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cache memcache Driver ported from Kohana PHP framework 
 * 
 * F-engine:
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @since		Version 0.5
 */
class CI_Cache_Memcache {

	// Memcache has a maximum cache lifetime of 30 days
	var $CACHE_CEILING = 2592000;

	/**
	 * Memcache resource
	 *
	 * @var Memcache
	 */
	var $memcache;

	/**
	 * Flags to use when storing values
	 *
	 * @var string
	 */
	var $flags;
	
	
	
	var $cong;

	/**
	 * Check for existence of the memcache extension and
	 * constructs the memcache Cache object
	 *
	 * @param   array configuration
	 * @throws  Cache_Exception
	 */
	function CI_Cache_Memcache($config) {

		// Check for the memcache extention
		if ( ! extension_loaded('memcache'))
		{
			show_error('Memcache PHP extention not loaded.');
		}

		$this->conf = $config;
		
		// Setup Memcache
		$this->memcache = new Memcache;

		// Load servers from configuration
		$servers = $config['servers'];

		if ( ! $servers)
		{
			// Throw an exception if no server found
			show_error('No Memcache servers defined in configuration');
		}

		// Setup default server configuration
		$config = array(
			'host'             => 'localhost',
			'port'             => 11211,
			'persistent'       => FALSE,
			'weight'           => 1,
			'timeout'          => 1,
			'retry_interval'   => 15,
			'status'           => TRUE,
			'failure_callback' => array($this, '_failed_request'),
		);

		// Add the memcache servers to the pool
		foreach ($servers as $server)
		{
			// Merge the defined config with defaults
			$server += $config;

			if ( ! $this->memcache->addServer($server['host'], $server['port'], $server['persistent'], $server['weight'], $server['timeout'], $server['retry_interval'], $server['status'], $server['failure_callback']))
			{
				show_error('Memcache could not connect  to host '.$server['host'].' using port '.$server['port']);
			}
		}

		// Setup the flags
		$this->flags = $this->conf['compression'] !== FALSE ? MEMCACHE_COMPRESSED : FALSE;
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

		// Get the value from Memcache
		$value = $this->memcache->get($id);

		// If the value wasn't found, normalise it
		if ($value === FALSE)
		{
			$value = (NULL === $default) ? NULL : $default;
		}

		// Return the value
		return $value;
	}

	/**
	 * Set a value to cache with id and lifetime
	 * 
	 * @param   string   id of cache entry
	 * @param   mixed    data to set to cache
	 * @param   integer  lifetime in seconds, maximum value 2592000
	 * @return  boolean
	 */
	function set($id, $data, $lifetime = 3600) {

		// If the lifetime is greater than the ceiling
		if ($lifetime > $this->CACHE_CEILING)
		{
			// Set the lifetime to maximum cache time
			$lifetime = $this->CACHE_CEILING + time();
		}
		// Else if the lifetime is greater than zero
		elseif ($lifetime > 0)
		{
			$lifetime += time();
		}
		// Else
		else
		{
			// Normalise the lifetime
			$lifetime = 0;
		}

		// Set the data to memcache
		return $this->memcache->set($id, $data, $this->flags, $lifetime);
	}

	/**
	 * Delete a cache entry based on id
	 *
	 * @param   string   id of entry to delete
	 * @param   integer  timeout of entry, if zero item is deleted immediately, otherwise the item will delete after the specified value in seconds
	 * @return  boolean
	 */
	function delete($id, $timeout = 0) {

		// Delete the id
		return $this->memcache->delete($id, $timeout);
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

		$result = $this->memcache->flush();

		// We must sleep after flushing, or overwriting will not work!
		// @see http://php.net/manual/en/function.memcache-flush.php#81420
		sleep(1);

		return $result;
	}

	/**
	 * Callback method for Memcache::failure_callback to use if any Memcache call
	 * on a particular server fails. This method switches off that instance of the
	 * server if the configuration setting `instant_death` is set to `TRUE`.
	 *
	 * @param   string   hostname 
	 * @param   integer  port 
	 * @return  void|boolean
	 * @since   3.0.8
	 */
	function _failed_request($hostname, $port) {

		if ( ! $this->conf['instant_death'])
			return; 

		// Setup non-existent host
		$host = FALSE;

		// Get host settings from configuration
		foreach ($this->conf['servers'] as $server)
		{
			if ($hostname == $server['host'] and $port == $server['port'])
			{
				$host = $server;
				continue;
			}
		}

		if ( ! $host)
			return;
		else
		{
			return $this->memcache->setServerParams(
				$host['host'],
				$host['port'],
				$host['timeout'],
				$host['retry_interval'],
				FALSE,
				array($this, '_failed_request')
			);
		}
	}
}