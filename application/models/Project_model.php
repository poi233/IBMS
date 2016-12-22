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
}
