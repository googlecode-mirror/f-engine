<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = "file";

/*** file ***/
$cache["file"] = array
(
	'cache_dir'          => BASEPATH.'cache/content/'.APPNAME,
	'default_expire'     => 3600,
);

/*** sqlite ***/
$cache["sqlite"] = array
(
	'default_expire'     => 3600,
	'database'           => BASEPATH.'cache/content/'.APPNAME.'.sql3',
	'schema'             => 'CREATE TABLE caches(id VARCHAR(127) PRIMARY KEY, tags VARCHAR(255), expiration INTEGER, cache TEXT)',
);

/*** apc ***/
$cache["apc"] = array
(
	'default_expire'     => 3600,
);

/*** xcache ***/
$cache["xcache"] =  array
(
	'default_expire'     => 3600,
);

/*** memcache ***/
$cache["memcache"] = array
(
	'default_expire'     => 3600,
	'compression'        => FALSE,              // Use Zlib compression (can cause issues with integers)
	'servers'            => array
	(
		array
		(
			'host'             => 'localhost',  // Memcache Server
			'port'             => 11211,        // Memcache port number
			'persistent'       => FALSE,        // Persistent connection
			'weight'           => 1,
			'timeout'          => 1,
			'retry_interval'   => 15,
			'status'           => TRUE,
		),
	),
	'instant_death'      => TRUE,               // Take server offline immediately on first fail (no retry)
);