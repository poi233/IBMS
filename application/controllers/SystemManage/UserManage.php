<?php
/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/26
 * Time: 21:08
 */

class UserManage extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    public function index($user_account=0)
    {
        if($user_account==0)
            $data['allUser'] = $this->User_model->get_all();
        else
            $data['allUser'] = $this->User_model->get_by_account($user_account);
        $this->load->view('userSystem/allUser',$data);
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
        $data = array(
            'user_account' => $user_account,
            'user_authority' => $_POST['user_authority'],
            'user_name' => $_POST['user_name']
        );
        if($_POST['user_password']!='')
            $data['user_password'] = sha1($_POST['user_password']);
        $this->User_model->update($data);
        redirect('SystemManage/userManage');
    }

    public function deleteUser($user_account)
    {
        $this->User_model->delete($user_account);
        redirect('SystemManage/userManage');
    }


    public function findAccount($user_account)
    {
        $res = $this->User_model->get_by_account($user_account)->row_array();
        echo json_encode($res);
    }
    public function search()
    {
        redirect('SystemManage/userManage/index/'+$_POST['search']);
    }
}