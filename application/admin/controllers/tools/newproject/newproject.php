<?php
/**
 * New project wizard
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class newproject extends Controller {

	private $path;

	function newproject()
	{
		parent::Controller();
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->masterview('tools/newproject/newproject',array(),'newproject');
	}
}