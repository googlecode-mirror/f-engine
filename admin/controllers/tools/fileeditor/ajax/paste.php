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
class paste extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
        if(!isset($_POST['newfile']) and $_POST['newfile'] != "") return;
        if(!isset($_POST['oldfile']) and $_POST['oldfile'] != "") return;
        if(!isset($_POST['action']) and $_POST['action'] != "") return;
        if(!isset($_POST['project']) and $_POST['project'] != "") return;

        $dir = ROOTPATH.$_POST["project"];
	
		$filename = $_POST['newfile'];

		if(file_exists($dir.$filename)) {

			$i=1;
			while(true) {

				$filename = str_replace(".","(".$i.").",$_POST['newfile']);

				if(!file_exists($dir.$filename)) {

					break;
				}
				$i++;
			}
		}

		if(copy($dir.$_POST['oldfile'], $dir.$filename) == true) {
			
			if($_POST["action"] == "cut") {
				
				unlink($dir.$_POST['oldfile']);
			}
			echo $filename;
		}

	}
}
?>
