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
        $data['allUser'] = $this->User_model->get_all();
        $this->load->view('projectSystem/projects_install',$data);
    }

    public function projectCheck($project_id)
    {
        $res = $this->Project_model->get_by_id($project_id)->row_array();
        echo json_encode($res);
    }

    public function addProject()
    {
        $allMembers = $_POST['allAddMembers'];
        $user_account = explode(',',$allMembers);
        $data = array(
            'project_id' => $_POST['projectID'],
            'project_name' => $_POST['projectName'],
            'project_version' => $_POST['projectVersion'],
            'project_subsys'=> $_POST['projectSubsystem']
        );
        $this->Project_model->insert($data);

        for($index=0;$index<count($user_account)-1;$index++)
        {
            $id = $this->User_model->get_by_account($user_account[$index])->row()->user_id;
            $to_project = array(
                'user_id' => $id,
                'project_id' => $_POST['projectID']
            );
            $this->Project_model->add_to_project($to_project);
        }
        redirect($_SERVER['HTTP_REFERER']);

    }
}