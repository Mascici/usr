<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('fungsi');
        $this->load->library('user_agent');
        $this->load->helper('myfunction_helper');
        $this->load->model('Mod_user');
    }

    function index()
    {
    	$logged_in = $this->session->userdata('id');
        if (empty($logged_in)) {
            redirect('login');
        }else{
            $data['karyawan']=$this->Mod_user->getAll()->result();
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('dashboard/dashboard_data',$data);
            $this->load->view('templates/footer');
        }
        
    }

    public function list_karyawan()
    {
        ini_set('memory_limit','512M');
        set_time_limit(3600);
        $list = $this->Mod_user->get_datatables();
        // $this->db->select('a.*,b.nama_departemen');
    	// $this->db->join('departemen b', 'a.level=b.id_departemen','left');
        // $this->db->order_by('a.id desc');
        // $list = $this->db->get('karyawan a')->result();
        $data = array();
        $no = $_POST['start'];
        // var_dump($list);
        // die();
        foreach ($list as $user) {
            $no++;
            $row = array();

            $row[] = $user->nik;
            $row[] = $user->nama;
            $row[] = $user->ttl;
            $row[] = $user->alamat;            
            $row[] = $user->pendidikan;
            $row[] = $user->id_departemen;
            $row[] = $user->level;
            $row[] = $user->grade;
            $row[] = $user->id;
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Mod_user->count_all(),
                        "recordsFiltered" => $this->Mod_user->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function insertdata()
    {
     $data = array(
        'username'=> $this->input->post('username'),
        'password'=> $this->input->post('password'),
        'nik'=> $this->input->post('nik'),
        'nama'=> $this->input->post('nama'),
        'ttl'=> $this->input->post('ttl'),
        'alamat'=> $this->input->post('alamat'),
        'pendidikan'=> $this->input->post('pendidikan'),
        'id_departemen'=> $this->input->post('id_departemen'),
        'level'=> $this->input->post('level'),
        'grade'=> $this->input->post('grade'),
        'status'=> $this->input->post('status')
     );
     $this->db->insert('karyawan',$data);
     echo json_encode(['status'=>TRUE]);
    }

    public function editdata()
    {
        $data = array(
            'username'=> $this->input->post('username'),
            'password'=> $this->input->post('password'),
            'nik'=> $this->input->post('nik'),
            'nama'=> $this->input->post('nama'),
            'ttl'=> $this->input->post('ttl'),
            'alamat'=> $this->input->post('alamat'),
            'pendidikan'=> $this->input->post('pendidikan'),
            'id_departemen'=> $this->input->post('id_departemen'),
            'level'=> $this->input->post('level'),
            'grade'=> $this->input->post('grade'),
            'status'=> $this->input->post('status')
         );
         $this->db->where('id', $this->input->post('id'));
         $this->db->update('karyawan',$data);
         echo json_encode(['status'=>TRUE]);
    }
    public function hapusdata($id){
        $this->Mod_user->deleteUsers($id,'karyawan');
        echo json_encode(['status'=>TRUE]);


    }

}
/* End of file Controllername.php */
 