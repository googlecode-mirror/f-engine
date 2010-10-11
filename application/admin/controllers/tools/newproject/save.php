<?php
/**
 * New project wizard
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class save extends Controller {

	private $path;

	function save()
	{
		parent::Controller();
		$this->load->helper("url");
	}

	function index()
	{
		if( !isset($_POST['projectname']) || $_POST['projectname'] == '') die;

		$pname = BASEPATH.'application/'.$_POST['projectname'];
		mkdir($pname, 0777);
		chmod($pname, 0777);

		$xml = simplexml_load_file(BASEPATH.'src/newproject.xml'); 
		
		if(isset($xml->dir))
		$this->run_folder($xml,$pname);

		$pname = BASEPATH.'application/'.$_POST['projectname'];

		//Open config.php
		$config = file_get_contents($pname."/config/config.php"); 

		//global_xss_filtering
		if(isset($_POST['global_xss_filtering']) && $_POST['global_xss_filtering'] == "yes")
			$config = str_replace('$config[\'global_xss_filtering\'] = FALSE;', '$config[\'global_xss_filtering\'] = TRUE;',
			$config);

		//permitted_uri_chars
		$config = 	str_replace('$config[\'permitted_uri_chars\'] = \'a-z 0-9~%.:_\-\'', 
					'$config[\'permitted_uri_chars\'] = \''.$_POST['permitted_uri_chars'].'\'',
					$config);

		//compress_output
		if(isset($_POST['compress_output']) && $_POST['compress_output'] == "yes")
			$config = 	str_replace('$config[\'compress_output\'] = FALSE;', 
					  	'$config[\'compress_output\'] = TRUE;',
						$config);

		//rewrite_short_tags
		if(isset($_POST['rewrite_short_tags']) && $_POST['rewrite_short_tags'] == "yes")
			$config = str_replace('$config[\'rewrite_short_tags\'] = FALSE;', '$config[\'rewrite_short_tags\'] = TRUE;',
			$config);

		//Save config.php
		file_put_contents($pname."/config/config.php",$config);

		//Open database.php
		$database = file_get_contents($pname."/config/database.php");

		//active_record
		if(isset($_POST['active_record']) && $_POST['active_record'] == "yes")
			$database = str_replace('$active_record = FALSE;', '$active_record = TRUE;',
			$database);

		//hostname
		$database = str_replace('$db[\'default\'][\'hostname\'] = "localhost";', 
		'$db[\'default\'][\'hostname\'] = "'.$_POST['hostname'].'";',
		$database);

		//username
		$database = str_replace('$db[\'default\'][\'username\'] = "db_username";', 
		'$db[\'default\'][\'username\'] = "'.$_POST['username'].'";',
		$database);

		//password
		$database = str_replace('$db[\'default\'][\'password\'] = "db_password";', 
		'$db[\'default\'][\'password\'] = "'.$_POST['password'].'";',
		$database);

		//database
		$database = str_replace('$db[\'default\'][\'database\'] = "db_name";', 
		'$db[\'default\'][\'database\'] = "'.$_POST['database'].'";',
		$database);

		//dbdriver
		$database = str_replace('$db[\'default\'][\'dbdriver\'] = "mysql";', 
		'$db[\'default\'][\'dbdriver\'] = "'.$_POST['dbdriver'].'";',
		$database);

		file_put_contents($pname."/config/database.php",$database);
		redirect("","refresh");
	}
	
	function run_folder ($xml,$pname,$debug=false) {

		if($debug) print_r($xml);

		if(isset($xml->file))
		foreach ($xml->file as $type => $item) {

			$current_folder = $pname.'/'.$item['name'];
			file_put_contents($current_folder, base64_decode((string)$item));
			chmod($current_folder, 0777);
		}

		foreach ($xml->dir as $type => $item) {

			$current_folder = $pname.'/'.$item['name'];
			mkdir($current_folder, 0777);
			chmod($current_folder, 0777);
			
			if($type == 'dir') {

				foreach ($item as $type => $subitem) {

					if($type == 'file') {

						file_put_contents($current_folder.'/'.$subitem['name'], base64_decode((string)$subitem));
						chmod($current_folder.'/'.$subitem['name'], 0777);

					} else {

						mkdir($current_folder.'/'.$subitem['name'], 0777);
						chmod($current_folder.'/'.$subitem['name'], 0777);
						$this->run_folder($subitem,$current_folder.'/'.$subitem['name']);
					}
				}
			}
		}
	}
}