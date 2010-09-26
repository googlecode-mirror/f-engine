<?php
/**
 * Dbmanager
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class delete extends Controller 
{
	function delete() {

		parent::Controller();
		session_start();

		$project = $this->uri->param(1) != "" ? $this->uri->param(1) : $_SESSION['project'];
		if(isset($project)) {

			require(APPPATH.'../'.$project.'/config/database.php');
			$this->load->database($db[$active_group], FALSE, TRUE);

		} else {

			$this->load->database("", FALSE, TRUE);	
		}
	}

	function index() {

		if(!isset($_POST['table'])) return;
		if(isset($_POST['primary']) || isset($_POST['unique'])) {

			if(isset($_POST["primary"]))
	            $this->db->where($_POST["primary"],$_POST["primary_value"]);
	        elseif(isset($_POST["unique"]))
	            $this->db->where($_POST["unique"],$_POST["unique_value"]);

	        $result = $this->db->delete($_POST['table']);

		} else {

			$table = $_POST["table"];
			unset($_POST["table"]);
			
	        $result = $this->db->f_delete($table,$_POST,"1");
		}

        echo $result;
	}
}
?>