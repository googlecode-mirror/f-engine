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
	var $button_counter;
	var $element_counter;
	var $formElement_counter;
	var $code;
	
	var $fe;
	var $id;
	
	function CI_Ajax() {

		$this->fe =& get_instance();
		$this->id = substr(preg_replace("/[^a-zA-Z0-9]*/","",base64_encode(implode($this->fe->uri->segments).time())),0,15);

		if($this->id == "") {
			$this->id = preg_replace("/[^a-zA-Z0-9]*/","",base64_encode("home".time()));
		}

		$this->link_counter = 0;
		$this->button_counter = 0;
		$this->element_counter = 0;
		$this->formElement_counter = 0;
		$this->code = array();
	}

	// --------------------------------------------------------------------

	function link($text,$target="",$update)
	{
		$id = "lnk".$this->link_counter."_".$this->id;
		$html = "<a id='$id' href='#'>$text</a>";
		$this->_ajaxLink($id,site_url($target),$update);

		$this->link_counter++;

		return $html;
	}

	function _ajaxLink($id,$target="",$update) {

		$script = 'jQuery("'.$update.'").html(html)';

		$this->code[] = "jQuery('#$id').live('click',function(){
			jQuery.ajax({'url':'$target','cache':false,'type':'post','success':function(html){".$script."}});
			return false;
			});\n";
	}
	
	function submitButton($text,$update) {

		$id = "btn".$this->button_counter."_".$this->id;
		$html = "<input type='submit' id='$id' value='$text'>";
		$this->_ajaxSubmitButton($id,$update);

		$this->link_counter++;

		return $html;
	}
	
	function _ajaxSubmitButton($id,$update) {
		
		$script = 'jQuery("'.$update.'").html(html)';

		$this->code[] = "jQuery('#$id').live('click',function(){
			jQuery.ajax({'url':jQuery(this).parents('form').attr('action'),'cache':false,'type':'post',
			data: jQuery(this).parents('form').serialize(),
			'success':function(html){".$script."}});
			return false;
			});\n";
	}
	
	function element($css_selector,$event = "click",$target,$update_selector) {

		$script = 'jQuery("'.$update_selector.'").html(html)';

		$this->code[] = "jQuery('$css_selector').live('$event',function(){
			var attrs = $('$css_selector')[0].attributes;
			var data = '';
			var value = false;
			for(var i=0;i<attrs.length;i++) {
				if(data == '') {
					data = attrs[i].nodeName + '=' + attrs[i].nodeValue;
				} else {
					data = data + '&' + attrs[i].nodeName + '=' + attrs[i].nodeValue;
				}

				if(attrs[i].nodeName == 'value' && attrs[i].nodeValue != '') { value = true }
			}
			if(value == false) {
				if(data == '') {
					data = 'value=' + $('$css_selector').attr('value');
				} else {
					data = data + '&' + 'value=' + $('$css_selector').attr('value');
				}
			}
			jQuery.ajax({'url':'$target','cache':false,'type':'post',
			'data': data,
			'success':function(html){".$script."}});
			return false;
			});\n";
		
		$this->element_counter++;
	}
	
	function formElement() {
	
	
	}

	
	function getAll() {

		return $this->code;
	}
	
	function getString($check_jquery = false) {

		$output = "<script type='text/javascript'>\n/*<![CDATA[*/\n";

		if($check_jquery) {
			$output .= $this->checkJquery();
			$output .= "window.onload = function() {\n";
		}

		foreach($this->getAll() as $script) {	
			$output .= $script;	
		}

		if($check_jquery) {
			$output .= $this->checkJquery();
			$output .= "}";
		}

		$output .= "\n/*]]>*/\n</script>";
		return $output;
	}

	function checkJquery() {

		$str = "if(typeof(jQuery) != 'function') {

			var file = document.createElement('script');
			file.src = '".public_data("js/jquery.js")."'
			file.type = 'text/javascript';
			document.getElementsByTagName('head')[0].appendChild(file);				
		}";
		
		return $str;
	}
	
	function __destruct() {
	
		//print_r($this->code);
	}

}

// END CI_Ajax class

/* End of file Ajax.php */
/* Location: ./system/libraries/Ajax.php */