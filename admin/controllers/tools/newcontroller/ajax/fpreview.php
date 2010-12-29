<?php
/**
 * New controller wizard
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class fpreview extends CI_Controller {

	private $apppath;
	private $public_data;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		
		if(isset($_SESSION['project'])) {

			$apppath = explode("/",str_replace("\\","/", APPPATH));
			$apppath[count($apppath)-2] = $_SESSION['project'];
			$this->apppath = implode("/",$apppath);

			$this->public_data = $this->apppath.'public_data/';

		} else {
			
			$this->apppath = APPPATH;
			$this->public_data = PUBLIC_DATA;
		}
	}

	function index() {

		if(!isset($_POST['file'])) return;

		if(!preg_match("/(\.gif|\.png|\.jpe?g)/i",$_POST['file'])) {

			$type = explode('/',$_POST['file']);
			switch($type[0]) {

				case 'css':
				case 'js':
							$handler = fopen($this->public_data.$_POST['file'], "r");
							break;

				case 'header':

							$handler = fopen($this->apppath.'views/'.$_POST['file'], "r");
							break;

				case 'footer':
							$handler = fopen($this->apppath.'views/'.$_POST['file'], "r");
							break;

				case 'models':
							$handler = fopen($this->apppath.'application/'.$_POST['file'], "r");
							break;

				case 'helpers':
				case 'libraries':
							$handler = fopen($this->apppath.$_POST['file'], "r");
							break;

				case "masterview":

							$content = file_get_contents($this->apppath."config/masterview.php");
							$items = explode(";",$content);

							foreach($items as $item) {

								preg_match("/conf\[[\"']".trim($type[1])."[\"']\]/i",$item,$matches);

								if(count($matches) > 0) {

									echo str_replace(array("\n"),array("<br />"),trim($item));
									return;
								}
							}
							return;

				default:
							return;
			}

			$content = fread($handler, 350);
			fclose($handler);

			echo "<pre>".htmlentities($content)."</pre>";	
		}
	}
}
?>