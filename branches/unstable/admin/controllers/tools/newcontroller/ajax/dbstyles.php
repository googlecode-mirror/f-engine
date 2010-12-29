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
class dbstyles extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	
	function index()
	{

		$data = array(
			"view" => $_POST["view"],
			"fields" => explode(",",$_POST["fields"])
		);
		$this->load->view('tools/newcontroller/db/fields_style',$data);
	}
}
