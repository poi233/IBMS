<?php
/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/22
 * Time: 23:40
 */
class User_model extends CI_Model
{
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
            ->join('user_project', 'user.user_id=user_project.user_id')
            ->where('user.user_id', $user_id)
            //->order_by('add_time', 'DESC')
            ->get();
        return $res;
    }

    public function get_account_by_id($user_id)
    {
        $res = $this->db
            ->select('*')
            ->from('user')
            ->where('user_id',$user_id)
            ->get();
        return $res->row()->user_account;
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

    public function delete($user_id)
    {
        $this->db->delete('user', array('user_id' => $user_id));
    }

    public function delete_user_project($project_id)
    {
        $this->db->delete('user_project', array('project_id' => $project_id));
    }

    public function update($data)
    {
        $this->db->update('user', $data, array('user_id' => $data['user_id']));
    }

    public function to_login($user_account)
    {
        $row = $this->User_model->get_by_account($user_account)->row();
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
        $data['user_id'] = $this->session->userdata('user_id');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_account');
        $this->session->unset_userdata('user_authority');
        $this->session->unset_userdata('lastActiveTime');
    }

    public function search($account)
    {
        $like_array = array('user_account' => $account, 'user_name' => $account);
        $res = $this->db
            ->select('*')
            ->from('user')
            ->or_like($like_array)
            ->get();
        return $res;
    }

    public function get_user_project_by_projectID($projectID)
    {
        $res = $this->db
            ->select('*')
            ->from('user_project')
            ->join('user', 'user_project.user_id=user.user_id')
            ->where('user_project.project_id', $projectID)
            ->get();
        return $res;
    }

    public function get_other_user_by_projectID($projectID)
    {
        $id_exist = array();
        $id = $this->User_model->get_user_project_by_projectID($projectID);
        foreach($id->result() as $idRow)
        {
            array_push($id_exist,$idRow->user_id);
        }
          $res = $this->db
            ->select('*')
            ->from('user')
            ->where_not_in('user.user_id', $id_exist)
            ->get();
        return $res;
    }

    public function get_project_by_userAccount($userID)
    {
        $res = $this->db
            ->select('*')
            ->from('user_project')
            ->where('user_id', $userID)
            ->get();
        return $res;
    }
}