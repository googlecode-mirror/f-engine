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
class newTable extends CI_Controller 
{
	function __construct() {
		
		parent::__construct();
        $this->load->helper('url');
	}

	function index() {
		
		echo "This script is not accesible directly";
	}
	
	function ajax() {

		$this->load->view('tools/dbmanager/newtable');
	}
}
?>