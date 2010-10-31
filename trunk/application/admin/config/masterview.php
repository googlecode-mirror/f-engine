<?php

	$active_group = "default";

	$conf['default'] =  array (
							'js'  		=> array (),
							'css' 		=> array ( 'default.css','userguide/userguide.css','plugins/drilldownMenu.css'),
							'header'	=> 'header/main',
							'footer'	=> 'footer/main',
							'title'		=> 'F-engine welcome page',
							'lang'			=>	'en',
							'description'	=>	'',
							'keywords'		=>	''
						);

	$conf['tools'] =  array (
							'js'  		=> array ( 'jquery/jquery.js','tools/index.js' ),
							'css' 		=> array ( 'default.css','tools/devtools.css' ),
							'header'	=> 'header/main',
							'footer'	=> 'footer/main',
							'title'		=> 'welcome to F-engine'
						);

	$conf['newproject'] =  array (
							'js'  		=> array (),
							'css' 		=> array ( 'default.css','tools/devtools.css' ),
							'header'	=> 'header/main',
							'footer'	=> 'footer/main',
						);

	$conf['newcontroller'] =  array (
							'js'  		=> array ( 	'jquery/jquery.js','jquery/plugins/idTabs.js','jquery/plugins/fileTree.js',
													'jquery/plugins/ui.core.js','jquery/plugins/ui.sortable.js',
													'jquery/plugins/contextmenu.js','tools/newcontroller.js' ),					
							'css' 		=> array (  'default.css','common/tabs.css','tools/default.css',
													'plugins/fileTree.css','plugins/contextmenu.css','tools/newcontroller.css' ),
							'header'	=> 'header/ncwizard',
							'footer'	=> 'footer/main',
						);

	$conf['done'] =  array (
							'view'		=> 'tools/newcontroller/done',
							'js'  		=> array (),					
							'css' 		=> array ('default.css'),
							'header'	=> 'header/main',
							'footer'	=> 'footer/main'
						);

	$conf['sel_project'] =  array (
							'js'  		=> array (),					
							'css' 		=> array (  'default.css' ),
							'header'	=> 'header/main',
							'footer'	=> 'footer/main'
						);

	$conf['dbmanager'] =  array (
							'js'  		=> array ( 'jquery/jquery.js','jquery/plugins/idTabs.js','jquery/plugins/autogrow.js','tools/dbmanager.js',
													'jquery/plugins/ui.core.js','jquery/plugins/ui.sortable.js','jquery/plugins/ajaxfileupload.js' ),
							'css' 		=> array ( 'default.css','tools/dbmanager.css','common/tabs.css','plugins/fileTree.css' ),
							'header'	=> 'header/dbmanager',
							'footer'	=> 'footer/main',
							'content_wrapper_style' => 'width:100%;'
						);		

	$conf['jspacker'] =  array (
							'js'  		=> array ( 'tools/jspacker/my.js','tools/jspacker/base2-load.js',
													'tools/jspacker/Packer.js','tools/jspacker/Words.js','tools/jspacker/bindings.js'),
							'css' 		=> array ( 'default.css','tools/jspacker.css' ),
							'header'	=> 'header/main',
							'footer'	=> 'footer/main',
						);

	$conf['csspacker'] =  array (
							'js'  		=> array ('jquery/jquery.js','tools/cssminifier.js'),
							'css' 		=> array ( 'default.css','tools/jspacker.css' ),
							'header'	=> 'header/main',
							'footer'	=> 'footer/main'
						);

	$conf['fileeditor'] =  array (
							'js'  		=> array ( 	'jquery/jquery.js','jquery/plugins/fileTree.js','jquery/plugins/contextmenu.js',
                                                    'editarea/edit_area_full.js','tools/fileeditor.js' ),
							'css' 		=> array (  'default.css','tools/default.css','plugins/fileTree.css',
                                                    'tools/fileeditor.css','plugins/contextmenu.css'),
							'header'	=> 'header/dbmanager',
							'footer'	=> 'footer/main'
						);
						
	$conf['userguide'] =  array (
							'js'  		=> array ( 'jquery/jquery.js','jquery/plugins/fMenu.js','userguide/launcher.js' ),
							'css' 		=> array ( 'default.css','userguide/userguide.css','plugins/drilldownMenu.css' ),
							'header'	=> 'header/main',
							'footer'	=> 'footer/main',
							'title'		=> 'F-engine userguide',
							'lang'			=>	'',
							'description'	=>	'',
							'keywords'		=>	''
						);