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
    }

    public function index(){
        $data['project'] = $this->Project_model->get_all();
        $this->load->view('projectSystem/projects_management',$data);
    }

    public function projectCheck($project_id)
    {
        $res = $this->Project_model->get_by_id($project_id)->row_array();
        echo json_encode($res);
    }

    public function addProjectIndex()
    {
        $data['allUser'] = $this->User_model->get_all();
        $this->load->view('projectSystem/projects_install',$data);
    }

    public function addProject()
    {
        $projectID = $_POST['projectID'];
        $allMembers = $_POST['allAddMembers'];
        $user_account = explode(',',$allMembers);
        $allSubsystems = $_POST['allAddSubsystems'];
        $subsystems = explode(',',$allSubsystems);
        $data = array(
            'project_id' => $projectID,
            'project_name' => $_POST['projectName'],
            'project_version' => $_POST['projectVersion'],
        );
        $this->Project_model->insert($data);

        for($index=0;$index<count($user_account)-1;$index++)
        {
            $id = $this->User_model->get_by_account($user_account[$index])->row()->user_id;
            $to_project = array(
                'user_id' => $id,
                'project_id' => $projectID
            );
            $this->Project_model->add_to_project($to_project);
        }

        for($index=0;$index<count($subsystems)-1;$index++)
        {
            $to_project = array(
                'subsystem' => $subsystems[$index],
                'project_id' => $projectID
            );
            $this->Project_model->add_subsystem($to_project);
        }

        redirect('SystemManage/Project');
    }

    public function modifyProjectIndex($projectID)
    {
        $data['otherUsers'] = $this->User_model->get_other_user_by_projectID($projectID);
        $data['allMembers'] = $this->User_model->get_user_project_by_projectID($projectID);
        $data['allSubsystem'] = $this->Project_model->get_all_subsystem($projectID);
        $data['project'] = $this->Project_model->get_by_id($projectID);
        $this->load->view('projectSystem/projects_modify',$data);

    }

    public function modifyProject()
    {
        $allMembers = $_POST['allAddMembers'];
        $user_account = explode(',',$allMembers);
        $allSubsystems = $_POST['allAddSubsystems'];
        $subsystems = explode(',',$allSubsystems);
        $data = array(
            'project_id' => $_POST['projectID'],
            'project_version' => $_POST['projectVersion'],
        );
        $this->Project_model->update($data);

        $this->User_model->delete_user_project($_POST['projectID']);
        for($index=0;$index<count($user_account)-1;$index++)
        {
            $id = $this->User_model->get_by_account($user_account[$index])->row()->user_id;
            $to_project = array(
                'user_id' => $id,
                'project_id' => $_POST['projectID']
            );
            $this->Project_model->add_to_project($to_project);
        }

        /*for($index=0;$index<count($subsystems)-1;$index++)
        {
            $to_project = array(
                'subsystem' => $subsystems[$index],
                'project_id' => $_POST['projectID']
            );
            $this->Project_model->add_subsystem($to_project);
        }*/

        redirect('SystemManage/Project');
    }

    public function search()
    {
        if ($_POST['search'] == '') {
            redirect('SystemManage/Project');
        } else {
            $data['project'] = $this->Project_model->search($_POST['search']);
            $this->load->view('projectSystem/projects_management', $data);
        }
    }
}