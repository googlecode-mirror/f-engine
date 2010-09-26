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
}

/* End of file DB_driver.php */
/* Location: ./system/database/DB_driver.php */