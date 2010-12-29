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
class updatefield extends CI_Controller
{
	function __construct() {

		parent::Controller();
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

        if(!isset($_POST['tablename']) || $_POST['tablename'] == '') return;
        if(!isset($_POST['tablefield']) || $_POST['tablefield'] == '') return;

        $params = explode('|', $_POST["query"]);

        $sql = "SHOW CREATE TABLE ".$_POST['tablename'];
        $tmp = $this->db->query($sql)->result();
        $row = "Create Table";

		/***    update table keys
        /****	check already existing keys and delete if necesary	***/
        $kexits = array();
        $kexist['primary'] = $kexist['unique'] = $kexist['index'] = false;

        //split in rows
        foreach(explode("\n",$tmp[0]->$row) as $item) {

            $item = substr($item, 2);

            // filter the rows selecting only thoose ones that matches with the field name
            if(stripos($item,"`".$_POST['tablefield']."`") > -1) {

                if(stripos($item,"UNIQUE KEY") > -1) {

                    $kexist["unique"] = true;

                    if(!isset($params[1]) || stripos($params[1],"UNIQUE") < 1 || stripos($params[1],"UNIQUE") == '') {

                        $tmp = explode(" ",$item);
                        $key_name = str_replace('`','',$tmp[2]);

                        $this->db->query("ALTER TABLE `{$_POST['tablename']}` DROP INDEX `{$key_name}`");
                    }
					
				} elseif(stripos($item,"auto_increment") > -1) {

					$item = str_replace(" auto_increment","",substr($item,0 ,-1));
					$sql = "ALTER TABLE `{$_POST['tablename']}` CHANGE `{$_POST['tablefield']}` {$item}";
					
					$this->db->query($sql);

                } elseif(stripos($item,"PRIMARY KEY") > -1) {

                    $kexist["primary"] = true;

                    if(stripos($params[0],"PRIMARY KEY") > -1)
                    	$this->db->query("ALTER TABLE `{$_POST['tablename']}` DROP PRIMARY KEY");

                } elseif(stripos($item,"KEY") > -1) {

                    $kexist["index"] = true;

                    if(!isset($params[1]) || stripos($params[1],"KEY") < 1 || stripos($params[1],"KEY") == '') {

                        $tmp = explode(" ",$item);
                        $key_name = str_replace('`','',$tmp[1]);

                        $this->db->query("ALTER TABLE `{$_POST['tablename']}` DROP INDEX `{$key_name}`");
                    }
                }
            }
        }

		/*** alter table ***/
        $sql = "ALTER TABLE `{$_POST['tablename']}` CHANGE `{$_POST['tablefield']}` {$params[0]}";
        $this->db->query($sql);

        /***    and new keys [filter already existing ones]    ***/
        if(isset($params[1])) {

            if($kexist["unique"] == false) {

                if(stripos($params[1],"UNIQUE") > -1)
                    $this->db->query("ALTER TABLE `".$_POST['tablename']."` ADD UNIQUE KEY `{$_POST['tablefield']}` ({$_POST['tablefield']})");
            }

            if($kexist["index"] == false) {

                if(stripos($params[1],"INDEX") > -1)
                    $this->db->query("ALTER TABLE `".$_POST['tablename']."` ADD INDEX `{$_POST['tablefield']}` ({$_POST['tablefield']})");
            }
        }

        print "1";
	}
}
?>