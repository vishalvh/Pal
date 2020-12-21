<?php
class Report extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
    function index() {
		$this->load->model('expense_model');
		$c_id = $this->input->get('company_id');
		$data['location'] = $this->expense_model->master_fun_get_tbl_val_location('sh_location', array('status' => 1, 'company_id' => $c_id));
		$this->load->view('report/pettycash',$data);
    }
}
?>