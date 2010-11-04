<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * F-engine
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.5
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * F-engine Ajax Class
 * CI_Ajax is a static class that provides a collection of helper methods for creating ajax requests.
 *
 * @package		F-engine
 * @subpackage	Libraries
 * @category	Libraries
 * @author		flmn
 * @link		http://www.f-engine.net/
 */
class CI_Ajax {


	var $link_counter;
	var $code;
	
	var $fe;
	var $id;
	
	function CI_Ajax() {

		$this->fe =& get_instance();
		$this->id = preg_replace("/[^a-zA-Z0-9]*/","",base64_encode(implode($this->fe->uri->segments)));

		$this->link_counter = 0;
		$this->code = array();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set a benchmark marker
	 *
	 * Multiple calls to this function can be made so that several
	 * execution points can be timed
	 *
	 * @access	public
	 * @param	string	$name	name of the marker
	 * @return	void
	 */
	function link($text,$target="",$options = array())
	{

		$id = "alnk".$this->link_counter."_".$this->id;
		$html = "<a id='$id' href='#'>$text</a>";
		$this->_ajaxLink($id,$target,$options);

		$this->link_counter++;

		return $html;
	}

	function _ajaxLink($id,$target="",$options) {

		$script = 'jQuery("'.$options["update"].'").html(html)';
		$this->code[] = $this->_delegate($id,"click",site_url($target),$script);
	}

	function _delegate($id,$event,$url,$script) {

		/*return "jQuery('body').delegate('#$id','$event',function(){
			jQuery.ajax({'url':'$url','cache':false,'type':'post','success':function(html){".$script."}});
			return false;});\n";*/
		
		return "jQuery('#$id').live('$event',function(){
			jQuery.ajax({'url':'$url','cache':false,'type':'post','success':function(html){".$script."}});
			return false;
			});\n";
		
	}
	
	function getAll() {

		return $this->code;
	}

	function __destruct() {
	
		//print_r($this->code);
	}

}

// END CI_Ajax class

/* End of file Ajax.php */
/* Location: ./system/libraries/Ajax.php */