/**
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.5
 * @filesource
 */
 jQuery.expr[':'].contains = function(a,i,m){
     return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
 };

 var backup;
 var clipboard = false;
 var item;

 /***	Filetrees
 ********************************************************/

 function preview (dir,rel_id) {

	$('ul li',$(dir)).not('.directory').each(function () {

		$(this).hover(

			function () {

				if($('#'+rel_id+':checked').length == 1) {

					var offset = $(this).offset();
					var wrapperOffset = $('div#contenidos').offset();

					$('#preview').attr('style','background-color:#EEEEEE; overflow:auto; display: block;width:500px;'+
												'top: '+ offset.top +'px; left: '+ (offset.left - wrapperOffset.left / 2) +'px;position:absolute;z-index:99999;');

					var er = new RegExp(/(\.gif|\.png|\.jpe?g)/i);
					if(er.test($(this).children('a').attr('rel'))) {

						$('#preview').html("<img src='"+BASE+"public_data/"+$(this).children('a').attr('rel')+"' />");
	
					} else {

						$.ajax({ type: "POST",
					  		 url: ROOT+"tools/newcontroller/ajax/fpreview",
					  		 data: "file="+$(this).children('a').attr('rel'),
							 success: function(msg) {
							   $('#preview').html(msg);
							 }
						});
					}

					$('#preview').removeClass('oculto');
				}
			},function () {	

				if($('#'+rel_id+':checked').length == 1) {

					$('#preview').addClass('oculto');
					$('#preview').attr('style','');
					//$('#preview').html('Loading...');
				}
			}
		);
	});
 }

 function add_item (file) {

 	var type = file.split('/')[0];
	var ext  = file.split('.')[file.split('.').length-1];
 	var item = file.substr(type.length+1);
 
 	if($('#'+type+'_select ul input[value="'+item+'"]').length > 0 && type != "masterview") {
		
 		$('#'+type+'_select ul input[value="'+item+'"]').parent().remove();
	 
 	} else {
	 
 		if(type == "masterview") {

 			$('#'+type+'_select ul li').remove();
 			$('#'+type+'_select ul').append(
						'<li class="file conf">'
						+item
						+'<input type="hidden" name="'+type+'" value="'+item+'" />'
						+'</li>');

 		} else {

 			$('#'+type+'_select ul').append(
						'<li class="file ext_'+ext+'">'
						+item
						+'<input type="hidden" name="'+type+'[]" value="'+item+'" />'
						+'</li>');
 		}

 	}
 }

 function highlight (obj) {

 	obj.hasClass('selected') ? obj.removeClass('selected') : obj.addClass('selected');
 }
 
 /***	contextMenu
 ********************************************************/

 function menu_manager (action, el, pos) {
	 
	switch(action) {

		case 'copy':

						clipboard = el.parent().clone(true);
						el.parent().after(clipboard);

						var newrow = el.parent().next();
						var newFieldName = $("div.row div.enlarge:eq(0) span",newrow).attr("title") + "_copy";
						
						$("div.row div.enlarge:eq(0) span",newrow).attr("title",newFieldName);
						$("div.row div.enlarge:eq(0) span",newrow).text(newFieldName);
						$("div.row div.enlarge:eq(0) input",newrow).attr("value",newFieldName);
						
						if( $("input[name=insert_field_names[]]:eq(0)",newrow).length > 0 )
							$("div.row div.enlarge:eq(0) input",newrow).after("<input type='hidden' name='insert_ignoreInDB[]' value='"+newFieldName+"' />");
						else if ( $("input[name=edit_field_names[]]:eq(0)",newrow).length > 0 )
							$("div.row div.enlarge:eq(0) input",newrow).after("<input type='hidden' name='edit_ignoreInDB[]' value='"+newFieldName+"' />");
						
						$("div.fldv div.enlarge:eq(0) span",newrow).text(newFieldName);
						
						$(newrow).animate({	opacity: 0.5}, 500, 'linear', function(el){
							$(this).animate({opacity: 1}, 300);
						});

						break;

		case 'edit':

						backup = el.clone(true);
						$(el[0]).addClass('edit');

						var obj = $($(el[0]).children('div.enlarge')[0]);
						value = $.trim(obj.text());
						obj.html('<input type="text" width="80px" value="'+value+'">');	

						$('input',obj).focus().keypress( function(e) {

							//on press enter trigger apply
							if (e.which == 13) {
								menu_manager('apply', el, pos);
								return false;
							}	

							//on press escape trigger undo
							if (e.keyCode == 27) {
								menu_manager('undo', el, pos);
								return false;
							}	
						});

						$('#myMenu li[class*="edit"]').addClass('oculto');
						$('#myMenu li[class*="delete"]').addClass('oculto');
						$('#myMenu li[class*="copy"]').addClass('oculto');
						$('#myMenu li[class*="paste"]').addClass('oculto');
						$('#myMenu li[class*="undo"]').removeClass('oculto');
						$('#myMenu li[class*="apply"]').removeClass('oculto');
						break;

		case 'apply':

						// we dont care over what element does the user fire the command
						// search div.edit node (since only one row can be edited at time) and apply the action					
						el = $('div.db_fields ul.dbfldlst li div.edit');

						el.removeClass('edit');
						var input = $('input[type="text"]', el);

						if (input.attr("value").length != 0) {

							el.replaceWith(backup);
							$("span:eq(0)",backup).attr("title",input.attr("value")).text(input.attr("value"));

							if($("input[name=insert_field_names[]]:eq(0)",backup).length > 0) {

								$("input[name=insert_field_names[]]:eq(0)",backup).attr("value",input.attr("value"));
								$("input[name=insert_ignoreInDB[]]:eq(0)",backup).attr("value",input.attr("value"));

							} else if ($("input[name=edit_field_names[]]:eq(0)",backup).length > 0) {

								$("input[name=edit_field_names[]]:eq(0)",backup).attr("value",input.attr("value"));
								$("input[name=edit_ignoreInDB[]]:eq(0)",backup).attr("value",input.attr("value"));
								
							} else {
								
								$("input[name=resume_field_names[]]:eq(0)",backup).attr("value",input.attr("value"));
							}
							
							if(backup.next().length > 0) {
								
								$("span:eq(0)",backup.next()).text(input.attr("value"));
							}
							
						} else {

							$(input).replaceWith($('div:eq(0)', backup));
						}

						$('#myMenu li[class*="edit"]').removeClass('oculto');
						$('#myMenu li[class*="delete"]').removeClass('oculto');
						$('#myMenu li[class*="copy"]').removeClass('oculto');
						$('#myMenu li[class*="paste"]').removeClass('oculto');
						$('#myMenu li[class*="undo"]').addClass('oculto');
						$('#myMenu li[class*="apply"]').addClass('oculto');	        					
						break;

		case 'delete':

						$(el[0]).parent().remove();
						break;

		case 'undo':

						// we dont care over what element does the user fire the command
						// search div.edit node (since only one row can be edited at time) and apply the action					
						el = $('div.db_fields ul.dbfldlst li div.edit');
						el.replaceWith(backup);
						backup = false;

						$('#myMenu li[class*="edit"]').removeClass('oculto');
						$('#myMenu li[class*="delete"]').removeClass('oculto');
						$('#myMenu li[class*="copy"]').removeClass('oculto');
						$('#myMenu li[class*="paste"]').removeClass('oculto');
						$('#myMenu li[class*="undo"]').addClass('oculto');
						$('#myMenu li[class*="apply"]').addClass('oculto');
						break;
	}
 }

 /***	Validations
 ********************************************************/
 function validation_manager (action, el, pos) {

	if(action == 'quit') return;

	var field = $(el).prev()[0];
	var start = field.value.length;
	
	if(field.value != "")
		field.value += '|'+action;
	else
		field.value = action;

	var end = field.value.length;

	if( field.createTextRange ){
		var selRange = field.createTextRange();
		selRange.collapse(true);
		selRange.moveStart("character", start);
		selRange.moveEnd("character", end);
		selRange.select();

	} else if( field.setSelectionRange ) {

		field.setSelectionRange(start, end);

	} else if( field.selectionStart ) {

		field.selectionStart = start;
		field.selectionEnd = end;
	}
	field.focus();   
 }

 /***	onLoad
 ********************************************************/

 $(document).ready(function() { 
	 
	$("#resume input.filter").focus();

 	/***	Filetrees
 	 ********************************************************/
	 //masterview conf
	 preview($("#masterview_list"),"enable_preview");
	 $("#masterview_list ul li a").click(function () {

		 add_item($(this).attr("rel"));
	 });

	//javascript
    $('#js_list').fileTree(

    	{root: 'js/', script: ROOT+'tools/newcontroller/ajax/filetree', hover: function (dir) {preview(dir,'enable_preview')}},
    	function(file) {	add_item(file);		},
    	function(obj)  {	highlight(obj);		}
    );
	$('#js_select ul').sortable();

	//css
    $('#css_list').fileTree(

    	{root: 'css/', script: ROOT+'tools/newcontroller/ajax/filetree', hover: function (dir) {preview(dir,'enable_preview')}},     	
    	function(file) {	add_item(file);		},
    	function(obj)  {	highlight(obj);		}
    );
	$('#css_select ul').sortable();

	//headers
    $('#header_list').fileTree(

    	{root: 'header/', script: ROOT+'tools/newcontroller/ajax/filetree', hover: function (dir) {preview(dir,'enable_preview')}},     	
    	function(file) {	add_item(file);		},
    	function(obj)  {	highlight(obj);		}
    );
	$('#header_select ul').sortable();

	//footers
    $('#footer_list').fileTree(

    	{root: 'footer/', script: ROOT+'tools/newcontroller/ajax/filetree', hover: function (dir) {preview(dir,'enable_preview')}},     	
    	function(file) {	add_item(file);		},
    	function(obj)  {	highlight(obj);		}
    );
	$('#footer_select ul').sortable();

 	/***	DB Table list
 	 ********************************************************/
	//datagrid
    $('#resume .db_list a').each(function (i) {

        $(this).bind('click', function () {

        	highlight($(this));
        });
    });
 
    //new record, edit
    $('.db_list a',$('#insert, #edit')).each(function (i) {

        $(this).bind('click', function () {

        	highlight( $("a.selected",$($(this).parent().parent())) );
        	highlight($(this));
        });
    });

 	/***	DB Table list filter
 	 ********************************************************/
	var filter = {
		insert: {items: 'null',length: 0},
		edit: {items: 'null',length: 0},
		resume: {items: 'null',length: 0}
	};

	//insert view
	filter.insert.items = $('div#insert .db_list ul li');
	$('#insert input.filter').bind('keyup', function () {

		if (this.value.length > filter.insert.length) {

			$.each(filter.insert.items.not(":contains('"+this.value+"')"), function() {

				if(!$("a",this).hasClass("selected"))
					if (!$(this).hasClass('oculto')) {	$(this).addClass('oculto');	}
			});

		} else {

			$.each(filter.insert.items.filter(":contains('"+this.value+"')"), function() {

				if ($(this).hasClass('oculto')) {	$(this).removeClass('oculto');	}
			});
			$.each(filter.insert.items.not(":contains('"+this.value+"')"), function() {

				if(!$("a",this).hasClass("selected"))
					if (!$(this).hasClass('oculto')) {	$(this).addClass('oculto');	}
			});
		}
		filter.insert.length = this.value.length;
	});

	//edit view
	filter.edit.items 	= $('div#edit .db_list ul li');
	$('#edit input.filter').bind('keyup', function () {

		if (this.value.length > filter.edit.length) {

			$.each(filter.edit.items.not(":contains('"+this.value+"')"), function() {

				if(!$("a",this).hasClass("selected"))
					if (!$(this).hasClass('oculto')) {	$(this).addClass('oculto');	}
			});

		} else {

			$.each(filter.edit.items.filter(":contains('"+this.value+"')"), function() {

				if ($(this).hasClass('oculto')) {	$(this).removeClass('oculto');	}
			});
			$.each(filter.edit.items.not(":contains('"+this.value+"')"), function() {
				
				if(!$("a",this).hasClass("selected"))
					if (!$(this).hasClass('oculto')) {	$(this).addClass('oculto');	}
			});
		}
		filter.edit.length = this.value.length;
	});

	//datagrid view
	filter.resume.items = $('div#resume .db_list ul li');
	$('#resume input.filter').bind('keyup', function () {

		if (this.value.length > filter.edit.length) {

			$.each(filter.resume.items.not(":contains('"+this.value+"')"), function() {

				if(!$("a",this).hasClass("selected"))
					if (!$(this).hasClass('oculto')) {	$(this).addClass('oculto');	}
			});

		} else {

			$.each(filter.resume.items.filter(":contains('"+this.value+"')"), function() {

				if ($(this).hasClass('oculto')) {	$(this).removeClass('oculto');	}
			});
			$.each(filter.resume.items.not(":contains('"+this.value+"')"), function() {
				
				if(!$("a",this).hasClass("selected"))
					if (!$(this).hasClass('oculto')) {	$(this).addClass('oculto');	}
			});
		}
		filter.resume.length = this.value.length;
	});	

	$('input.filter').bind("blur",function () {

		//trigger filter event in all filter boxes
		filter.insert.length = $(this).attr("value").length +1;
		filter.edit.length =  $(this).attr("value").length +1;
		filter.resume.length =  $(this).attr("value").length +1;

		//copy current search value to the other filter boxes
		$("input.filter").attr("value",$(this).attr("value"));

		//trigger filter in all boxes 
		$("input.filter").trigger('keyup');
	});

	/***	Buttons		***/
	//go to database fields  button
 	$('.go2db_fields').bind('click',function() {

		var wrapper = $(this).parent().parent().parent();
 		var tables = new Array;

 		$.each($('.db_list a[class="selected"]',wrapper), function () {	tables.push($.trim($(this).text()));	});
		
		if(tables.length > 0) {
			
			$(this).parent().parent().fadeOut("normal", function () {

				$(this).next().fadeIn("normal");
			});

			$.ajax({	
				type: "POST",
				url: ROOT+"tools/newcontroller/ajax/dbfields",
				data: "db="+tables.join(',')+"&view="+wrapper.attr('id'),
				cache: true,							
				success: function(content) {

				 	/***	Ajax success
				 	 ********************************************************/
					$('.db_fields',wrapper).html(content);

					//sortables
					$.each($('.db_fields ul.dbfldlst',wrapper), function () {	$(this).sortable();	});

					//context menu
					$.each($('.db_fields ul.dbfldlst li',wrapper).children('div').not('.fldv'), function () {	

						$(this).contextMenu({
					        menu: 'myMenu',
							wrapper: $('div.frame',wrapper)[1]
							},
					    	function(action, el, pos){	menu_manager(action, el, pos);	}
					    );
					});

					//delete row
					$("img.del_row").click(function () {
						
						var parent_li = $(this).parent().parent().parent();

						if(parent_li.parent().children("li").length > 2)
							menu_manager("delete",$(this).parent().parent());
						else
							$(parent_li).animate({opacity: 0.4},400, function () {
								
								$(parent_li).animate({opacity: 1},400);
							});
					});
					

				 	/***	Table fields <--> Validation rules switcher
				 	 ********************************************************/
					$.each($('.db_fields a.vrules',wrapper), function () {

						$(this).bind('click', function () {
	
							if(wrapper.attr("id") == "edit")
								$('div.editRecLnk', wrapper).toggle();
							
							$('div.help > div',wrapper).toggle();
							$('span',$(this).parent()).toggle();
							
							//show field
							if($('div.db_fields ul.dbfldlst li:first div:first',wrapper).hasClass('oculto')) {

								$.each($('div.db_fields ul.dbheader li div div',wrapper).not('div.enlarge:eq(0)'), function () {

									$(this).removeClass('oculto');
								});
								$.each($('div.db_fields ul.dbfldlst li',wrapper).children('div:odd'), function () {

									$(this).addClass('oculto');
								});
								$.each($('div.db_fields ul.dbfldlst li',wrapper).children('div:even'), function () {

									$(this).removeClass('oculto');
								});

							// show validation rules
							} else {

								$.each($('div.db_fields ul.dbheader li div div',wrapper).not('div.enlarge:eq(0)'), function () {

									$(this).addClass('oculto');
								});
								$.each($('div.db_fields ul.dbfldlst li',wrapper).children('div:even'), function () {

									$(this).addClass('oculto');
								});
								$.each($('div.db_fields ul.dbfldlst li',wrapper).children('div:odd'), function () {

									$(this).removeClass('oculto');
								});
								
								//update validation context menu
								var menu = $('#moreValidations ul');
								menu.children('li').remove();

								$('div.db_fields ul.dbfldlst li div.fldv span',wrapper).each(function () {
									
									var txt = $.trim($(this).text());
									menu.append('<li class="addSubV"><a href="#matches[' + txt + ']">' + txt + '</a></li>');
								});
							}
							$(this).blur();
						});
					});

				 	/***	Table fields <--> db rels switcher
				 	 ********************************************************/
					$.each($('.db_fields a.dbrel',wrapper), function () {

						$(this).bind('click', function () {

							$(this).children().toggle();
							$(this).parent().prev().toggle();
							$('span',$(this).parent()).toggle();
							$('div.db_fields fieldset',wrapper).children(':gt(0)').toggle();

							$(this).blur();
						});
					});	

					 /***	Validation Menu
					 ********************************************************/
					$.each($('.db_fields ul.dbfldlst li div.fldv a',wrapper), function () {	

						$(this).contextMenu({
					        menu: 'moreValidations',
							wrapper: $('div.frame',wrapper)[1],
							button: $.browser.msie ? 1 : 0  // Internet explorers left-click value matches "1". "0" for the rest off the browsers
					    	},
					    	function(action, el, pos){	

								validation_manager(action, el, pos);
							}
					    );
					});

					/***	Delete feature
				 	 ********************************************************/
					if(wrapper.attr('id') == 'resume') {

						$('#resume input[name=delete]').click( function () {	$('#resume div.delRecLnk').slideToggle("slow");	});
					}
					
					// if more than one table is selected Then:
					if($('#resume input[name=delete_db]').length > 0) {

						//disable all by default
						$('#resume input[name=remove_id_fields[]]').attr('disabled','disabled');
						
						//radio onChange event
						$('#resume input[name=delete_db]').change(function () {
							
							$('#resume input[name=remove_id_fields[]]').attr('disabled','disabled');
							$('#resume input[rel='+$(this).attr('value')+']').attr('disabled','');
						});
						
						// select the first one 
						$('#resume input[name=delete_db]:eq(0)').click();	
						$('#resume input[rel='+$('#resume input[name=delete_db]:eq(0)').attr('value')+']').attr('disabled','');
					}
					
				 	/***	Table relationships
				 	 ********************************************************/
					
					//resume
					$('#relationships').next().children('span:eq(0)').click(function () {
						
						$('#relationships').append($('#relationships span:eq(0)').clone());
					});
					$('#relationships').next().children('span:eq(1)').click(function () {
						
						if($('#relationships span').length > 1)
							$($('#relationships span')[$('#relationships span').length -1]).remove();
						else
							$('#relationships span').animate({opacity: 0.4},400, function () {
								
								$('#relationships span').animate({opacity: 1},400);
							});
					});
					
					//edit
					$('#edit_relationships').next().children('span:eq(0)').click(function () {
						
						$('#edit_relationships').append($('#edit_relationships span:eq(0)').clone());
					});
					$('#edit_relationships').next().children('span:eq(1)').click(function () {
						
						if($('#edit_relationships span').length > 1)
							$($('#edit_relationships span')[$('#edit_relationships span').length -1]).remove();
						else
							$('#edit_relationships span').animate({opacity: 0.4},400, function () {
								
								$('#edit_relationships span').animate({opacity: 1},400);
							});
					});
					
					//insert
					$('#insert_relationships').next().children('span:eq(0)').click(function () {
						
						$('#insert_relationships').append($('#insert_relationships span:eq(0)').clone());
					});
					$('#insert_relationships').next().children('span:eq(1)').click(function () {
						
						if($('#insert_relationships span').length > 1)
							$($('#insert_relationships span')[$('#insert_relationships span').length -1]).remove();
						else
							$('#insert_relationships span').animate({opacity: 0.4},400, function () {
								
								$('#insert_relationships span').animate({opacity: 1},400);
							});
					});
					
					// div toogle
					$('span.rel_title',wrapper).click(function () {
						
						$($(this).next()).slideToggle("slow");
					});
					
				}//end success
			});//end ajax	
		}//end if
	});//end bind


 	/***	Form workflow
 	 ********************************************************/
	$('.back2db_list').bind('click',function() {

		$(this).parent().parent().fadeOut("normal", function () {

			$(this).prev().fadeIn("normal");
			
			$('div.db_fields',this).html('');

			var help = $('div.help > div',this);
			if($(help[0]).attr('style') != null) {	help.toggle(); }
		});
	});
	
	
 	/***	Create model
 	 ********************************************************/
	$("#cmodel").change(function () {
		
		
		if($(this).attr("value") == 1) {
			
			$(this).next().show().children("input").focus().select();

		} else {
			
			$(this).next().hide();
		}
	});
	
 });//end ready