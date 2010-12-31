<?php
/**
 * New controller wizard
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class dbfields extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		session_start();
	}
	
	function index()
	{

		$tables = explode(',',$_POST['db']);

		if($tables) {

		    if(isset($_SESSION['project'])) {

				require(FCPATH.'../'.$_SESSION['project'].'/config/database.php');
				$this->load->database($db[$active_group]);

			} else {

				$this->load->database();	
			}
			
			foreach($tables as $db) {

				$data[$db] = $this->db->query('describe '.$db)->result();	
			}
		}

		if($data) {

			foreach ($data as $name=>$table) {

				$i=0;
				foreach ($table as $field) {

					$data[$name][$i++]->validation = $this->get_validation($field);
				}
			}

			if($_POST['view'] == 'resume') {

				$this->load->view('tools/newcontroller/db/fields_resume',array('databases' => $data, 'view' => $_POST['view']));
	
			} elseif ($_POST['view'] == 'edit') {

				$this->load->view('tools/newcontroller/db/fields_edit',array('databases' => $data, 'view' => $_POST['view']));

			} else {

				$this->load->view('tools/newcontroller/db/fields',array('databases' => $data, 'view' => $_POST['view']));	
			}
		}		
	}

	function get_validation ($field) {

		$validations = array();

		if($field->Null == 'NO')	{	

			$validations[] = 'required';
		}

		if(strpos($field->Type, 'int') !== false)	{

			if(strpos($field->Type, 'unsigned') !== false) {

				$validations[] = 'is_natural';

			} else {

				$validations[] = 'integer';
			}

			$start = strpos($field->Type, '(')+1;
			$end = strpos($field->Type, ')');
			$validations[] = 'max_length['.substr($field->Type, $start, $end-$start).']';

		} elseif (strpos($field->Type, 'char') !== false) {

			//$validations[] = 'alpha_num';

			$start = strpos($field->Type, '(')+1;
			$end = strpos($field->Type, ')');
			$validations[] = 'max_length['.substr($field->Type, $start, $end-$start).']';

		} elseif (strpos($field->Type, 'date') !== false) {

			$validations[] = 'date';

		} elseif (strpos($field->Type, 'time') !== false) {

			$validations[] = 'time';

		} elseif (strpos($field->Type, 'timestamp') !== false) {

			$validations[] = 'timestamp';
		}

		return implode('|', $validations);
	}
}
?>