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
class save extends CI_Controller 
{
	private $apppath;
	private $public_data;

	private $filename;

	function __construct() {

		parent::__construct();
		$this->load->helper('url');
		session_start();

		$this->load->model("newform");
	}

	function index() {

		if(count($_POST) == 0) {
			die;
		}

		$this->newform->init($_POST);

		/**
		 * create folders and files if required
		 */
		if(isset($_POST["action"]) && $_POST["action"] == "create") {

			$this->newform->create_folders();
			$this->newform->write_files();

			if(isset($_SESSION['project'])) {

				$data = array('link' => "<a href='".base_url().'../'.$_SESSION['project'].'/index.php/'.$_POST['url']."'>Go to my new page</a>");

			} else {

				$data = array('link' => "<a href='".site_url().$_POST['url']."'>link</a>");
			}

		} else {

			$this->newform->set_files();
			$data = $this->newform->get_files();
		}
		
		
		$this->load->masterview('tools/newcontroller/done',$data,'done');
	}
}
?>