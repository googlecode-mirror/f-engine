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
class createtable extends CI_Controller
{
	function __construct() {
		
		parent::__construct();
		$this->load->helper('url');
	}
	
	function index() {
		
		echo "This script is not accesible directly";
	}
	
	function ajax() {

        if(!isset($_POST['tablename']) || $_POST['tablename'] == '') return;
        if(!isset($_POST['tablefields'])) return;

        $table_fields = array();
        $table_keys = array();

        foreach($_POST['tablefields'] as $field) {

            $tmp = explode('|',$field);
            
            $table_fields[] = $tmp[0];

            if(isset($tmp[1])) {

                $fieldname = explode(' ',$tmp[0]);

                if(strpos($tmp[1],"unique") > -1)
                    $table_keys[] = "UNIQUE KEY `{$fieldname[0]}` ({$fieldname[0]})";

                elseif(strpos($tmp[1],"index") > -1)
                    $table_keys[] = "KEY `{$fieldname[0]}` ({$fieldname[0]})";
            }
        }

        $fields =  "\n\t".implode($table_fields,",\n\t");
        if(count($table_keys) > 0)
            $keys =  ",\n\t".implode($table_keys,",\n\t");

        $charset = explode('_',$_POST['table_collation']);

        $sql = "CREATE TABLE `".trim($_POST['tablename'])."` (";
        $sql .= $fields;
        if(isset($keys)) $sql .= $keys;
        $sql .= "\n) ENGINE={$_POST['table_type']} CHARSET={$charset[0]} COLLATE={$_POST['table_collation']}";

        if($this->uri->param(1) == "preview") {

            echo $sql;

        } else {

        	if(isset($_POST['project'])) {

				require(FCPATH.'../'.$_POST['project'].'/config/database.php');
				if(isset($_POST["dbconf"]) and isset($db[$_POST["dbconf"]]))
					$this->load->database($db[$_POST["dbconf"]]);
				else
					$this->load->database($db[$active_group]);

			} else {

				$this->load->database();	
			}

            echo $this->db->query($sql);
        }
	}
}
?>