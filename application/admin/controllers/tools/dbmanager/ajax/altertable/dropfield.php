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
class dropField extends Controller
{
	function dropField() {

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
        if(!isset($_POST['field']) || $_POST['field'] == '') return;

        $sql = "ALTER TABLE `".$_POST['tablename']."` DROP  ". $_POST['field'] .";";
        $this->db->query($sql);

        print "1";
	}
}
?>