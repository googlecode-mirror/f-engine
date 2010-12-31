<?php
/**
 * File editor
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.4
 * @filesource
 */
class addfolder extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
        if(!isset($_POST['file'])) return;
		if(!isset($_POST['project']) and $_POST['project'] != "") return;

        $dir = ROOTPATH."/".$_POST["project"];
		$filename = $_POST['file'];

        if(mkdir($dir.$filename, 0777)) {

        	chmod($dir.$filename,0777);
        	echo $filename;
        }
	}
}
?>