<?php

/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/22
 * Time: 23:43
 */
class Login extends CI_Controller
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
        $this->load->view('userSystem/login');
    }

    public function logout()
    {
        $this->User_model->logout();
        redirect("");
    }

    public function login()
    {
        $this->form_validation->set_rules('user_account', 'Username', 'callback_username_check');
        $this->form_validation->set_rules('user_password', 'Password', 'callback_password_check');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('userSystem/login');
        } else {
            $this->User_model->to_login($_POST['user_account']);
            redirect('Index');
        }
    }

    public function username_check($user_name)
    {
        $user = $this->User_model->get_by_account($user_name);
        if ($user->num_rows() == 0) {
            $this->form_validation->set_message('username_check', '用户名不存在');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function password_check()
    {
        $user = $this->User_model->get_by_account($_POST['user_account']);
        if ($user->num_rows() > 0 && $user->row()->user_password != sha1($_POST['user_password'])) {
            $this->form_validation->set_message('password_check', '密码错误');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}