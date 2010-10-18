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
class backup extends Controller 
{
	function backup() {
		
		parent::Controller();
		
		session_start();

		$project = $_POST["project"] != "" ? $_POST["project"] : $_SESSION["project"]; 
		if(isset($project)) {

			require(APPPATH.'../'.$project.'/config/database.php');
			$this->load->database($db[$active_group]);

		} else {

			$this->load->database();	
		}
		
		$this->load->dbutil();
	}
	
	function index() {
		
		
		$backup_query = "select ".$_POST["backup_query"][0]." from ".$_POST['table']." ".$_POST["backup_query"][1];
		
		if($_POST['format'] == "browser") {

			if($_POST['witch'] == 'this') {

				$prefs = array(
	                'tables'      => array($_POST['table']),  // Array of tables to backup.
	                'format'      => 'txt',             // gzip, zip, txt
	                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
	                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
	                'newline'     => "\n"               // Newline character used in backup file
	              ); 

				 $backup =& $this->dbutil->backup($prefs,$backup_query); 
				 echo $backup;

			} else if($_POST['witch'] == 'All') {
				
				$prefs = array(
	                'format'      => 'txt',             // gzip, zip, txt
	                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
	                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
	                'newline'     => "\n"               // Newline character used in backup file
	              ); 

				$backup =& $this->dbutil->backup($prefs); 
				echo $backup;

			} else if($_POST['witch'] == 'custom') {

				if(!isset($_POST['tables'])) {
					
					echo "Select at least one table";
					return;
				}

				$prefs = array(
	                'tables'      => $_POST['tables'],  // Array of tables to backup.
	                'format'      => 'txt',             // gzip, zip, txt
	                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
	                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
	                'newline'     => "\n"               // Newline character used in backup file
	              );

				$backup =& $this->dbutil->backup($prefs);
				echo $backup;
			}
			
		} elseif($_POST['format'] == "txt") {

			if($_POST['witch'] == 'this') {
				
				$prefs = array(
	                'tables'      => array($_POST['table']), 	// Array of tables to backup.
	                'format'      => $_POST['compression'], 	// gzip, zip, txt
	                'add_drop'    => TRUE,              		// Whether to add DROP TABLE statements to backup file
	                'add_insert'  => TRUE,              		// Whether to add INSERT data to backup file
	                'newline'     => "\n"               		// Newline character used in backup file
	              ); 
				  
			} elseif($_POST['witch'] == 'All') {
				
				$prefs = array(
	                'format'      => $_POST['compression'], // gzip, zip, txt
	                'add_drop'    => TRUE,              	// Whether to add DROP TABLE statements to backup file
	                'add_insert'  => TRUE,              	// Whether to add INSERT data to backup file
	                'newline'     => "\n"               	// Newline character used in backup file
	              ); 
	              
			} else if($_POST['witch'] == 'custom') {

				if(!isset($_POST['tables'])) return;

				$prefs = array(
	                'tables'      => $_POST['tables'],  	// Array of tables to backup.
	                'format'      => $_POST['compression'], // gzip, zip, txt
	                'add_drop'    => TRUE,              	// Whether to add DROP TABLE statements to backup file
	                'add_insert'  => TRUE,              	// Whether to add INSERT data to backup file
	                'newline'     => "\n"               	// Newline character used in backup file
	              );

			}

			if($_POST['witch'] == 'this')
           		$backup =& $this->dbutil->backup($prefs,$backup_query);
           	else
           		$backup =& $this->dbutil->backup($prefs);

            // Load the download helper and send the file to your desktop
            $this->load->helper('download');
            force_download('mybackup.'.$_POST['compression'], $backup);
			
			
		} elseif($_POST['format'] == "xml") {
			
			$this->load->database();

            //select databases to be backuped
			if($_POST['witch'] == 'this') {

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

                $filename = 'mybackup.xml.'.$_POST['compression'];

                $this->load->library('zip');
                $this->zip->add_data('mybackup.xml', $backup);
                $backup = $this->zip->get_zip();

            } else {

                $filename = 'mybackup.xml.gz';
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

                $filename = 'mybackup.csv';

            } elseif ($_POST['compression'] == 'zip') {

                $filename = 'mybackup.csv.'.$_POST['compression'];

                $this->load->library('zip');
                $this->zip->add_data('mybackup.csv', $backup);
                $backup = $this->zip->get_zip();

            } else {

                $filename = 'mybackup.csv.gz';
                $backup = gzencode($backup);
            }

            $this->load->helper('download');
            force_download($filename, $backup);
		}
	}
}
?>