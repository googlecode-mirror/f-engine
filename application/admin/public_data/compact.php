<?php

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

		if(file_exists(realpath(dirname(__FILE__))."/".$prefix.$file)) {

			include($prefix.$file);

		} else {

			echo "/* request file not found: ".$prefix.$file." */";
		}
	}

	if($options["compress"] and extension_loaded('zlib')){
		ob_end_flush();
	}
