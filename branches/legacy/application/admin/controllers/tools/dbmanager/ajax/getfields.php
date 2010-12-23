<?php
/**
 * Dbmanager
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.5
 * @filesource
 */
class getfields extends Controller
{
	function getfields() {
		
		parent::Controller();

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


	}

	function index() {
		
		echo "This script is not accesible directly";
	}
	
	function ajax() {
		
		if(!isset($_POST['table'])) return;
		
		$fields = $this->db->list_fields($_POST['table']); 
		
		echo '<ul id="'.$_POST["table"].'_fields" class="jqueryFileTree">';
		foreach($fields as $field) {
			echo "<li><a href='#'>$field</a></li>";
		}
		echo "</ul>";
	}
}
?>