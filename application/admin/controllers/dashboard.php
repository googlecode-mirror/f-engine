<?php
/**
 * Dashboard
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class dashboard extends Controller {

	function dashboard()
	{
		parent::Controller();
		$this->load->helper(array('url','directory'));
	}

	function index()
	{
		$my_projects = array();
		$projects = directory_map(APPPATH.'../', true);

		foreach($projects as $project) {

			if(is_dir(APPPATH.'../'.$project) && $project != 'fengine') {

				if($project != "admin")
					$my_projects[] = $project;
			}	
		}

		$this->load->masterview('welcome',array('myprojects' => $my_projects),'default');
	}
}