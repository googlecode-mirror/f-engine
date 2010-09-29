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

        if ( stripos(substr($_POST['sql'],0, stripos(trim($_POST['sql'])," ")+1), 'update ') !== false
        		  || stripos($_POST['sql'], 'insert ') !== false
                  || stripos($_POST['sql'], 'delete ') !== false
                  || stripos($_POST['sql'], 'drop ') !== false
                  || stripos($_POST['sql'], 'create table ') !== false
                  || stripos($_POST['sql'], 'alter') !== false) {

           $this->db->query($_POST["sql"]);
           
           echo "Affected rows: ".$this->db->affected_rows();

           return;

        } elseif(stripos(substr($_POST['sql'],0,stripos(trim($_POST['sql'])," ")+1),'SELECT ') > -1) {

        	$tablelist = $this->db->list_tables();
        	$sql_segments = explode(" ", str_replace(array("`", "(", ")",",","\n")," ",$_POST["sql"]));

        	$table = '';
        	$match_num = 0;

        	foreach($sql_segments as $item) {

        		if(in_array($item, $tablelist)) {

        			if($table != $item) {
        				$table = $item;
        			}

        			$match_num++;
        		}
        	}

        	if($match_num == 1) {
        		
        		echo "<!--exam-->".$table;

        	} else {
        		echo "<!--exam-->";
        	}

        } else  {

            $result = $this->db->query($_POST["sql"])->result();

            foreach ($result as $data) {

                foreach($data as $key=>$value) {

                    echo $key."<br /><pre>";
                    print_r($value);
                    echo "</pre>";
                }
            }

            return;
        }
	}
}
?>