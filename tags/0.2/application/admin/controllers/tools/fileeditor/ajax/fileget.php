<?php
/**
 * File editor
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class fileget extends Controller {

	function fileget()
	{
		parent::Controller();
		session_start();
	}
	
	function index()
	{

        if(!isset($_POST['file'])) return;
		
		if(isset($_SESSION['project'])) {

			$apppath = explode("/",str_replace("\\","/", APPPATH));
			$apppath[count($apppath)-2] = $_SESSION['project'];
			$root = implode("/",$apppath);

		} else {

			$root = APPPATH;	
		}

		if( file_exists($root . $_POST['file'])) {

            echo file_get_contents($root . $_POST['file']);
		}
	}
}
?>
