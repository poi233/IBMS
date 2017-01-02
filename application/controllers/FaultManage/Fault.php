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
    }

    public function index()
    {
        $this->load->view('faultSystem/fault_mine');
    }

    public function choose_status($fault_id)
    {
        $status = $this->Fault_basic_model->get_fault($fault_id)->row()->fault_status;
        switch($status)
        {
            case 0:
                redirect('FaultManage/Fault/driftFault/'.$fault_id);
                break;
            case 1:
                redirect('FaultManage/Fault/checkFault/'.$fault_id);
                break;
            case 2:
                redirect('FaultManage/Fault/locateFault/'.$fault_id);
                break;
            case 3:
                redirect('FaultManage/Fault/modifyFault/'.$fault_id);
                break;
            case 7:
                redirect('FaultManage/Fault/checkFaultFail/'.$fault_id);
                break;
            case 8:
                redirect('FaultManage/Fault/hangFault/'.$fault_id);
            case 9:
                redirect('FaultManage/Fault/locateFaultFail/'.$fault_id);
                break;
            default:
                return;
        }
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
            'checker_id' => $_POST['checkerID'],
            'creator_id' => $this->session->userdata('user_id')
        );
        $this->Fault_basic_model->insert_fault_basic($data);
    }

    public function driftFault($fault_id)
    {
        $data['user'] = $this->User_model->get_all_authority_user();
        $data['project'] = $this->Project_model->get_all();
        $data['fault'] = $this->Fault_status_model->get_info_of_each_status($fault_id)->row();
        $this->load->view('faultSystem/fault_drift',$data);
    }

    public function driftFaultSend()
    {
        if($_POST['faultStatus']==2)
        {
            $this->Fault_basic_model->delete_basic($_POST['faultID']);
            return;
        }
        $data=array(
            'fault_id' => $_POST['faultID'],
            'fault_level' => $_POST['faultLevel'],
            'fault_detail' => $_POST['faultDetail'],
            'fault_reappear_info' => $_POST['faultReappearInfo'],
            'project_id' => $_POST['projectID'],
            'fault_status' => $_POST['faultStatus'],
            'checker_id' => $_POST['checkerID']
        );
        $this->Fault_basic_model->update_basic($data);
    }

    public function checkFault($fault_id)
    {
        $data['user'] = $this->User_model->get_all_authority_user();
        $data['fault'] = $this->Fault_status_model->get_info_of_each_status($fault_id)->row();
        $this->load->view('faultSystem/fault_check',$data);
    }

    public function checkFaultSend()
    {
        $status = $_POST['faultStatus'];
        $basic_update = array(
            'fault_id' => $_POST['faultID'],
            'fault_status' => $_POST['faultStatus']
        );
        switch($status)
        {
            case 2:
                $data2=array(
                    'fault_id'=>$_POST['faultID'],
                    'locator_id'=>$_POST['locatorID'],
                    'modifier_id'=>$_POST['modifierID'],
                );
                $this->Fault_basic_model->insert_fault_check($data2);
                break;
            case 7:
                $data7=array(
                    'fault_id'=>$_POST['faultID'],
                    'error_info'=>$_POST['errorInfo']
                );
                $this->Fault_basic_model->handle_error($data7);
                break;
            case 8:
                break;
        }
        $this->Fault_basic_model->update_basic($basic_update);
    }

    public function checkFaultFail($fault_id)
    {
        $data['user'] = $this->User_model->get_all_authority_user();
        $data['project'] = $this->Project_model->get_all();
        $data['fault'] = $this->Fault_status_model->get_info_of_each_status($fault_id)->row();
        $this->load->view('faultSystem/fault_check_fail',$data);
    }

    public function checkFaultFailSend()
    {
        if($_POST['faultStatus']==2)
        {
            $this->Fault_basic_model->delete_basic($_POST['faultID']);
            return;
        }
        $data=array(
            'fault_id' => $_POST['faultID'],
            'fault_level' => $_POST['faultLevel'],
            'fault_detail' => $_POST['faultDetail'],
            'fault_reappear_info' => $_POST['faultReappearInfo'],
            'project_id' => $_POST['projectID'],
            'fault_status' => $_POST['faultStatus'],
            'checker_id' => $_POST['checkerID']
        );
        $this->Fault_basic_model->update_basic($data);
    }

    public function hangFault($fault_id)
    {
        $data['fault'] = $this->Fault_status_model->get_info_of_each_status($fault_id)->row();
        $this->load->view('faultSystem/fault_hang',$data);

    }

    public function locateFault($fault_id)
    {
        $data['fault'] = $this->Fault_status_model->get_info_of_each_status($fault_id)->row();
        $data['user'] = $this->User_model->get_all_authority_user();
        $data['subsystem'] = $this->Project_model->get_all_subsystem($data['fault']->project_id);
        $this->load->view('faultSystem/fault_locate',$data);
    }

    public function locateFaultSend()
    {
        $status = $_POST['faultStatus'];
        $basic_update = array(
            'fault_id' => $_POST['faultID'],
            'fault_status' => $_POST['faultStatus']
        );
        switch($status)
        {
            case 3:
                $data3=array(
                    'fault_id'=>$_POST['faultID'],
                    'fault_subsystem'=>$_POST['faultSubsystem'],
                    'fault_locate_detail'=>$_POST['faultLocateDetail']
                );
                $this->Fault_basic_model->insert_fault_locate($data3);
                break;
            case 9:
                $data9=array(
                    'fault_id'=>$_POST['faultID'],
                    'error_info'=>$_POST['errorInfo']
                );
                $this->Fault_basic_model->handle_error($data9);
                break;
        }
        $this->Fault_basic_model->update_basic($basic_update);
    }

    public function locateFaultFail($fault_id)
    {
        $data['user'] = $this->User_model->get_all_authority_user();
        $data['fault'] = $this->Fault_status_model->get_info_of_each_status($fault_id)->row();
        $this->load->view('faultSystem/fault_locate_fail',$data);
    }

    public function locateFaultFailSend()
    {
        $status = $_POST['faultStatus'];
        $basic_update = array(
            'fault_id' => $_POST['faultID'],
            'fault_status' => $_POST['faultStatus']
        );
        switch($status)
        {
            case 2:
                $data2=array(
                    'fault_id'=>$_POST['faultID'],
                    'locator_id'=>$_POST['locatorID'],
                );
                $this->Fault_basic_model->update_check($data2);
                break;
            case 7:
                $data7=array(
                    'fault_id'=>$_POST['faultID'],
                    'error_info'=>$_POST['errorInfo']
                );
                $this->Fault_basic_model->handle_error($data7);
                break;
            case 8:
                break;
        }
        $this->Fault_basic_model->update_basic($basic_update);
    }

    public function modifyFault($fault_id)
    {
        $data['fault'] = $this->Fault_status_model->get_info_of_each_status($fault_id)->row();
        $this->load->view('faultSystem/fault_modify',$data);
    }

    public function modifyFaultSend()
    {

    }




}