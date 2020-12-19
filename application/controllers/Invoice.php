<?php
class Invoice extends CI_Controller {
function __construct() {
	parent::__construct();
}
function index() {
$id = $this->uri->segment('2');
$this->load->model("service_model_1");
$data = $this->service_model_1->select_all('sh_cutomer_invoce',array('id'=>$id));
redirect('credit_debit/print_invoice_pdf?sdate='.$data[0]->sdate.'&edate='.$data[0]->edate.'&lid='.$data[0]->location_fk.'&Employeename='.$data[0]->cust_fk.'&bildate='.$data[0]->bill_date);

}

}
?>