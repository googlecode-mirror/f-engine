<?php
/**
 * Css packer
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class csspacker extends Controller {

	function csspacker()
	{
		parent::Controller();
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->masterview('tools/csspacker/csspacker',array(),'csspacker');
	}
}
?>