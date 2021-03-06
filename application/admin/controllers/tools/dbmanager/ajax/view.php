<?php
/**
 * Dbmanager
 *
 * @package	F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.5
 * @filesource
 */
class view extends Controller 
{
	var $isView = false;
	var $createTable = false;
	var $tableNum = array();

	function view() {

		parent::Controller();
		$this->load->helper(array('url','form'));
		//$this->output->enable_profiler = true;
	}

	function index() {

		echo "This script is not accesible directly";
	}

	function ajax($offset=0) {

		//Set default items per page
		$items_per_page = 20;	

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

		//show edit/delete buttons
		$actions = true;

		//database table list
		$listables = $this->db->list_tables();

		/*** Exam tab ***/
		if(isset($_POST["query"])) {

			$query_str = $_POST["query"];

			/*** Split query into sentence and record limit ***/
			if(stripos($query_str, "limit")) {

				$limit_pos = strripos($query_str, "limit");

				$query_array = array(
					substr($query_str,0,$limit_pos),
					trim(str_ireplace("limit","",substr($query_str,$limit_pos)))
				);

			} else {

				$query_array = array($query_str);
			}

			$query_nolimit = $query_array[0];
			$query_nolimit = preg_replace("/;\s*$/i","",$query_nolimit);

			//should we show actions and/or pagination ?
			list($actions, $pagination) = $this->showActions($query_str,$listables);

			//redefine offset and limit (if sent)
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
				
				if(strrpos($query_nolimit," order ") !== false) {

					$query_nolimit = substr($query_nolimit,0,strrpos($query_nolimit," order "));
				}

				$orderby = " ORDER BY ".$_POST["orderby"]." ";
				$query_str = $query_nolimit.$orderby." LIMIT ".$offset.",".$items_per_page;

			} elseif(isset($_POST["query"]) && stripos($_POST["query"],"order") !== false) {	

				preg_match("/order\sby\s.* (asc\s|desc\s)/i",$query_nolimit,$match);

				if(count($match) > 0) {

					$tmp = trim(preg_replace("/order\sby\s/i","",$match[0]));
					$orderby = $tmp;
					$query_orderby = explode(" ",$tmp);
				} 

				$query_str = $query_nolimit;

				if($pagination == true) {

					$query_str .= " LIMIT ".$offset.",".$items_per_page;
				}

			} elseif( isset($_POST["table"]) and $_POST["table"] != "" ) {

				if($pagination == false) {

					$query_str = $query_nolimit;

				} else {

					$query_str = $query_nolimit." LIMIT ".$offset.",".$items_per_page;
				}

			} else {

				$query_str = $query_nolimit;
			}

			//skip errors
			$this->db->skip_errors = TRUE;
			$itemCountSql = "select count(*) as itemNum from (".$query_nolimit.") as tmp";
			$rs = $this->db->query($itemCountSql);
			$this->db->skip_errors = FALSE;

			//disable item count (pagination) when query has "order by rand()"
			if(strpos($query_nolimit,"rand()")) {

				$total_rows = $rs->row()->itemNum > $items_per_page ? $rs->row()->itemNum : $items_per_page;

			} elseif(!is_string($rs)) {

				$total_rows = $rs->row()->itemNum;

			} else {

				$total_rows = $this->db->query($query_nolimit)->num_rows();
			}

			// Run query
			$this->benchmark->mark('query_execution_time_start'); 
			if(isset($_POST["action"]) and $_POST["action"] == 'refresh')  {

				if(stripos($query_str,"limit") !== false) {

					$query = $this->db->query($query_str);

				} else {

					if($pagination == false) {

						$sql = $_POST["query"];

					} else {

						$sql = preg_replace("/;\s*$/i","",$query_str)." LIMIT ".$items_per_page;
					}

					$query = $this->db->query($sql);
				}

			} else {

				$query = $this->db->query($query_str);
			}

			$this->benchmark->mark('query_execution_time_end');
			$execution_time = $this->benchmark->elapsed_time('query_execution_time_start', 'query_execution_time_end'); 

			$sql = $this->db->last_query();

			if ($total_rows > 0) {
				$fields = array();
				if(isset($query)) {
					foreach($query->row_array() as $key => $val) {

						$fields[] = $key;
					}
				}

			} else {

				if(isset($_POST["table"]) and $_POST["table"] != "")
					$fields = $this->db->list_fields($_POST["table"]);
				else 
					$fields = array(); 
			}

			if($currentable != ""  && in_array(strtolower( array_shift( explode(",",$this->get_primary($currentable,false))) ) ,array_map("strtolower",$fields)) ) {

				$primary = $this->get_primary($currentable);
			}

			if(!isset($primary))    $primary = false;

		} else {

			// Fetch the total number of DB rows
			$total_rows = $this->db->count_all($currentable);

			// Run the query
			$this->benchmark->mark('query_execution_time_start');
			$query = $this->db->get($_POST['table'], $items_per_page, $offset);

			$this->benchmark->mark('query_execution_time_end');
			$execution_time = $this->benchmark->elapsed_time('query_execution_time_start', 'query_execution_time_end'); 

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
						'orderby' => isset($_POST["orderby"]) ? explode(" ",$_POST["orderby"]) : false,
						'execution_time' => $execution_time
		);

		if(isset($query_orderby)) {

			//replace default orderby
			$data['exam']['orderby'] = $query_orderby;
		}

		$data["isView"] = $this->isView;
		if($data["isView"] or (isset($_POST["query"]) and count($this->tableNum) == 0)) {

			$data["actions"] = false;

		} else {

			if($data['exam']['primary']) {

	        	$tmp = explode('|',$data['exam']['primary']);
	        	$exam_keys = explode(",",$tmp[1]);

	        	if(count($exam_keys) > 1) {

	        		$index_count = 0;
	        		foreach($data['exam']['query']->row() as $key => $item) {

	        			if(in_array($key,$exam_keys)) {
	        				$index_count++;
	        			}
	        		}

	        		if(count($exam_keys) != $index_count) {

	        			$actions = false;
	        		}
	        	}
	        }

	        $data["actions"] = $actions;
		}

        if(!isset($_POST['fullLoad'])) {

			$this->load->view('tools/dbmanager/exam',$data);
			return;
        }

		/*** get data for insert and structure tabs ***/
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
		$data['tables'] = $listables;
		$this->load->view('tools/dbmanager/data', $data);
	}

    function get_primary ($table = '',$concat_type = true) {

    	if($table == '') return '';	

    	if(!$this->createTable) {

    		$sql = "SHOW CREATE TABLE ".$table;
        	$query = $this->createTable = $this->db->query($sql)->row();

    	} else {

    		$query = $this->createTable;
    	}

        if(isset($query->View)) {

        	$row = "Create View";
        	$this->isView = true;

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

		//count(*)
		preg_match("/\s*count\(/i",$dummy_query,$count);
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
		$this->tableNum = $multidb = array_unique($multidb[0]);
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
		  count($multifrom) > 1 || count($count) > 0 ) {

			return array(false,true);

		} else {

			return array(true,true);
		}
    }
}
?>