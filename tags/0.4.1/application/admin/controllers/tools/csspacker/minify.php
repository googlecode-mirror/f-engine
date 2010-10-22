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
class minify extends Controller {

	function minify() {

		parent::Controller();
		$this->load->library('csstidy');
	}
	
	function index() {
		
		if($_POST['css'] == '') return;
		
		$result = array();
		$this->csstidy->parse($_POST['css']);
		$result['css'] = $this->csstidy->print->plain();
		
		$start_size = $this->csstidy->print->size('input');
		$end_size = $this->csstidy->print->size();

		$result['ratio'] = 'compression ratio: '.$end_size.'/'.$start_size.'='.round($end_size/$start_size,3);
		
		if(!function_exists('json_decode')) {	//PHP < 5.2

			echo json_encode($result);

		} else {

			$this->load->library('json');
			echo $this->json->encode($result);
		}
	}
}
?>