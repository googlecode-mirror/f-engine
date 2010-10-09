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

        $.post(ROOT+'tools/fileeditor/ajax/fileget',"file="+item, function (content) {

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

 
 function file_save(id, content){

    var file_name = window.frame_editor.editArea.curr_file;

    $.post(ROOT+'tools/fileeditor/ajax/fileput',"file="+file_name+"&content="+escape(content), function (resp) {

        if(resp == '') {

            //delete edited status
             window.frame_editor.editArea.files[file_name].edited = false;
             $('#tab_browsing_list li.selected a.edited',window.frame_editor.document).removeClass('edited');
        } else {

            alert(resp);
        }
    });
 }

 /***	onLoad
 ********************************************************/

 $(document).ready(function() { 

 	/***	Filetrees
 	 ********************************************************/

    $('#js_list').fileTree(

    	{root: '/', script: ROOT+'tools/fileeditor/ajax/filetree'}, /*,onLoad: context_menu*/
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
        //,is_multi_files: false
    });
 });//end ready