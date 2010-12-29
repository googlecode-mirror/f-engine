/**
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */

$(document).ready(function() { 
	
	$('#clear-all').click(function () {
		
		$('#input')[0].value = '';
	});
	
	$('#pack-script').click(function () {
		
		$.post($('#form').attr('action'), $('#form').serialize(), function(msg) {

			$('#output')[0].value = msg.css;
			$('#message').html(msg.ratio);

		}, "json");
	});
});