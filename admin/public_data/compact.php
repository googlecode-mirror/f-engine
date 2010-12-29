<?php
	/***
	 * This script combines and compacts css and javascript files
	 * to reduce the number of HTTP requests and speed up 
	 * web page load time
	 */
	define('BASEPATH',realpath(dirname(__FILE__))."/../../");
	include(realpath(dirname(__FILE__))."/../config/config.php");

	$options = $config["compact"];

	if($options["compress"] and extension_loaded('zlib')) {
			ob_start('ob_gzhandler');
	}

	header ("content-type: text/css; charset: UTF-8");
	header ("cache-control: must-revalidate");

	$offset = 60 * 60 * $options["cachetime"];
	$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
	header ($expire);

	if(isset($_GET["css"])) {

		$files = $_GET["css"];
		$prefix = "css/";

	} elseif(isset($_GET["js"])) {

		$files = $_GET["js"];
		$prefix = "js/";		

	} else {

		return;
	}

	$files = explode(",",$files);

	foreach($files as $file) {

		$filename = realpath(dirname(__FILE__)."/".$prefix.$file);

		if(file_exists($filename) and strstr($filename, realpath(dirname(__FILE__)))) {

			include($filename);

		} else {

			echo "\n/* file not found: ".$filename." */\n";
		}
	}

	if($options["compress"] and extension_loaded('zlib')){
		ob_end_flush();
	}
