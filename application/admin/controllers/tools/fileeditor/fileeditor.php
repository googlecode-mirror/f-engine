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
class fileeditor extends Controller 
{
	function fileeditor() {
		
		parent::Controller();
		$this->load->helper('url');
		session_start();
	}
	
	function index() {

		if($this->uri->param(1) == "select") {

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

			/***	Load view	***/
			$this->load->masterview('tools/fileeditor/main',array(),'fileeditor');
		}
	}
	
	function target_project () {

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
		$this->load->masterview('tools/select_project/select',$data,'sel_project');
	}
}
?>