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
class insert extends Controller 
{
	function insert() {
		
		parent::Controller();
		session_start();

		$project = $this->uri->param(1) != "" ? $this->uri->param(1) : $_SESSION['project'];
		if(isset($project)) {

			require(APPPATH.'../'.$project.'/config/database.php');
			$this->load->database($db[$active_group]);

		} else {
			$this->load->database();	
		}
	}
	
	function index() {
		
		$table = $_POST['table'];
		unset($_POST['table']);
		
		$result = $this->db->insert($table, $_POST);
		echo $result;
	}
}
?>