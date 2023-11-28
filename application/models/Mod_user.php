<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_user extends CI_Model {

    function view_user($id)
    {   
        $this->db->where('id',$id);
        return $this->db->get('karyawan');
    }

    function getAll()
    {   
        // $sql = "SELECT a.*, b.nama_departemen FROM karyawan AS a LEFT JOIN jenis_departemen AS b ON a.id_departemen = b.id_departemen ORDER BY id";
		// $querySQL = $this->db->query($sql);
		// if($querySQL){return $querySQL->result();}
		// else{return 0;}
        $this->db->select('a.*','b.nama_departemen');
    	$this->db->join('jenis_departemen b', 'a.id_departemen=b.id_departemen','left');
        $this->db->order_by('a.id desc');
        return $this->db->get('karyawan a');
    }

    function cekUsername($username)
    {
        $this->db->where("username",$username);
        return $this->db->get("karyawan");
    }

    function insertUser($tabel, $data)
    {
        $insert = $this->db->insert($tabel, $data);
        return $insert;
    }

    function getUser($id)
    {   
        $this->db->where("id", $id);
        return $this->db->get("karyawan a")->row();
    }

    function updateUser($id, $data)
    {
        $this->db->where('id', $id);
		$this->db->update('karyawan', $data);
    }
    

    function deleteUsers($id, $table)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

    function userlevel()
    {
       return $this->db->order_by('level ASC')
                        ->get('karyawan')
                        ->result();
    }

    function getImage($id)
    {
        $this->db->select('image');
        $this->db->from('karyawan');
        $this->db->where('id', $id);
        return $this->db->get();
    }
    
    function reset_pass($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('karyawan', $data);
    }
}