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
class insert extends CI_Controller 
{
	function __construct() {

		parent::__construct();
		$this->load->helper("url");
		session_start();
	}

	function index() {
		
		echo "This script is not accesible directly";
	}
	
	function ajax($project = '', $dbconf = '') {
		
		if($project == '') {	
			$project = $_SESSION['project'];
		}

		if(isset($project)) {

			require(FCPATH.'../'.$project.'/config/database.php');

			if(isset($db[$dbconf]))
				$this->load->database($db[$dbconf]);
			else
				$this->load->database($db[$active_group]);

		} else {
			$this->load->database();	
		}
		
		$table = $_POST['table'];
		unset($_POST['table']);
		
		$result = $this->db->insert($table, $_POST);
		echo $result;
	}
}
?>