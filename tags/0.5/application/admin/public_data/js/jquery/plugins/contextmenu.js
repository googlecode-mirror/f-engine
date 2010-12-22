// jQuery Context Menu Plugin
//
// Version 1.00
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
//
// Visit http://abeautifulsite.net/notebook/80 for usage and more information
//
// Terms of Use
//
// This software is licensed under a Creative Commons License and is copyrighted
// (C)2008 by Cory S.N. LaViska.
//
// For details, visit http://creativecommons.org/licenses/by/3.0/us/
//
/***
 * 
 * Mod F-engine:
 * Added o.stopPropagation property
 * Added o.wrapper property
 * Added submenu feature
 */

if(jQuery)( function() {
	$.extend($.fn, {
		
		contextMenu: function(o, callback) {
			// Defaults
			if( o.menu == undefined ) return false;
			if( o.inSpeed == undefined ) o.inSpeed = 100;
			if( o.outSpeed == undefined ) o.outSpeed = 75;
			// 0 needs to be -1 for expected results (no fade)
			if( o.inSpeed == 0 ) o.inSpeed = -1;
			if( o.outSpeed == 0 ) o.outSpeed = -1;
			if( o.button == undefined ) o.button = 2;
			if( o.stopPropagation == undefined ) o.stopPropagation = false;		
			

			// Loop each context menu
			$(this).each( function() {
				var el = $(this);

				var offset = $(el).offset();
				// Add contextMenu class
				$('#' + o.menu).addClass('contextMenu');
				
				// Simulate a true right click
				$(this).mousedown( function(e) {
					
					var evt = e;
					$(this).mouseup( function(e) {

						var srcElement = $(this);
						$(this).unbind('mouseup');
						if( evt.button == o.button ) {

							// Hide context menus that may be showing
							$(".contextMenu").hide();
							// Get this context menu
							var menu = $('#' + o.menu);
							
							if( $(el).hasClass('disabled') ) return false;
							
							// Detect mouse position
							var d = {}, x, y;
							if( self.innerHeight ) {
								d.pageYOffset = self.pageYOffset;
								d.pageXOffset = self.pageXOffset;
								d.innerHeight = self.innerHeight;
								d.innerWidth = self.innerWidth;
							} else if( document.documentElement &&
								document.documentElement.clientHeight ) {
								d.pageYOffset = document.documentElement.scrollTop;
								d.pageXOffset = document.documentElement.scrollLeft;
								d.innerHeight = document.documentElement.clientHeight;
								d.innerWidth = document.documentElement.clientWidth;
							} else if( document.body ) {
								d.pageYOffset = document.body.scrollTop;
								d.pageXOffset = document.body.scrollLeft;
								d.innerHeight = document.body.clientHeight;
								d.innerWidth = document.body.clientWidth;
							}
						
							if(o.wrapper != undefined) {
								
								var correctionX = $(o.wrapper).offset().left;
							} else {
								
								var correctionX = 0;
							}
							
							(e.pageX) ? x = e.pageX - correctionX : x = e.clientX + d.scrollLeft + correctionX;
							(e.pageY) ? y = e.pageY : x = e.clientY + d.scrollTop;
							
							// Show the menu
							$(document).unbind('click');
							$(menu).css({ top: y, left: x }).fadeIn(o.inSpeed);
							
							// Hover events
							$(menu).children('LI').children('A').not('.submenu').mouseover( function() {
								$(menu).find('LI.hover').removeClass('hover');
								if($(menu).find('ul').css('display') != 'none')
									$(menu).find('ul').animate({ 'width' : 0, 'height' : 0 }, 200, function () { $(this).css('display','none'); });
								$(this).parent().addClass('hover');
								
							}).mouseout( function() {

								$(menu).find('LI.hover').removeClass('hover');
							});
							
							//Submenu Hover events
							$(menu).find('LI > A.submenu').parent().mouseover( function() {
								
								$(menu).find('LI.hover').removeClass('hover');
								$(this).addClass('hover');
								
								if ($(menu).find('ul').css('display') == 'none') {

									//calculate top position
									$(this).find('ul').css({
										'width': '',
										'height': ''
									})
									var top = $(this).offset().top - $(menu).offset().top;
									var height = $(this).find('ul').height();
									var width = $(this).find('ul').width();
									
									$(this).find('ul').css({
									
										'position': 'absolute',
										'left': $(menu).width() - 1,
										'top': top,
										'width': 0,
										'height': 0
									
									}).animate({
									
										'width': width,
										'height': height
									}, 400);
									
									
									/*** submenu highlight and event control ***/
									$(this).find('ul li').mouseover(function(e){
									
										$(this).addClass('hover');
										e.stopPropagation();
										
									}).mouseout(function(e){
									
										$(this).removeClass('hover');
										e.stopPropagation();
									});
								}

							}).mouseout( function() {
								
								$(menu).find('LI.hover').removeClass('hover');
							});
							
							// Keyboard
							$(document).keypress( function(e) {
								switch( e.keyCode ) {
									case 38: // up
										if( $(menu).find('LI.hover').size() == 0 ) {
											$(menu).find('LI:last').addClass('hover');
										} else {
											$(menu).find('LI.hover').removeClass('hover').prevAll('LI:not(.disabled)').eq(0).addClass('hover');
											if( $(menu).find('LI.hover').size() == 0 ) $(menu).find('LI:last').addClass('hover');
										}
									break;
									case 40: // down
										if( $(menu).find('LI.hover').size() == 0 ) {
											$(menu).find('LI:first').addClass('hover');
										} else {
											$(menu).find('LI.hover').removeClass('hover').nextAll('LI:not(.disabled)').eq(0).addClass('hover');
											if( $(menu).find('LI.hover').size() == 0 ) $(menu).find('LI:first').addClass('hover');
										}
									break;
									case 13: // enter
										$(menu).find('LI.hover A').trigger('click');
									break;
									case 27: // esc
										$(document).trigger('click');
									break
								}
							});
							
							// When items are selected
							$('#' + o.menu).find('A').unbind('click');
							$('#' + o.menu).find('LI:not(.disabled) A').click( function() {
								$(document).unbind('click').unbind('keypress');
								$(".contextMenu").hide();
								// Callback
								if( callback ) callback( $(this).attr('href').substr(1), $(srcElement), {x: x - offset.left, y: y - offset.top, docX: x, docY: y} );
								return false;
							});
							
							// Hide bindings
							setTimeout( function() { // Delay for Mozilla
								$(document).click( function() {
									$(document).unbind('click').unbind('keypress');
									$(menu).fadeOut(o.outSpeed);
									return false;
								});
							}, 0);
						}
					});
					
					if(o.stopPropagation)	e.stopPropagation();
				});
				
				// Disable text selection
				if( $.browser.mozilla ) {
					$('#' + o.menu).each( function() { $(this).css({ 'MozUserSelect' : 'none' }); });
				} else if( $.browser.msie ) {
					$('#' + o.menu).each( function() { $(this).bind('selectstart.disableTextSelect', function() { return false; }); });
				} else {
					$('#' + o.menu).each(function() { $(this).bind('mousedown.disableTextSelect', function() { return false; }); });
				}
				// Disable browser context menu (requires both selectors to work in IE/Safari + FF/Chrome)
				$(el).add('UL.contextMenu').bind('contextmenu', function() { return false; });
				
			});
			return $(this);
		},
		
		// Disable context menu items on the fly
		disableContextMenuItems: function(o) {
			if( o == undefined ) {
				// Disable all
				$(this).find('LI').addClass('disabled');
				return( $(this) );
			}
			$(this).each( function() {
				if( o != undefined ) {
					var d = o.split(',');
					for( var i = 0; i < d.length; i++ ) {
						$(this).find('A[href="' + d[i] + '"]').parent().addClass('disabled');
						
					}
				}
			});
			return( $(this) );
		},
		
		// Enable context menu items on the fly
		enableContextMenuItems: function(o) {
			if( o == undefined ) {
				// Enable all
				$(this).find('LI.disabled').removeClass('disabled');
				return( $(this) );
			}
			$(this).each( function() {
				if( o != undefined ) {
					var d = o.split(',');
					for( var i = 0; i < d.length; i++ ) {
						$(this).find('A[href="' + d[i] + '"]').parent().removeClass('disabled');
						
					}
				}
			});
			return( $(this) );
		},
		
		// Disable context menu(s)
		disableContextMenu: function() {
			$(this).each( function() {
				$(this).addClass('disabled');
			});
			return( $(this) );
		},
		
		// Enable context menu(s)
		enableContextMenu: function() {
			$(this).each( function() {
				$(this).removeClass('disabled');
			});
			return( $(this) );
		},
		
		// Destroy context menu(s)
		destroyContextMenu: function() {
			// Destroy specified context menus
			$(this).each( function() {
				// Disable action
				$(this).unbind('mousedown').unbind('mouseup');
			});
			return( $(this) );
		}
		
	});
})(jQuery);