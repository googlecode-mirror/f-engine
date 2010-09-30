<?php
/**
 * Dbmanager
 *
 * @package	F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link			http://www.f-engine.net/
 * @since		Version 0.3
 * @filesource
 */
class view extends Controller 
{
	function view() {

		parent::Controller();
		$this->load->helper(array('url','form'));
		$this->load->library('pagination');
		session_start();
	}

	function index($offset=0) {

		//Set items per page var
		$items_per_page = 10;	

		if(isset($_POST["query"])) {
			
			$tmp = array_pop(explode(",",$_POST["query"]));
			
			if(is_numeric($tmp))
				$items_per_page = (int) $tmp;
		}

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
			$query_nolimit = explode("LIMIT", $query_str);
			$query_nolimit = $query_nolimit[0];
			
			if(isset($_POST["orderby"]) &&  $_POST["orderby"] != '') {
				
				$query_nolimit = explode("order", $query_nolimit);
				$query_nolimit = $query_nolimit[0];	
				
				$orderby = " order by ".strtolower($_POST["orderby"])." ";
				
			} else {
				
				$orderby = " ";
			}

			// Fetch the total number of DB rows
			$total_rows = $this->db->query($query_nolimit)->num_rows();

			// Run the query
			if($_POST["action"] == 'refresh')  {
				
				if(stripos($_POST["query"],"limit") !== false) {
					
					
					$query_str = str_ireplace("limit","LIMIT",$_POST["query"]);
					$tmp = explode("LIMIT", $query_str); 
					$tmp2 = explode("order", $tmp[0]);
					$sql = $tmp2[0].$orderby."LIMIT ".$tmp[1];

					$query = $this->db->query($sql);

				} else {

					$sql = $_POST["query"].$orderby." LIMIT ".$items_per_page;
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

		// Pagination
		$data =  array(
						'base_url'		 => site_url().'tools/dbmanager/ajax/view',
						'total_rows'	 => $total_rows,
						'per_page'		 => $items_per_page,
						'offset'		=> $offset,
						'uri_segment'	 => 5,
						'full_tag_open'	 => '<p style="margin:1px;">',
						'full_tag_close' => '</p>',
						'first_link'			=> '«',
						'last_link'			=> '»'
		);

		$this->pagination->initialize($data);

		$data['exam'] = array(
						'title'	=>  'View Data',
						'query'		=> $query,
						'sql'		=> $sql,
						'fields'	=> $fields,
						'primary'	=> $primary,
						'paginate'	=> $this->pagination->create_links(),
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
}
?>