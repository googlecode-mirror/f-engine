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
class update extends CI_Controller 
{
	function __construct() {
		
		parent::__construct();
		$this->load->helper('url');
		session_start();

		$project = $this->uri->param(1) != "" ? $this->uri->param(1) : $_SESSION['project'];
		if(isset($project)) {

			require(FCPATH.'../'.$project.'/config/database.php');
			if(isset($_POST["dbconf"]) and isset($db[$_POST["dbconf"]])) {
				
				$this->load->database($db[$_POST["dbconf"]], FALSE, TRUE);
				unset($_POST["dbconf"]);
				
			} else
				$this->load->database($db[$active_group], FALSE, TRUE);

		} else {
			$this->load->database("", FALSE, TRUE);
		}
	}

	function index() {
		
		echo "This script is not accessible directly";
	}
	
	function ajax() {

		$table = $_POST['table'];
        unset($_POST['table']);

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

            unset($_POST["primary"]);
            unset($_POST["primary_value"]);

			// Now do the query
			$result = $this->db->update($table, $_POST, $where,"1");

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
            unset($_POST["unique"]);
            unset($_POST["unique_value"]);

			// Now do the query
			$result = $this->db->update($table, $_POST, $where,"1");

        } elseif(count($_POST) > 0) {
	
			$where = array();
			$data = array();

			foreach($_POST as $key => $val) {

				if(substr($key,0,4) == "old_") {

					$subkey = substr($key,4);
					$where[$subkey] = rawurldecode($val);

				} else {

					$data[$key] = rawurldecode($val);
				}
			}

			// Now do the query
			$result = $this->db->update($table, $data, $where,"1");

        } else {
        	
        	die("error");
        }

		echo $result;
	}
}
?>