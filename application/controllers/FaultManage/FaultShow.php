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
        $this->load->view('faultShow/fault_management',$data);
    }

    public function detailInfo($fault_id)
    {
        $data['fault'] = $this->Fault_status_model->get_info_of_each_status($fault_id)->row();
        $this->load->view('faultShow/fault_search_view',$data);
    }

    public function showStatistic()
    {
        $this->load->view('faultShow/fault_stat');
    }


    public function search()
    {
        if ($_POST['search'] == '') {
            redirect('FaultManage/FaultShow');
        } else {
            $data['all_fault'] = $this->Fault_basic_model->search($_POST['search']);
            $this->load->view('faultShow/fault_management', $data);
        }
    }
}
