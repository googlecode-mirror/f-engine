<?php
/**
 * Dbmanager
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.4
 * @filesource
 */
class delete extends CI_Controller 
{
	function __construct() {

		parent::__construct();
		session_start();

		$project = $this->uri->param(1) != "" ? $this->uri->param(1) : $_SESSION['project'];
		if(isset($project)) {

			require(APPPATH.'../'.$project.'/config/database.php');
			if(isset($_POST["dbconf"]) and isset($db[$_POST["dbconf"]])) {

				$this->load->database($db[$_POST["dbconf"]], FALSE, TRUE);
				unset($_POST["dbconf"]);
				
			} else {
				$this->load->database($db[$active_group], FALSE, TRUE);
			}

		} else {

			$this->load->database("", FALSE, TRUE);	
		}
	}
		
	function index() {
		
		echo "This script is not accesible directly";
	}
	
	function ajax() {

		if(!isset($_POST['table'])) return;
		if(isset($_POST['primary']) || isset($_POST['unique'])) {

			if(isset($_POST["primary"])) {

				if(is_array($_POST["primary_value"])) {
					$where = array();
					$i=0;
					foreach(explode(",",$_POST["primary"]) as $field) {
						$where[$field] = $_POST["primary_value"][$i];
						$i++;
					}

				} else {
					$where = array($_POST["primary"] => $_POST["primary_value"]); 
				}

			} elseif(isset($_POST["unique"])) {

			    if(is_array($_POST["unique"])) {
					$where = array();
					$i=0;
					foreach(explode(",",$_POST["unique"]) as $field) {
						$where[$field] = $_POST["unique"][$i];
						$i++;
					}

				} else {
					$where = array($_POST["unique"] => $_POST["unique_value"]); 
				}
			}

			$this->db->where($where);
	        $result = $this->db->delete($_POST['table']);

		} else {

			$table = $_POST["table"];
			unset($_POST["table"]);

			$where = array();
			foreach($_POST as $key=>$val) {
				
				$where[$key] = rawurldecode($val);
			}
			
	        $result = $this->db->f_delete($table,$where,"1");
		}

        echo $result;
	}
}
?>