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
//requires jquery
$(document).ready(function() {	

	$('form input[type=submit]').click(function () {

		$.post($('form').attr('action'), $("form").serialize() + "&jsonResponse=true", function(data) {

			if(data.error_num > 0) {

				$.each($('div.error'),function() {	$(this).html('');	});

				$.each(data.error_msg,function(field,item) {

					var target = $('#'+field+'_errormsg');

					if(target.lenght > 0)
						target.html(item);
					else	
						$("input[name="+field+"]").next().html(item);
				});

			} else {

				if(data.redirect != '') window.location = data.redirect;
			}
		}, "json");

		return false;
	});
});