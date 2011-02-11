<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniters Database Driver Class extension
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.2
 * @filesource
 */

if ( ! class_exists('DB_driver'))
{
	require('CI_DB_driver.php');
}

class CI_DB_driver extends DB_driver {
	
	var $skip_errors = FALSE;
	
	/**
	 * Constructor.  Accepts one parameter containing the database
	 * connection settings.
	 *
	 * @param array
	 */	
	function CI_DB_driver($params)
	{
		parent::DB_driver($params);

	}
	
	// --------------------------------------------------------------------

	/**
	 * get_string
	 *
	 * @access	public
	 * @param	string	the table upon which the query will be performed
	 * @param	array	an associative array data of key/values
	 * @param	mixed	the "where" statement
	 * @param	mixed	orderby statement
	 * @param	int		the limit
	 * @return	string		
	 */	
	function f_select($table, $data, $where = '', $extra = array())
	{

		$fields = is_array($data) ? implode(",",$data) : $data;

		if (is_array($where))			
			$filter = implode(" ",$this->parse_where($where));
		elseif($where != '')
			$filter = $this->escape($where);

		if(is_array($table))
			$str = "SELECT ".$fields." FROM ".implode(",",$table);		
		else
			$str = "SELECT ".$fields." FROM ".$table;

		if(isset($filter) && $filter != '') $str .= " WHERE ".$filter;

		if(is_array($extra) && count($extra) > 0)
			$str .= ' '.implode(" ",$extra);
		elseif(!is_array($extra) && $extra != '')
			$str .= ' '.$extra;

		$obj = $this->query($str);
		return $obj;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate an insert string
	 *
	 * @access	public
	 * @param	string	the table upon which the query will be performed
	 * @param	array	an associative array data of key/values
	 * @return	string		
	 */	
	function f_insert($table, $data)
	{
		$fields = array();	
		$values = array();

		foreach($data as  $key => $val)
		{

			if(is_numeric($key)) {

				$tmp = explode("=",$val);
				$fields[] = $this->_escape_identifiers(trim($tmp[0]));
				$values[] = trim($tmp[1]);

			} else {

				$fields[] = $this->_escape_identifiers($key);
				$values[] = $this->escape($val);
			}
		}	
		
		$str =  $this->_insert($table, $fields, $values);
		return $this->query($str);
	}	

	// --------------------------------------------------------------------

	/**
	 * Generate an delete string
	 *
	 * @access	public
	 * @param	string	the table upon which the query will be performed
	 * @param	array	an associative array data of key/values
	 * @param	mixed	the "where" statement
	 * @param	integer	the limit statement
	 * @return	string		
	 */	
	function f_delete($table, $where, $limit = '')
	{
		if ($where == '')
			return false;

		if ( ! is_array($where))
		{
			$where = array($where);
		}
		
		$this->ar_where = $this->parse_where($where);

		$str = $this->_delete($table, $where, array(), $limit);
		return $this->query($str);
	}	
		
	// --------------------------------------------------------------------

	/**
	 * Generate an update string
	 *
	 * @access	public
	 * @param	string	the table upon which the query will be performed
	 * @param	array	an associative array data of key/values
	 * @param	mixed	the "where" statement
	 * @return	string		
	 */	
	function f_update($table, $data, $where)
	{

		if ($where == '')
			return false;
					
		if (is_array($data))			
			$fields = implode(" ",$this->parse_where($data,','));
		elseif($data != '')
			$fields = $this->escape($data);

		if (is_array($where))			
			$dest = implode(" ",$this->parse_where($where));
		elseif($where != '')
			$dest = $this->escape($where);

		$str =  "update ".$table." set ".$fields;
		if($dest != '')
			$str .= " where ".$dest;

		return $this->query($str);
	}
	
	/*** f-mod 
	 * 
	 *	elseif ($val !== '')
	 *	para que f_select acepte string sin $key
	 ***/
	private function parse_where($where, $joinner = ' AND ') {
		
		$dest = array();
		foreach ($where as $key => $val)
		{
			$prefix = (count($dest) == 0) ? '' : $joinner;

			if (is_array($val)) {
			//deprecated
				
				foreach($val as $tabla1=>$tabla2) {
					
					$dest[] = $prefix.$this->_escape_identifiers($tabla1).'='.$this->_escape_identifiers($tabla2);
				}

			} elseif ($val !== '') {
				
				if(is_numeric($key)) {

					//$dest[] = $prefix.$this->escape($val);
					$dest[] = $prefix.$val;
					
				} else if ( ! $this->_has_operator($key)) {
					
					$key = $this->_escape_identifiers($key).' =';
					$val = ' '.$this->escape($val);
					$dest[] = $prefix.$key.$val;

				} else {

					$val = ' '.$this->escape($val);
					$dest[] = $prefix.$key.$val;
				}
				
			//empty values
			} else {
			
				$key = $this->_escape_identifiers($key).' =';
				$val = ' '.$this->escape($val);
				$dest[] = $prefix.$key.$val;
			}	
		}

		return $dest;	
	}
	
	// --------------------------------------------------------------------

	/**
	 * Execute the query
	 *
	 * Accepts an SQL string as input and returns a result object upon
	 * successful execution of a "read" type query.  Returns boolean TRUE
	 * upon successful execution of a "write" type query. Returns boolean
	 * FALSE upon failure, and if the $db_debug variable is set to TRUE
	 * will raise an error.
	 *
	 * @access	public
	 * @param	string	An SQL query string
	 * @param	array	An array of binding data
	 * @return	mixed		
	 */	
	function query($sql, $binds = FALSE, $return_object = TRUE)
	{
		if ($sql == '')
		{
			if ($this->db_debug)
			{
				log_message('error', 'Invalid query: '.$sql);
				return $this->display_error('db_invalid_query');
			}
			return FALSE;
		}

		// Verify table prefix and replace if necessary
		if ( ($this->dbprefix != '' AND $this->swap_pre != '') AND ($this->dbprefix != $this->swap_pre) )
		{			
			$sql = preg_replace("/(\W)".$this->swap_pre."(\S+?)/", "\\1".$this->dbprefix."\\2", $sql);
		}
	
		// Is query caching enabled?  If the query is a "read type"
		// we will load the caching class and return the previously
		// cached query if it exists
		if ($this->cache_on == TRUE AND stristr($sql, 'SELECT'))
		{
			if ($this->_cache_init())
			{
				$this->load_rdriver();
				if (FALSE !== ($cache = $this->CACHE->read($sql)))
				{
					return $cache;
				}
			}
		}

		// Compile binds if needed
		if ($binds !== FALSE)
		{
			$sql = $this->compile_binds($sql, $binds);
		}

		// Save the  query for debugging
		if ($this->save_queries == TRUE)
		{
			$this->queries[] = $sql;
		}

		// Start the Query Timer
		$time_start = list($sm, $ss) = explode(' ', microtime());
	
		// Run the Query
		if (FALSE === ($this->result_id = $this->simple_query($sql)))
		{
	
			if ($this->save_queries == TRUE)
			{
				$this->query_times[] = 0;
			}
		
			// This will trigger a rollback if transactions are being used
			$this->_trans_status = FALSE;

			if ($this->db_debug)
			{
				// grab the error number and message now, as we might run some
				// additional queries before displaying the error
				$error_no = $this->_error_number();
				$error_msg = $this->_error_message();
				
				// We call this function in order to roll-back queries
				// if transactions are enabled.  If we don't call this here
				// the error message will trigger an exit, causing the 
				// transactions to remain in limbo.
				$this->trans_complete();

				if($this->skip_errors == TRUE) {

					return $error_msg;

				} else {

					// Log and display errors
					log_message('error', 'Query error: '.$error_msg);
					return $this->display_error(
											array(
													'Error Number: '.$error_no,
													$error_msg,
													$sql
												)
											);
				}

			}

			return FALSE;
		}
		// Stop and aggregate the query time results
		$time_end = list($em, $es) = explode(' ', microtime());
		$this->benchmark += ($em + $es) - ($sm + $ss);

		if ($this->save_queries == TRUE)
		{
			$this->query_times[] = ($em + $es) - ($sm + $ss);
		}

		// Increment the query counter
		$this->query_count++;
		
		// Was the query a "write" type?
		// If so we'll simply return true
		if ($this->is_write_type($sql) === TRUE)
		{
			// If caching is enabled we'll auto-cleanup any
			// existing files related to this particular URI
			if ($this->cache_on == TRUE AND $this->cache_autodel == TRUE AND $this->_cache_init())
			{
				$this->CACHE->delete();
			}
		
			return TRUE;
		}

		// Return TRUE if we don't need to create a result object
		// Currently only the Oracle driver uses this when stored
		// procedures are used
		if ($return_object !== TRUE)
		{
			return TRUE;
		}
	
		// Load and instantiate the result driver	
		
		$driver 		= $this->load_rdriver();
		$RES 			= new $driver();
		$RES->conn_id	= $this->conn_id;
		$RES->result_id	= $this->result_id;

		if ($this->dbdriver == 'oci8')
		{
			$RES->stmt_id		= $this->stmt_id;
			$RES->curs_id		= NULL;
			$RES->limit_used	= $this->limit_used;
			$this->stmt_id		= FALSE;
		}
		
		// oci8 vars must be set before calling this
		$RES->num_rows	= $RES->num_rows();
				
		// Is query caching enabled?  If so, we'll serialize the
		// result object and save it to a cache file.
		if ($this->cache_on == TRUE AND $this->_cache_init())
		{
			// We'll create a new instance of the result object
			// only without the platform specific driver since
			// we can't use it with cached data (the query result
			// resource ID won't be any good once we've cached the
			// result object, so we'll have to compile the data
			// and save it)
			$CR = new CI_DB_result();
			$CR->num_rows 		= $RES->num_rows();
			$CR->result_object	= $RES->result_object();
			$CR->result_array	= $RES->result_array();
			
			// Reset these since cached objects can not utilize resource IDs.
			$CR->conn_id		= NULL;
			$CR->result_id		= NULL;

			$this->CACHE->write($sql, $CR);
		}
		
		return $RES;
	}
}

/* End of file DB_driver.php */
/* Location: ./system/database/DB_driver.php */