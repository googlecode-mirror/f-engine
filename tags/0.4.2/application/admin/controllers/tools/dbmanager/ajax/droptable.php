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
class droptable extends Controller 
{
	function droptable() {

		parent::Controller();
		session_start();

		$project = $_POST["project"] != "" ? $_POST["project"] : $_SESSION['project'];
		if(isset($project)) {

			require(APPPATH.'../'.$project.'/config/database.php');
			if(isset($_POST["dbconf"]) and isset($db[$_POST["dbconf"]]))
				$this->load->database($db[$_POST["dbconf"]]);
			else
				$this->load->database($db[$active_group]);

		} else {
			$this->load->database();	
		}

		$this->load->dbforge() ;
	}
		
	function index() {
		
		echo "This script is not accesible directly";
	}
	
	function ajax() {

		if(!isset($_POST['table'])) return;

		echo $this->dbforge->drop_table($_POST['table']);
	}
}
?>