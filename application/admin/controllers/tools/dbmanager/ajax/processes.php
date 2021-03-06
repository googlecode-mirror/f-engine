<?php
class processes extends Controller 
{
	function processes() {
		
		parent::Controller();
	}
	
	function index() {

		$this->init_db();
		$data['processes'] = $this->db->query("SHOW PROCESSLIST")->result();
		
		$this->load->view("tools/dbmanager/processes",$data);
	}
	
	function init_db () {

		$project = $_POST['project'] != "" ? $_POST['project'] : $_SESSION['project'];
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

}
?>