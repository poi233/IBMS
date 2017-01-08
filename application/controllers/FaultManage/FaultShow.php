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
        $data['barData'] = null;
        $data['xy'] = null;
        $data['project'] = $this->Project_model->get_all();
        $data['type']=array(
            'type' => -1
        );
        $this->load->view('faultShow/fault_stat',$data);
    }

    public function generateStat()
    {
        $project_id = $_POST['projectID'];
        switch($_POST['type']) {
            case 0:
                $data['barData'] = $this->Fault_basic_model->get_creator_stat($project_id);
                $data['xy'] = array(
                  'x'=>'创建人',
                  'y'=>'缺陷个数'
                );
                $data['type']=array(
                    'type' => 0
                );
                break;
            case 1:
                $data['barData'] = $this->Fault_basic_model->get_level_stat($project_id);
                $data['xy'] = array(
                    'x'=>'缺陷级别',
                    'y'=>'缺陷个数'
                );
                $data['type']=array(
                    'type' => 1
                );
                break;
            case 2:
                $data['barData'] = $this->Fault_basic_model->get_status_stat($project_id);
                $data['xy'] = array(
                    'x'=>'缺陷状态',
                    'y'=>'缺陷个数'
                );
                $data['type']=array(
                    'type' => 2
                );
                break;
            default:
                $data['barData'] = null;
                $data['xy'] = null;
                break;
        }
        $data['project'] = $this->Project_model->get_all();
        $this->load->view('faultShow/fault_stat',$data);
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
