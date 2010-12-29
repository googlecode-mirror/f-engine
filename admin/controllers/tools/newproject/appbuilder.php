<?php
/**
 * App creator
 *
 * @package		F-engine
 * @author		flmn
 * @copyright	Copyright (c) 2010, Mikel Madariaga
 * @license		http://www.f-engine.net/userguide/license
 * @link		http://www.f-engine.net/
 * @since		Version 0.1
 * @filesource
 */
class appbuilder extends CI_Controller {

	private $xml;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('directory'); 
		$this->load->helper(array('xml','file'));
		
		$this->path = array(APPPATH.'../base/');

	}
	
	function index()
	{

		$this->xml = new XmlWriter();
		$this->xml->openMemory();
		$this->xml->setIndent(true);
		$this->xml->startElement('app');

		$this->fill_xml(directory_map(BASEPATH.'application/base'));

		$this->xml->endElement();
		header ("Content-Type:text/xml");
		print '<?xml version="1.0" encoding="utf-8"?>'."\n".$this->xml->outputMemory();
	}
	
	function fill_xml($files) {

		foreach ($files as $name => $file) {

			//directory
			if(is_array($file)) {

				$this->xml->startElement('dir');
					$this->xml->startAttribute("name");
					$this->xml->text($name);
					$this->xml->endAttribute();

					$this->path[] = $name; 
						$this->fill_xml($file);
					array_pop($this->path);

			    $this->xml->endElement();

			//file
			} else {

				$this->xml->startElement('file');
					$this->xml->startAttribute("name");
					$this->xml->text($file);
					$this->xml->endAttribute();
					
					$fcontent = read_file(implode("/",$this->path).'/'.$file); 
					$this->xml->writeCData(base64_encode($fcontent));

			    $this->xml->endElement();
			}
		}

	}
}