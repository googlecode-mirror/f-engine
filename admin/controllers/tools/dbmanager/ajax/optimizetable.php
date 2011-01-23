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
class optimizetable extends CI_Controller
{
	function __construct() {
		
		parent::__construct();
		session_start();

		$project = $_POST["project"] != "" ? $_POST["project"] : $_SESSION['project'];  
		if(isset($project)) {

			require(FCPATH.'../'.$project.'/config/database.php');
			if(isset($_POST["dbconf"]) and isset($db[$_POST["dbconf"]]))
				$this->load->database($db[$_POST["dbconf"]]);
			else
				$this->load->database($db[$active_group]);

		} else {
			$this->load->database();	
		}

		$this->load->dbutil() ;
	}
	
		
	function index() {
		
		echo "This script is not accessible directly";
	}
	
	function ajax() {
		
		if(!isset($_POST['table'])) return;

        $response = $this->dbutil->optimize_table($_POST['table']);
        echo $response['Msg_text'];
	}
}
?>