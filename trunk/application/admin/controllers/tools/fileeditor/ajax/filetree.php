<?php
/**
 * File editor
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class filetree extends Controller {

	function filetree()
	{
		parent::Controller();
		session_start();
	}
	
	function index()
	{
		if(!isset($_POST['dir'])) return;
		
		$_POST['dir'] = urldecode($_POST['dir']);
		$base = explode("/",$_POST['dir']);
		
		if(isset($_SESSION['project'])) {

			$apppath = explode("/",str_replace("\\","/", APPPATH));
			$apppath[count($apppath)-2] = $_SESSION['project'];
			$root = implode("/",$apppath);

		} else {

			$root = APPPATH;	
		}
		

		if( file_exists($root . $_POST['dir'])) {

			$files = scandir($root . $_POST['dir']);
			natcasesort($files);

			$data['basedir'		] 	= htmlentities($_POST['dir']);
			$data['directories'	] 	= array();
			$data['files'		]	= array();
			
			if( count($files) > 2 ) {

				foreach( $files as $file ) {
					
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
						
						$data['directories'][] = $file;
					}
				}

				foreach( $files as $file ) {
					
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {

						$data['files'][] = $file;
					}
				}
			}

			$this->load->view('tools/filetree/filetree',$data);
		}
	}
}
?>
