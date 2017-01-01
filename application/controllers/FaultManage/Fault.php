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
        $data['user'] = $this->User_model->get_all_authority_user();
        $data['project'] = $this->Project_model->get_all();
        $this->load->view('faultSystem/fault_basic',$data);
    }

    public function addFaultSend()
    {
        $data=array(
            'fault_level' => $_POST['faultLevel'],
            'fault_detail' => $_POST['faultDetail'],
            'fault_reappear_info' => $_POST['faultReappearInfo'],
            'project_id' => $_POST['projectID'],
            'fault_status' => $_POST['faultStatus'],
            'checker_id' => $_POST['checkID'],
            'creator_id' => $this->session->userdata('user_id'),
        );
        $this->Fault_basic_model->insert_fault_basic($data);
    }

    public function checkFault($fault_id)
    {
        $status = $this->Fault_basic_model->get_fault_status($fault_id);
        $data['fault'] = $this->Fault_status_model->get_info_by_status($fault_id,$status);
        $this->load->view('faultSystem/fault_check',$data);
    }

    public function checkFaultSend()
    {

    }




}