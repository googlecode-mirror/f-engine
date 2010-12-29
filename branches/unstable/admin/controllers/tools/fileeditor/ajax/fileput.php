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
class fileput extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
        if(!isset($_POST['file'])) return;
        if(!isset($_POST['project']) and $_POST['project'] != "") return;

		$apppath = explode("/",str_replace("\\","/", APPPATH));
		$apppath[count($apppath)-2] = $_POST['project'];
		$root = implode("/",$apppath);


		if( file_exists($root . $_POST['file'])) {

            file_put_contents($root . $_POST['file'], $_POST['content']);
		}
	}
}
?>
