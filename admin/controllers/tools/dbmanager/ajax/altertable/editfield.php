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
class editfield extends CI_Controller
{
	function __construct() {
		
		parent::Controller();
        $this->load->helper('url');
		session_start();

		$project = $_POST["project"] != "" ? $_POST["project"] : $_SESSION['project'];  
        if(isset($project)) {

			require(APPPATH.'../'.$project.'/config/database.php');
			if(isset($_POST["dbconf"]) and isset($db[$_POST["dbconf"]]))
				$this->load->database($db[$_POST["dbconf"]], FALSE, TRUE);
			else
				$this->load->database($db[$active_group], FALSE, TRUE);

		} else {

			$this->load->database("", FALSE, TRUE);	
		}
	}

	function index() {

        if(!isset($_POST['tablename'])) return;
        if(!isset($_POST['field'])) return;

        $sql = "SHOW CREATE TABLE ".$_POST['tablename'];
        $tmp = $this->db->query($sql)->result();
        $row = "Create Table";

        $data["keys"] = array();

        foreach(explode("\n",$tmp[0]->$row) as $item) {

            if(stripos($item,"`".$_POST['field']."`")) {

               $item = substr($item, 2);

               if(!isset($data["field"])) {

                    $tmp = explode(" ",$item);
                    $data["fieldname"] = substr(array_shift($tmp),1,-1);
                    $data["field"] = array_shift($tmp);

                    $field_detail = explode("(",$data["field"]);
                    $data["type"] = $field_detail[0];

                    if(count($field_detail) > 1) {

                        $data["length"] = substr($field_detail[1],0,-1);
                    } else {

                        $data["length"] = "";
                    }

                    for($i=0; $i < count($tmp); $i++) {
                        
                        if(isset($tmp[$i]) && $tmp[$i] == "collate") {

                            unset($tmp[$i]);
                            if(isset($tmp[$i+1])) unset($tmp[$i+1]);
                        }
                    }

                    $data["other"] = substr(implode(" ",$tmp),0,-1);

                    //unsigned zerofill
                    if(stripos($data["other"],"unsigned zerofill") > -1) {

                        $data["unsigned_zero"] = true;
                        $data["unsigned"] = false;

                    } else {

                        $data["unsigned_zero"] = false;

                        // unsigned
                        if(stripos($data["other"],"unsigned") > -1)
                            $data["unsigned"] = true;
                        else
                            $data["unsigned"] = false;

                        //on update current timestamp
                        $data["current_timestamp"] = false;

                        // unsigned
                        if(stripos($data["other"],"on update CURRENT_TIMESTAMP") > -1)
                            $data["current_timestamp"] = true;
                        else
                            $data["current_timestamp"] = false;
                    }

                    //null
                    if(strpos($data["other"],"NOT NULL") > -1)
                        $data["null"] = false;
                    else
                        $data["null"] = true;

                    //default 'value'
                    $pos = stripos($data["other"],"default '");
                    if($pos > -1) {

                        $pos += strlen("default '");
                        $substr = substr($data["other"],$pos);
                        $pos2 = strpos($substr,"'");

                        if($pos2 > -1)
                            $data["default"] = substr($data["other"],$pos,$pos2);

                    } else {

                        // default current_timestamp ?
                        $pos = stripos($data["other"],"default CURRENT_TIMESTAMP");
                        if($pos > -1) {

                            $data["default"] = "current_timestamp";
                        }
                    }

                    //primary key
                    if(strpos($data["other"],"auto_increment") > -1)
                        $data["primary"] = true;
                    else
                        $data["primary"] = false;


                } else {

                    $data["keys"][] = $item;
                }
            }
        }

        $data["primary"] = $data["unique"] = $data["key"] = false;

        foreach($data["keys"] as $key) {

            if(stripos($key,"UNIQUE KEY") > -1)
                $data["unique"] = true;

            elseif(stripos($key,"PRIMARY KEY") > -1)
                $data["primary"] = true;

            elseif(stripos($key,"KEY") > -1)
                $data["key"] = true;
        }
        
        unset($data["field"]);
        unset($data["keys"]);


        if(!isset($data["default"]))    $data["default"] = "";

		$this->load->view('tools/dbmanager/editfield',$data);
	}
}
?>