<?php
if( (isset($_SERVER["LOCAL_ADDR"]) && $_SERVER["LOCAL_ADDR"] != $_SERVER["REMOTE_ADDR"])
    || (isset($_SERVER["SERVER_ADDR"]) && $_SERVER["SERVER_ADDR"] != $_SERVER["REMOTE_ADDR"]) ) {

    print("This page is only accessible from local machine");
    die;
}

/*
|---------------------------------------------------------------
| PHP ERROR REPORTING LEVEL
|---------------------------------------------------------------
|
| By default CI runs with error reporting set to ALL.  For security
| reasons you are encouraged to change this when your site goes live.
| For more info visit:  http://www.php.net/error_reporting
|
*/

	error_reporting(E_ALL);

/*
|---------------------------------------------------------------
| DEFINE APPLICATION CONSTANTS
|---------------------------------------------------------------
|
| EXT		- The file extension.  Typically ".php"
| FCPATH	- The full server path to THIS file
| SELF		- The name of THIS file (typically "index.php")
| BASEPATH	- The full server path to the "system" folder
| APPPATH	- The full server path to the "application" folder
|
*/
	define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
	define('FCPATH', __FILE__);
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
	
	//is windows? 
	if(stripos(php_uname(),"windows") !== false) {
		define('BASEPATH', realpath(dirname(__FILE__).'/../../').'\\');
		define('APPPATH', realpath(dirname(__FILE__)).'\\');
	} else  {
		define('BASEPATH', realpath(dirname(__FILE__).'/../../').'/');
		define('APPPATH', realpath(dirname(__FILE__)).'/');
	}

	define('APPNAME',array_pop(explode("/",substr(APPPATH,0,-1))));

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		define('IS_AJAX', TRUE);
	} else {
		define('IS_AJAX', FALSE);
	}
	

/*
|---------------------------------------------------------------
| LOAD THE FRONT CONTROLLER
|---------------------------------------------------------------
|
| And away we go...
|
*/

require_once BASEPATH.'core/fengine'.EXT;

/* End of file index.php */
/* Location: ./index.php */
