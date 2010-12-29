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
class backup extends CI_Controller 
{
	function __construct() {

		parent::__construct();

		@set_time_limit(0);
		session_start();

		$project = $_POST["project"] != "" ? $_POST["project"] : $_SESSION["project"]; 
		if(isset($project)) {

			require(APPPATH.'../'.$project.'/config/database.php');

			if(isset($_POST["dbconf"]) and isset($db[$_POST["dbconf"]]))
				$this->load->database($db[$_POST["dbconf"]]);
			else
				$this->load->database($db[$active_group]);

		} else {

			$this->load->database();	
		}

		$this->load->dbutil();
	}

	function index() {

		if(isset($_POST["backup_query"]))
			$backup_query = "select ".$_POST["backup_query"][0]." from ".$_POST['table']." ".$_POST["backup_query"][1];
		else
			$backup_query = "";

		if($_POST['format'] == "browser") {

			if($_POST['witch'] == 'this') {

				$prefs = array(
	                'tables'      => array($_POST['table']),  
	                'format'      => 'txt', 
	                'add_drop'    => isset($_POST['drop']) ? true : false,
	                'add_insert'  => isset($_POST['inserts']) ? true : false,
	                'newline'     => "\n",
					'extended'	  => isset($_POST['extended']) ? true : false,
					'ifnotexists' => isset($_POST['notexists']) ? true : false
	              ); 

				 $backup =& $this->dbutil->backup($prefs,$backup_query); 
				 echo $backup;

			} else if($_POST['witch'] == 'All') {
				
				$prefs = array(
	                'format'      => 'txt',
	                'add_drop'    => isset($_POST['drop']) ? true : false,
	                'add_insert'  => isset($_POST['inserts']) ? true : false,
	                'newline'     => "\n",
					'extended'	  => isset($_POST['extended']) ? true : false,
					'ifnotexists' => isset($_POST['notexists']) ? true : false
	              ); 

				$backup =& $this->dbutil->backup($prefs); 
				echo $backup;

			} else if($_POST['witch'] == 'custom') {

				if(!isset($_POST['tables'])) {
					
					echo "Select at least one table";
					return;
				}

				$prefs = array(
	                'tables'      => $_POST['tables'],
	                'format'      => 'txt',
	                'add_drop'    => isset($_POST['drop']) ? true : false,
	                'add_insert'  => isset($_POST['inserts']) ? true : false,
	                'newline'     => "\n",
					'extended'	  => isset($_POST['extended']) ? true : false,
					'ifnotexists' => isset($_POST['notexists']) ? true : false
	              );

				$backup =& $this->dbutil->backup($prefs);
				echo $backup;
			}

		} elseif($_POST['format'] == "txt") {

			if($_POST['witch'] == 'this') {

				$prefs = array(
	                'tables'      => array($_POST['table']),
	                'format'      => $_POST['compression'],
	                'add_drop'    => isset($_POST['drop']) ? true : false,
	                'add_insert'  => isset($_POST['inserts']) ? true : false,
	                'newline'     => "\n",
					'extended'	  => isset($_POST['extended']) ? true : false,
					'ifnotexists' => isset($_POST['notexists']) ? true : false
	              ); 
	              
	              $filename = $_POST['table'];

			} elseif($_POST['witch'] == 'All') {

				$prefs = array(
	                'format'      => $_POST['compression'],
	                'add_drop'    => isset($_POST['drop']) ? true : false,
	                'add_insert'  => isset($_POST['inserts']) ? true : false,
	                'newline'     => "\n",
					'extended'	  => isset($_POST['extended']) ? true : false,
					'ifnotexists' => isset($_POST['notexists']) ? true : false
	              ); 
	              
	              $filename = $_POST["dbconf"];

			} else if($_POST['witch'] == 'custom') {

				if(!isset($_POST['tables'])) return;

				$prefs = array(
	                'tables'      => $_POST['tables'],
	                'format'      => $_POST['compression'],
	                'add_drop'    => isset($_POST['drop']) ? true : false,
	                'add_insert'  => isset($_POST['inserts']) ? true : false,
	                'newline'     => "\n",
					'extended'	  => isset($_POST['extended']) ? true : false,
					'ifnotexists' => isset($_POST['notexists']) ? true : false
	              );
	              
	              $filename = $_POST["dbconf"];
			}

			if($_POST['witch'] == 'this')
           		$backup =& $this->dbutil->backup($prefs,$backup_query);
           	else
           		$backup =& $this->dbutil->backup($prefs);

           	
           	$backup .= "\n ";
           	
            // Load the download helper and send the file to your desktop
            $this->load->helper('download');
            force_download($filename.'.'.$_POST['compression'], $backup);
			
			
		} elseif($_POST['format'] == "xml") {
			
			$this->load->database();

            //select databases to be backuped
			if($_POST['witch'] == 'this') {
				
				$filename = $_POST['table'];

				if($_POST["backup_query"][0] != '')
					$query = $this->db->query($backup_query);
				else
					$query = $this->db->query("SELECT * FROM ".$_POST['table']);

				
				//die($query);
                $config = array (
                                  'root'    => $_POST['table'],
                                  'element' => 'element',
                                  'newline' => "\n",
                                  'tab'    => "\t"
                                );
				
                $backup = '<?xml version="1.0" encoding="utf-8" ?><root>'
                          .$this->dbutil->xml_from_result($query, $config).'</root>';

			} elseif ($_POST['witch'] == 'All') {

				$filename = $_POST['dbconf'];
				
				$dbs = $this->db->list_tables();
                $backup = '<?xml version="1.0" encoding="utf-8" ?>
                           <root>';


                $config = array (
                                  'element' => 'element',
                                  'newline' => "\n",
                                  'tab'    => "\t"
                                );

                foreach($dbs as $db) {

                    $query = $this->db->query("SELECT * FROM ".$db);
                    $config['root'] = $db;
                    $backup .= $this->dbutil->xml_from_result($query, $config);
                }

                $backup .= '</root>';

			} elseif ($_POST['witch'] == 'custom') {

				$filename = $_POST['dbconf'];
				
                $backup = '<?xml version="1.0" encoding="utf-8" ?>
                           <root>';

                $config = array (
                                  'element' => 'element',
                                  'newline' => "\n",
                                  'tab'    => "\t"
                                );

                foreach($_POST['tables'] as $db) {

                    $query = $this->db->query("SELECT * FROM ".$db);
                    $config['root'] = $db;
                    $backup .= $this->dbutil->xml_from_result($query, $config);
                }

                $backup .= '</root>';

            } else {

                return;
            }

            if($_POST['compression'] == 'txt') {

                $filename = 'mybackup.xml';

            } elseif ($_POST['compression'] == 'zip') {

                $filename = $filename.'.xml.'.$_POST['compression'];

                $this->load->library('zip');
                $this->zip->add_data('mybackup.xml', $backup);
                $backup = $this->zip->get_zip();

            } else {

                $filename = $filename.'.xml.gz';
                $backup = gzencode($backup);
            }

            $this->load->helper('download');
            force_download($filename, $backup);
				

		} elseif($_POST['format'] == "csv") {
			
            $this->load->database();
            
            if($_POST["backup_query"][0] != '')
				$query = $this->db->query($backup_query);            
            else
            	$query = $this->db->query("SELECT * FROM ".$_POST['table']);

            $backup = $this->dbutil->csv_from_result($query);

            if($_POST['compression'] == 'txt') {

                $filename = $_POST['table'].'.csv';

            } elseif ($_POST['compression'] == 'zip') {

                $filename = $_POST['table'].'.csv.'.$_POST['compression'];

                $this->load->library('zip');
                $this->zip->add_data($_POST['table'].'.csv', $backup);
                $backup = $this->zip->get_zip();

            } else {

                $filename = $_POST['table'].'.csv.gz';
                $backup = gzencode($backup);
            }

            $this->load->helper('download');
            force_download($filename, $backup);
		}
	}
}
?>