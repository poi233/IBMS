<?php
/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/23
 * Time: 22:23
 */
class Project extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Project_model');
    }

    public function index()
    {
        $this->load->view('projectSystem/projects_install');
    }
}