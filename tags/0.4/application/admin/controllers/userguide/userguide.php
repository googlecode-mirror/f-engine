<?php
/**
 * F-engine's userguide
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class userguide extends Controller {

	function userguide()
	{
		parent::Controller();
		$this->load->helper('url');
	}
	
	function index()
	{
		$data = array();
		
		if(count($this->uri->params) != 0)
			$data['page'] = 'userguide/'.implode('/',$this->uri->params);

		$this->load->masterview('userguide/main',$data,'userguide');
	}
	
	function ajax() {

		$this->load->view('userguide/'.implode('/',$this->uri->params));
	}
}
?>
