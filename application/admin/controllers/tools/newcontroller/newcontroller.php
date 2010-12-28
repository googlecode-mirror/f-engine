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
class newcontroller extends Controller 
{
	function newcontroller() {

		parent::Controller();
		$this->load->helper(array('url','directory'));
		session_start();
	}

	function index() {

		if($this->uri->param(0) == "select" and !isset($_POST['project'])) {

			$this->target_project();
			return;
		}
		
		if(isset($_POST['project'])) {
			
			$_SESSION['project'] = $_POST['project']; 
		}

		if(!isset($_SESSION['project'])) {

			$this->target_project();
			return;

		} else {
			
			require(APPPATH.'../'.$_SESSION['project'].'/config/database.php');
			
			if ($db[$active_group]["username"] != "" && $db[$active_group]["database"] != "") {

				$this->load->database($db[$active_group]);

			} else {

				$this->target_project(false);
				return;
			}
		}
		/***	Forms	***/
		$data['fields'] = $this->db->list_tables();
		
		/***	Masterview confs	***/
		$data['masterview'] = array();
		require(APPPATH.'../'.$_SESSION['project'].'/config/masterview.php');
		foreach($conf as $key=>$val) {
			
			$data['masterview'][] = $key;
		}
		
		/*** template folders ***/
		$templates = directory_map(APPPATH.'views/tools/newcontroller/templates');
		
		$directories = array();
		foreach($templates as $dir => $val) {

			$directories[] = $dir;	
		}

		$data["templates"] = $directories;

		/***	Load view	***/
		$this->load->masterview('tools/newcontroller/newcontroller',$data,'newcontroller');
	}

	function target_project ($valid = true) {

		$this->load->helper("directory");
		$my_projects = array();
		$projects = directory_map(APPPATH.'../', true);

		foreach($projects as $project) {

			if(is_dir(APPPATH.'../'.$project) && $project != 'fengine') {

				$my_projects[] = $project;
			}	
		}

		if($this->uri->param(1) != "")
			$segments = array_pop($this->uri->segments);
		else
			$segments = $this->uri->segments;

		$data = array(
			"action" => site_url().implode($this->uri->segments,"/"),
			"projects" => $my_projects
		);
		
		if(!$valid)  $data["db_error"] = true;

		$this->load->masterview('tools/select_project/select',$data,'sel_project');
	}
}
?>