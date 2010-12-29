<?php
class import extends CI_Controller 
{
	function __construct() {

		parent::__construct();
	}

	function index($project, $dbconf) {

		@set_time_limit(0);

		/*** Load database ***/
		require(APPPATH.'../'.$project.'/config/database.php');
		$this->load->database($db[$dbconf]);

		/*** Parse file ***/
		$error = "";
		$msg = "";
		$fileElementName = 'fileToUpload';

		if(!empty($_FILES[$fileElementName]['error']))
		{
			switch($_FILES[$fileElementName]['error'])
			{
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}

			echo $error;

		} elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none') {

			$error = 'No file was uploaded..';

		} else {

			$this->load->helper("file");
			$_FILES['fileToUpload']['name'];
			$type = get_mime_by_extension($_FILES['fileToUpload']['name']);

			switch($type) {

				case "application/x-zip":
					$content = $this->_unzip($_FILES['fileToUpload']['tmp_name']);
					break;

				case "application/x-gzip":
					$gz = gzopen($_FILES['fileToUpload']['tmp_name'], 'r');
					$content = "";
					while (!gzeof($gz)) {
					  $content .= gzgetc($gz);
					}
					gzclose($gz);
					break;

				default:

					$content = file_get_contents($_FILES['fileToUpload']['tmp_name']);
					break;
			}

			$items = preg_split("/;(\r?\n|\r)/", $content);

			if(count($items) > 0) {

				$this->load->database();
				foreach($items as $item) {

					if(trim($item) != "")
						$this->db->query($item);
				}
			}

			@unlink($_FILES['fileToUpload']);		
		}
	}

	function _unzip($file) {

		if (@function_exists('zip_open')) {

			$handler = zip_open($file);
			if (is_resource($handler)) {

				$entry = zip_read($handler);
				$data = zip_entry_read($entry,zip_entry_filesize($entry));
				zip_entry_close($entry);

				return $data;
			}

		} else {

			//extension needed

		}
	}
}
?>