<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_login extends CI_Model {

    function Auth($username, $password)
    {

        //menggunakan active record . untuk menghindari sql injection
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $this->db->where("status", 'Y');
        return $this->db->get("karyawan");    
    }

    function check_db($username)
    {
        return $this->db->get_where('karyawan', array('username' => $username));
    }



}

/* End of file Mod_login.php */
