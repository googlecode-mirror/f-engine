<?php
/**
 * Dbmanager
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.3
 * @filesource
 */
class query extends Controller
{
	function query() {

		parent::Controller();
		session_start();

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

	function index() {

		if(!isset($_POST['sql'])) return;

		$patterns = array(
			'/["\'][^,]*["\']/i',
			'/\s{2}/i'
		);
		$dummy_query = preg_replace($patterns, "", trim($_POST['sql']));
		
        if ( stripos($dummy_query, 'update ') !== false
             || stripos($dummy_query, 'insert ') !== false
             || stripos($dummy_query, 'delete ') !== false
             || stripos($dummy_query, 'drop ') !== false
             || stripos($dummy_query, 'create ') !== false
             || stripos($dummy_query, 'alter ') !== false) {

           $this->db->query($_POST["sql"]);
           
           echo "Affected rows: ".$this->db->affected_rows();

        } else {

        	$list_tables = $this->db->list_tables();
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
}
?>