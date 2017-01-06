<?php
/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2017/1/6
 * Time: 19:08
 */
class FaultShow extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['all_fault'] = $this->Fault_basic_model->get_all();
        $this->load->view('faultSystem/fault_management');
    }

    public function search()
    {
        if ($_POST['search'] == '') {
            redirect('FaultManage/FaultShow');
        } else {
            $data['all_fault'] = $this->Fault_basic_model->search($_POST['search']);
            $this->load->view('faultSystem/fault_management', $data);
        }
    }
}
