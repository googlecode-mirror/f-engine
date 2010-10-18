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
class fileget extends Controller {

	function fileget()
	{
		parent::Controller();

	}
	
	function index()
	{

        if(!isset($_POST['file'])) return;
        if(!isset($_POST['project']) and $_POST['project'] != "") return;

		$apppath = explode("/",str_replace("\\","/", APPPATH));
		$apppath[count($apppath)-2] = $_POST['project'];
		$root = implode("/",$apppath);

		if( file_exists($root . $_POST['file'])) {

            echo file_get_contents($root . $_POST['file']);
		}
	}
}
?>
