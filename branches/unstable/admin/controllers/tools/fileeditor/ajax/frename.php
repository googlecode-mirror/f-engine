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
class frename extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		session_start();
	}
	
	function index()
	{
        if(!isset($_POST['file']) and $_POST['file'] != "") return;
        if(!isset($_POST['newname']) and $_POST['newname'] != "") return;
        if(!isset($_POST['project']) and $_POST['project'] != "") return;

        $dir = BASEPATH."application/".$_POST["project"];

		if(rename($dir.$_POST['file'], $dir.$_POST['newname']) == true) {

			echo "1";
		}
	}
}
?>
