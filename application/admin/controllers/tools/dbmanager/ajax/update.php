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
class update extends Controller 
{
	function update() {
		
		parent::Controller();
		$this->load->helper('url');
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

		$table = $_POST['table'];
        unset($_POST['table']);

		if(isset($_POST["primary"])) {

            $where = array($_POST["primary"] => $_POST["primary_value"]);
            unset($_POST["primary"]);
            unset($_POST["primary_value"]);

			// Now do the query
			$result = $this->db->update($table, $_POST, $where,"1");

        } elseif(isset($_POST["unique"])) {

            $where = array($_POST["unique"] => $_POST["unique_value"]);
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