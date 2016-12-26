<?php
/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/22
 * Time: 23:40
 */
class User_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    public function get_all()
    {
        $res = $this->db
            ->select('*')
            ->from('user')
            ->get();
        return $res;
    }

    public function get_all_info($user_id)
    {
        $res = $this->db
            ->select('*')
            ->from('user')
            ->join('user_project','user.user_id=user_project.user_id')
            ->where('user.user_id',$user_id)
            //->order_by('add_time', 'DESC')
            ->get();
        return $res;
    }


    public function get_by_id($id)
    {
        $res = $this->db->get_where('user', array('user_id' => $id));
        return $res;
    }

    public function get_by_account($account)
    {
        $result = $this->db->get_where('user', array('user_account' => $account));
        return $result;
    }

    public function insert($data)
    {
        return $this->db->insert('user', $data);
    }

    public function delete($id)
    {
        $this->db->delete('user', array('user_id' => $id));
    }

    public function update($data)
    {
        $this->db->update('user', $data, array('user_id' => $data['user_id']));
    }

    public function to_login($user_account)
    {
        $row=$this->User_model->get_by_account($user_account)->row();
        $this->session->set_userdata('user_id', $row->user_id);
        $this->session->set_userdata('user_account', $row->user_account);
        $this->session->set_userdata('user_authority', $row->user_authority);
        $current = time();
        $this->session->set_userdata('lastActiveTime', $current);
    }

    public function login_authorize()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            return FALSE;
        }
        $current = time();
        $lastActiveTime = $this->session->userdata('lastActiveTime');
        $timeSpan = $current - $lastActiveTime;
        if ($timeSpan > TIMEOUT_LIMIT) {
            $this->logout();
            return FALSE;
        }
        $this->session->set_userdata('lastActiveTime', $current);
        return $user_id;
    }

    public function logout()
    {
        $data['user_id']=$this->session->userdata('user_id');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_account');
        $this->session->unset_userdata('user_authority');
        $this->session->unset_userdata('lastActiveTime');
    }
}