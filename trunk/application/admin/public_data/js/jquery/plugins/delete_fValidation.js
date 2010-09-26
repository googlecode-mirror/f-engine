/*
 * F-engine form validation v0.1
 * http://
 *
 * Copyright (c) 2009 Mikel Madariaga
 * licensed under the MIT license.
 */

if(jQuery) (function($) {

	$.extend($.fn, {
		fValidation: function(opt){

			// Defaults
			if( !opt ) var o = {};
			if( opt.validate == undefined ) opt.validate = true;
			if( opt.onValidateError == undefined) opt.header = undefined;
			if( opt.onSuccess == undefined) opt.menu = undefined;
			
			var form = this;
			
			$('input[type="submit"]',form).click(function(){
			
				$.post($(form).attr('action'), $("form").serialize(), function(data){
				
					if (opt.validate && data.error_num > 0) {
						
						if(opt.onValidateError != undefined) 
						
							opt.onValidateError(data.error_msg);
							
						else {
							
							$.each($('div.error'), function(){
							
								$(this).html('');
							});
							
							$.each(data.error_msg, function(field, item){
							
								$("input[name=" + field + "]").next().html(item);
							});
						}	
						
					}
					else {
					
						if(opt.onSuccess != undefined)
							opt.onSuccess(data);
						else if (data.redirect != '') 
							window.location = data.redirect;
					}
				}, "json");
				
				return false;
			});
		}
	});
})(jQuery);