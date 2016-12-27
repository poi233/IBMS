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

    public function get_by_name($name)
    {
        $result = $this->db->get_where('project', array('project_name' => $name));
        return $result;
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
}
