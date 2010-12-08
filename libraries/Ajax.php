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
	var $timer_counter;

	var $ui_counter;

	var $code;
	
	var $fe;
	var $id;
	
	var $functions;
	
	function CI_Ajax() {

		$this->fe =& get_instance();
		$this->id = substr(preg_replace("/[^a-zA-Z0-9]*/","",base64_encode(implode($this->fe->uri->segments).time())),0,15);

		if($this->id == "") {
			$this->id = preg_replace("/[^a-zA-Z0-9]*/","",base64_encode("home".time()));
		}

		$this->link_counter = 0;
		$this->button_counter = 0;
		$this->element_counter = 0;
		$this->timer_counter = 0;
		$this->ui_counter = 0;

		$this->code = array();
		$this->functions = array();
		
		log_message('debug', "Ajax Class Initialized");
	}

	// --------------------------------------------------------------------

	function link($text,$target="",$update) {

		$id = "lnk".$this->link_counter."_".$this->id;
		$html = "<a id='$id' href='".site_url($target)."'>$text</a>";
		$this->_ajaxLink($id,site_url($target),$update);

		$this->link_counter++;

		return $html;
	}

	function _ajaxLink($id,$target="",$update) {

		$success = 'jQuery("'.$update.'").html(html)';

		$this->code[] = "jQuery('#$id').unbind('click').click(function(){
			jQuery.ajax({'url':'$target','cache':false,'type':'post','success':function(html){".$success."}});
			return false;
			});\n";
	}
	
	function submitButton($text,$update,$redirect="") {

		$id = "btn".$this->button_counter."_".$this->id;
		$html = "<input type='submit' id='$id' value='$text'>";
		$this->_ajaxSubmitButton($id,$update,site_url($redirect));

		$this->link_counter++;

		return $html;
	}
	
	function _ajaxSubmitButton($id,$update,$redirect = false, $redirectOn = "") {

		if($redirect) {
			$success = '
			if(resp == "'.$redirectOn.'") { document.location = "'.$redirect.'"; }
			else if(resp != "") { jQuery("'.$update.'").html(resp); }
			';
		} else {
			
			$success = 'if(resp != "") { jQuery("'.$update.'").html(resp); }';
		}

		$this->code[] = "jQuery('#$id').click(function(){
			jQuery.ajax({'url':jQuery(this).parents('form').attr('action'),'cache':false,'type':'post',
			data: jQuery(this).parents('form').serialize(),
			success:function(resp){ ".$success."},
			'error' : function() {alert('An error occurred');}
			});
			return false;
			});\n";
	}

	function element($css_selector,$event = "click",$target,$update_selector) {

		$success = 'jQuery("'.$update_selector.'").html(html)';

		$this->code[] = "jQuery('$css_selector').$event(function(){
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
			'success':function(html){".$success."}});
			return false;
			});\n";

		$this->element_counter++;
	}

	function timer($timer,$target,$update_selector) {

		$target = site_url($target);
		$time = rand();
		$success = 'jQuery("'.$update_selector.'").html(html)';

		$this->code[] = preg_replace("/[^a-zA-Z0-9]*/","",base64_encode($update_selector))." = setInterval('f$time()',$timer);\n";

		$this->functions[] = "\nfunction f$time () {
			jQuery.ajax({'url':'$target','cache':false,'type':'post','success':function(html){$success}});
			}\n
			"; 

		$this->timer_counter++;
	}

	function clearTimer($selector) {

		$id = preg_replace("/[^a-zA-Z0-9]*/","",base64_encode($selector));
		$this->code[] = "clearInterval($id);\n";
		$this->timer_counter++;
	}

	function autocomplete($input,$target,$options =array()) {

		$random = rand(0,100);

		$this->code[] = '$("'.$input.'").autocomplete({
            source: function(req, add){
                $.ajax({
                    url: "'.site_url($target).'",
                    dataType: "json",
                    type: "POST",
                    data: req,
                    success: function(data){
                        if(data.response.length > 0){
                           add(data.response);
                        }
                    }
                });
            }
        });';
		$this->ui_counter++;
	}
	
	function datePicker($input) {

		$random = rand(0,100);
		$this->code[] = '$("'.$input.'").datepicker();';
		$this->ui_counter++;
	}

	function itemNum() {

		return ($this->element_counter + $this->link_counter + $this->button_counter 
		+ $this->timer_counter + $this->ui_counter);
	}

	function getString() {

		if(IS_AJAX == true) {

			$check_jquery = false;

		} else {

			$check_jquery = true;
		}

		$output = "\n<script type='text/javascript'>\n/*<![CDATA[*/\n";

		foreach($this->functions as $script) {	
			$output .= $script;	
		}

		if($check_jquery) {
			$output .= $this->checkJquery();
		}

		foreach($this->code as $script) {	
			$output .= $script;	
		}

		if($check_jquery) {
			$output .= " }";
		}

		$output .= "\n/*]]>*/\n</script>";
		return $output;
	}

	function checkJquery() {

		$time = time();
		if($this->ui_counter > 0) {

			$str = "
			if(typeof(jQuery) != 'function') {

				var file = document.createElement('script');
				file.src = '".public_data("js/jquery.js")."';
				file.type = 'text/javascript';
				document.getElementsByTagName('head')[0].appendChild(file);

				var file = document.createElement('script');
				file.src = '".public_data("js/jquery-ui.js")."';
				file.type = 'text/javascript';
				document.getElementsByTagName('head')[0].appendChild(file);

				_".$time."();

			} else {

				_".$time."();
			}\n

			function checkCss_".$time."() {

				var css = false;

				$('link').each(function () { 
					if($(this).attr('href').indexOf('jquery-ui.css') >= 0) {

						css = true;
					} 
				});

				if(!css) {

					var file	= document.createElement('link');
					file.href	= '".public_data("css/jquery-ui.css")."';
					file.type	= 'text/css';
					file.rel	= 'stylesheet';
					file.media	= 'screen, projection';
					document.getElementsByTagName('head')[0].appendChild(file);
				}
			}

			function _".$time."() {

				if(typeof(jQuery) != 'function' ||  typeof(jQuery().autocomplete) != 'function') { setTimeout('_".$time."()',700); return; }
				checkCss_".$time."();
			";
		
		} else {
		
			$str = "
			if(typeof(jQuery) != 'function') {
	
				var file = document.createElement('script');
				file.src = '".public_data("js/jquery.js")."';
				file.type = 'text/javascript';
				document.getElementsByTagName('head')[0].appendChild(file);
	
				_".$time."();
			} else {
		
				_".$time."();
			}\n
			function _".$time."() {
	
				if(typeof(jQuery) != 'function') { setTimeout('_".$time."()',700); return; }
			";
		}

		return $str;
	}

	function __destruct() {

		//print_r($this->code);
	}
}

// END CI_Ajax class

/* End of file Ajax.php */
/* Location: ./system/libraries/Ajax.php */