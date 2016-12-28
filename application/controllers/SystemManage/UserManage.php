<?php

/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/26
 * Time: 21:08
 */
class UserManage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    public function index()
    {
        $data['allUser'] = $this->User_model->get_all();
        $this->load->view('userSystem/allUser', $data);
    }

    public function addUser()
    {
        $data = array(
            'user_account' => $_POST['user_account'],
            'user_password' => sha1("111111"),
            'user_authority' => $_POST['user_authority'],
            'user_name' => $_POST['user_name']
        );
        $this->User_model->insert($data);
        redirect('SystemManage/userManage');
    }

    public function modifyUser($user_account)
    {
        $user_id = $this->User_model->get_by_account($user_account)->row()->user_id;
        $data = array(
            'user_id' => $user_id,
            'user_account' => $_POST['user_account'],
            'user_authority' => $_POST['user_authority'],
            'user_name' => $_POST['user_name']
        );
        if ($_POST['user_password'] != '')
            $data['user_password'] = sha1($_POST['user_password']);
        $this->User_model->update($data);
        redirect('SystemManage/userManage');
    }

    public function deleteUser($user_id)
    {
        $this->User_model->delete($user_id);
        redirect('SystemManage/userManage');
    }


    public function findAccount($user_account)
    {
        $res = $this->User_model->get_by_account($user_account)->row_array();
        echo json_encode($res);
    }

    public function search()
    {
        if ($_POST['search'] == '') {
            redirect('SystemManage/userManage');
        } else {
            $data['allUser'] = $this->User_model->search($_POST['search']);
            $this->load->view('userSystem/allUser', $data);
        }
    }

    public function passwordCheck($password)
    {
        $pass = $this->User_model
            ->get_by_id($this->session->userdata('user_id'))
            ->row()
            ->user_password;
        if($pass == sha1($password))
            echo true;
        else
            echo false;
    }

    public function deleteCheck($userID)
    {
        $res = $this->User_model->get_project_by_userAccount($userID);

        if($res->num_rows()==0)
            echo true;
        else
            echo false;
    }

    public function changePassword()
    {
        $user_id = $this->session->userdata('user_id');
        $data['user_id'] = $user_id;
        $data['user_password'] = sha1($_POST['newPassword']);
        $this->User_model->update($data);
        redirect($_SERVER['HTTP_REFERER']);
    }
}