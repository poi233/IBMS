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

    public function get_all()
    {
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->get();
        return $res;
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
        $where = '(fault_status=0 OR fault_status=5 OR fault_status=6 OR fault_status=7) AND creator_id= ';
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->where($where,$session_id)
            //->where('creator_id',$session_id)
            ->get();
        return $res;
    }

    public function checker_get_info($session_id)
    {
        $where = '(fault_status=1 OR fault_status=8 OR fault_status=9) AND checker_id= ';
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->where($where, $session_id)
            ->get();
        return $res;
    }

    public function locator_get_info($session_id)
    {
        $where = '(fault_status=2 or fault_status=10) AND locator_id=';
        $res = $this->db
            ->select('*')
            ->from('fault_check')
            ->join('fault_basic','fault_check.fault_id=fault_basic.fault_id')
            ->where($where, $session_id)
            ->get();
        return $res;
    }

    public function modifier_get_info($session_id)
    {
        $where = '(fault_status=3 OR fault_status=11) and modifier_id=';
        $res = $this->db
            ->select('*')
            ->from('fault_check')
            ->join('fault_basic','fault_check.fault_id=fault_basic.fault_id')
            ->where($where, $session_id)
            ->get();
        return $res;
    }

    public function validator_get_info($session_id)
    {
        $where = 'fault_status=4 AND validator_id=';
        $res = $this->db
            ->select('*')
            ->from('fault_modify')
            ->join('fault_basic','fault_modify.fault_id=fault_basic.fault_id')
            ->where($where, $session_id)
            ->get();
        return $res;
    }


    public function insert_fault_basic($data)
    {
        $this->db->insert('fault_basic',$data);
    }

    public function update_fault_basic($data)
    {
        $this->db->update('fault_basic',$data,array('fault_id' => $data['fault_id']));
    }

    public function handle_fault_check($data)
    {

        $res = $this->db
            ->select('*')
            ->from('fault_check')
            ->where('fault_id',$data['fault_id'])
            ->get();
        if ($res->num_rows() == 0)
            $this->db->insert('fault_check',$data);
        else
            $this->db->update('fault_check',$data,array('fault_id' => $data['fault_id']));
    }

    public function handle_fault_locate($data)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_locate')
            ->where('fault_id',$data['fault_id'])
            ->get();
        if ($res->num_rows() == 0)
            $this->db->insert('fault_locate',$data);
        else
            $this->db->update('fault_locate',$data,array('fault_id' => $data['fault_id']));
    }

    public function handle_fault_modify($data)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_modify')
            ->where('fault_id',$data['fault_id'])
            ->get();
        if ($res->num_rows() == 0)
            $this->db->insert('fault_modify',$data);
        else
            $this->db->update('fault_modify',$data,array('fault_id' => $data['fault_id']));
    }

    public function handle_fault_validation($data)
    {
        $res = $this->db
            ->select('*')
            ->from('fault_validation')
            ->where('fault_id',$data['fault_id'])
            ->get();
        if ($res->num_rows() == 0)
            $this->db->insert('fault_validation',$data);
        else
            $this->db->update('fault_validation',$data,array('fault_id' => $data['fault_id']));
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
            $this->db->update('fault_error',$data,array('fault_id' => $data['fault_id']));
    }

    public function delete_basic($fault_id)
    {
        $this->db->delete('fault_basic', array('fault_id' => $fault_id));
    }

    public function search($search)
    {
        $like_array = array(
            'fault_basic.project_id' => $search,
            'user.user_account' => $search,
        );
        $res = $this->db
            ->select('*')
            ->from('fault_basic')
            ->join('user','fault_basic.creator_id=user.user_id')
            ->or_like($like_array)
            ->get();
        return $res;
    }

}