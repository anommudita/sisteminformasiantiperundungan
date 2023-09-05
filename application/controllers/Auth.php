<?php
// depedency phpmailer

use PharIo\Manifest\Email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
class Auth extends CI_Controller{


    // function construct
    public function __construct()
    {
        parent::__construct();

        // load model user
        $this->load->model('Guru_model', 'users');


        date_default_timezone_set("Asia/Singapore");
    }

    public function Index()
    {
        // membersihkan session
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        // $this->session->unset_userdata('blockEndTime');

        // membershikan token ketika token sudah kadaluarsa
        // $this->users->delete_token_expired();

        $this->form_validation->set_rules('username', 'Username', 'required|trim', [

            'required' => 'Username harus diisi'
        ]);
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|trim',
            [
                'required' => 'Password harus diisi'
            ]
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/login');
        } else {
            // validasi sukses
            $this->_login();
        }
    }


    private function _login()
    {
        // ambil data input dari form login
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $rememberMe = $this->input->post('rememberMe');
        
        // ambil data dari database
        $user = $this->users->get_data_by_username($username);

        // mengambil ip address
        $ip_address = $this->input->ip_address();

        // hapus session blocktime
        $this->session->unset_userdata('blockEndTime');

        // Autentikasi untuk admin dan guru
        if ($user) {
            // jika password benar yang diinputkan benar sesuai dengan database!
            if ((password_verify($password, $user['password']))) {

                // jika user is_active
                if ($user['is_active'] == 1) {
                    // jika user sudah berhasil login
                    $this->db->set('status_login', 1);
                    $this->db->where('username', $username);
                    $this->db->update('users');

                    // jika berhasil login hapus record ip address
                    $this->users->clear_attempts($ip_address);


                    // tambahkan data untuk menentukan access session
                    $data = [
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'rememberMe' => ($rememberMe == 1 ) ? TRUE : FALSE
                    ];

                    if ($rememberMe == 1) {
                        $this->input->set_cookie('__ACTIVE_SESSION_DATA', 172800); //48 jam

                        // set session agar tersimpan di halaman selanjutnya
                        $this->session->set_userdata($data);
                    } else {
                        // set session agar tersimpan di halaman selanjutnya
                        $this->session->set_userdata($data);
                    }
                    // perkondisian untuk menentukan halaman sesuai dengan role - nya
                    if ($user['role'] == 1) {
                        // redirect ke halaman admin
                        redirect('admin');
                    } elseif ($user['role'] == 2) {
                        // redirect ke halaman guru
                        redirect('guru');
                    }
                } else {
                    // jika usernya tidak aktif}
                    $this->session->set_flashdata('message', '<div class="btn btn-danger" role="alert">Akun Belum Aktif</div>');
                    redirect('login');
                }
            }else{

                // password salah record ip address
                $this->users->record_attempts($ip_address);

                // array untuk menghitung jumlah percobaan dan durasi(detik)
                $attemptsThresholds = [3 => 120, 4 => 240, 5 => 480, 6 => 960, 7 => 1920]; // [jumlah_percobaan => durasi_blokir_dalam_detik]

                // menghitung jumlah percobaan
                $attempts = $this->users->get_attempts($ip_address);

                if($attempts && $attempts >= 3){
                // perulangan untuk menghitung jumlah percobaan
                foreach ($attemptsThresholds as $threshold => $duration) {
                    if ($attempts >= $threshold) {
                        $blockEndTime = time() + $duration;
                        $this->session->set_userdata('blockEndTime', $blockEndTime);
                        $this->session->set_flashdata('message', '<div class="btn btn-danger" role="alert">Anda telah mencapai batas login!</div>');
                    }
                }
                    redirect('login');
                }

                // Notifikasi gagal password salah
                $this->session->set_flashdata('message', '<div class="btn btn-danger">Password Salah!</div>');
                // Redirect ke halaman login
                redirect('login');
            }

        } else {
            // Notifikasi gagal
            $this->session->set_flashdata('message', '<div class="btn btn-danger" role="alert">Username Belum Terdaftar!</div>');
            // Redirect ke halaman login
            redirect('login');
        }
    }


    // function untuk verifikasi email1
    public function verify()
    {
        // mengambil email dan token dari url
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $guru = $this->db->get_where('users', ['email' => $email])->row_array();

        if ($guru) {
            // jika user ada!
            // mengecek token di database!
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $date = $user_token['date_created'];

                // konversi tanggal ke unix
                $timestamp = strtotime($date);

                // menghitung waktu satu hari (86400 detik);
                $oneDay = 60 * 60 * 24; // hasilnya 86400 detik

                // jika user token ada sesuai dengan database!
                // jika token belum kadaluarsa selama sehari 24 jam
                if (time() - $timestamp < $oneDay) {
                    // update is_active menjadi 1 ==> account is active
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('users');

                    // jika sudah aman accountnya, maka token dihapus karena tidak dibutuhkan lagi!
                    $this->users->delete_token($email);

                    $this->session->set_flashdata('message', '<div class="btn btn-success" role="alert">' . $email . ' telah aktivasi! Silahkan Login.</div>');
                    redirect('auth');
                } else {
                    // jika token sudah kadaluarsa
                    // hapus tokennya atau hapus usernya!
                    $this->users->delete_akun_guru($email);
                    $this->users->delete_token($email);

                    $this->session->set_flashdata('message', '<div class="btn btn-danger" role="alert">Token Kadaluarsa</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="btn btn-danger" role="alert">Akun gagal aktivasi! Email Salah</div>');
                redirect('auth');
            }
        }
    }


    // forgot password
    public function lupaPassword(){


        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email harus diisi',
            'valid_email' => 'Email tidak valid'
        ]);

        // mengambil ip address
        $ip_address = $this->input->ip_address();

        // clear ip address
        if($ip_address){
            // jika berhasil login hapus record ip address
            $this->users->clear_attempts($ip_address);
        }

        if($this->form_validation->run() === false){
            $this->load->view('auth/lupa_password');
        }else{
            
            // ambil emailnya
            $email = $this->input->post('email');

            // cek email dan email harus sudah aktif , apakah ada di database
            $user = $this->db->get_where('users', ['email' => $email, 'is_active' => 1])->row_array();

            if($user){
                // jika user ada
                // generate token
                $token = base64_encode(random_bytes(32));


                // simpan token ke database
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => date('Y/m/d H:i:s')
                ];

                // insert ke database
                $this->db->insert('user_token', $user_token);

                // kirim email
                $this->_sendEmail($token);

                // tambahkan ip address
                $this->users->record_attempts($ip_address);

                // menghitung jumlah percobaan
                $attempts = $this->users->get_attempts($ip_address);

                if($attempts >= 1){
                     $blockEndTime1 = time() + 120; // 2 menit
                    $this->session->set_userdata('blockEndTime1', $blockEndTime1);
                }

                // notif berhasil
                $this->session->set_flashdata('message', '<div class="btn btn-success" role="alert">Cek email untuk reset password!</div>');

                redirect('lupaPassword');


            }else{
                // jika user tidak ada
                $this->session->set_flashdata('message', '<div class="btn btn-danger" role="alert">Email belum terdaftar atau belum aktif!</div>');
                redirect('lupaPassword');
            }
        }
        
    }


    // email verifikasi dengan function modifier private
    private function _sendEmail($token)
    {

        // email client        
        $email = $this->input->post('email');;
        $subject =  'Akun Guru SIAP';


        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;                                     //Enable SMTP authentication
            $mail->Username = 'otweditor007@gmail.com';
            $mail->Password = 'gchmemrutuqiiuga';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom('otweditor007@gmail.com',
                'Admin SIAP'
            );
            $mail->addAddress($email);
            $mail->Subject = ($subject);


            // link untuk mengarahakan aktifasi akun
            $link = base_url() . 'auth/gantiKataSandi?email=' . $email . '&token=' . urlencode($token);

            // hari ini 
            $date = date('Y-m-d');

            // file html 
            $htmlContent = file_get_contents('application/views/admin/message_email/forgotPassword.php');
            $htmlContent = str_replace('{{DATE}}', $date, $htmlContent);
            $htmlContent = str_replace('{{LINK}}', $link, $htmlContent);

            // content
            $mail->isHTML(true);                                //Set email format to HTML
            // $mail->Subject = 'Here is the subject';
            $mail->Body    = $htmlContent;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    // ganti kata sandi
    public function gantiKataSandi(){
            
            // mengambil email dan token dari url
            $email = $this->input->get('email');
            $token = $this->input->get('token');
    
            // cek email di database
            $user = $this->db->get_where('users', ['email' => $email])->row_array();
            // var_dump($user);
    
            if($user){
                // jika user ada
                // cek token di database
                $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
    
                if($user_token){
                    // jika token ada
                    // simpan session

                    $this->session->set_userdata('reset_email', $email);

                    // redirect ke halaman ubah kata sandi
                    $this->ubahKataSandi();

                }else{
                    // jika token tidak ada
                    $this->session->set_flashdata('message', '<div class="btn btn-danger" role="alert">Token Salah!</div>');
                    redirect('auth/lupaPassword');
                }
            }else{
                // jika user tidak ada
                $this->session->set_flashdata('message', '<div class="btn btn-danger" role="alert">Email Salah!</div>');
                redirect('auth/lupaPassword');
            }
    }


    // ubah  kata sandi untuk user
    public function ubahKataSandi(){
        // // tidak bisa mengakses halaman change password jika belum mendapatkan session reset email dari email yang dikirimkan
        if (!$this->session->userdata('reset_email')) {
            redirect('login');
        }

        // var_dump($this->session->userdata('reset_email'));

        // inputan form password1
        $this->form_validation->set_rules('password1', 'Password1', 'trim|required|min_length[3]|matches[password2]', [
            'matches' => 'Kata sandi tidak sama!',
            'min_length' => 'Kata sandi terlalu pendek!',
            'required' => 'Kata sandi harus diisi'
        ]);

        // // inputan form password2
        $this->form_validation->set_rules('password2', 'Password2', 'trim|required|min_length[3]|matches[password1]',
            [
                'matches' => 'Kata Sandi tidak sama!',
                'min_length' => 'Konfirmasi Kata Sandi terlalu pendek!',
                'required' => 'Konfirmasi kata Sandi harus diisi'

            ]
    );


        if($this->form_validation->run() == false){
            $this->load->view('auth/ubah_kata_sandi');
        }else { 
            // enkripsi password
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            $email = $this->session->userdata('reset_email');

            // query update password
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('users');

            // delete token
            $this->db->delete('user_token', ['email' => $email]);

            // hapus session reset email
            $this->session->unset_userdata('reset_email');

            // notif flash data
            $this->session->set_flashdata('message', '<div class="btn btn-success" role="alert">Kata sandi telah diperbarui! Silahkan login.</div>');
            redirect('login');
        }

        // echo 'halaman ubah kata sandi';

    }


    // logout 
    public function logout()
    {
        $username = $this->session->userdata('username');
        // jika user telah login ubah nilai ke 0
        $this->db->set('status_login', 0);
        $this->db->where('username', $username);
        $this->db->update('users');

        // membersihkan session
        $this->session->unset_userdata('klasifikasi');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');

        // notif berhasil jika logout
        $this->session->set_flashdata('message', '<div class="btn btn-success" role="alert">Anda Telah Logout!</div>');

        // sleep(1);
        // redirect ke halaman login
        redirect('login');
    }

    public function blocked()
    {
        $username = $this->session->userdata('username');
        // jika user telah login ubah nilai ke 0
        $this->db->set('status_login', 0);
        $this->db->where('username', $username);
        $this->db->update('users');

        // // membersihkan session
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('email');
        $this->load->view('auth/blocked');
    }


    public function not_found()
    {
        $this->load->view('auth/blocked');
    }



}
