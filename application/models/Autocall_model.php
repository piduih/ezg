<?php
class Autocall_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function call_procedure()
    {
        $this->db->query("call calBinary");
        $this->db->query("call calBinary_s2");
        $this->db->query("call calBinary_s3");

        //$query = $this->db->get();
        //return $query->result();
    }
}