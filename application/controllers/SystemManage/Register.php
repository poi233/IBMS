<?php

/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/22
 * Time: 23:43
 */
class Register extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

}