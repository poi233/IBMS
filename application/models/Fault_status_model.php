<?php
/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/30
 * Time: 18:15
 */
class Fault_status_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Fault_basic_model');
    }

    public function get_info_of_each_status($fault_id)
    {
        $status = $this->Fault_basic_model->get_fault($fault_id)->row()->fault_status;
        switch ($status) {
            case 0:
                return $this->get_drift_info($fault_id);
            case 1:
                return $this->get_check_info($fault_id);
            case 2;
                return $this->get_locate_info($fault_id);
            case 3:
                return $this->get_modify_info($fault_id);
            case 4:
                return $this->get_validation_info($fault_id);
            case 5:
                return $this->get_to_complete_info($fault_id);
            case 6:
                return $this->get_complete_info($fault_id);
            case 7:
                return $this->get_check_fail_info($fault_id);
            case 8:
                return $this->get_hang_info($fault_id);
            case 9:
                return $this->get_locate_fail_info($fault_id);
            case 10:
                return $this->get_modify_fail_info($fault_id);
            case 11:
                return $this->get_validation_fail_info($fault_id);
            default:
                return false;
        }
    }

    public function get_drift_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->where('fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_check_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->where('fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_locate_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('fault_check', 'fault_basic.fault_id=fault_check.fault_id')
            ->where('fault_basic.fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_modify_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('fault_locate', 'fault_basic.fault_id=fault_locate.fault_id')
            ->where('fault_basic.fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_validation_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('fault_check', 'fault_basic.fault_id=fault_check.fault_id')
            ->join('fault_locate', 'fault_basic.fault_id=fault_locate.fault_id')
            ->join('fault_modify', 'fault_basic.fault_id=fault_modify.fault_id')
            ->where('fault_basic.fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_to_complete_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('fault_check', 'fault_basic.fault_id=fault_check.fault_id')
            ->join('fault_locate', 'fault_basic.fault_id=fault_locate.fault_id')
            ->join('fault_modify', 'fault_basic.fault_id=fault_modify.fault_id')
            ->join('fault_validation', 'fault_basic.fault_id=fault_validation.fault_id')
            ->where('fault_basic.fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_complete_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('fault_check', 'fault_basic.fault_id=fault_check.fault_id')
            ->join('fault_locate', 'fault_basic.fault_id=fault_locate.fault_id')
            ->join('fault_modify', 'fault_basic.fault_id=fault_modify.fault_id')
            ->join('fault_validation', 'fault_basic.fault_id=fault_validation.fault_id')
            ->where('fault_basic.fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_check_fail_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('fault_error','fault_basic.fault_id=fault_error.fault_id')
            ->where('fault_basic.fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_hang_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->where('fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_locate_fail_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('fault_error','fault_basic.fault_id=fault_error.fault_id')
            ->join('fault_check', 'fault_basic.fault_id=fault_check.fault_id')
            ->where('fault_basic.fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_modify_fail_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('fault_error','fault_basic.fault_id=fault_error.fault_id')
            ->join('fault_check', 'fault_basic.fault_id=fault_check.fault_id')
            ->where('fault_basic.fault_id', $fault_id)
            ->get();
        return $res;
    }

    public function get_validation_fail_info($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('fault_error','fault_basic.fault_id=fault_error.fault_id')
            ->join('fault_locate', 'fault_basic.fault_id=fault_locate.fault_id')
            ->where('fault_basic.fault_id', $fault_id)
            ->get();
        return $res;
    }

}