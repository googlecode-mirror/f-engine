<?php
/**
 * New controller wizard
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class filetree extends CI_Controller {

	private $apppath;
	private $public_data;
	
	function __construct()
	{
		parent::__construct();
		session_start();

		if(isset($_SESSION['project'])) {

			$apppath = explode("/",str_replace("\\","/", APPPATH));
			$apppath[count($apppath)-2] = $_SESSION['project'];
			$this->apppath = implode("/",$apppath);

			$this->public_data = $this->apppath.'public_data/';

		} else {

			$this->apppath = APPPATH;
			$this->public_data = PUBLIC_DATA;
		}
	}
	
	function index()
	{
		if(!isset($_POST['dir'])) return;
		
		$_POST['dir'] = urldecode($_POST['dir']);
		$base = explode("/",$_POST['dir']);
		
		switch($base[0]) {
			
			case 'js':
			case 'css':
							$root = $this->public_data;	
							break;
			case 'header':
							$root = $this->apppath.'views/';
							break;
			case 'footer':
							$root = $this->apppath.'views/';
							break;
			case 'models':
							$root = $this->apppath.'application/';
							break;
			case 'helpers':
			case 'libraries':
							$root = $this->apppath;
							break;
			default:
							return;							
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
		} else {
			
			die($root . $_POST['dir']);
		}
	}
}
?>
