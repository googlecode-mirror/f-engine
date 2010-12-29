/**
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.4
 * @filesource
 */

 /***	Filetree
 ********************************************************/

 function file_open (file) {

	var ext = file.substring(file.length-4);

	//disable image editing
	if(ext == ".png" || ext == ".jpg" || ext == "jpeg" || ext == ".gif" )
		return false;

    var ext  = file.split('.')[file.split('.').length-1];
    var item = file.substr(file.split('/')[0].length+1);
    var obj = $('#js_list a[rel='+file+']');

 	if(obj.hasClass('selected')) {

        //editAreaLoader.closeFile('editor', item);
 		return false;

    } else {

        obj.addClass('selected');

        $.post(ROOT+'tools/fileeditor/ajax/fileget',"file="+item+"&project="+$("#currentprojectname").attr("rel"), 
        function (content) {

            var new_file= {id: item, text: content, syntax: ext, title: item};
            editAreaLoader.openFile('editor', new_file);
            return true;
        });
    }
 }

 /***	Edit area
 ********************************************************/
 function file_close (obj) {

    var file = '/' + obj.id;
    var obj = $('#js_list a[rel='+file+']');

    if(obj.hasClass('selected'))    obj.removeClass('selected');

    return true;
 }
 
 function trigger_file_close(el) {

	var filename = $(el).attr("rel").substring(1).replace("/","%2F");
	var iframetab = $("li[id=tab_file_"+filename+"]",window.frame_editor.document);
	
	$("a img",iframetab).click();	
 }

 
 function file_save(id, content){

    var file_name = window.frame_editor.editArea.curr_file;

    $.ajax({
    	type: 'POST',
    	url: ROOT+'tools/fileeditor/ajax/fileput',
    	data: {
	    	"file"    : file_name,
	    	"content" : content,
	    	"project" : $("#currentprojectname").attr("rel")
    	},
    	success: function (resp) {

            if(resp == '') {

                //delete edited status
                 window.frame_editor.editArea.files[file_name].edited = false;
                 $('#tab_browsing_list li.selected a.edited',window.frame_editor.document).removeClass('edited');
            } else {

                alert(resp);
            }
        }
    });
 }
 
 
 /*** contextmenu events ***/
 function context_menu () {

	 $('#js_list li.file a').contextMenu({menu: 'fileMenu',wrapper: $('#js_list')},
	    function(action, el, pos){	
			fileMenuHandler(action, el, pos);	
		}
	 );
	 
	 $('#js_list li.directory a').contextMenu({menu: 'dirMenu',wrapper: $('#js_list')},
	    function(action, el, pos){	
			directoryMenuHandler(action, el, pos);	
		}
	);
 }
 
 function fileMenuHandler (action, el) {

	 switch(action) {

	 	case "rename":

 			var reply = prompt("File name: ", $(el).attr("rel").replace(/^.*\//ig,""));
 			if(reply != "" && reply != null) {

 				var newname = $(el).attr("rel").replace($(el).attr("rel").replace(/^.*\//ig,""),reply);

 		        $.post(ROOT+'tools/fileeditor/ajax/frename',
 		        "file="+$(el).attr("rel")+"&newname="+newname+"&project="+$("#currentprojectname").attr("rel"), 
 		        function (resp) {

 		        	if(resp == true) {

 		        		$(el).attr("rel",newname).text(reply);

 		        	} else {

 		        		alert("rename failed");
 		        	}

 		            return true;
 		        });
 			}

 			break;

	 	case "cut":

 			var item = $("#fileMenu li.paste, #dirMenu li.paste");
 			item.each(function () {

 				$(this).removeClass("oculto").attr("rel",el.attr("rel")).attr("action","cut");
 				$("a",this).text("Paste "+el.attr("rel").replace(/^.*\//ig,""));
 			})
			break;
	
	 	case "copy":

 			var item = $("#fileMenu li.paste, #dirMenu li.paste");
 			item.each(function () {

 				$(this).removeClass("oculto").attr("rel",el.attr("rel")).attr("action","paste");
 				$("a",this).text("Paste "+el.attr("rel").replace(/^.*\//ig,""));
 			})

			break;
	 			
	 	case "paste":

	 			var oldfile = $("#fileMenu li.paste").attr("rel");
	 			var newfile = $(el).attr("rel").replace(/[^\/]*\..*$/ig,"")+$("#fileMenu li.paste").attr("rel").replace(/^.*\//ig,"");
	 			var action = $("#fileMenu li.paste").attr("action");
	 				
		        $.post(ROOT+'tools/fileeditor/ajax/paste',
		        "oldfile="+oldfile+"&newfile="+newfile+"&action="+$("#fileMenu li.paste").attr("action")+
		        "&project="+$("#currentprojectname").attr("rel"), 
		        function (resp) {

 		        	if(resp != "") {

 		        		var node = $("a[rel="+$("#fileMenu li.paste").attr("rel")+"]").parent().clone(true);
 		        		$("a",node).attr("rel",resp);
 		        		$("a",node).text(resp.replace(/^.*\//ig,"")).removeClass("selected");
 		        		node.click(function () {
 		        			file_open(this);
 		        		});
 		        		$(el).parent().parent().append(node);

 		        		if(action == "cut") {

 		        			var node = $("#js_list a[rel="+$("#fileMenu li.paste").attr("rel")+"]");
 		        			if(node.hasClass("selected")) {

 		        				trigger_file_close(node);
 		        			}

 		        			$("a[rel="+$("#fileMenu li.paste").attr("rel")+"]").parent().remove();
 		        		}

 		        	} else {

 		        		alert("Paste failed");
 		        	}

		            return true;
		        });
	 			break;

	 	case "delete":

		 		var answer = confirm("Do you really want to delete "+$.trim(el.text())+"?");
		 		if (answer){

		 			$.post(ROOT+'tools/fileeditor/ajax/delete',
			        "file="+el.attr("rel")+"&project="+$("#currentprojectname").attr("rel"), 
			        function (resp) {

	 		        	if(resp != "") {

	 	 		      	 	if($(el).hasClass("selected")) {

	 	 		      	 		trigger_file_close(el);
	 	 		      	 	}

	 		        		$("a[rel="+el.attr("rel")+"]").parent().remove();

	 		        	} else {

	 		        		alert("Delete failed");
	 		        	}

			            return true;
			        });
		 		}
 				break;
	 }
 }

 function directoryMenuHandler (action, el, pos) {

	 switch(action) {

	 	case "refresh":

	 			var parentDir = $(el).parent();
 				$("ul",parentDir).remove();
 				parentDir.removeClass("expanded").addClass("collapsed");
 				$("a",parentDir).click();
	 			break;

	 	case "rename":

	 		var pathSegments = $(el).attr("rel").split("/");
	 		var folderName = "";
	 		for(i=0; i < pathSegments.length; i++) {

	 			if(pathSegments[i] != "") {
	 				folderName = pathSegments[i];
	 			}
	 		}

 			var reply = prompt("Folder name: ", folderName);

 			if(reply != "" && reply != null) {

 				var newname = $(el).attr("rel").replace(folderName,reply);

 		        $.post(ROOT+'tools/fileeditor/ajax/frename',
 		        "file="+$(el).attr("rel")+"&newname="+newname+"&project="+$("#currentprojectname").attr("rel"), 
 		        function (resp) {

 		        	if(resp == true) {

 		        		$(el).attr("rel",newname).text(reply);

 		        	} else {

 		        		alert("rename failed");
 		        	}

 		            return true;
 		        });
 			}

 			break;

	 	case "file":

	 			if($(el).parent().hasClass("collapsed")) {

	 				$(el).click();
	 			}

	 			var reply = prompt("File name: ", $(el).attr("rel").replace(/^.*\//ig,""));
	 			var path = $(el).attr("rel") + reply;

	 			if($("a[rel="+path+"]").length > 0) {

	 				alert("File allready exists");
	 				return;
	 			}

	 			if(reply != "" && reply != null) {

	 				var filename = $(el).attr("rel") + reply;

	 		        $.post(ROOT+'tools/fileeditor/ajax/addfile',
	 		        "file="+filename+"&project="+$("#currentprojectname").attr("rel"), 
	 		        function (resp) {

	 		        	if(resp != "") {

	 			 			var parentDir = $(el).parent();
	 		 				$("ul",parentDir).remove();
	 		 				parentDir.removeClass("expanded").addClass("collapsed");
	 		 				$("a",parentDir).click();

	 		        	} else {

	 		        		alert("Error");
	 		        	}

	 		            return true;
	 		        });
	 			}
	 			break;

	 	case "folder":

 			if($(el).parent().hasClass("collapsed")) {

 				$(el).click();
 			}

 			var reply = prompt("Folder name: ", $(el).attr("rel").replace(/^.*\//ig,""));

 			var path = $(el).attr("rel") + reply;
 			if($("a[rel="+path+"/]").length > 0) {
 
 				alert("Folder allready exists");
 				return;
 			}

 			if(reply != "" && reply != null) {

 				var filename = $(el).attr("rel") + reply;

 		        $.post(ROOT+'tools/fileeditor/ajax/addfolder',
 		        "file="+filename+"&project="+$("#currentprojectname").attr("rel"), 
 		        function (resp) {

 		        	if(resp != "") {

 			 			var parentDir = $(el).parent();
 		 				$("ul",parentDir).remove();
 		 				parentDir.removeClass("expanded").addClass("collapsed");
 		 				$("a",parentDir).click();

 		        	} else {

 		        		alert("Error");
 		        	}

 		            return true;
 		        });
 			}
 			break;

	 	case "paste":

 			if($(el).parent().hasClass("collapsed")) {

 				$(el).click();
 			}

 			var oldfile = $("#fileMenu li.paste").attr("rel");
 			var newfile = $(el).attr("rel")+$("#fileMenu li.paste").attr("rel").replace(/^.*\//ig,"");

 			var action = $("#fileMenu li.paste").attr("action");

	        $.post(ROOT+'tools/fileeditor/ajax/paste',
	        "oldfile="+oldfile+"&newfile="+newfile+"&action="+$("#fileMenu li.paste").attr("action")+
	        "&project="+$("#currentprojectname").attr("rel"), 
	        function (resp) {

	        	if(resp != "") {

	        		var node = $("a[rel="+$("#fileMenu li.paste").attr("rel")+"]").parent().clone(true);
	        		$("a",node).attr("rel",resp);
	        		$("a",node).text(resp.replace(/^.*\//ig,"")).removeClass("selected");
	        		node.click(function () {
	        			file_open(this);
	        		});

	        		$(el).next().append(node);
	        		if(action == "cut") {

	        			var node = $("#js_list a[rel="+$("#fileMenu li.paste").attr("rel")+"]");
	        			if(node.hasClass("selected")) {

	        				trigger_file_close(node);
	        			}

	        			$("a[rel="+$("#fileMenu li.paste").attr("rel")+"]").parent().remove();
	        		}

	        	} else {

	        		alert("Paste failed");
	        	}

	            return true;
	        });
 			break;
	 }
 }

 /***	onLoad
 ********************************************************/
 $(document).ready(function() { 

 	/***	Filetrees
 	 ********************************************************/
    $('#js_list').fileTree(

    	{root: '/', script: ROOT+'tools/fileeditor/ajax/filetree/'+$("#currentprojectname").attr("rel"),
    	onLoad: context_menu},
    	function(file) {	file_open(file);	}
    );

    /*** Edit area ***/
    $('#editor')[0].value = '';
    editAreaLoader.init({
        id: "editor"	// id of the textarea to transform
        ,start_highlight: true
        ,font_size: "8"
        ,font_family: "verdana, monospace"
        ,allow_toggle: false
        ,language: "en"
        ,syntax: "php"
        ,toolbar: "save, search, go_to_line, fullscreen, |, undo, redo, |, select_font, |, change_smooth_selection, |, syntax_selection, |, highlight, reset_highlight, |, help"
        ,syntax_selection_allow: "php,js,html,css,xml,sql"
        ,save_callback: "file_save"
        ,EA_file_close_callback: "file_close"
    });

 });//end ready