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
class addField extends CI_Controller
{
	function __construct() {

		parent::__construct();
		$this->load->helper('url');
		session_start();

        $project = $_POST["project"] != "" ? $_POST["project"] : $_SESSION['project'];
		if(isset($project)) {

			require(FCPATH.'../'.$project.'/config/database.php');
			if(isset($_POST["dbconf"]) and isset($db[$_POST["dbconf"]]))
				$this->load->database($db[$_POST["dbconf"]], FALSE, TRUE);
			else
				$this->load->database($db[$active_group], FALSE, TRUE);

		} else {

			$this->load->database("", FALSE, TRUE);	
		}
	}

	function index() {

        if(!isset($_POST['tablename']) || $_POST['tablename'] == '') return;

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

        $i=0;
        foreach($table_fields as $field) {

        	if(isset($sql)) {
            	$sql .= " , ADD {$field}";
            	
            	if(isset($_POST["where"])) {
	        	    switch($_POST["where"]) {
			            case "begin":
			            case "after":
	
			            	$sql .= " AFTER `".array_shift(explode(" ",$table_fields[$i-1]))."`";
			            	break;
			        }
            	}
		         
        	} else {

            	$sql = "ALTER TABLE `".$_POST['tablename']."` ADD {$field}";
 
            	if(isset($_POST["where"])) {
	        		switch($_POST["where"]) {
			            case "begin":
			            	$sql .= " FIRST";
			            	break;
			            case "after":
			            	$sql .= " AFTER `".$_POST["after_field"]."`";
			            	break;
			         }
            	}
        	}

			$i++;
        }

        $this->db->query($sql);

        foreach($table_keys as $key) {

            $sql = "ALTER TABLE `".$_POST['tablename']."` ADD {$key};";
            $this->db->query($sql);
        }

        print "1";
	}
}
?>