<?php
/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/22
 * Time: 23:40
 */
class Project_model extends CI_Model{
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
            ->from('project')
            ->get();
        return $res;
    }

    public function get_by_id($id)
    {
        $res = $this->db->get_where('project', array('project_id' => $id));
        return $res;
    }

    public function get_name_by_id($project_id)
    {
        $res = $this->db
            ->select('*')
            ->from('project')
            ->where('project_id',$project_id)
            ->get();
        return $res->row()->project_name;
    }


    public function get_by_name($name)
    {
        $result = $this->db->get_where('project', array('project_name' => $name));
        return $result;
    }

    public function get_all_subsystem($projectID)
    {
        $res = $this->db
            ->select('*')
            ->from('project_subsystem')
            ->where('project_id', $projectID)
            ->get();
        return $res;
    }

    public function insert($data)
    {
        return $this->db->insert('project', $data);
    }

    public function delete($project_id)
    {
        $this->db->delete('project', array('project_id' => $project_id));
    }

    public function update($data)
    {
        $this->db->update('project', $data, array('project_id' => $data['project_id']));
    }

    public function add_to_project($data)
    {
        $this->db->insert('user_project',$data);
    }

    public function add_subsystem($data)
    {
        $this->db->insert('project_subsystem',$data);
    }

    public function search($search)
    {
        $like_array = array(
            'project.project_id' => $search,
            'project_name' => $search,
            'project_version' => $search,
        );
        $res = $this->db
            ->select('*')
            ->from('project')
            ->or_like($like_array)
            ->get();
        return $res;
    }
}
