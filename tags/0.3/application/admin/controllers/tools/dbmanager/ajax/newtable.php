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
class newTable extends Controller 
{
	function newTable() {
		
		parent::Controller();
        $this->load->helper('url');
	}
	
	function index() {

		$this->load->view('tools/dbmanager/newtable');
	}
}
?>