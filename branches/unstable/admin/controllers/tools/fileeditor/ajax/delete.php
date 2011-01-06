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
class delete extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
        if(!isset($_POST['file']) and $_POST['file'] != "") return;
        if(!isset($_POST['project']) and $_POST['project'] != "") return;

        $dir = ROOTPATH.$_POST["project"];
		$filename = $_POST['file'];

		if(file_exists($dir.$filename)) {

			if( unlink($dir.$filename) ) {

				echo $filename;
			}
		}
	}
}
?>