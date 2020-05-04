<?php 

defined('BASEPATH') OR exit('No dirrect script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        if ($this->session->userdata('nik')) {
            redirect('user','refresh');
        }
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false){
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validasi berhasil pake method baru
            $this->_login();
        }
    }
    private function _login()
    {
        $nik = $this->input->post('nik');
        $password = $this->input->post('password');
        $user = $this->db->get_where('employe', ['nik' => $nik])-> row_array();
        // jika usernya ada
        if($user) {
            // jika usernya aktif
            if($user['is_active'] == 1) {
                // cek password
                if(password_verify($password, $user['password'])) {
                    $data = [
                        'nik' => $user['nik'],
                        'position_id' => $user['position_id'],
						'akses_surat_id' => $user['akses_surat_id'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
					// target page if success
					redirect('jobs', 'refresh');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong Password! </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Your NIK has not been activated! </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Your Nik has not registered! </div>');
            redirect('auth');
        }
    }
    // public function registration()
    // {
    //     if ($this->session->userdata('email')) {
    //         redirect('user','refresh');
    //     }
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim');
    //     $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]', [
    //         'is_unique' => 'This Email is Already Exist!'
    //     ]);
    //     $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[5]|matches[password2]',[
    //         'matches' => 'Password Not Match!',
    //         'min_length' => 'Password Too Short!'
    //     ]);
    //     $this->form_validation->set_rules('password2', 'Password', 'trim|required|min_length[5]|matches[password1]');
    //     if ($this->form_validation->run() == FALSE) {
    //         $data['title'] = "Registration Page";
    //         $this->load->view('templates/auth_header', $data);
    //         $this->load->view('auth/registration');
    //         $this->load->view('templates/auth_footer');
    //     } else {
    //         $email = $this->input->post('email');
    //         $data = [
    //             'name' => htmlspecialchars($this->input->post('name')),
    //             'email' => htmlspecialchars($email),
    //             'image' => 'default.jpg',
    //             'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
    //             'role_id' => 2,
    //             'is_active' => 0,
    //             'date_created' => time()
    //         ];
    //         // siapkan token
    //         $token = base64_encode(random_bytes(8));
    //         $user_token = [
    //             'email' => $email,
    //             'token' => $token,
    //             'date_created' => time()
    //         ];
    //         $this->db->insert('user', $data);
    //         $this->db->insert('user_token', $user_token);
    //         $this->_sendEmail($token, 'verify');
    //         $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
    //         Congratulation! Your Account Has Been Created. Please Activate Your Account! </div>');
    //         redirect('auth');
    //     }
    // }

    // private function _sendEmail($token, $type)
    // {
    //     $config = [
    //         'protocol'  => 'smtp',
    //         'smtp_host' => 'ssl://smtp.gmail.com',
    //         'smtp_user' => 'julianhelloworld@gmail.com',
    //         'smtp_pass' => 'helloworld2212',
    //         'smtp_port' => 465,
    //         'mailtype'  => 'html',
    //         'charset'   => 'utf-8',
    //         'newline'   => "\r\n"
    //     ];
    //     $this->load->library('email');
    //     $this->email->initialize($config);
    //     $this->email->from('julianhelloworld@gmail.com','Login App');
    //     $this->email->to($this->input->post('email'));
    //     if ($type == 'verify') {
    //         $this->email->subject('Account Verification');
    //         $this->email->message('Click this link to verify your account : <a href="'.base_url(). 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) .'">Activate</a>');
    //     } elseif ($type == 'forgot') {
    //         $this->email->subject('Reset Password');
    //         $this->email->message('Click this link to reset your password : <a href="'.base_url(). 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) .'">Reset Password</a>');
    //     }
    //     if($this->email->send()){
    //         return true;
    //     } else {
    //         echo $this->email->print_debugger();
    //         die;
    //     }
    // }
    // public function verify()
    // {
    //     $email = $this->input->get('email');
    //     $token = $this->input->get('token');
    //     $user = $this->db->get_where('user', ['email' => $email])->row_array();
    //     if ($user) {
    //         $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
    //         if ($user_token) {
    //             if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
    //                 $this->db->set('is_active', 1);
    //                 $this->db->where('email', $email);
    //                 $this->db->update('user');
    //                 $this->db->delete('user_token', ['email' => $email]);
    //                 $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated! Please Login.</div>');
    //                 redirect('auth');
    //             } else {
    //                 $this->db->delete('user', ['email' => $email]);
    //                 $this->db->delete('user_token', ['email' => $email]);
    //                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    //                 Account Activate Failed! Token Expired.</div>');
    //                 redirect('auth');
    //             }
    //         } else {
    //             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    //             Account Activate Failed! Wrong Token.</div>');
    //             redirect('auth');
    //         }
    //     } else {
    //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    //         Account Activate Failed! Wrong Email.</div>');
    //         redirect('auth');
    //     }
    // }
    public function logout()
    {
        $this->session->unset_userdata('nik');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Your Session Has been Ended </div>');
        redirect('auth');
    }
    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
    // public function forgotPassword()
    // {
    //     $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
    //     if ($this->form_validation->run() == FALSE) {
    //         $data['title'] = 'Forgot Password';
    //         $this->load->view('templates/auth_header', $data);
    //         $this->load->view('auth/forgot-password');
    //         $this->load->view('templates/auth_footer');
    //     } else {
    //         $email = $this->input->post('email');
    //         $user = $this->db->get_where('employe', ['email' => $email, 'is_active' => 1])->row_array();
    //         if ($user) {
    //             $token = base64_encode(random_bytes(32));
    //             $user_token = [
    //                 'email' => $email,
    //                 'token' => $token,
    //                 'date_created' => time()
    //             ];
    //             $this->db->insert('user_token', $user_token);
    //             $this->_sendEmail($token, 'forgot');
    //             $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
    //             Please Check Your Email To Reset Your Password! </div>');
    //             redirect('auth');
    //         }else {
    //             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    //             Email Not Found Or Maybe Your Account Is Not Activated! </div>');
    //             redirect('auth/forgotpassword');
    //         }
    //     }
    // }
    // public function resetPassword()
    // {
    //     $email = $this->input->get('email');
    //     $token = $this->input->get('token');
    //     $user = $this->db->get_where('user', ['email' => $email])->row_array();
    //     if ($user) {
    //         $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
    //         if ($user_token) {
    //             $this->session->set_userdata('reset_email', $email);
    //             $this->changePassword();
    //         }else {
    //             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    //             Reset Password Failed! Wrong Token </div>');
    //             redirect('auth/forgotpassword');
    //         }
    //     }else {
    //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    //         Reset Password Failed! Wrong Email </div>');
    //         redirect('auth');
    //     }
    // }
    // public function changePassword()
    // {
    //     if(!$this->session->userdata('reset_email')) {
    //         redirect('auth','refresh');
    //     }
    //     $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[5]|matches[password2]');
    //     $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[5]|matches[password1]');
    //     if ($this->form_validation->run() == FALSE) {
    //         $data['title'] = 'Change Password';
    //         $this->load->view('templates/auth_header', $data);
    //         $this->load->view('auth/change-password');
    //         $this->load->view('templates/auth_footer');
    //     } else {
    //         $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
    //         $email = $this->session->userdata('reset_email');
    //         $this->db->set('password', $password);
    //         $this->db->where('email', $email);            
    //         $this->db->update('user');
    //         $this->session->unset_userdata('reset_email');
    //         $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
    //         Password Success Changed, Please Login! </div>');
    //         redirect('auth','refresh');
    //     }
    // }
}
