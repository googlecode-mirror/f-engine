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

//onload
$(document).ready(function () {

	$("div#id, div#tables").show();
	$("div#id").children("div").show();
	initTab_backup();
	init_paginationLinks(); //refresh and order by buttons also
	initTab_sql();
	maximize();
	$('#tableContent textarea.expanding').autogrow();
	expandTablelist();
	processList();

	$("#db_list input.filter").focus();
});

/***	Switch database configuration
 ********************************************************/
$("select[name=db_conf]").change(function () {

	var form = $(this).parent().parent();
	$(form).attr("action",$(form).attr("action")+$(this).attr("value"));

	form.submit();
});

/***	DB Table list filter
 ********************************************************/
var filter = {
	items: 'null',length: 0
};

filter.items = $('#db_list ul li');

//disable enter button
$('input.filter').bind('keypress', function(e) {
    if(e.keyCode==13) {
           return false;
    }
});

$('input.filter').bind('keyup', function () {

	if (this.value.length > filter.length) {

		$.each(filter.items.not(":contains('"+this.value+"')"), function() {

			if (!$(this).hasClass('oculto')) {	$(this).addClass('oculto');	}
		});

	} else {

		$.each(filter.items.filter(":contains('"+this.value+"')"), function() {

			if ($(this).hasClass('oculto')) {	$(this).removeClass('oculto');	}
		});

		$.each(filter.items.not(":contains('"+this.value+"')"), function() {

			if (!$(this).hasClass('oculto')) {	$(this).addClass('oculto');	}
		});
	}
	filter.length = this.value.length;

}).bind("click",function () {

	$(this).select();
});

/***	DB Table list item highlight
 ********************************************************/
$('#db_list a').each(function () {

    $(this).bind('click', function () {

		$('div.newTable a').css('color','');

		$('ul.jqueryFileTree a.selected').removeClass('selected');
		$(this).addClass('selected');

		var values = "table="+$(this).text()+ "&dbconf=" + $("select[name=db_conf]").attr("value")+"&fullLoad=true&project="+$("#currentprojectname").attr("rel");
		
		if($("#exam-results a.refresh:eq(0)").hasClass("keepQuery")) {

			values += "&query=" + $("#current_query span:eq(0)").text();
		}
		
		$.ajax({ type: "POST",
				 async: false,
		  		 url: $('#forms form').attr('action'),
		  		 data: values,
				 success: function(msg) {
					loadContent(msg);		
				 }
		});
    });
});

$('div.newTable a').click(function () {

	$(this).css('color','#2F3B6F').blur();

	$.post( $(this).attr("href"), 
	{ project: $("#currentprojectname").attr("rel"), 
	  dbconf : $("select[name=db_conf]").attr("value")} ,
	  function (html) {
		  loadCreateTable(html);
	  }
	);
	return false;
});

//reset  db field form
function reset_values (obj) {

    $('input:checked',obj).removeAttr('checked');
    $('input[type="text"]',obj).attr('value','');
    $($('input[name=fdefault]',obj)[0]).removeAttr('disabled').show();
    $($('input[name=fdefault]',obj)[1]).attr('disabled','disabled').parent().hide();
    $('input[name="fname"]',obj).focus();
}

function loadCreateTable (html) {

	$('#db_list .jqueryFileTree a.selected').removeClass("selected");
	$('#tableContent').html(html);

	//tabs
	$('#tableContent ul.idTabs').each(function () {	$.idTabs(this,$.idTabs.settings);	});

	$('#fields input[name=findex]').change(function () {

		if($(this).attr('value') == "primary key") {

			$('#fields input[name=auto_increment]').removeAttr('disabled');

		} else {

			$('#fields input[name=auto_increment]').attr('disabled','disabled');
		}
	});	

    $('#fields select[name=ftype]').change(function () {

        //reset default values
        $('#fields input[name=flong]').removeAttr('disabled','');
        $('#fields input[name=fattr]').removeAttr('disabled','');
        $('#fields input[name=auto_increment]').attr('disabled','disabled');

        switch($('#fields select[name=ftype] option:selected').attr('rel')) {

            case 'Numeric':

                    $($('#fields input[name=fattr]')[3]).attr('disabled','disabled');
					$('#fields input[name=findex]:eq(1)').removeAttr('disabled');
					
					if($('#fields input[name=findex]:eq(1):checked').length > 0)
						$('#fields input[name=auto_increment]').removeAttr('disabled');

                    break;

            case 'String':

                    $('#fields input[name=fattr]').attr('disabled','disabled');
					$('#fields input[name=findex]:eq(1)').attr('disabled','disabled');
                    $('#fields input[name=auto_increment]').attr('disabled','disabled');
                    break;

            case 'Time':

                    $('#fields input[name=flong]').attr('disabled','disabled');
                    $('#fields input[name=fattr]').attr('disabled','disabled');
					$('#fields input[name=findex]:eq(1)').attr('disabled','disabled');
                    $('#fields input[name=auto_increment]').attr('disabled','disabled');

                    if($('#fields select[name=ftype] option:selected').attr('value') == "TIMESTAMP") {

                        $($('#fields input[name=fdefault]')[0]).attr('disabled','disabled').hide();
                        $($('#fields input[name=fdefault]')[1]).removeAttr('disabled').parent().show();
                        $($('#fields input[name=fattr]')[3]).attr('disabled','');
                    }

                    break;

            case 'Date':

                    $('#fields input[name=flong]').attr('disabled','disabled');
                    $('#fields input[name=fattr]').attr('disabled','disabled');
					$('#fields input[name=findex]:eq(1)').attr('disabled','disabled');
                    $('#fields input[name=auto_increment]').attr('disabled','disabled');
                    break;

            case 'Other':

                    $('#fields input[name=flong]').attr('disabled','disabled');
                    $('#fields input[name=fattr]').attr('disabled','disabled');
					$('#fields input[name=findex]:eq(1)').attr('disabled','disabled');
                    $('#fields input[name=auto_increment]').attr('disabled','disabled');

                    break;     
        }
    });

	$('#addfield').click( function () {

		var str = $('#fields input[name=fname]').attr('value');
        str += ' ' + $('#fields select[name=ftype]').attr('value');

        if($('#fields input[name=flong]').attr('value'))
            str += '(' + $('#fields input[name=flong]').attr('value') + ')';

        if($('#fields input[name=fattr]:checked').attr('value'))
            str += ' ' + $('#fields input[name=fattr]:checked').attr('value');

        if($('#fields input[name=fnull]:checked').attr('value'))
            str += ' ' + $('#fields input[name=fnull]:checked').attr('value');

        if($('#fields input[name=fdefault]:enabled').attr('value'))
            str += ' DEFAULT ' + $('#fields input[name=fdefault]:enabled').attr('value');

        if(typeof($('#fields input[name=auto_increment]:checked')[0]) != 'undefined')
            str += ' auto_increment';

        if($('#fields input[name=findex]:checked').attr('value')) {

            switch($('#fields input[name=findex]:checked').attr('value')) {

                case "primary key":
                        str += ' primary key';
                        break;

                default:

                       str += ' | ' + $('#fields input[name=findex]:checked').attr('value');
            }
        }

		if ($('#fields code').children('ul').length == 0) {

			$('#fields code').append('<ul style="list-style:none;padding:0;display:inline;"></ul>');
			$('#fields code ul').sortable();
		}

        $('#fields code ul').append('<li>'+
                                    '<img src="'+ BASE +'public_data/img/contextmenu/delete.png" title="delete this field" class="delete_field" style="cursor:pointer" /> '
                                    + str +
                                    '<input type="hidden" name="tablefields[]" value="'+ str +'"/>'+
                                '</li>');
        reset_values($('#fields '));

	});

    $('#reset').click (function () {
        
        reset_values($('#fields'));
    });

    $("img.delete_field").live("click", function(){
        $(this).parent().remove();
    });

    $('#finish input.preview').click (function () {

        $.post($('#tableContent form').attr('action') + '/preview', $('#tableContent form').serialize() ,function (response) {

			response = response.replace(/\n/g,"<BR>");
            $('#finish pre').html(response);
        });
        return false;
    });

    $('#finish input.submit').click (function () {
        
        $.ajax({
            type: "POST",
            url: $('#tableContent form').attr('action'),
            dataType:"html",
            data: $('#tableContent form').serialize(),
            success:function(response){
	        	if(response == 1 || response == '1') {
	
	                window.location.reload();
	
	            } else {
	            	
	                $('#finish pre').html(response);
	            }
            },
            error: function (xhr, textStatus, thrownError){

                var debug = xhr.responseText;
                debug= debug.substring(debug.indexOf("<h1"),debug.indexOf("</div"));
                $('#finish pre').html(debug);
            }   
        });
        return false;
    });
    
    $("#tableContent input.next, #tableContent input.prev").click(function () {
    	
    	var tabIndex = $(this).attr("rel");
    	$("#tableContent ul.idTabs li:eq("+tabIndex+")").click();
    });
    
    $("#main input[name=tablename]").focus();
}

function pagination (html) {

    $('#exam-results').html(html);

	/*** exam :: pagination ***/
    init_paginationLinks();

	/*** exam :: edit ***/
    $('#exam-results tr:gt(0) td a.edit').click(function () {

        $.post($(this).attr('href')+$("#currentprojectname").attr("rel"), 
        "table="+$('#db_list ul.jqueryFileTree a.selected').text() + "&dbconf=" + $("select[name=db_conf]").attr("value") + "&" + $(this).parent().serialize(),
        function (content) {

            $('#exam div.edit').html(content);
            $('#exam > div').toggle();
            recordEditEvents();
        });
        return false;
    });

	/*** exam :: delete ***/
    $('#exam-results tr:gt(0) td a.delete').click(function () {

    	$.post($(this).attr('href')+$("#currentprojectname").attr("rel"), 
    	        "table="+$('#db_list ul.jqueryFileTree a.selected').text() + "&dbconf=" + $("select[name=db_conf]").attr("value") + "&" +$(this).parent().serialize(), 
        function (response) {
            if(response == 1) {

            	if($("#exam-results > table tr").length == 2) {
            		$('#db_list ul li a.selected').click();
            	} else {
                	$("#exam-results aexpandContent:eq(0)").click();
            	}

            } else {

                alert(response);
            }
        });
        return false;
    });
    
    expandContent();
    
}

function loadContent (msg) {

	if(msg  != "undefined" || msg != undefined)
		$('#tableContent').html(msg);

	
	$("#content-wrapper").css("width","100%");
	
	//tabs
	$('#tableContent ul.idTabs').each(function () {	$.idTabs(this,$.idTabs.settings);	});

	//Load maximize/minimize events
	maximize();
	
	/*** exam :: pagination ***/
	init_paginationLinks();

	/*** exam :: edit ***/
    $('#exam-results tr:gt(0) td a.edit').click(function () {

        $.post($(this).attr('href')+$("#currentprojectname").attr("rel"), 
        "table="+$('#db_list ul.jqueryFileTree a.selected').text() + "&dbconf=" + $("select[name=db_conf]").attr("value") + "&" +$(this).parent().serialize(),
        function (content) {

            $('#exam div.edit').html(content);
            $('#exam > div').toggle();
            recordEditEvents();
        });
        return false;
    });

	/*** exam :: delete ***/
    $('#exam-results tr:gt(0) td a.delete').click(function () {

        $.post($(this).attr('href')+$("#currentprojectname").attr("rel"), 
        "table="+$('#db_list ul.jqueryFileTree a.selected').text() + "&dbconf=" + $("select[name=db_conf]").attr("value") + "&" +$(this).parent().serialize(), 
        function (response) {
            if(response == 1) {
            	
            	if($("#exam-results > table tr").length == 2) {
            		$('#db_list ul li a.selected').click();
            	} else {
                	$("#exam-results a.refresh:eq(0)").click();
            	}

            } else {

                alert(response);
            }
        });
        return false;
    });

    expandContent();

    /*** sql ***/
    initTab_sql();

	/*** insert :: submit ***/
    $("textarea.primary").parent().hover(function () {

    	if($("textarea",this).attr("disabled") == true)
    		$("textarea",this).removeAttr("disabled").attr("value","");

    }, function () {

    	var txtArea = $("textarea",this);
    	if(txtArea.attr("value") == "") {

    		txtArea.attr({"value": "Primary key - auto increment ","disabled":"disabled"});
    	}
    });
    
	$('#insert form input[type="submit"]').click(function () {

		var form = $(this).parent();
		$.post(form.attr('action') + "/" + $("#currentprojectname").attr("rel") + "/" + $("select[name=db_conf]").attr("value"), 
				form.serialize(), function (response) {

			if(response == 1) {

				$.ajax({ type: "POST",
				  		 url: $('#forms form').attr('action'),
				  		 data: "table="+$('#db_list ul.jqueryFileTree a.selected').text() + "&dbconf=" + $("select[name=db_conf]").attr("value") +"&fullLoad=true&project=" + $("#currentprojectname").attr("rel"),
						 success: function(msg) {
							loadContent(msg);		
						 }
				});

			} else {

				alert('error');
			}
		});
		return false;
	});


    /*** structure > add new field ***/
    //add new field -- init
    $('#structure div#tfields a.addfield').click(function () {

		$(this).blur();
        $('#structure > ul').hide();
        $('#structure > div:eq(0)').hide();
        $('#newField').show();

		return false;
    });


    /*** structure > edit field ***/

    //edit field
    $('#structure div#tfields table tr:gt(0) td a.edit_field').click(function () {

        var form = $($(this).parent());

        $.post(form.attr('action'), 
        	   form.serialize() +"&project=" + $("#currentprojectname").attr("rel")+"&dbconf=" + $("select[name=db_conf]").attr("value"), 
        	   function (response) {
                
               $('#editfield').html(response);
               $('#tfields').hide();
               $('#structure ul').hide();
               $('#editfield').show();

                //edit field --  send button
                $('#sendEditField').click (function () {

                    var str = $('#editfield input[name=fname]').attr('value');
                    str += ' ' + $('#editfield select[name=ftype]').attr('value');

                    if($('#editfield input[name=flong]').attr('value') != '' && $('#editfield input[name=flong]:disabled').length == 0)
                        str += '(' + $('#editfield input[name=flong]').attr('value') + ')';

                    if($('#editfield input[name=fattr]:checked').attr('value'))
                        str += ' ' + $('#editfield input[name=fattr]:checked').attr('value');

                    if($('#editfield input[name=fnull]:checked').attr('value'))
                        str += ' ' + $('#editfield input[name=fnull]:checked').attr('value');

                    if($('#editfield input[name=fdefault]:enabled').attr('value'))
                        str += ' DEFAULT ' + $('#editfield input[name=fdefault]:enabled').attr('value');

                    if(typeof($('#editfield input[name=auto_increment]:checked')[0]) != 'undefined')
                        str += ' auto_increment';

                    if($('#editfield input[name=findex]:checked').attr('value')) {

                        switch($('#editfield input[name=findex]:checked').attr('value')) {

                            case "primary key":
                                    str += ' primary key';
                                    break;

                            default:

                                   str += ' | ' + $('#editfield input[name=findex]:checked').attr('value');
                        }
                    }
                    
			        $.ajax({
			            type: "POST",
			            url: $('#editfield form').attr('action'),
			            dataType:"html",
			            data: "query="+str
                              +"&tablename="+$('#editfield input[name=tablename]').attr('value')
                              +"&tablefield="+$('#editfield input[name=tablefield]').attr('value')
                              +"&project=" + $("#currentprojectname").attr("rel")
                              + "&dbconf=" + $("select[name=db_conf]").attr("value"),
			            success:function(response){
				        	if(response == 1 || response == '1') {
				
				                $('#db_list a.selected').click();
				
				            } else {
				            	
				                alert(response);
				            }
			            },
			            error: function (xhr, textStatus, thrownError){
			
			                var debug = xhr.responseText;
			                debug= debug.substring(debug.indexOf("<h1"),debug.indexOf("</div"));
			                $("#editfield div.error").html(debug);
			            }   
			        });
                });

                //cancel edit field -- cancel button
                $('#editfield input.cancel').click(function () {

                    $('#structure > ul').show();
                    $('#structure > div:eq(0)').show();
                    $('#editfield').hide();
                    $('#editfield').html('');
                });

                //send

                //edit field -- events
                $('#editfield select[name=ftype]').change(function () {

                    //reset default values
                    $('#editfield input[name=flong]').removeAttr('disabled','');
                    $('#editfield input[name=fattr]').removeAttr('disabled','');
                    $('#editfield input[name=auto_increment]').removeAttr('disabled');

                    switch($('#editfield select[name=ftype] option:selected').attr('rel')) {


                        case 'Numeric':

                                $($('#editfield input[name=fattr]')[3]).attr('disabled','disabled');
                                break;

                        case 'String':

                                $('#editfield input[name=fattr]').attr('disabled','disabled');
                                $('#editfield input[name=auto_increment]').attr('disabled','disabled');
                                break;

                        case 'Time':

                                $('#editfield input[name=flong]').attr('disabled','disabled');
                                $('#editfield input[name=fattr]').attr('disabled','disabled');
                                $('#editfield input[name=auto_increment]').attr('disabled','disabled');

                                if($('#editfield select[name=ftype] option:selected').attr('value') == "TIMESTAMP") {

                                    $($('#editfield input[name=fdefault]')[0]).attr('disabled','disabled').hide();
                                    $($('#editfield input[name=fdefault]')[1]).removeAttr('disabled').parent().show();
                                    $($('#editfield input[name=fattr]')[3]).attr('disabled','');
                                }
                                break;

                        case 'Date':

                                $('#editfield input[name=flong]').attr('disabled','disabled');
                                $('#editfield input[name=fattr]').attr('disabled','disabled');
                                $('#editfield input[name=auto_increment]').attr('disabled','disabled');
                                break;

                        case 'Other':

                                $('#editfield input[name=flong]').attr('disabled','disabled');
                                $('#editfield input[name=fattr]').attr('disabled','disabled');
                                $('#editfield input[name=auto_increment]').attr('disabled','disabled');

                                break;
                    }
                });
        });

        return false;
    });

    //drop field
    $('#structure div#tfields table tr:gt(0) td a.delete_field').click(function () {

    	if(confirm("Are you sure?")) {
	        var form = $($(this).parent());
	
	        $.post(form.attr('action'), form.serialize()+"&project=" + $("#currentprojectname").attr("rel")
	        		+"&dbconf=" + $("select[name=db_conf]").attr("value"), 
	        function (response) {
	
	               if(response == 1 || response == '1') {
	
	                  $('#db_list a.selected').click();
	
	               } else {
	
	                   alert(response);
	               }
	        });
    	}
    	
    	$(this).blur();
        return false;
    });

    //add new field -- events
    $('#newField select[name=ftype]').change(function () {

        //reset default values
        $('#newField input[name=flong]').removeAttr('disabled','');
        $('#newField input[name=fattr]').removeAttr('disabled','');
        $('#newField input[name=auto_increment]').removeAttr('disabled');

        switch($('#newField select[name=ftype] option:selected').attr('rel')) {

            case 'Numeric':

                    $($('#newField input[name=fattr]')[3]).attr('disabled','disabled');
                    break;

            case 'String':

                    $('#newField input[name=fattr]').attr('disabled','disabled');
                    $('#newField input[name=auto_increment]').attr('disabled','disabled');
                    break;

            case 'Time':

                    $('#newField input[name=flong]').attr('disabled','disabled');
                    $('#newField input[name=fattr]').attr('disabled','disabled');
                    $('#newField input[name=auto_increment]').attr('disabled','disabled');

                    if($('#newField select[name=ftype] option:selected').attr('value') == "TIMESTAMP") {

                        $($('#newField input[name=fdefault]')[0]).attr('disabled','disabled').hide();
                        $($('#newField input[name=fdefault]')[1]).removeAttr('disabled').parent().show();
                        $($('#newField input[name=fattr]')[3]).attr('disabled','');
                    }
                    break;

            case 'Date':

                    $('#newField input[name=flong]').attr('disabled','disabled');
                    $('#newField input[name=fattr]').attr('disabled','disabled');
                    $('#newField input[name=auto_increment]').attr('disabled','disabled');
                    break;

            case 'Other':

                    $('#newField input[name=flong]').attr('disabled','disabled');
                    $('#newField input[name=fattr]').attr('disabled','disabled');
                    $('#newField input[name=auto_increment]').attr('disabled','disabled');

                    break;
        }
    });

    $("img.delete_field").live("click", function() {
        $(this).parent().remove();
    });

    /*** structure: buttons ***/

    //cancel add new field -- cancel
    $('#newField input.cancel').click(function () {

        $('#structure > ul').show();
        $('#structure > div:eq(0)').show();
        $('#newField').hide();
        $('#newField code').html('');
    });

    //add new field -- reset button
    $('#newField input.resetField').click (function () {

        reset_values($('#newField table'));
    });

    //add new field --  add button
    $('#newField input.add').click (function () {

		var str = $('#newField input[name=fname]').attr('value');
        str += ' ' + $('#newField select[name=ftype]').attr('value');

        if($('#newField input[name=flong]').attr('value'))
            str += '(' + $('#newField input[name=flong]').attr('value') + ')';

        if($('#newField input[name=fattr]:checked').attr('value'))
            str += ' ' + $('#newField input[name=fattr]:checked').attr('value');

        if($('#newField input[name=fnull]:checked').attr('value'))
            str += ' ' + $('#newField input[name=fnull]:checked').attr('value');

        if($('#newField input[name=fdefault]:enabled').attr('value'))
            str += ' DEFAULT ' + $('#newField input[name=fdefault]:enabled').attr('value');

        if(typeof($('#newField input[name=auto_increment]:checked')[0]) != 'undefined')
            str += ' auto_increment';

        if($('#newField input[name=findex]:checked').attr('value')) {

            switch($('#newField input[name=findex]:checked').attr('value')) {

                case "primary key":
                        str += ' primary key';
                        break;

                default:

                       str += ' | ' + $('#newField input[name=findex]:checked').attr('value');
            }
        }


        $('#newField code').append('<div>'+
                                    '<img src="'+ BASE +'public_data/img/contextmenu/delete.png" title="delete this field" class="delete_field" style="cursor:pointer" /> '
                                    + str +
                                    '<input type="hidden" name="tablefields[]" value="'+ str +'"/>'+
                                '</div>');

        reset_values($('#newField table'));
    });

    //add new field --  send button
    $('#sendField').click (function () {

        $.ajax({
            type: "POST",
            url: $('#newField form').attr('action'),
            dataType:"html",
            data: $('#newField form').serialize()+"&project=" + $("#currentprojectname").attr("rel")
            +"&dbconf=" + $("select[name=db_conf]").attr("value"),
            success:function(response){
	        	if(response == 1 || response == '1') {
	
	                $('#db_list a.selected').click();
	
	            } else {
	            	
	                alert(response);
	            }
            },
            error: function (xhr, textStatus, thrownError){

                var debug = xhr.responseText;
                debug= debug.substring(debug.indexOf("<h1"),debug.indexOf("</div"));
                $("#newField div.error").html(debug);
            }   
        });
    });

	/*** backup ***/
    initTab_backup();

	/*** other ***/
	initTab_other();

    /*** expanding textareas ***/
    $('#tableContent textarea.expanding').autogrow();

}

function recordEditEvents () {

	$('#exam div.edit input.cancel').click(function () {

		$('#exam > div').toggle();
	});

	$('#exam div.edit textarea.expanding').autogrow();

	$('#exam div.edit input[type="submit"]').click(function () {

		var form = $(this).parent();
		$.post(form.attr('action'), 
		form.serialize()+"&dbconf=" + $("select[name=db_conf]").attr("value"), 
		function (response) {

			if(response == 1) {

					$("#exam-results a.refresh:eq(0)").click();
					$('#exam > div').toggle();

			} else {

				alert('error');
			}
		});
		return false;
	});
}

/*** init exam tab, pagination and refresh button events ***/
function init_paginationLinks() {

	//pagination and refresh buttons
	$('#exam-results div.pagination a').click( function () {

		var orderby = '';

		if( $("#exam-results th.desc").length > 0 )
			orderby = $("#exam-results th.desc center").text() + " desc"
		else if( $("#exam-results th.asc").length > 0 )
			orderby = $("#exam-results th.asc center").text() + " asc"

		$("#current_query > img").removeClass("oculto");
		$.ajax({ type: "POST",
		  		 url: $(this).attr('href'),
		  		 data: {
						"table"	 :	$('#db_list .jqueryFileTree a.selected').text(), 
						"dbconf" :	$("select[name=db_conf]").attr("value"),
						"query"	 :	$.trim($("#current_query span:eq(0)").text()),
						"action" :	$(this).attr("class"),
						"orderby" : orderby,
						"project" : $("#currentprojectname").attr("rel")
				},
				success: function(msg) {
					pagination(msg);
				},
				error: function (xhr, ajaxOptions, thrownError) {

					loading();
					debug = xhr.responseText;
					resp = debug.substring(debug.indexOf("<body"),debug.indexOf("</body"));
					resp = resp.replace("select count(*) as itemNum from (","").replace(") as tmp","");

                    $("#exam-results > table, #exam-results > div#content").replaceWith(resp);
                    $("#exam-results div.pagination").hide();
                    $("#current_query span:eq(1)").hide();
                }  
		});
		
		if(parseInt($(this).offset().top) > 300) {

			//set scroll
			$('html,body').animate({scrollTop: (parseInt($("#forms h2 a").offset().top))}, 800);
		}

		return false;
	});

    /*** order by links ***/
    $("#exam-results tr:eq(0) th").not(".actions").css("cursor","pointer").click(function () {

    	if( $(this).hasClass("desc") ) {

    		$("th",$(this).parent()).removeClass("desc").removeClass("asc");
    		$(this).addClass("asc");

    	} else if ( $(this).hasClass("asc") ) {

    		$("th",$(this).parent()).removeClass("desc").removeClass("asc");
    		$(this).addClass("desc");

    	} else { 

    		$("th",$(this).parent()).removeClass("desc").removeClass("asc");
    		$(this).addClass("desc");
    	}

    	$("#exam-results a.refresh:eq(0)").click();
    });
}

/*** init backup ***/
function initTab_backup () {

    $('#backup form input[name="witch"]').change(function () {

        switch($(this).attr('value')) {

            case "custom":   

            		if($('#format input[name=format]:eq(3)').attr("value") == "csv")
            			$('#format input[name=format]:eq(1)').click();

            		$('#format input[name=format]:eq(3)').attr("disabled","disabled");
            		$('#tables select[name="tables[]"]').show();
                    $('#tables input[name=backup_query[]]:eq(0)').parent().parent().hide();
                    break;

            case "All":

            		if($('#format input[name=format]:eq(3)').attr("value") == "csv")
	        			$('#format input[name=format]:eq(1)').click();

            		$('#format input[name=format]:eq(3)').attr("disabled","disabled");
                	$('#tables select[name="tables[]"]').hide();
                	$('#tables input[name=backup_query[]]:eq(0)').parent().parent().hide();
            		break;

            default:

            		$('#format input[name=format]:eq(3)').removeAttr("disabled");
                    $('#tables select[name="tables[]"]').hide();
            		$('#tables input[name=backup_query[]]:eq(0)').parent().parent().show();
            		break;
        }
    });

	$('#backup form input[type="submit"]').click(function () {

		var form = $('#backup form');

		if($('input[name="witch"]:eq(2):checked',form).length > 0) {

			if($('select[name="tables[]"]').serialize()== "") {

				alert('Select at least one table');
				return false;
			}
		}

		if($('input[name="witch"]:checked',form).attr('value') == '')  {}

		if($('input[name="format"]',form)[0].checked == true) {

			$.ajax({
				type: "POST",
				url : form.attr('action'), 
				data: form.serialize()
				+"&project=" + $("#currentprojectname").attr("rel")+ "&dbconf=" + $("select[name=db_conf]").attr("value"), 
				success : function (response) {

					//replace line breaks by html <br> tags
					response = response.replace(/\n/g,"<BR>");

					/***
					 * if current table has more than 7 fields
					 * split inserts in 2 lines
					 */
					if($('#tfields tr:gt(0)').length > 7)
						response = response.replace(" VALUES ","<BR>VALUES ");
					$('div#result code',form).html(response);

					$("#backup a[href=#result]").parent().show();
					$('#backup ul li:eq(4)').click();

				}, error: function (xhr, ajaxOptions, thrownError){

					debug = xhr.responseText;
					response = debug.substring(debug.indexOf("<body"),debug.indexOf("</body"));

					$('div#result code',form).html(response);
					$('#backup ul li:eq(3)').click();
	            }
			});
			return false;
		}
	});
}

function initTab_sql() {

    $('#query input').click(function () {

    	$("#sqlResult").hide();
        var form = $('#query form');

        $.ajax({
        	type : "POST",
        	url : form.attr('action'),
        	data : form.serialize()+"&project=" + $("#currentprojectname").attr("rel") + "&dbconf=" + $("select[name=db_conf]").attr("value"),
        	success : function (response) {

        		var newquery = $("#query textarea").attr("value");

        		//table undetected, just fire the query
        		if(response == "<!--exam-->" && $('ul.jqueryFileTree a.selected').length == 0) {

                    if( $("#db_list li a.selected").length == 0 ) {

                    	$("#current_query span:eq(0)").text(newquery);
                    	loading();

                    	//hide old results and pagination
                    	$("#exam-results > table, #exam-results > div#content").hide();
                    	
                    	//switch tabs
                    	$("#tableContent ul a[href=#exam]").parent().show();
                    	$("#tableContent ul a[href=#exam]").click();
                    	$("#exam-results a.refresh:eq(0)").click();
                    }

                //switch table and fire query
        		} else if(  response.substring(0,11) == "<!--exam-->" && response.substring(11) != "" && 
        					$('ul.jqueryFileTree a.selected').attr("title") != response.substring(11)) {

        			var newtable = response.substring(11);
        			$("#exam-results a.refresh:eq(0)").addClass("keepQuery");
        			$("#current_query span:eq(0)").text(newquery);
        			$('ul.jqueryFileTree a[title='+newtable+']').click();
                
        		//keep table and fire query
        		} else if(response.substring(0,11) == "<!--exam-->") {

                	//tab switch
                	if($("#tableContent ul.idTabs li:eq(0)").hasClass("oculto")) {
                		$("#tableContent ul.idTabs li:eq(0)").removeClass("oculto");
                	}

                	$("#tableContent ul.btnTabs a[href*=#exam]").click();

                	//hide old results and pagination
                	$("#exam-results div.pagination").hide();
                	$("#exam-results > table").hide();
                	$("#exam-results > table, #exam-results > div#content").hide();

                	$('#sqlResult').hide();
            		$("#current_query span:eq(0)").text(newquery);
            		loading();

            		//reset old order by 
            		$("#exam-results th").removeClass("desc").removeClass("asc");
            		
            		targetPage = ROOT+"/tools/dbmanager/ajax/view/";
            		var querySegments = $("#current_query > span:eq(0)").text().split("limit");

            		if(querySegments.length > 1) {

            			var limitAndOffset = querySegments[1].split(",");
            			if(limitAndOffset.length > 1) {

            				targetPage += limitAndOffset[0] + "/"
            			}
            		}

            		//fire query
            		$("#exam-results a.refresh:eq(0)").attr("href",targetPage);
            		$("#exam-results a.refresh:eq(0)").click();

            	//create/drop table queries
        		} else if(response.substring(0,14) == "<!--refresh-->") {

        			if(response.substring(14) != "") {

        				/*** TODO:: refresh table list ***/
        				$('#sqlResult code').html(response).parent().show();
        				
        			} else {
        				
        				document.location.href = document.location.href;
        			}

            	//show results (Usually for insert and updates) 
            	} else {

                	$('#sqlResult code').html(response).parent().show();
            	}

            }, error: function (xhr, ajaxOptions, thrownError){

				debug = xhr.responseText;
				response = debug.substring(debug.indexOf("<body"),debug.indexOf("</body"));

				$('#sqlResult code').html(response).parent().show();
            }  
        });

        return false;
    });
}

function initTab_other() {

	$('#remove_table').click( function () {

		var answer = confirm("Do you really want to drop this table?");

		if (answer) {

			$.post($('#remove_table').attr('rel'), 
			'table='+$('#db_list a.selected').text() + "&dbconf=" + $("select[name=db_conf]").attr("value") +"&project=" + $("#currentprojectname").attr("rel"), 
			function (response) {

				if(response == 1) {

					$('#db_list a.selected').parent().remove();
					$('#tableContent').html(' ');

				} else {

					alert('error ocurred');
				}
			});
		}
	});

	$('#optimize_table').click( function () {

		var answer = confirm("Do you really want to optimize this table?");

		if (answer) {

			$.post($('#optimize_table').attr('rel'), 
			'table='+$('#db_list a.selected').text() + "&dbconf=" + $("select[name=db_conf]").attr("value") +"&project=" + $("#currentprojectname").attr("rel"), 
			function (response) {

                alert(response);
			});
		}
	});

	$('#repair_table').click( function () {

		var answer = confirm("Do you really want to repair this table?");

		if (answer) {

			$.post($('#repair_table').attr('rel'), 
			'table='+$('#db_list a.selected').text() + "&dbconf=" + $("select[name=db_conf]").attr("value") +"&project=" + $("#currentprojectname").attr("rel"), 
			function (response) {

				if(response == 1) {

					alert('Table status: Ok');

				} else {

					alert(response);
				}
			});
		}
	});
}

function loading() {

	if($("#current_query > img").hasClass("oculto"))
		$("#current_query > img").removeClass("oculto");
	else
		$("#current_query > img").addClass("oculto");
}

function expandContent() {

    /*** exam :: expand content ***/
    $('#exam-results tr:gt(0) td img.expand').hover(function () {

    	$(this).css("opacity","1");

    }, function () {

    	$(this).css("opacity","0.3");

    }).click(function () {

    	var cell = $(this).prev();
    	var content = cell.attr("title");

    	$(this).fadeOut("fast");
    	cell.animate({opacity: 0.1}, 300,function () {

    		if(cell.attr("title").length > 300) {
    			cell.css({"display":"block","width":"300px"});
    		}

    		cell.attr("title","").css("white-space","pre-line");
    		cell.html(content);
    		cell.next().remove();
    		
    		cell.css("opacity",1);//fadeIn("fast");
    	});


    });
}

function maximize () {

	//maximize
	$('#tableContent a#maximize').click(function () {

		$('#current_query').css({
			'max-width' : $(window).width()-150
		});

		$('#tableContent').css({

			'position' : 'absolute',
			'background-color': 'white',
			'top' : 0,
			'left' : '-' + $('#contenidos').offset().left + "px",
			'width' : $(document).width(),
			/*'height' : $(document).height()*/
		});

		$('#contenidos div.leftFrame').hide();
		$('#tableContent a#maximize').hide();
		$('#tableContent a#minimize').show();

		$("#tableContent ul.btnTabs.idTabs").css("max-width",screen.width-150);
	});

	//minimize
	$('#tableContent a#minimize').click(function () {

		$('#tableContent').css({
			'position' : '',
			'background-color': '',
			'width' : '',
			'top' : '',
			'left' : ''
		});

		$('#contenidos div.leftFrame').show();
		$('#tableContent a#minimize').hide();
		$('#tableContent a#maximize').show();
	});

	//Window resize event
	$(window).resize(function() {

		if($("#minimize:visible").length > 0) {
			$("#maximize").click();
		}
	});
}

var collapseId;
function expandTablelist() {

	/*** set html/styles ***/
	var node = $("#db_list").next();

	$("div.autogrow-dummy").children().remove()
	var dummy = $("div.autogrow-dummy").clone();
	dummy.attr("class","dblist-dummy");

	$("div.autogrow-dummy").after(dummy);

	node.css({
		"visibility":"visible",
		"display":"none",
		"position" : "absolute",
		"margin" : "1px 0 0 6px",
		"left" : $("div.leftFrame > form").width() -55,
		"top"  : $("div.leftFrame > form").offset().top - node.height() -2
	}).attr("id","expandTableList");

	$("div.frame").after(node);

	/*** add events ***/
	$("#expandTableList img.right").click(function () {

		$("div.dblist-dummy").html($("ul.jqueryFileTree:eq(0)").clone());
		var width = $("div.dblist-dummy").width()+10;

		if(width < $("div.frame").width()) {

			return;
		}

		$("div.frame").animate({"width":width},400,"swing", function () {

			$("#expandTableList").css("width",$("#db_list").next().width());
			$("#expandTableList img.right").addClass("oculto");
			$("#expandTableList img.left").removeClass("oculto");
		});

		var arrow = $("#expandTableList");
		width = width - arrow.width();
		arrow.animate({"left":width},450,"swing");
	});

	$("#expandTableList img.left").click(function () {

		var width = 150;

		if($("div.frame").width() > width) {

			$("div.frame").animate({"width":width},400,"swing", function () {
	
				$("#expandTableList").css("width",$("#db_list").next().width());
				$("#expandTableList img.right").removeClass("oculto");
				$("#expandTableList img.left").addClass("oculto");
			});
	
			var arrow = $("#expandTableList");
			width = width - arrow.width();
			arrow.css({"left":width});

		}
	});

	$("div.leftFrame").hover(function () {

		$("div.dblist-dummy").html($("#db_list ul.jqueryFileTree:eq(0)").clone());
		var width = $("div.dblist-dummy").width();

		if($("#db_list").width() < width) {

			$("#expandTableList").fadeIn(1000);
			clearTimeout(collapseId);
		}

	}, function () {

		collapseId = setTimeout("collapseTableList()",700);
	});	
}

function collapseTableList () {

	if($("#expandTableList img.right").hasClass("oculto"))
		$("#expandTableList").hide();
	else
		$("#expandTableList").fadeOut(600);
	$("#expandTableList img.left").click();
}

/*** auto refresh precessList event ***/
var pl_timerId;
function processList() {

	$("#autorefresh").click(function () {

		if($(this).not(":checked").length == 0) {

			$("#seconds").parent().slideDown(function () {

				$("#seconds").focus().select();
			});
			refreshProcessList();

		} else {

			clearTimeout(pl_timerId);
			$("#seconds").parent().slideUp();
		}
	});
}

function refreshProcessList() {

	$.ajax({ type: "POST",
 		 url: $("#autorefresh").parent().attr('action'),
 		 data: {
				"dbconf" :	$("select[name=db_conf]").attr("value"),
				"project" : $("#currentprojectname").attr("rel")
		},
		success: function(msg) {

			$("#processes table").replaceWith(msg);
			$("#processes table th").animate({"opacity":0.5}, function () {

				$(this).animate({"opacity":1});
			})
		}
	});

	if($("#autorefresh:checked").length > 0) {

		var timer = parseInt($("#seconds").attr("value").replace(/[^0-9]*/,""));
		
		if(timer == "" || timer == 0) {
			
			timer = 4000;
			
		} else {
			
			timer = timer * 1000;
		}

		pl_timerId = setTimeout("refreshProcessList()",timer);
	}
}

/***
 * 
 * Import tab file upload
 */
function ajaxFileUpload()
{
	$("#backup_error").hide();
	$("#buttonUpload").text("Uploading...").attr("disabled","disabled");

	$.ajaxFileUpload({
		
		url:ROOT+"tools/dbmanager/ajax/import/"+$("#currentprojectname").attr("rel")+"/"+$("select[name=db_conf]").attr("value"),
		secureuri:false,
		fileElementId:'fileToUpload',
		success: function (data, status) {

			var resp =  data.body.innerHTML;

			if(resp != "" && resp.indexOf("error")) {

				resp = resp.replace(/\n/g,"<BR>");

				$("#backup_error").show();
				$("#backup_error").html(resp);

			} else {

				window.location.reload();
			}

			$("#buttonUpload").text("Upload").removeAttr("disabled");
		},
		error: function (data, status, e)
		{
			var resp  = data.body.innerHTML;
			resp = resp.substring(resp.indexOf("<body"),resp.indexOf("</body"));
			resp = resp.replace(/\n/g,"<BR>");
			$("#backup_error").show();
			$("#backup_error").html(resp);

			$("#buttonUpload").text("Upload").removeAttr("disabled");
		}
	});

	return false;
}