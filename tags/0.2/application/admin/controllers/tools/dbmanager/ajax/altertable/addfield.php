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
class addField extends Controller
{
	function addField() {

		parent::Controller();
		$this->load->helper('url');
		session_start();

        $project = $_POST["project"] != "" ? $_POST["project"] : $_SESSION['project'];
		if(isset($project)) {

			require(APPPATH.'../'.$project.'/config/database.php');
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

        foreach($table_fields as $field) {

            $sql = "ALTER TABLE `".$_POST['tablename']."` ADD {$field};";
            $this->db->query($sql);
        }

        foreach($table_keys as $key) {

            $sql = "ALTER TABLE `".$_POST['tablename']."` ADD {$key};";
            $this->db->query($sql);
        }

        print "1";
	}
}
?>