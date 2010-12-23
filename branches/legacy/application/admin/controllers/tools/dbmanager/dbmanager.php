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

		if($this->uri->param(1) == "select") {

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

			if(file_exists(APPPATH.'../'.$_SESSION['project'].'/config/database.php')) {
			
				require(APPPATH.'../'.$_SESSION['project'].'/config/database.php');
				
				if($current_db != '' and isset($db[$current_db])) 
					$active_group = $current_db;
	
				$this->load->database($db[$active_group]);
				
				$db_configurations = array();
				foreach($db as $key => $val) {
					
					$db_configurations[] = $key;
				}

			} else {

				$this->target_project();
				return;	
			}
		}
		
		if($this->db->platform() != "mysql" && $this->db->platform() != "mysqli") {

			echo "Only for mysql databases";
			return;
		}

		$data["projectname"] = $_SESSION['project'];
		$data["dbconf"] = $active_group;

		/***	table list and details	***/
		$data['details'] = $this->db->query("SHOW TABLE STATUS FROM ".$db[$active_group]["database"])->result();

		$data["tables"] = array();
		foreach($data['details'] as $table) {

			$data["tables"][] = $table->Name;
		}

		/***	Defined db configuratiosn	***/
		$data["db_conf"] = $db_configurations;
		$data["current_db"] = $current_db;

		/*** process list ***/
		$data['processes'] = $this->db->query("SHOW PROCESSLIST")->result();

		/*** users/privileges ***/
		$this->db->skip_errors = TRUE;
		$data['permissions'] = $this->db->query("SELECT *, IF(`Password` = '', 'N', 'Y') AS 'Has_password' FROM `mysql`.`user` LIMIT 10");
		
		if(!is_string($data['permissions'])) {
	
			$data['permissions'] = $data['permissions']->result();

			$privilege_list = array();
			foreach($data['permissions'][0] as $row => $val) {
	
				if (preg_match("/_priv$/", $row)) {
	
					$privilege_list[] = $row;
				}
			}
	
			$i=0;
			foreach($data['permissions'] as $row) {
	
				$user_privileges = array();
	
				foreach($row as $key => $val) {
	
					if (preg_match("/_priv$/", $key) and $val == "Y") {
						$user_privileges[] = $val;
					}
				}
	
				if( count($privilege_list) == count($user_privileges) ) {
	
					$data['permissions'][$i]->Privileges = "ALL PRIVILEGES";
	
				} elseif( count($privilege_list) == 0 ) {
	
					$data['permissions'][$i]->Privileges = "USAGE";
	
				} else {
					
					$data['permissions'][$i]->Privileges = "Other";
				}
				$i++;
			}
		}

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