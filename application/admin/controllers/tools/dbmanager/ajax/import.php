<?php
class import extends Controller 
{
	function import() {
		
		parent::Controller();
	}
	
	function index() {

		set_time_limit(0);

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

			$content = file_get_contents($_FILES['fileToUpload']['tmp_name']);
			
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
}
?>