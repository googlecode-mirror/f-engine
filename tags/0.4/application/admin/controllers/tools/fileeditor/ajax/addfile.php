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
class addfile extends Controller {

	function addfile()
	{
		parent::Controller();
	}
	
	function index()
	{
        if(!isset($_POST['file'])) return;
		if(!isset($_POST['project']) and $_POST['project'] != "") return;

        $dir = BASEPATH."application/".$_POST["project"];
		$filename = $_POST['file'];

		if(substr($filename,0,13) == "/controllers/") {
			
			$segments = explode("/",substr($filename,13));
			$cname = array_shift(explode(".",$segments[count($segments)-1]));

			$content = "<?php\r\n".$this->load->view("tools/fileeditor/templates/controller",array("classname" => $cname),true)."\r\n?>";

		} elseif(substr($filename,0,8) == "/models/") {	

			$segments = explode("/",substr($filename,8));
			$cname = array_shift(explode(".",$segments[count($segments)-1]));

			$content = "<?php\r\n".$this->load->view("tools/fileeditor/templates/model",array("classname" => $cname),true)."\r\n?>";
			
			
		} else {
			
			$content = "";
		}

        if(file_put_contents($dir.$filename, $content) !== false) {
        	
        	echo $filename;
        }
	}
}
?>