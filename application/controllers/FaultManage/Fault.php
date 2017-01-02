<?php
/**
 * Created by PhpStorm.
 * User: j
 * Date: 2016/12/25
 * Time: 22:58
 */
class Fault extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Fault_basic_model');
        $this->load->model('Fault_status_model');
    }

    public function index()
    {
        $this->load->view('faultSystem/fault_management');
    }

    public function addFault()
    {
        $this->load->view('faultSystem/fault_basic');
    }

    public function addFaultSend()
    {
        $data=array(
            'fault_level' => $_POST['fault_level'],
            'fault_detail' => $_POST['fault_detail'],
            'fault_reappear_info' => $_POST['fault_reappear_info'],
            'project_id' => $_POST['project_id'],
            'fault_status' => $_POST['fault_status'],
            'checker_id' => $_POST['checker_id'],
            'creator_id' => $this->session->userdata('user_id'),
        );
        $this->Fault_basic_model->insert_fault_basic($data);
    }


}