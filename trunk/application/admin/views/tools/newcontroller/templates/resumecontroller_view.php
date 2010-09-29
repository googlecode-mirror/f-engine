php
class <?php echo $classname;?> extends Controller {

	function <?php echo $classname;?>() {

		parent::Controller();
		$this->load->helper('url');
	}

	function index() {

		$this->load->database();
		
		<?php if(isset($where)) { echo '$where = '.$where."\r\n"; } ?>
		$content = $this->db->f_select(array('<?php echo implode("','",$dbs);?>'),
		'<?php echo implode(", ",$data);?>'<?php if(isset($where)) { echo ',$where'; } ?>)->result();

		$data = array(
<?php foreach($assets as $key => $val) {
			echo "\t\t\t'".$key."' => array(".$val."),\r\n";
 } ?>
			'content'=>$content
		); 
		$this->load->masterview('<?php echo $vpath;?>/datagrid', $data, "default");
	}
}