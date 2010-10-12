<?php
/**
 * Dbmanager
 *
 * @package	F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link			http://www.f-engine.net/
 * @since		Version 0.4
 * @filesource
 */
class view extends Controller 
{
	function view() {

		parent::Controller();
		$this->load->helper(array('url','form'));
	}
	
	function index() {
		
		echo "This script is not accesible directly";
	}
	
	function ajax($offset=0) {

		//Set items per page var
		$items_per_page = 10;	

		if(isset($_POST['project'])) {

			require(APPPATH.'../'.$_POST['project'].'/config/database.php');

			if(isset($_POST["dbconf"]) and isset($db[$_POST["dbconf"]]))
				$this->load->database($db[$_POST["dbconf"]], FALSE, TRUE);
			else
				$this->load->database($db[$active_group], FALSE, TRUE);

		} else {

			$this->load->database("", FALSE, TRUE);	
		}

		$data = array();

		//get target table
		$currentable = $_POST["table"];

		// Set query limit/offset	
		$items_per_page = $items_per_page;

		//show edit and delete buttons
		$actions = true;

		//database table list
		$listables = $this->db->list_tables();

		/*** Exam tab ***/
		if(isset($_POST["query"])) {

			$query_str = str_ireplace("limit","LIMIT",$_POST["query"]);
			$query_array = explode("LIMIT", $query_str);
			$query_nolimit = $query_array[0];

			//redefine offset and limit if is sent
			if(isset($query_array[1])) {

				@list($newOffset,$newLimit) = explode(",",$query_array[1]);

				if(isset($newLimit) and is_numeric($newLimit)) {

					$items_per_page = $newLimit;

				} else {

					$items_per_page = $newOffset;
				}
			}

			if(isset($_POST["orderby"]) &&  $_POST["orderby"] != '') {

				$query_nolimit = str_ireplace("ORDER","order",$query_nolimit);
				$query_nolimit = explode("order", $query_nolimit);
				$query_nolimit = $query_nolimit[0];	

				$orderby = " ORDER BY ".$_POST["orderby"]." ";

			} else {

				$orderby = " ";
			}

			// Fetch the total number of DB rows
			$total_rows = $this->db->query($query_nolimit)->num_rows();

			// Run query
			if($_POST["action"] == 'refresh')  {

				if(stripos($_POST["query"],"limit") !== false) {

					$query_str = str_ireplace(array("limit","order"),array("LIMIT","ORDER"),$_POST["query"]);
					$tmp = explode("LIMIT", $query_str); 
					$tmp2 = explode("ORDER", $tmp[0]);
					$sql = $tmp2[0].$orderby."LIMIT ".$tmp[1];

					$query = $this->db->query($sql);

				} else {

					list($actions, $pagination) = $this->showActions($_POST["query"],$listables);

					if($actions == false) {

						$actions = false;
					}

					if($pagination == false) {

						$sql = $_POST["query"];
						$pagination = false;

					} else {

						$sql = preg_replace("/;\s*$/i","",$_POST["query"]).$orderby." LIMIT ".$items_per_page;
					}

					$query = $this->db->query($sql);
				}

			} else {

				$query = $this->db->query($query_nolimit.$orderby." LIMIT ".$offset.",".$items_per_page);
			}

			$sql = $this->db->last_query();

			if ($total_rows > 0) {
				$fields = array();
				if(isset($query)) {
					foreach($query->row_array() as $key => $val) {

						$fields[] = $key;
					}
				}

			} else {

				$fields = $this->db->list_fields($_POST["table"]); 
			}

			if($currentable != ""  && in_array(strtolower( array_shift( explode(",",$this->get_primary($currentable,false))) ) ,array_map("strtolower",$fields)) ) {

				$primary = $this->get_primary($currentable);
			}

			if(!isset($primary))    $primary = false;

		} else {

			// Fetch the total number of DB rows
			$total_rows = $this->db->count_all($currentable);

			// Run the query
			$query = $this->db->get($_POST['table'], $items_per_page, $offset);
			$sql = $this->db->last_query();

			// Now let's get the field names				
			$primary = $this->get_primary($currentable);
			if(!isset($primary))    $primary = false;
			$fields = $this->db->list_fields($currentable);
		}

		if(isset($pagination) && $pagination === false) {
			
			$paginate = '';
			$data = array(
				'offset' => 0,
			);

		} else {
			
			$this->load->library('pagination');

			// Pagination
			$data =  array(
							'base_url'		 => site_url('tools/dbmanager/ajax/view'),
							'total_rows'	 => $total_rows,
							'per_page'		 => $items_per_page,
							'offset'	     => $offset,
							'uri_segment'	 => 5,
							'full_tag_open'	 => '<p style="margin:1px;">',
							'full_tag_close' => '</p>',
							'first_link'	 => '«',
							'last_link'		 => '»'
			);
	
			$this->pagination->initialize($data);
			$paginate = $this->pagination->create_links();
		}


		$data['exam'] = array(
						'title'	=>  'View Data',
						'query'		=> $query,
						'sql'		=> $sql,
						'fields'	=> $fields,
						'primary'	=> $primary,
						'paginate'	=> $paginate,
						'orderby' => isset($_POST["orderby"]) ? explode(" ",$_POST["orderby"]) : false
		);

		$data["actions"] = $actions;

        if(!isset($_POST['fullLoad'])) {

               $this->load->view('tools/dbmanager/exam',$data);
               return;
        }

		/*** insert and structure tabs ***/
        if($currentable != '') {
			$data['structure'] = $this->db->query('describe '.$currentable)->result();
        	$tmp = $this->db->query('SHOW CREATE TABLE '.$currentable)->row();
        }

        $field = "Create Table";
 
        if(!isset($tmp->$field)) {
        	
        	$field = "Create View";
        }

        $data['createtable'] = $tmp->$field;

		/*** backup tab ***/
		$data['dbfields'] = $listables;
		$this->load->view('tools/dbmanager/data', $data);
	}

    function get_primary ($table = '',$concat_type = true) {

    	if($table == '') return '';	

        $sql = "SHOW CREATE TABLE ".$table;
        $query = $this->db->query($sql)->row();

        if(isset($query->View)) {

        	$row = "Create View";
 
        } else {

        	$row = "Create Table";
        }

        foreach(explode("\n",$query->$row) as $item) {

            $item = substr($item, 2);

            if (stripos($item,"UNIQUE KEY") > -1) {

                $unique = str_replace("`","",substr($item,strpos($item,'(`')+2, strpos($item,'`)') - strpos($item,'(`') -2));

            } elseif (stripos($item,"PRIMARY KEY") > -1) {

                $primary = str_replace("`","",substr($item,strpos($item,'(`')+2, strpos($item,'`)') - strpos($item,'(`') -2));
                break;
            }
        }

        if(isset($primary)) {
            
        	if($concat_type)
        		return "primary|".$primary;
        	else
        		return $primary;
        }
        
        if(isset($unique)) {
            
        	if($concat_type)
        		return "unique|".$primary;
        	else
        		return $unique;
        }
        
        return false;
    }

    function showActions ($query,$dblist) {

    	$patterns = array(
			'/["\'][^,]*["\']/i',
			'/\s{2}/i'
		);
		$dummy_query = preg_replace($patterns, "", trim($query));

		//show
		preg_match("/^\s*show\s*/i",$dummy_query,$show);
		//group by
		preg_match("/\s+group\s+by/i",$dummy_query,$groupby);
		//having
		preg_match("/\s+having\s+by/i",$dummy_query,$having);
		//join
		preg_match("/\s+join\s+/i",$dummy_query,$join);
		//union
		preg_match("/\s+union\s+/i",$dummy_query,$union);

		//multidatabase
		preg_match_all("(".implode("|",$dblist).")",$dummy_query,$multidb);
		$multidb = $multidb[0];
		//multiple select
		preg_match_all("/select\s+/i",$dummy_query,$multiselect);
		$multiselect = $multiselect[0];
		//multiple from
		preg_match_all("/\s+from\s+/i",$dummy_query,$multifrom);
		$multifrom = $multifrom[0];

		// returns array(show actions,show pagination)
		if (count($show) > 0) {

			return array(false,false);

		} elseif (count($groupby) > 0 || count($having)  > 0  || count($join) > 0 || 
		  count($union)   > 0 || count($multidb) > 1  || count($multiselect) > 1  || 
		  count($multifrom) > 1 ) {

			return array(false,true);

		} else {

			return array(true,true);
		}
    }
}
?>