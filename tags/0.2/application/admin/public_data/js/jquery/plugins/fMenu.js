/**
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */

/***
 * based on 
 * http://www.filamentgroup.com/lab/jquery_ipod_style_and_flyout_menus/
 */

if(jQuery) (function($) {

	$.extend($.fn, {
		fMenu: function(o) {

			var wrapper = this;

			// Defaults
			if( !o ) var o = {};
			if( o.containner == undefined ) o.containner = 'div.menuContainner';
			if( o.header == undefined) o.header = 'div.header';
			if( o.menu == undefined) o.menu = 'div.ddMenu';
			if( o.breadcrumbs == undefined) o.breadcrumbs = 'div.breadcrumbs';
			if( o.selectedClass == undefined) o.selectedClass = 'selected';
			if( o.parentClass == undefined) o.parentClass = 'parent';
			if( o.speed == undefined) o.speed = 300;

            var defaultMenuTitle = $.trim($(o.header + '.title').text());

			var innerVars = {};

		    innerVars.width =  parseInt($(o.menu).css('width'));

			//Breadcrumbs events
			$(o.containner + ' ' + o.breadcrumbs, wrapper).click (function () {

				showprev();
			});

			//Menu events
		 	$(o.menu + ' ul > li', wrapper).filter('.' + o.parentClass).click(function () {

				$(this).blur();
				showNext(this, innerVars.width);
				return false;

			}).end().not('.' + o.parentClass).click(function () {

				$(o.menu + ' ul li.' + o.selectedClass, wrapper).removeClass('selected');
				$(this).addClass(o.selectedClass);
				$(this).blur();
				$('a',this).blur();

				$.get($('a',this).attr('href'), function (content) {

					$('#content').html(content);
				});

				return false;
			});

			function showNext  (obj, width) {

                var menuTitle = $('a[href="#"]:eq(0)',obj).text();

                if(menuTitle != '')
                    $('#fMenu .header .title').text(menuTitle.substring(0, 18))
                else
                    $('#fMenu .header .title').text(defaultMenuTitle)
                
				var width =  parseInt($(o.menu + ':eq(0)').css('width'));
				var content = '<div class="'+ o.menu +'"><ul>'+$(obj).children('ul').html()+'</ul></div>';

				$('li.parent',content).click(function () { showNext(this, width); return false; });

				$(o.menu + ' ul.active').removeClass('active');

				$('ul:eq(0)',obj)
				.addClass('visible')
				.css({
					position: 'absolute',
					display: 'block',
					visibility: 'visible',
					top: '0',
					left: $(o.containner).width(),
					width: $(o.containner).width()
				});
	
				$(o.menu).animate({ height: $('ul:eq(0)',obj).height()}, o.speed*0.9, 'linear');

				$('ul:eq(0)',obj)
					.animate({ left: 0 }, o.speed,'linear', function () {
	
						$(obj).parent().css('visibility','hidden');
						$(this).addClass('active');
						if($(o.breadcrumbs).css('display') == "none") 
							$(o.breadcrumbs).slideDown('fast');
					});
			}

			function showprev() {

				var currentUl = $( o.containner + ' ' + o.menu + ' ul.visible .active', wrapper);
				var parentUl = currentUl.parent().parent();
				parentUl.css('visibility','visible');

                var menuTitle = $('a[href="#"]:eq(0)',currentUl.parent().parent().parent()).text();

                if(menuTitle != '')
                    $('#fMenu .header .title').text(menuTitle)
                else
                    $('#fMenu .header .title').text(defaultMenuTitle)
                
				
				currentUl.animate({ left:  $(o.menu).width()}, o.speed,'linear', function () {
				
					$(this).removeClass('active').removeClass('visible').attr('style','');
				
					if(parentUl.parent().parent()[0].tagName.toUpperCase() != "UL")
						$(o.breadcrumbs, wrapper).slideUp('fast', function () {
							$(o.menu, wrapper).animate({ height: parentUl.height()}, function () {

								parentUl.addClass('active');
							});
						});
					else 	
						$(o.menu, wrapper).animate({ height: parentUl.height()}, function () {
							parentUl.addClass('active');
						});
				});
			}
		}
	});
})(jQuery);