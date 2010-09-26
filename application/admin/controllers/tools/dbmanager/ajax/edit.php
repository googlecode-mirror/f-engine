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
class edit extends Controller 
{
	function edit() {

		parent::Controller();
		$this->load->helper(array('url','form'));
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
		
		$table = $_POST['table'];
		unset($_POST['table']);		

		if(isset($_POST['primary']) || isset($_POST['unique'])) {

			if(isset($_POST["primary"]))
	            $query = $this->db->get_where($table, array($_POST["primary"] => $_POST["primary_value"]));
	        elseif(isset($_POST["unique"]))   
	            $query = $this->db->get_where($table, array($_POST["unique"] => $_POST["unique_value"]));
			
		} elseif(count($_POST) > 0) {

			$data = array();

			foreach($_POST as $key => $val) {

				$data[$key] = rawurldecode($val);				
			}

			$query = $this->db->get_where($table, $data);

		} else  {

			die("error");
		}
		
		$data = array(
						'title'		=> 	'Edit Data',
						'fields'	=> 	$query->field_data(),
						'query'		=> 	$query->row(),
						'action'	=> 	site_url().'tools/dbmanager/ajax/update/'.$this->uri->param(1),
						'table'		=> 	$table,
						"data"		=>  $_POST
					);

		$this->load->view('tools/dbmanager/edit', $data);

	}
}
?>