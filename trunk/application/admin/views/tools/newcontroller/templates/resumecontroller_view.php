php
class <?php echo $classname;?> extends Controller {

	function <?php echo $classname;?>() {

		parent::Controller();
		$this->load->helper('url');
	}

	function index() {

		$this->load->database();

		$content = $this->db->f_select(array('<?php echo implode("','",$dbs);?>'),<?php echo "\r\n\t\t'".implode(", ",$data);?>')->result();

		$data = array(
<?php foreach($assets as $key => $val) {
			echo "\t\t\t'".$key."' => array(".$val."),\r\n";
 } ?>
			'content'=>$content
		); 
		$this->load->masterview('<?php echo $vpath;?>/datagrid', $data, "default");
	}
}