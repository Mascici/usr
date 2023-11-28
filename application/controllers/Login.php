<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_login'));
        
    }

    public function index()
    {
        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in==TRUE) {
            redirect('dashboard');
        }else{
            $this->load->view('admin/login_data');
        }
    }//end function index

    function login()
    {
        
        $this->_validate();
        //cek username database
        $username = anti_injection($this->input->post('username'));

        if($this->Mod_login->check_db($username)->num_rows()==1) {
            $db = $this->Mod_login->check_db($username)->row();
            // $apl = $this->Mod_login->Aplikasi()->row();

            if(anti_injection($this->input->post('password'), $db->password)) {
            //cek username dan password yg ada di database
                $userdata = array(
                    'id'  => $db->id,
                    'username'    => ucfirst($db->username),
                    'nama'   => ucfirst($db->nama),
                    'departemen'    => $db->id_departemen
                );

                $this->session->set_userdata($userdata);
                $data['status'] = TRUE;
                echo json_encode($data);
            }else{

                $data['pesan'] = "Username atau Password Salah!";
                $data['error'] = TRUE;
                echo json_encode($data);
            }
        }else{
            $data['pesan'] = "Username atau Password belum terdaftar!";
            $data['error'] = TRUE;
            echo json_encode($data);
        }
        
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->load->driver('cache');
        $this->cache->clean();
        ob_clean();
        redirect('login');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('username') == '')
        {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Username is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('password') == '')
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Login.php */
