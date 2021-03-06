<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
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

/**
 * F-engine: Added backup feature
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.3
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * MySQLi Utility Class
 *
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */

require('ci_mysqli_utility.php');
class CI_DB_mysqli_utility extends DB_mysqli_utility {

	// --------------------------------------------------------------------
	/**
	 * MySQL Export
	 *
	 * @access	private
	 * @param	array	Preferences
	 * @return	mixed
	 */
	function _backup($params = array(),$sql='')
	{
		if (count($params) == 0)
		{
			return FALSE;
		}

		// Extract the prefs for simplicity
		extract($params);
	
		// Build the output
		$output = '';
		foreach ((array)$tables as $table)
		{
			// Is the table in the "ignore" list?
			if (in_array($table, (array)$ignore, TRUE))
			{
				continue;
			}

			// Get the table schema
			$query = $this->db->query("SHOW CREATE TABLE `".$this->db->database.'`.'.$table);
			
			// No result means the table name was invalid
			if ($query === FALSE)
			{
				continue;
			}
			
			// Write out the table schema
			$output .= '#'.$newline.'# TABLE STRUCTURE FOR: '.$table.$newline.'#'.$newline.$newline;

 			if ($add_drop == TRUE)
 			{
				$output .= 'DROP TABLE IF EXISTS '.$table.';'.$newline.$newline;
			}
			
			$i = 0;
			$result = $query->result_array();

			$is_view = false;
			foreach ($result[0] as $key=>$val)
			{
				if(in_array($key, array("character_set_client","collation_connection"))) {

					continue;
				}

				if(strpos($val,"CREATE ALGORITHM") !== false) {

					$val = preg_replace("/ALGORITHM.*DEFINER/","",$val);
					$is_view = true;
				}

				if ($i++ % 2)
				{
					if(isset($ifnotexists) and $ifnotexists == true)
						$output .= str_replace("`$table`","IF NOT EXISTS `$table` ",$val).';'.$newline.$newline;
					else
						$output .= $val.';'.$newline.$newline;
				}
			}

			// If inserts are not needed we're done...
			if ($add_insert == FALSE or $is_view)
			{
				continue;
			}

			// Grab all the data from the current table
			if($sql != '')
				$query = $this->db->query($sql);
			else
				$query = $this->db->query("SELECT * FROM $table");
			
			if ($query->num_rows() == 0)
			{
				continue;
			}

			// Fetch the field names and determine if the field is an
			// integer type.  We use this info to decide whether to
			// surround the data with quotes or not

			$i = 0;
			$field_str = '';
			$is_int = array();

			while ($field = mysqli_fetch_field($query->result_id))
			{
				// Most versions of MySQL store timestamp as a string
				// More info: http://www.php.net/manual/en/mysqli.constants.php
				$is_int[$i] = (in_array($field->type,
								array(MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_INT24, MYSQLI_TYPE_LONG, MYSQLI_TYPE_LONGLONG), 
										TRUE)
										) ? TRUE : FALSE;
										
				// Create a string of field names
				$field_str .= '`'.$field->name.'`, ';
				$i++;
			}

			// Trim off the end comma
			$field_str = preg_replace( "/, $/" , "" , $field_str);
			
			
			// Build the insert string
			$kont = 0;
			foreach ($query->result_array() as $row) {

				$val_str = '';

				$i = 0;
				foreach ($row as $v)
				{
					// Is the value NULL?
					if ($v === NULL)
					{
						$val_str .= 'NULL';
					}
					else
					{
						// Escape the data if it's not an integer
						if ($is_int[$i] == FALSE)
						{
							$val_str .= $this->db->escape($v);
						}
						else
						{
							$val_str .= $v;
						}					
					}					

					// Append a comma
					$val_str .= ', ';
					$i++;
				}

				// Remove the comma at the end of the string
				$val_str = preg_replace( "/, $/" , "" , $val_str);

				// Build the INSERT string
				if(isset($extended) and $extended == true) {

					if($kont == 0) {

						$output .= $newline.'INSERT INTO '.$table.' ('.$field_str.') VALUES '.$newline.'('.$val_str.')';

					} elseif($kont % 25 == 0) {

						$output .= ';'.$newline.$newline.'INSERT INTO '.$table.' ('.$field_str.') VALUES '.$newline.'('.$val_str.')';

					} else {

						$output .= ','.$newline.'('.$val_str.')';
					}

					$kont++;

				} else {

					$output .= 'INSERT INTO '.$table.' ('.$field_str.') VALUES '.$newline.'('.$val_str.');'.$newline;
				}
			}

			if(isset($extended) and $extended == true and substr($output,-1) == ")") {

				$output .= ';';
			}

			$output .= $newline.$newline;
		}

		return $output;
	}
}

/* End of file mysqli_utility.php */
/* Location: ./system/database/drivers/mysqli/mysqli_utility.php */