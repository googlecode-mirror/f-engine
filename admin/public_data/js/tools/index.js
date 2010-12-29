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
div2show = false;
timer = null;

function changeDiv () {

	$('#contenidos div.preview > div').hide();
	$('#contenidos div.preview > div.' + div2show ).show();
	$('#contenidos ul.list li a').css('color','');
	$('#contenidos ul.list li[rel=' + div2show + '] a').css('color','black');
}

$(document).ready(function() { 

	$('#contenidos ul.list li').each(function () {

		$(this).hover(

			function () {

				div2show = $(this).attr('rel');
				timer = setTimeout(changeDiv,170);
			},
			function () {

				if(timer != null) {
					
					clearTimeout(timer);
					timer = null;	
				}
			}
		);
	});
});