php
class <?php echo $classname;?> extends Controller {

	function <?php echo $classname;?>() {

		parent::Controller();
		$this->load->helper('url');
		$this->load->library('pagination'); 
	}

	function index($current_page = 0) {

		$this->load->database();

		/*** get records ***/
		<?php if(isset($where)) { echo '$where = '.$where."\r\n"; } ?>
		$extra = "limit $current_page,20";
		$content = $this->db->f_select(array('<?php echo implode("','",$dbs);?>'),
		'<?php echo implode(", ",$data);?>'<?php if(isset($where)) { echo ',$where'; } ?>,$extra)->result();

		/*** set pagination ***/
		$config['base_url'] = site_url("<?php echo $vpath;?>");
		$config['total_rows'] = $this->db->f_select(array('<?php echo implode("','",$dbs);?>'),'count(*) as itemNum'<?php if(isset($where)) { echo ',$where'; } ?>)->row()->itemNum;
		$config['per_page'] = '20';
		$config['uri_segment'] = <?php echo substr_count($vpath, "/") + 2; ?>;

		$this->pagination->initialize($config); 

		/*** load view ***/
		$data = array(
<?php foreach($assets as $key => $val) {
			echo "\t\t\t'".$key."' => array(".$val."),\r\n";
 } ?>
			'content' => $content,
			'pagination' => $this->pagination->create_links() 
		); 
		$this->load->masterview('<?php echo $vpath;?>/datagrid', $data, "<?php echo $masterview;?>");
	}
}