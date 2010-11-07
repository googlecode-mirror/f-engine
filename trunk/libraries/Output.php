<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * F-engine
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.5
 * @filesource
 */
require('CI_Output.php');
class CI_Output extends Output {
	
	// --------------------------------------------------------------------
	
	/**
	 * Display Output
	 *
	 * All "view" data is automatically put into this variable by the controller class:
	 *
	 * $this->final_output
	 *
	 * This function sends the finalized output data to the browser along
	 * with any server headers and profile data.  It also stops the
	 * benchmark timer so the page rendering speed and memory usage can be shown.
	 *
	 * @access	public
	 * @return	mixed
	 */		
	function _display($output = '')
	{	
		// Note:  We use globals because we can't use $CI =& get_instance()
		// since this function is sometimes called by the caching mechanism,
		// which happens before the CI super object is available.
		global $BM, $CFG;
		
		// --------------------------------------------------------------------
		
		// Set the output data
		if ($output == '')
		{
			$output =& $this->final_output;
		}
		
		// --------------------------------------------------------------------
		
		// Do we need to write a cache file?
		if ($this->cache_expiration > 0)
		{
			$this->_write_cache($output);
		}
		
		// --------------------------------------------------------------------

		// Parse out the elapsed time and memory usage,
		// then swap the pseudo-variables with the data

		$elapsed = $BM->elapsed_time('total_execution_time_start', 'total_execution_time_end');		
		$output = str_replace('{elapsed_time}', $elapsed, $output);
		
		$memory	 = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
		$output = str_replace('{memory_usage}', $memory, $output);		

		// --------------------------------------------------------------------
		
		// Is compression requested?
		if ($CFG->item('compress_output') === TRUE)
		{
			if (extension_loaded('zlib'))
			{
				if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) AND strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE)
				{
					ob_start('ob_gzhandler');
				}
			}
		}

		// --------------------------------------------------------------------
		
		// Are there any server headers to send?
		if (count($this->headers) > 0)
		{
			foreach ($this->headers as $header)
			{
				@header($header[0], $header[1]);
			}
		}		

		// --------------------------------------------------------------------
		
		// Does the get_instance() function exist?
		// If not we know we are dealing with a cache file so we'll
		// simply echo out the data and exit.
		if ( ! function_exists('get_instance'))
		{
			echo $output;
			log_message('debug', "Final output sent to browser");
			log_message('debug', "Total execution time: ".$elapsed);
			return TRUE;
		}
	
		// --------------------------------------------------------------------

		// Grab the super object.  We'll need it in a moment...
		$CI =& get_instance();
		
		// Do we need to generate profile data?
		// If so, load the Profile class and run it.
		if ($this->enable_profiler == TRUE)
		{
			$CI->load->library('profiler');				
										
			// If the output data contains closing </body> and </html> tags
			// we will remove them and add them back after we insert the profile data
			if (preg_match("|</body>.*?</html>|is", $output))
			{
				$output  = preg_replace("|</body>.*?</html>|is", '', $output);
				if(!defined('MASTERVIEW') and isset($CI->ajax)) {
					$output .= $CI->ajax->getString();
				}
				$output .= $CI->profiler->run();
				$output .= '</body></html>';
			}
			else
			{
				if(!defined('MASTERVIEW') and isset($CI->ajax) and $CI->ajax->itemNum() > 0) {
					$output .= $CI->ajax->getString();
				}
				$output .= $CI->profiler->run();
			}
			
		} else {
		
			if(!defined('MASTERVIEW') and isset($CI->ajax) and $CI->ajax->itemNum() > 0) {

				if (preg_match("|</body>.*?</html>|is", $output))
				{
					$output  = preg_replace("|</body>.*?</html>|is", '', $output);
					$output .= $CI->ajax->getString();
					$output .= '</body></html>';

				} else {

					$output .= $CI->ajax->getString();
				}
			}
		}
		
		// --------------------------------------------------------------------

		// Does the controller contain a function named _output()?
		// If so send the output there.  Otherwise, echo it.
		if (method_exists($CI, '_output'))
		{
			$CI->_output($output);
		}
		else
		{
			echo $output;  // Send it to the browser!
		}
		
		log_message('debug', "Final output sent to browser");
		log_message('debug', "Total execution time: ".$elapsed);		
	}
	
}