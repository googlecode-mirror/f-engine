<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Database Utility Class
 *
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
if ( ! class_exists('DB_utility'))
{
	require('CI_DB_utility.php');
}

class CI_DB_utility extends DB_utility {

	/**
	 * Constructor
	 *
	 * Grabs the CI super object instance so we can access it.
	 *
	 */	
	function CI_DB_utility()
	{
		// Assign the main database object to $this->db
		$CI =& get_instance();
		$this->db =& $CI->db;
		
		log_message('debug', "Database Utility Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Database Backup
	 *
	 * @access	public
	 * @return	void
	 */
	function backup($params = array(),$query='')
	{
		// If the parameters have not been submitted as an
		// array then we know that it is simply the table
		// name, which is a valid short cut.
		if (is_string($params))
		{
			$params = array('tables' => $params);
		}
		
		// ------------------------------------------------------
	
		// Set up our default preferences
		$prefs = array(
						'tables'		=> array(),
						'ignore'		=> array(),
						'filename'		=> '',
						'format'		=> 'gzip', // gzip, zip, txt
						'add_drop'		=> TRUE,
						'add_insert'	=> TRUE,
						'newline'		=> "\n",
						'extended'		=> false,
						'ifnotexists' 	=> false
					);

		// Did the user submit any preferences? If so set them....
		if (count($params) > 0)
		{
			foreach ($prefs as $key => $val)
			{
				if (isset($params[$key]))
				{
					$prefs[$key] = $params[$key];
				}
			}
		}

		// ------------------------------------------------------

		// Are we backing up a complete database or individual tables?	
		// If no table names were submitted we'll fetch the entire table list
		if (count($prefs['tables']) == 0)
		{
			$prefs['tables'] = $this->db->list_tables();
		}
		
		// ------------------------------------------------------

		// Validate the format
		if ( ! in_array($prefs['format'], array('gzip', 'zip', 'txt'), TRUE))
		{
			$prefs['format'] = 'txt';
		}

		// ------------------------------------------------------

		// Is the encoder supported?  If not, we'll either issue an
		// error or use plain text depending on the debug settings
		if (($prefs['format'] == 'gzip' AND ! @function_exists('gzencode'))
		 OR ($prefs['format'] == 'zip'  AND ! @function_exists('gzcompress')))
		{
			if ($this->db->db_debug)
			{
				return $this->db->display_error('db_unsuported_compression');
			}
		
			$prefs['format'] = 'txt';
		}

		// ------------------------------------------------------

		// Set the filename if not provided - Only needed with Zip files
		if ($prefs['filename'] == '' AND $prefs['format'] == 'zip')
		{
			$prefs['filename'] = (count($prefs['tables']) == 1) ? $prefs['tables'] : $this->db->database;
			$prefs['filename'] .= '_'.date('Y-m-d_H-i', time());
		}

		// ------------------------------------------------------
				
		// Was a Gzip file requested?
		if ($prefs['format'] == 'gzip')
		{
			return gzencode($this->_backup($prefs,$query));
		}

		// ------------------------------------------------------
		
		// Was a text file requested?
		if ($prefs['format'] == 'txt')
		{
			return $this->_backup($prefs,$query);
		}

		// ------------------------------------------------------

		// Was a Zip file requested?		
		if ($prefs['format'] == 'zip')
		{
			// If they included the .zip file extension we'll remove it
			if (preg_match("|.+?\.zip$|", $prefs['filename']))
			{
				$prefs['filename'] = str_replace('.zip', '', $prefs['filename']);
			}
			
			// Tack on the ".sql" file extension if needed
			if ( ! preg_match("|.+?\.sql$|", $prefs['filename']))
			{
				$prefs['filename'] .= '.sql';
			}

			// Load the Zip class and output it
			
			$CI =& get_instance();
			$CI->load->library('zip');
			$CI->zip->add_data($prefs['filename'], $this->_backup($prefs,$query));							
			return $CI->zip->get_zip();
		}
	}
}

/* End of file DB_utility.php */
/* Location: ./system/database/DB_utility.php */