<?php
/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2017/1/1
 * Time: 15:17
 */
class Fault_basic_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function get_fault($fault_id)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->where('fault_id',$fault_id)
            ->get();
        return $res;
    }

    public function creator_get_info($session_id)
    {
        $where = 'fault_status=0 OR fault_status=5 OR fault_status=6';
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->where('creator_id',$session_id)
            ->where($where)
            ->get();
        return $res;
    }

    public function checker_get_info($session_id)
    {
        $where = 'fault_status=1 OR fault_status=8 OR fault_status=9 OR fault_status=10 OR fault_status=7';
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->where('checker_id', $session_id)
            ->wehre($where)
            ->get();
        return $res;
    }

    public function locator_get_info($session_id)
    {
        $where = 'fault_status=2 or fault_status=11';
        $res = $this->db
            ->select('*')
            ->from('fault_check')
            ->join('fault_basic','fault_check.fault_id=fault_basic.fault_id')
            ->where('checker_id', $session_id)
            ->wehre($where)
            ->get();
        return $res;
    }

    public function modifier_get_info($session_id)
    {
        $where = 'fault_status=3 OR fault_status=12';
        $res = $this->db
            ->select('*')
            ->from('fault_check')
            ->join('fault_basic','fault_check.fault_id=fault_basic.fault_id')
            ->where('modifier_id', $session_id)
            ->wehre($where)
            ->get();
        return $res;
    }

    public function validator_get_info($session_id)
    {
        $where = 'fault_status=4';
        $res = $this->db
            ->select('*')
            ->from('fault_modify')
            ->join('fault_basic','fault_modify.fault_id=fault_basic.fault_id')
            ->where('validator_id', $session_id)
            ->wehre($where)
            ->get();
        return $res;
    }



    public function insert_fault_basic($data)
    {
        $this->db->insert('fault_basic',$data);
    }

    public function insert_fault_check($data)
    {
        $this->db->insert('fault_check',$data);
    }

    public function insert_fault_locate($data)
    {
        $this->db->insert('fault_locate',$data);
    }

    public function insert_fault_modify($data)
    {
        $this->db->insert('fault_modify',$data);
    }

    public function insert_fault_validation($data)
    {
        $this->db->insert('fault_validation',$data);
    }

    public function insert_fault_transfer($data)
    {
        $this->db->insert('fault_transfer',$data);
    }

    public function handle_error($data)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_error')
            ->where('fault_id',$data['fault_id'])
            ->get();
        if ($res->num_rows() == 0)
            $this->db->insert('fault_error',$data);
        else
            $this->db->update('fault_error',$data);
    }

    public function update_basic($data)
    {
        $this->db->update('fault_basic',$data,array('fault_id' => $data['fault_id']));
    }

    public function delete_basic($fault_id)
    {
        $this->db->delete('fault_basic', array('fault_id' => $fault_id));
    }


}