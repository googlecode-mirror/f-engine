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
class query extends Controller
{
	function query() {

		parent::Controller();
		session_start();
	}

	function index() {
		
		echo "This script is not accesible directly";
	}
	
	function ajax() {

		if(!isset($_POST['sql'])) return;


		$patterns = array(
			'/["\'][^,]*["\']/i',
			'/\s{2}/i'
		);
		$dummy_query = preg_replace($patterns, "", trim($_POST['sql']));

		preg_match("/^\s*show\s+/i",$dummy_query,$show);

		preg_match("/^\s*update\s+/i",$dummy_query,$update);
		preg_match("/^\s*insert\s+into/i",$dummy_query,$insert);
		preg_match("/^\s*delete\s+/i",$dummy_query,$delete);
		preg_match("/^\s*drop\s+table/i",$dummy_query,$drop);
		preg_match("/^\s*create\s+table/i",$dummy_query,$create);
		preg_match("/^\s*alter\s+table/i",$dummy_query,$alter);

        if ( count($show) == 0 and (
             count($update) > 0 || count($insert) > 0 ||
             count($delete) > 0 || count($alter) > 0)) {

			$this->init_db();
			$this->db->query($_POST["sql"]);
			echo "Affected rows: ".$this->db->affected_rows();

        } elseif( count($show) == 0 and count($drop) > 0 ) {	
			
        	$this->init_db();
			$this->db->query($_POST["sql"]);
        	echo "<!--refresh-->";
        	
        } elseif( count($show) == 0 and count($create) > 0 ) {	
			
        	$this->init_db();
			$this->db->query($_POST["sql"]);
        	echo "<!--refresh-->Your SQL query has been executed successfully";

        } else {

			$list_tables = $_POST["tables"];
        	$tablelist = array_map("strtolower",$list_tables);
        	$sql_segments = explode(" ", str_replace(array("`", "(", ")",",","\n")," ",$dummy_query));

        	$table = '';
        	$match_num = 0;

        	foreach($sql_segments as $item) {

        		if(in_array(strtolower($item), $tablelist)) {

        			if(strtolower($table) != $item) {

        				for($i=0; $i < count($list_tables); $i++) {
       					
        					if(strtolower($item) == strtolower($list_tables[$i])) {
        						$table = $list_tables[$i];
        					}
        				}
        			}

        			$match_num++;
        		}
        	}

        	if($match_num == 1) {
        		echo "<!--exam-->".$table;
        	} else {
        		echo "<!--exam-->";
        	}
        }
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