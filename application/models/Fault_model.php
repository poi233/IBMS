<?php
/**
 * Created by PhpStorm.
 * User: puyihao
 * Date: 2016/12/30
 * Time: 18:15
 */
class Fault_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }
}