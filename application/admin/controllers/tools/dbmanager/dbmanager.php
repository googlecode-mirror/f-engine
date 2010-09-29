<?php
/**
 * Dbmanager
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.3
 * @filesource
 */
class dbmanager extends Controller 
{
	function dbmanager() {
		
		parent::Controller();
		$this->load->helper('url');
		session_start();
	}
	
	function index($current_db = '') {

		if($this->uri->param(0) == "select") {

			//select project
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
			
			if($current_db != '' and isset($db[$current_db]))
				$this->load->database($db[$current_db]);
			else
				$this->load->database($db[$active_group]);
			
			$db_configurations = array();
			foreach($db as $key => $val) {
				
				$db_configurations[] = $key;
			}
		}
		
		if($this->db->platform() != "mysql" && $this->db->platform() != "mysqli") {

			echo "Only for mysql databases";
			return;
		}

		/***	Forms	***/
		$data["dbfields"] = $data['fields'] = $this->db->list_tables();

		/***	Defined db configuratiosn	***/
		$data["db_conf"] = $db_configurations;
		$data["current_db"] = $current_db;

		/***	Load view	***/
		$this->load->masterview('tools/dbmanager/dbmanager',$data,'dbmanager');
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

		if($this->uri->param(0) != "")
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