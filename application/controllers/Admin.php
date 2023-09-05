<?php

// depedency phpmailer

use PharIo\Manifest\Email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class Admin extends CI_Controller{

    // constructor
    public function __construct()
    {
        parent::__construct();


        // styel baru mengambil model
        $this->load->model([
            'Sekolah_model' => 'sekolah',
            'Guru_model' => 'guru',
            'Siswa_model' => 'siswa',
            'Laporan_model' =>'laporan',
            'Log_model' => 'log_laporan',
            'Klasifikasi_model' => 'klasifikasi'
        ]);


        // // cek session untuk username
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        // cek session untuk email
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }

        // cek session untuk email
        if (!$this->session->userdata('role')) {
            redirect('auth');
        }

        // function helper untuk cek akses
        is_logged_in();

        // default waktu
        date_default_timezone_set("Asia/Makassar");
    }


    // dahsboard
    public function index(){

        // hapus session blocktime
        $this->session->unset_userdata('blockEndTime');

        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        $data['sekolah'] = $this->sekolah->countAllSekolah();
        $data['guru'] = $this->guru->countAllAkunGuru();
        $data['siswa'] = $this->siswa->countAllSiswa();
        $data['laporan'] = $this->laporan->countAllLaporan();

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/template/footer', $data);
    }


    // API data guru dan siswa
    public function data_api()
    {
        $action = $this->input->get('action');
        $response = array(); // Inisialisasi response
        switch ($action) {
            case 'list':
                $akunGuru['data'] = $this->guru->get_data_akun_guru();
                $response = array(
                    'status' => 'success',
                    'message' => 'Data akun guru berhasil diambil',
                    'data' => $akunGuru['data']
                );
                break;
            case 'view_data':
                $id = $this->input->get('id');
                $akunGuru['data'] = $this->guru->get_data_by_id_api($id);
                $response = array(
                    'status' => 'success',
                    'code' => '200',
                    'message' => 'Data akun guru berhasil diambil by id',
                    'data' => $akunGuru['data']
                );
                break;
            case 'view_data_edit_log':
                $id = $this->input->get('id');
                $logs['data'] = $this->log_laporan->get_data_log_by_id_api($id);
                $response = array(
                    'status' => 'success',
                    'code' => '200',
                    'message' => 'Data log berhasil diambil by id_log',
                    'data' => $logs['data']
                );
                break;
            case 'view_data_edit_klasifikasi':
                $id = $this->input->get('id');
                $klasifikasi['data'] = $this->klasifikasi->get_data_klasifikasi_by_id_api($id);
                $response = array(
                    'status' => 'success',
                    'code' => '200',
                    'message' => 'Data klasifikasi berhasil diambil by id_klasifikasi',
                    'data' => $klasifikasi['data']
                );
                break;
            case 'edit_guru':
                $id = $this->input->get('id');
                $akunGuru['data'] = $this->guru->get_data_by_id_api($id);
                $response = array(
                    'status' => 'success',
                    'code' => '201',
                    'message' => 'Data akun guru berhasil diedit'
                );
                break;
        }

        $response = json_encode($response);
        $this->output->set_content_type('application/json')
        ->set_output($response);
    }

    // active akun guru
    public function active_akun($username){

        sleep(1);
        $this->guru->active_akun_guru($username);

        redirect('admin/akun_guru');
    }


    public function edit_akun_guru($id){

        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // inputan edit name
        $this->form_validation->set_rules('edit_name', 'Edit_name', 'required', [
            'required' => 'Nama tidak boleh kosong!'
        ]);

        // inputan edit username 
        $this->form_validation->set_rules('edit_username', 'Edit_username', 'required', [
            'required' => 'Username tidak boleh kosong!'
        ]);

        // inputan edit email
        $this->form_validation->set_rules('edit_email', 'Edit_email', 'required', [
            'required' => 'Email tidak boleh kosong!'
        ]);

        // data akun guru by id
        $data['guru'] = $this->guru->get_data_by_id($id);
        
        if($this->form_validation->run() === false){
            // semua data akun guru
            $data['akun_guru'] = $this->guru->get_data_akun_guru();

            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/akun_guru/index', $data);
            $this->load->view('admin/template/footer', $data);

        }else{
            // upload gambar
            // cek jika ada gambar di upload atau tidak dari variable $_FILES
            $upload_image = $_FILES['edit_image']['name'];

            if ($upload_image) {
                // file format yang boleh diupload
                $config['allowed_types'] = 'gif|jpg|png|jpeg|heic';

                // ukuran file yang boleh diupload lebh dari 5mb
                $config['max_size'] = '5120';

                // lokasi penyimpanan file
                $config['upload_path'] = './assets/img/guru/profile/';

                // resolusi gambar yang diupload
                // $config['max_width'] = '1024';
                // $config['max_height'] = '768';
                // load library upload  
                $this->load->library('upload', $config);

                // cek apakah file berhasil diupload
                if ($this->upload->do_upload('edit_image')) {
                    // add gambar baru 
                    $new_image = $this->upload->data('file_name');

                    // gambar lama selain gambar defaultnya
                    $old_image = $data['guru']['foto'];
                    // cek apakah ada gambar atau tidak
                    // cek jika selain nama gambar default maka hapus gambar lama
                    if ($old_image && $old_image != 'default.png' || $old_image != 'default1.png') {
                        // jika ada hapus gambar lama
                        unlink(FCPATH . 'assets/img/guru/profile/' . $old_image);
                    }
                } else {
                    // jika gagal
                    echo $this->upload->display_errors();

                    // flash data
                    $this->session->set_flashdata('flash_failed', 'File melebihin batas!');

                    redirect('admin/akun_guru');
                }
            } else {
                // jika tidak ada gambar yang diupload maka gunakan gambar lama dengan variable new_image
                $new_image = $data['guru']['foto'];
            }

            // perkondisian ganti password
            if ($this->input->post('edit_password',true) == null) {
                $password_now = $data['guru']['password'];
            } else {
                $password = $this->input->post('edit_password', true);
                $password_now = password_hash($password, PASSWORD_DEFAULT);
                $this->_editPassword($password, $this->input->post('edit_email', true));
            }
            // update data akun guru melalui model atau database
            $this->guru->update_akun_guru($id, $new_image, $password_now);

            //  flash data
            $this->session->set_flashdata('flash', 'diubah!');

            // redirect
            redirect('admin/akun_guru');
        }
    }

    private function _editPassword($password, $email){

        // email admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));
        $emailAdmin = $data['user']['email'];

        $subject =  'Akun Guru SIAP';
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;                                     //Enable SMTP authentication
            $mail->Username = $emailAdmin;
            $mail->Password = 'gchmemrutuqiiuga';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom($emailAdmin, 'Admin SIAP');
            $mail->addAddress($email);
            $mail->Subject = ($subject);
            // $mail->Body = $message;

            // hari ini 
            $date = date('Y-m-d');

            // file html 
            $htmlContent = file_get_contents('application/views/admin/message_email/editPassword.php');
            $htmlContent = str_replace('{{PASSWORD}}', $password, $htmlContent);
            $htmlContent = str_replace('{{DATE}}', $date, $htmlContent);

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

    // halaman akun guru
    public function  akun_guru(){

        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get akun guru
        $data['akun_guru'] = $this->guru->get_data_akun_guru();

        // total_perundungan_by_guru
        // $data['total_laporan'] = $this->laporan->countAllLaporanByGuru($data['akun_guru']['id']);
        // var_dump($data['total_laporan']);

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/akun_guru/index', $data);
        $this->load->view('admin/template/footer', $data);
    }

    // halaman tambah akun guru
    public function tambah_akun_guru()
    {
             // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));   // data akun guru
        $data['akun_guru'] = $this->guru->get_data_akun_guru(); 

        // var_dump($data['akun_guru']);

        // inputan name
        $this->form_validation->set_rules('name', 'Name', 'required', [
            'required' => 'Nama tidak boleh kosong!'
        ]);

        // inputan username
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]', [
            'is_unique' => 'Username sudah terdaftar!',
            'required' => 'Username tidak boleh kosong!'
        ]);

        // inputan email
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'Email sudah terdaftar!',
            'required' => 'Email tidak boleh kosong!'
        ]);

        // inputan password
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]', [
            'min_length' => 'Password terlalu pendek!',
            'required' => 'Password tidak boleh kosong!'
        ]);


        if ($this->form_validation->run() == false) {
            $data['akun_guru'] = $this->guru->get_data_akun_guru();
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/akun_guru/index', $data);
            $this->load->view('admin/template/footer', $data);

        } else {
            // upload gambar
            // cek jika ada gambar di upload atau tidak dari variable $_FILES
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                // file format yang boleh diupload
                $config['allowed_types'] = 'gif|jpg|png|jpeg|heic';

                // ukuran file yang boleh diupload lebh dari 5mb
                $config['max_size'] = '5120';

                // lokasi penyimpanan file
                $config['upload_path'] = './assets/img/guru/profile/';

                // resolusi gambar yang diupload
                // $config['max_width'] = '1024';
                // $config['max_height'] = '768';

                // load library upload  
                $this->load->library('upload', $config);

                // cek apakah file berhasil diupload
                if ($this->upload->do_upload('image')) {
                    // add gambar baru 
                    $new_image = $this->upload->data('file_name');
                } else {
                    // jika gagal
                    echo $this->upload->display_errors();

                    // flash data
                    $this->session->set_flashdata('flash_failed', 'File melebihin batas!');

                    redirect('admin/akun_guru');
                }
            } else {
                // jika tidak ada gambar yang diupload
                $new_image = 'default.png';
            }

            //  email yang diinputkan :
            $email = $this->input->post('email', true);


            // siapkan token!
            // function base64_encode untuk mendeskripsi token agar bisa diakses di url
            // base64_encode untuk mendeskripsi token agar bisa disimpan ke database
            $token = base64_encode(random_bytes(32));

            // insert data  akun guru ke database
            $this->guru->insert_akun_guru($new_image);


            // simpan token ke database
            date_default_timezone_set("Asia/Singapore");
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => date('Y/m/d H:i:s')
            ];

            $this->db->insert('user_token', $user_token);

            // setelah data berhasil disimpan, kirim email untuk verifikasi
            $this->_sendEmail($token);
            
            // flashdata
            $this->session->set_flashdata('flash', 'ditambahkan!');

            // redirect
            redirect('admin/akun_guru');
        }
    }

    // email verifikasi dengan function modifier private
    private function _sendEmail($token)
    {

        // email admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));
        $emailAdmin = $data['user']['email'];

        $email = $this->input->post('email');
        $subject =  'Akun Guru SIAP';
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;                                     //Enable SMTP authentication
        $mail->Username = $emailAdmin;
        $mail->Password = 'gchmemrutuqiiuga';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom($emailAdmin, 'Admin SIAP');
        $mail->addAddress($email);
        $mail->Subject = ($subject);
        // $mail->Body = $message;

        // inputan username dan password
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // link untuk mengarahakan aktifasi akun
        $link = base_url() . 'auth/verify?email=' . $email . '&token=' . urlencode($token);

        // hari ini 
        $date = date('Y-m-d');

        // file html 
        $htmlContent = file_get_contents('application/views/admin/message_email/register.php');
        $htmlContent = str_replace('{{USERNAME}}', $username, $htmlContent);
        $htmlContent = str_replace('{{PASSWORD}}', $password, $htmlContent);
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


    // hapus akun guru
    public function hapus_akun_guru($username)
    {
        $data['akun_guru'] = $this->guru->get_data_by_username($username);
        $old_image = $data['akun_guru']['foto'];
        // var_dump($old_image);
        // die;
        sleep(2);
        if ($old_image == 'default.png' || $old_image == 'default1.png') {
            // hapus data sekolah melalui model atau database
            $this->guru->delete_guru($username);
            //redirect
            redirect('admin/akun_guru');
        }

        if ($old_image != 'default.png'
        ) {
            unlink(FCPATH . 'assets/img/guru/profile/' . $old_image);
            // hapus data sekolah melalui model atau database
            $this->guru->delete_guru($username);
            //redirect
            redirect('admin/akun_guru');
        }
    }


    // generate password menggunakan ajax
    public function generate_password()
    {
        $length = 12; // panjang password
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $randomChar =  $chars[rand(0, strlen($chars) - 1)];
            $password .= $randomChar;
        }
        echo $password;
    }


    // halaman sekolah
    public function  sekolah()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // // get sekolah
        $data['sekolah'] = $this->sekolah->get_data_sekolah();
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/sekolah/index', $data);
        $this->load->view('admin/template/footer', $data);
    }

    // cari sekolah
    public function cari_sekolah(){
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));


        // ambil keyword search
        if($this->input->post('cari_sekolah')){
            $data['keyword'] = $this->input->post('cari_sekolah', true);
            // ambil data melalui session
            $this->session->set_userdata('keyword', $data['keyword']);
        }else{
            $data['keyword'] = $this->session->userdata('keyword');
        }

 

        // // config pagination
        // $config['base_url'] = 'http://bro-developer/sisteminformasiantiperundungan/admin/cari_sekolah/index';
        // config pagination
        $config['base_url'] = base_url('admin/cari_sekolah/index');

        // total data semua sekolah
        $this->db->like('nama_sekolah', $data['keyword']);
        $this->db->from('sekolah');
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 8;
        $config['num_links'] = 3;

        $data['all_sekolah'] = $config['total_rows'];


        // styling pagination
        // tag pembuka dan tag penutup
        $config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '  </ul></nav>';

        // tampilan first
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        // tampilan last
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        // tampilan tanda next
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        // tampilan tanda prev
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        // tampilan current page atau tampilan sekarang yang sedang active
        $config['cur_tag_open'] = '<li class="page-item active"> <a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        // tampilan number atau digit
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        // dikarenakan pagination ci tidak memiliki class maka kita harus menambahkan class dengan code berikut!
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        // pagination data sekolah
        $data['start'] = $this->uri->segment(4);
        $data['sekolah'] = $this->sekolah->get_all_sekolah_pagination($config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/sekolah/cari_sekolah', $data);
        $this->load->view('admin/template/footer', $data);

    }

    // halaman detail sekolah
    public function  detail_sekolah($id)
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // // get akun guru
        // $data['sekolah'] = $this->sekolah->get_data_sekolah();
        // get data sekolah by id
        $data['sekolah'] = $this->sekolah->get_data_sekolah_by_id($id);

        // menghitung keseluruhan data lapor perundungan 
        $data['lapor_siswa'] = $this->laporan->TotalPerundunganBySekolah($id);
        // var_dump($data['lapor_siswa']);
        // die;

        // get data siswa by id sekolah
        $data['siswa'] =  $this->siswa->get_data_siswa_by_id_sekolah($id);


        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/sekolah/detail_sekolah', $data);
        $this->load->view('admin/template/footer', $data);
    }

    // halaman tambah sekolah 
    public function tambah_sekolah(){
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // nama_sekolah
        $this->form_validation->set_rules(
            'name',
            'Name',
            'required|trim',
            [
                'required' => 'Nama sekolah harus disii!'
            ]
        );

        // alamat_sekolah
        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
            'required|trim',
            [
                'required' => 'Alamat sekolah harus disii!'
            ]
        );

        // no_telepon_sekolah
        $this->form_validation->set_rules(
            'no_telepon',
            'No_telepon',
            'required|max_length[14]|trim',
            [
                'required' => 'Nomor telepon harus disii!',
                'max_length' => 'Nomor yang anda masukan salah'
            ]
        );

        // kabupaten
        $this->form_validation->set_rules(
            'kabupaten',
            'Kabupaten',
            'required',
            [
                'required' => 'Silahkan pilih kabupaten!',
            ]
        );

        // kecamatan
        $this->form_validation->set_rules(
            'kecamatan',
            'Kecamatan',
            'required',
            [
                'required' => 'Silahkan pilih kecamatan!',
            ]
        );

        // kota
        $this->form_validation->set_rules(
            'kota',
            'Kota',
            'required',
            [
                'required' => 'Silahkan pilih kota!',
            ]
        );


        if($this->form_validation->run() == false){
            $data['kabupaten'] =  $this->sekolah->get_kabupaten();
            $data['kecamatan'] =  $this->sekolah->get_kecamatan();
            $data['kota'] =  $this->sekolah->get_kota();
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/sekolah/tambah_sekolah', $data);
            $this->load->view('admin/template/footer', $data);
        }else{
            // upload gambar
            // cek jika ada gambar di upload atau tidak dari variable $_FILES
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                // file format yang boleh diupload
                $config['allowed_types'] = 'gif|jpg|png|jpeg|heic';

                // ukuran file yang boleh diupload lebh dari 5mb
                $config['max_size'] = '5120';

                // lokasi penyimpanan file
                $config['upload_path'] = './assets/img/sekolah/gambar/';

                // resolusi gambar yang diupload
                // $config['max_width'] = '1024';
                // $config['max_height'] = '768';

                // load library upload  
                $this->load->library('upload', $config);

                // cek apakah file berhasil diupload
                if ($this->upload->do_upload('image')) {
                    // add gambar baru 
                    $new_image = $this->upload->data('file_name');
                } else {
                    // jika gagal
                    echo $this->upload->display_errors();
                    
                    // flash data
                    $this->session->set_flashdata('flash_failed', 'File melebihin batas!');

                    redirect('admin/sekolah');
                }
            } else {
                // jika tidak ada gambar yang diupload
                $new_image = 'default.png';
            }

            // insert ke database
            $this->sekolah->insert_sekolah($new_image);

            //  flash data
            $this->session->set_flashdata('flash', 'ditambahkan!');

            // redirect
            redirect('admin/sekolah');
        }
    }


    // halaman tambah sekolah 
    public function edit_sekolah($id)
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // nama_sekolah
        $this->form_validation->set_rules(
            'name',
            'Name',
            'required|trim',
            [
                'required' => 'Nama sekolah harus disii!'
            ]
        );
        // alamat_sekolah
        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
            'required|trim',
            [
                'required' => 'Alamat sekolah harus disii!'
            ]
        );

        // no_telepon_sekolah
        $this->form_validation->set_rules(
            'no_telepon',
            'No_telepon',
            'required|max_length[14]|trim',
            [
                'required' => 'Nomor telepon harus disii!',
                'max_length' => 'Nomor yang anda masukan salah'
            ]
        );

        // kabupaten
        $this->form_validation->set_rules(
            'kabupaten',
            'Kabupaten',
            'required',
            [
                'required' => 'Silahkan pilih kabupaten!',
            ]
        );

        // kecamatan
        $this->form_validation->set_rules(
            'kecamatan',
            'Kecamatan',
            'required',
            [
                'required' => 'Silahkan pilih kecamatan!',
            ]
        );

        // kota
        $this->form_validation->set_rules(
            'kota',
            'Kota',
            'required',
            [
                'required' => 'Silahkan pilih kota!',
            ]
        );

        // get data sekolah by id
        $data['sekolah'] = $this->sekolah->get_data_sekolah_by_id($id);

        if ($this->form_validation->run() == false) {
            $data['kabupaten'] =  $this->sekolah->get_kabupaten();
            $data['kecamatan'] =  $this->sekolah->get_kecamatan();
            $data['kota'] =  $this->sekolah->get_kota();
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/sekolah/edit_sekolah', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            // upload gambar
            // cek jika ada gambar di upload atau tidak dari variable $_FILES
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                // file format yang boleh diupload
                $config['allowed_types'] = 'gif|jpg|png|jpeg|heic';

                // ukuran file yang boleh diupload lebh dari 5mb
                $config['max_size'] = '5120';

                // lokasi penyimpanan file
                $config['upload_path'] = './assets/img/sekolah/gambar/';

                // resolusi gambar yang diupload
                // $config['max_width'] = '1024';
                // $config['max_height'] = '768';

                // load library upload  
                $this->load->library('upload', $config);

                // cek apakah file berhasil diupload
                if ($this->upload->do_upload('image')) {
                    // add gambar baru 
                    $new_image = $this->upload->data('file_name');

                    // gambar lama selain gambar defaultnya
                    $old_image = $data['sekolah']['gambar'];
                    // var_dump($old_image);
                    // die;
                    // cek apakah ada gambar atau tidak
                    // cek jika selain nama gambar default maka hapus gambar lama
                    if ($old_image && $old_image != 'default.png') {
                        // jika ada hapus gambar lama
                        unlink(FCPATH . 'assets/img/sekolah/gambar/' . $old_image);
                    }

                } else {
                    // jika gagal
                    echo $this->upload->display_errors();

                    // flash data
                    $this->session->set_flashdata('flash_failed', 'File melebihin batas!');

                    redirect('admin/sekolah');
                }
            } else {
                // jika tidak ada gambar yang diupload maka gunakan gambar lama dengan variable new_image
                $new_image = $data['sekolah']['gambar'];
            }

            // update data sekolah melalui model atau database
            $this->sekolah->update_sekolah($id, $new_image);


            //  flash data
            $this->session->set_flashdata('flash', 'diubah!');

            // redirect
            redirect('admin/sekolah');
        }
    }

    // hapus halaman sekolah
    public function hapus_sekolah($id){
        $data['sekolah'] = $this->sekolah->get_data_sekolah_by_id($id);
        $old_image = $data['sekolah']['gambar'];
        // var_dump($old_image);
        sleep(2);
        if ($old_image == 'default.png') {
            // hapus data sekolah melalui model atau database
            $this->sekolah->delete_sekolah($id);
            //redirect
            redirect('admin/sekolah');
        }

        if ($old_image != 'default.png') {

            unlink(FCPATH . 'assets/img/sekolah/gambar/' . $old_image);
            // hapus data sekolah melalui model atau database
            $this->sekolah->delete_sekolah($id);
            //redirect
            redirect('admin/sekolah');
        }
    }


    // memanggil data kecamatan
    public function getKecamatan()
    {
        $kabupatenId = $this->input->post('kabupatenId');

        // Ambil data kecamatan dari database berdasarkan kabupatenId
        // Contoh pengambilan data dari model
        $dataKecamatan = $this->sekolah->getKecamatan($kabupatenId);

        echo json_encode($dataKecamatan);
    }


    // memanggil data kota
    public function getKota()
    {

        $kabupatenId = $this->input->post('kabupatenId');

        $dataKota = $this->sekolah->getKota($kabupatenId);

        echo json_encode($dataKota);
    }



    // halaman klasifikasi 
    public function klasifikasi(){

    // data admin
    $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

    // get klasifikasi
    $data['klasifikasi'] = $this->klasifikasi->get_data_klasifikasi();
    // var_dump($data['klasifikasi']);

    $this->load->view('admin/template/header', $data);
    $this->load->view('admin/template/sidebar', $data);
    $this->load->view('admin/template/topbar', $data);
    $this->load->view('admin/klasifikasi/index', $data);
    $this->load->view('admin/template/footer', $data);
    }



    // tambah klasifikas 
    public function tambah_klasifikasi(){


        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get klasifikasi
        $data['klasifikasi'] = $this->klasifikasi->get_data_klasifikasi();
        // var_dump($data['klasifikasi']);

        $this->form_validation->set_rules(
            'klasifikasi',
            'Klasifikasi',
            'required|trim',
            [
                'required' => 'klasifikasi harus disii!'
            ]
        );

        if($this->form_validation->run() === false){

            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/klasifikasi/index', $data);
            $this->load->view('admin/template/footer', $data);

        }else{
            // insert ke database
            $this->klasifikasi->insert_klasifikasi();

            //  flash data
            $this->session->set_flashdata('flash', 'ditambahkan!');

            // redirect
            redirect('admin/klasifikasi');
    
        }

    }


    // edit klasifikas 
    public function edit_klasifikasi($id)
    {


        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get klasifikasi
        $data['klasifikasi'] = $this->klasifikasi->get_data_klasifikasi();
        // var_dump($data['klasifikasi']);

        $this->form_validation->set_rules(
            'edit_klasifikasi',
            'Edit_klasifikasi',
            'required|trim',
            [
                'required' => 'klasifikasi harus disii!'
            ]
        );

        if ($this->form_validation->run() === false) {

            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/klasifikasi/index', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            // insert ke database
            $this->klasifikasi->update_klasifikasi($id);

            //  flash data
            $this->session->set_flashdata('flash', 'diperbarui!');

            // redirect
            redirect('admin/klasifikasi');
        }
    }


    // hapus klasifikasi
    public function hapus_klasifikasi($id){

        $this->klasifikasi->delete_klasifikasi($id);

        //  flash data
        $this->session->set_flashdata('flash', 'dihapus!');

        // redirect
        redirect('admin/klasifikasi');

    }



    // halaman siswa
    public function siswa(){
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get akun guru
        $data['siswa'] = $this->siswa->get_data_siswa();
        // var_dump($data['siswa']);

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/siswa/index', $data);
        $this->load->view('admin/template/footer', $data);
    }


    public function getGuru(){
        $sekolah = $this->input->post('sekolah');

        // Ambil data guru dari database berdasarkan sekolah
        // Contoh pengambilan data dari model
        $guru = $this->guru->get_guru_by_sekolah($sekolah);

        echo json_encode($guru);
    }

    // halaman tambah siswa
    public function tambah_siswa()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        //  get data siswa
        $data['siswa'] = $this->siswa->get_data_siswa();

        // get data kelas dari model siswa
        $data['kelas'] = $this->siswa->get_data_kelas();


        $data['akun_guru'] = $this->guru->get_data_akun_guru();
        // var_dump($data['akun_guru']);   


        // nisn
        $this->form_validation->set_rules(
            'nisn',
            'Nisn',
            'required|trim|is_unique[siswa.nisn]|max_length[10]|min_length[10]|numeric',
            [
                'required' => 'NISN harus disii!',
                'is_unique' => 'NISN sudah terdaftar!',
                'max_length' => 'NISN yang anda masukan salah',
                'min_length' => 'NISN yang anda masukan kurang dari 10 digit',
                'unique' => 'NISN sudah terdaftar!'
            ]
        );
        // nama_siswa
        $this->form_validation->set_rules(
            'name',
            'Name',
            'required|trim',
            [
                'required' => 'Nama siswa harus disii!'
            ]
        );

        // alamat siswa
        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
            'required|trim',
            [
                'required' => 'Alamat siswa harus disii!'
            ]
        );

        // no_telepon siswa
        $this->form_validation->set_rules(
            'no_telepon',
            'No_telepon',
            'required|max_length[20]|trim',
            [
                'required' => 'Nomor telepon harus disii!',
                'max_length' => 'Nomor yang anda masukan salah'
            ]
        );

        // jenis_kelamin
        $this->form_validation->set_rules(
            'jenis_kelamin',
            'Jenis_kelamin',
            'required',
            [
                'required' => 'Silahkan pilih jenis kelamin!',
            ]
        );

        // tanggal_lahir
        $this->form_validation->set_rules(
            'tanggal_lahir',
            'Tanggal_lahir',
            'required',
            [
                'required' => 'Masukan tanggal lahir!',
            ]
        );

        // umur
        $this->form_validation->set_rules(
            'umur',
            'Umur',
            'required',
            [
                'required' => 'Umur harus diisi!',
            ]
        );

        // sekolah
        $this->form_validation->set_rules(
            'sekolah',
            'Sekolah',
            'required',
            [
                'required' => 'Sekolah harus diisi!',
            ]
        );


        // guru
        $this->form_validation->set_rules(
            'guru',
            'Guru',
            'required',
            [
                'required' => 'Guru harus dipilih!',
            ]
        );

        // kelas
        $this->form_validation->set_rules(
            'kelas',
            'Kelas',
            'required',
            [
                'required' => 'Kelas harus diisi!',
            ]
        );


        if ($this->form_validation->run() == false
        ) {
            // get data sekolah
            $data['sekolah'] = $this->sekolah->get_data_sekolah();
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/siswa/tambah_siswa', $data);
            $this->load->view('admin/template/footer', $data);

        } else {
            // upload gambar
            // cek jika ada gambar di upload atau tidak dari variable $_FILES
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                // file format yang boleh diupload
                $config['allowed_types'] = 'gif|jpg|png|jpeg|heic';

                // ukuran file yang boleh diupload lebh dari 5mb
                $config['max_size'] = '5120';

                // lokasi penyimpanan file
                $config['upload_path'] = './assets/img/siswa/foto/';

                // resolusi gambar yang diupload
                // $config['max_width'] = '1024';
                // $config['max_height'] = '768';

                // load library upload  
                $this->load->library('upload', $config);

                // cek apakah file berhasil diupload
                if ($this->upload->do_upload('image')) {
                    // add gambar baru 
                    $new_image = $this->upload->data('file_name');
                } else {
                    // jika gagal
                    echo $this->upload->display_errors();

                    // flash data
                    $this->session->set_flashdata('flash_failed', 'File melebihin batas!');

                    redirect('admin/siswa');
                    
                }
            } else {
                // jika tidak ada gambar yang diupload
                    $new_image = 'default.png';
            }

            // insert ke database
            $this->siswa->insert_siswa($new_image);

            //  flash data
            $this->session->set_flashdata('flash', 'ditambahkan!');

            // redirect
            redirect('admin/siswa');
        }
    }

    // halaman edit siswa
    public function edit_siswa($id)
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        //  get data siswa
        $data['siswa'] = $this->siswa->get_data_siswa_by_id($id);
        // var_dump($data['siswa']);

        // get data kelas dari model siswa
        $data['kelas'] = $this->siswa->get_data_kelas();

        $data['akun_guru'] = $this->guru->get_data_akun_guru();

        // nisn
        $this->form_validation->set_rules(
            'nisn',
            'Nisn',
            'required|trim|max_length[10]|min_length[10]|numeric',
            [
                'required' => 'NISN harus disii!',
                'max_length' => 'NISN yang anda masukan salah',
                'min_length' => 'NISN yang anda masukan kurang dari 10 digit',
            ]
        );

        // nama_siswa
        $this->form_validation->set_rules(
            'name',
            'Name',
            'required|trim',
            [
                'required' => 'Nama siswa harus disii!'
            ]
        );

        // alamat siswa
        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
                'required|trim',
            [
                'required' => 'Alamat siswa harus disii!'
            ]
        );

        // no_telepon siswa
        $this->form_validation->set_rules(
            'no_telepon',
            'No_telepon',
            'required|max_length[20]|trim',
            [
                'required' => 'Nomor telepon harus disii!',
                'max_length' => 'Nomor yang anda masukan salah'
            ]
        );

        // jenis_kelamin
        $this->form_validation->set_rules(
            'jenis_kelamin',
            'Jenis_kelamin',
            'required',
            [
                'required' => 'Silahkan pilih jenis kelamin!',
            ]
        );

        // tanggal_lahir
        $this->form_validation->set_rules(
            'tanggal_lahir',
            'Tanggal_lahir',
            'required',
            [
                'required' => 'Masukan tanggal lahir!',
            ]
        );

        // umur
        $this->form_validation->set_rules(
            'umur',
            'Umur',
            'required',
            [
                'required' => 'Umur harus diisi!',
            ]
        );

        // sekolah
        $this->form_validation->set_rules(
            'sekolah',
            'Sekolah',
            'required',
            [
                'required' => 'Sekolah harus diisi!',
            ]
        );


        // guru
        $this->form_validation->set_rules(
            'guru',
            'Guru',
            'required',
            [
                'required' => 'Guru harus dipilih!',
            ]
        );



        // kelas
        $this->form_validation->set_rules(
            'kelas',
            'Kelas',
            'required',
            [
                'required' => 'Kelas harus diisi!',
            ]
        );


        if (
            $this->form_validation->run() == false
        ) {
            // get data sekolah
            $data['sekolah'] = $this->sekolah->get_data_sekolah();
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/siswa/edit_siswa', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            // upload gambar
            // cek jika ada gambar di upload atau tidak dari variable $_FILES
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                // file format yang boleh diupload
                $config['allowed_types'] = 'gif|jpg|png|jpeg|heic';

                // ukuran file yang boleh diupload lebh dari 5mb
                $config['max_size'] = '5120';

                // lokasi penyimpanan file
                $config['upload_path'] = './assets/img/siswa/foto/';

                // resolusi gambar yang diupload
                // $config['max_width'] = '1024';
                // $config['max_height'] = '768';

                // load library upload  
                $this->load->library('upload', $config);

                // cek apakah file berhasil diupload
                if ($this->upload->do_upload('image')) {
                    // add gambar baru 
                    $new_image = $this->upload->data('file_name');
                    // gambar lama siswa 
                    $old_image = $data['siswa']['foto'];

                    if ($old_image && $old_image != 'default.png') {
                        // jika ada hapus gambar lama 
                        unlink(FCPATH . 'assets/img/siswa/foto/' . $old_image);
                    }
                } else {
                    // jika gagal
                    echo $this->upload->display_errors();

                    // flash data
                    $this->session->set_flashdata('flash_failed', 'File melebihin batas!');

                    redirect('admin/siswa');
                }
            } else {
                // jika tidak ada gambar yang diupload maka gunakan gambar lama dengan variable new_image
                $new_image = $data['siswa']['foto'];
            }

            // insert ke database
            $this->siswa->edit_siswa($id, $new_image);

            //  flash data
            $this->session->set_flashdata('flash', 'diubah!');

            // redirect
            redirect('admin/siswa');
        }
    }


    // hapus siswa
    public function hapus_siswa($id)
    {
        $data['siswa'] = $this->siswa->get_data_siswa_by_id($id);
        $old_image = $data['siswa']['foto'];
        // var_dump($old_image);
        sleep(2);
        if ($old_image == 'default.png') {
            // hapus data siswa melalui model atau database
            $this->siswa->delete_siswa($id);
            //redirect
            redirect('admin/siswa');
        }

        if ($old_image != 'default.png') {

            unlink(FCPATH . 'assets/img/siswa/foto/' . $old_image);
            // hapus data siswa melalui model atau database
            $this->siswa->delete_siswa($id);
            //redirect
            redirect('admin/siswa');
        }
    }

    // Report Siswa
    public function lapor_siswa()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get akun guru
        $data['laporan'] = $this->laporan->get_data_laporan_siswa();
        // var_dump($data['laporan']);
        // var_dump($data['siswa']);

        $this->session->unset_userdata('klasifikasi');

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/lapor_siswa/index', $data);
        $this->load->view('admin/template/footer', $data);
    }


    // Tambah Report Siswa
    public function edit_lapor_siswa($id)
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get data kelas dari model siswa
        $data['kelas'] = $this->siswa->get_data_kelas();
        // get data sekolah
        $data['sekolah'] = $this->sekolah->get_data_sekolah();
        // var_dump($data['siswa']);

        $data['lapor_siswa'] = $this->laporan->get_data_laporan_siswa_by_id($id);
        // var_dump($data['lapor_siswa']);

        // nisn
        $this->form_validation->set_rules(
            'nisn',
            'Nisn',
            'required',
            [
                'required' => 'NISN harus diisi!',
            ]
        );

        // nama
        $this->form_validation->set_rules(
            'name',
            'Name',
            'required',
            [
                'required' => 'Nama harus diisi!',
            ]
        );

        // kelas
        $this->form_validation->set_rules(
            'kelas',
            'Kelas',
            'required',
            [
                'required' => 'Kelas harus diisi!',
            ]
        );

        // keterangan
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'required',
            [
                'required' => 'Keterangan harus diisi!',
            ]
        );


        // sekolah
        $this->form_validation->set_rules(
            'sekolah',
            'Sekolah',
            'required',
            [
                'required' => 'Sekolah harus diisi!',
            ]
        );

        if($this->form_validation->run() == false){
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/lapor_siswa/edit_lapor_siswa', $data);
            $this->load->view('admin/template/footer', $data);
        }else{
            // insert ke database
            $this->laporan->update_laporan_siswa($data['user']['id'], $id);

            //  flash data
            $this->session->set_flashdata('flash', 'diperbarui!');

            // redirect
            redirect('admin/lapor_siswa');
        }
    }


    public function tambah_lapor_siswa()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get data kelas dari model siswa
        $data['kelas'] = $this->siswa->get_data_kelas();
        // get data sekolah
        $data['sekolah'] = $this->sekolah->get_data_sekolah();
        // var_dump($data['siswa']);

        // nisn
        $this->form_validation->set_rules(
            'nisn',
            'Nisn',
            'required',
            [
                'required' => 'NISN harus diisi!',
            ]
        );

        // nama
        $this->form_validation->set_rules(
            'name',
            'Name',
            'required',
            [
                'required' => 'Nama harus diisi!',
            ]
        );

        // kelas
        $this->form_validation->set_rules(
            'kelas',
            'Kelas',
            'required',
            [
                'required' => 'Kelas harus diisi!',
            ]
        );

        // keterangan
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'required',
            [
                'required' => 'Keterangan harus diisi!',
            ]
        );


        // sekolah
        $this->form_validation->set_rules(
            'sekolah',
            'Sekolah',
            'required',
            [
                'required' => 'Sekolah harus diisi!',
            ]
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/lapor_siswa/tambah_lapor_siswa', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            // insert ke database
            $this->laporan->insert_laporan_siswa($data['user']['id']);

            // tambah kolom total_perundungan di tabel siswa
            $this->db->set('total_rundungan', 'total_rundungan + 1', FALSE);
            $this->db->where('id', $this->input->post('id_siswa'));
            $this->db->update('siswa');


            //  flash data
            $this->session->set_flashdata('flash', 'ditambahkan!');

            // redirect
            redirect('admin/lapor_siswa');
        }
    }

    // hapus laporan siswa
    public function hapus_laporan_siswa($id, $id_siswa)
    {
        sleep(2);

        // delete data laporan siswa
        $this->laporan->delete_laporan_siswa($id);


        // tambah kolom total_perundungan di tabel siswa
        $this->db->set('total_rundungan', 'total_rundungan - 1', FALSE);
        $this->db->where('id', $id_siswa);
        $this->db->update('siswa');

        //redirect
        redirect('admin/lapor_siswa');
    }


    // get data nisn untuk ajax
    public function get_data_nisn(){
        $nisn = $this->input->post('nisn');
        $data_nisn = $this->siswa->get_data_siswa_by_nisn($nisn);
        if ($data_nisn) {
            echo json_encode(array('success' => true, 'data' => $data_nisn));
        } else {
            echo json_encode(array('success' => false));
        }
    }



    // halaman log lapor perundungan
    public function log($id){
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get data lapor siswa 
        $data['lapor'] = $this->laporan->get_data_laporan_by_id($id);
        // var_dump($data['lapor']);
        // die;

        $data['dateMulai'] = date('Y-m-d H:i:s');

        // // get data status kecuali 0
        $data['status'] = $this->log_laporan->get_status();
        // var_dump($data['status']);

        // id laporan
        // $data['lapor_siswa'] = $id;
        

        $data['log'] = $this->log_laporan->get_data_log_by_id_laporan($id);
        // var_dump($data['log']);
        // die;

        // data klasifikasi 
        $data['klasifikasi'] = $this->klasifikasi->get_data_klasifikasi();

        // // logika klasifikasi
        // $data_session_klasifikasi =$this->session->userdata('klasifikasi');
        // if($data['log']){
        //     if($data_session_klasifikasi){
        //         $laporan_klasifikasi = $data_session_klasifikasi;
        //     }else{
        //         $data_log_1 = $data['log'][0]['id_klasifikasi'];
        //         if($data_log_1){
        //             $laporan_klasifikasi = $data_log_1;
        //         }else {
        //             $laporan_klasifikasi = null;
        //         }
        //     }

        //     $data_log_1 = $data['log'][0]['id_klasifikasi'];
        //     if
        //     ($data_session_klasifikasi && $data_log_1){
        //         $laporan_klasifikasi = $data['log'][0]['id_klasifikasi'];
        //     }
            
        // }else{
        //     if
        //     ($data_session_klasifikasi){
        //         $laporan_klasifikasi = $data_session_klasifikasi;
        //     }else{
        //         $laporan_klasifikasi = null;
        //     }
        // }
        // var_dump($data_session_klasifikasi);
        // die;
        // $data['status_klasifikasi'] = $laporan_klasifikasi;

        // $data['session_klasifikasi'] = $this->session->userdata('klasifikasi');
        // var_dump($data['session_klasifikasi']);
        // die;

        // pengambilan klasifikasi jika sudah ada nilai dinputkan maka log semua akan bernilai klasifikasinya
        // if($data['log']){
        //     $data['klasifikasi_laporan'] = $data['log'][0]['id_klasifikasi'];
        // }else{
        //     $data['klasifikasi_laporan'] = null;
        // }

        // data pertama akan digunakan untuk menambahkan log
        // $$data['status_klasifikasi'] = $data['klasifikasi_laporan'];
        // var_dump($data['klasifikasi_laporan']);
        // die;

        // data array status 
        $statusData = $this->db->get('status')->result_array();

        $statusArray = array();
        foreach ($statusData as $statusItem) {
            $statusArray[] = $statusItem['status'];
        }
        $data['statusJson'] = json_encode($statusArray);

        // data update status
        $this->db->select('*');
        $this->db->from('log'); // Ganti 'nama_tabel' dengan nama tabel yang sesuai
        $this->db->order_by('date_created', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $data['latest_data'] = $query->row_array();
        // var_dump($data['latest_data']);

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/log/index', $data);
        $this->load->view('admin/template/footer', $data);
    }

    // get waktu untuk date selesai
    public function get_date(){
        $id_status = $this->input->post('id_status');

        // var_dump($id_status);

        if($id_status && $id_status != '1'){
            $data['dateSelesai'] = date('Y-m-d H:i:s');
            echo json_encode(array('success' => true, 'data' => $data));
        }else{
            $data['dateSelesai'] = null;
            echo json_encode(array('success' => false));
        }
    }


    // update klasifikasi
    // id_log itu adalah id lapor_siswa
    public function updateKlasifikasi($id_log){

        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // option klasifikasi
        $this->form_validation->set_rules(
            'klasifikasi1',
            'Klasifikasi1',
            'required',
            [
                'required' => 'Klasifikasi harus dipilih!',
            ]
        );

        // var_dump($this->input->post('klasifikasi1'));
        // die;

        if($this->form_validation->run() == false){
            $this->session->set_flashdata('flash_failed', 'Klasifikasi harus dipilih!');
            redirect('admin/log/'.$id_log);
        }else{


            $klasifikasi = $this->input->post('klasifikasi1');
            $session_klasifikasi = $this->session->set_userdata('klasifikasi', $klasifikasi);
            // update semua data klasifikasi by id log
            $this->klasifikasi->update_klasifikasi_by_id_log($id_log);

            //  flash data
            $this->session->set_flashdata('flash', 'diperbarui!');

            redirect('admin/log/' . $id_log);
        }

    }

    // terapkan klasifikasi
    public function terapkanKlasifikasi($id_log){
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // option klasifikasi
        $this->form_validation->set_rules(
            'klasifikasi1',
            'Klasifikasi1',
            'required',
            [
                'required' => 'Klasifikasi harus dipilih!',
            ]
        );

        // var_dump($this->input->post('klasifikasi1'));
        // die;

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('flash_failed', 'Klasifikasi harus dipilih!');
            redirect('admin/log/' . $id_log);
        } else {


            $klasifikasi = $this->input->post('klasifikasi1');

            // update klasifikawsi 
            $this->klasifikasi->update_klasifikasi_by_id_log($id_log,$klasifikasi);

            
            // $session_klasifikasi = $this->session->set_userdata('klasifikasi', $klasifikasi);

            // //  flash data
            $this->session->set_flashdata('flash', 'diterapkan');
            redirect('admin/log/' . $id_log);
            // var_dump($klasifikasi);
            // die;
        }
    }


    // tambah log laporan 
    public function tambah_log($id){

        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get data lapor siswa 
        $data['lapor'] = $this->laporan->get_data_laporan_by_id($id);

        $data['dateMulai'] = date('Y-m-d H:i:s');

        // // get data status kecuali 0
        $data['status'] = $this->log_laporan->get_status();

        // // id laporan
        $data['lapor_siswa'] = $id;
        // var_dump($data['lapor']);

        $data['log'] = $this->log_laporan->get_data_log_by_id_laporan($id);

        // pengambilan klasifikasi jika sudah ada nilai dinputkan maka log semua akan bernilai klasifikasinya
        if ($data['log']) {
            $data['klasifikasi_laporan'] = $data['log'][0]['id_klasifikasi'];
        } else {
            $data['klasifikasi_laporan'] = null;
        }

        $data['status_klasifikasi'] = $data['klasifikasi_laporan'];

        // data klasifikasi 
        $data['klasifikasi'] = $this->klasifikasi->get_data_klasifikasi();



        if($data['lapor']['id_klasifikasi'] == null || $data['lapor']['klasifikasi'] == null){
            $this->session->set_flashdata('flash_failed', 'Klasifikasi harus dipilih!');
            redirect('admin/log/' . $id);

        }


        // data array status 
        $statusData = $this->db->get('status')->result_array();

        $statusArray = array();
        foreach ($statusData as $statusItem) {
            $statusArray[] = $statusItem['status'];
        }
        $data['statusJson'] = json_encode($statusArray);

        // Date Mulai
        $this->form_validation->set_rules(
            'date_mulai',
            'Date_mulai',
            'required',
            [
                'required' => 'Date Mulai harus diisi!',
            ]
        );

        // Date Selesai
        $this->form_validation->set_rules(
            'date_selesai',
            'Date_selesai',
            'required',
            [
                'required' => 'Date selesai harus diisi!',
            ]
        );

        // option status
        $this->form_validation->set_rules(
            'optionStatus',
            'OptionStatus',
            'required',
            [
                'required' => 'Status harus dipilih!',
            ]
        );


        // // option klasifikasi
        // $this->form_validation->set_rules(
        //     'optionKlasifikasi',
        //     'OptionKlasifikasi',
        //     'required',
        //     [
        //         'required' => 'Klasifikas harus dipilih!',
        //     ]
        // );

        // keterangan
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'required',
            [
                'required' => 'Keterangan harus diisi!',
            ]
        );


        if($this->form_validation->run() === false){
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/log/index', $data);
            $this->load->view('admin/template/footer', $data);
        }else{
            

            // insert ke data base dan data session klasifikasi
            // $klasifikasi = $this->session->userdata('klasifikasi');

            // if($klasifikasi){
            //     $klasifikasi = $this->session->userdata('klasifikasi');
            // }else{
            //     $klasifikasi = $this->input->post('klasifikasi');

            //     if($klasifikasi == null){

            //         // flash data
            //         $this->session->set_flashdata('flash_failed', 'Klasifikasi harus dipilih!');

            //         // redirect halaman log
            //         redirect('admin/log/'.$id);
            //     }
            // }

            $user = $data['user']['id'];
            $this->log_laporan->insert_log($id, $user);



            $this->db->select('*');
            $this->db->from('log'); // Ganti 'nama_tabel' dengan nama tabel yang sesuai
            $this->db->order_by('date_created', 'DESC');
            $this->db->limit(1);
            $query = $this->db->get();
            $data['data_status'] = $query->row_array();
            
            $status = $data['data_status']['status'];

            // tambah kolom status di tabel lapor_siswa
            $this->db->set('status', $status);
            $this->db->where('id_laporan', $id);
            $this->db->update('lapor_siswa');


            //  flash data
            $this->session->set_flashdata('flash', 'ditambahkan!');

            // redirect
            redirect('admin/log/'.$id);
        }
    }


    // edit log laporan siswa
    // tambah log laporan 
    public function edit_log($id_log)
    {

        $id = $this->input->post('edit_lapor_siswa');

        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get data lapor siswa 
        $data['lapor'] = $this->laporan->get_data_laporan_by_id($id);

        $data['dateMulai'] = date('Y-m-d H:i:s');

        // // get data status kecuali 0
        $data['status'] = $this->log_laporan->get_status();

        // // id laporan
        $data['lapor_siswa'] = $id;
        // var_dump($data['lapor']);

        $data['log'] = $this->log_laporan->get_data_log_by_id_laporan($id);

        // pengambilan klasifikasi jika sudah ada nilai dinputkan maka log semua akan bernilai klasifikasinya
        if ($data['log']) {
            $data['klasifikasi_laporan'] = $data['log'][0]['id_klasifikasi'];
        } else {
            $data['klasifikasi_laporan'] = null;
        }

        $data['status_klasifikasi'] = $data['klasifikasi_laporan'];

        // data array status 
        $statusData = $this->db->get('status')->result_array();

        $statusArray = array();
        foreach ($statusData as $statusItem) {
            $statusArray[] = $statusItem['status'];
        }
        $data['statusJson'] = json_encode($statusArray);

        // Date Mulai
        $this->form_validation->set_rules(
            'edit_date_mulai',
            'Edit_date_mulai',
            'required',
            [
                'required' => 'Date Mulai harus diisi!',
            ]
        );

        // Date Selesai
        $this->form_validation->set_rules(
            'edit_date_selesai',
            'Edit_Date_selesai',
            'required',
            [
                'required' => 'Date selesai harus diisi!',
            ]
        );

        // option status
        $this->form_validation->set_rules(
            'edit_optionStatus',
            'Edit_optionStatus',
            'required',
            [
                'required' => 'Status harus dipilih!',
            ]
        );

        // // option klasifikasi
        // $this->form_validation->set_rules(
        //     'edit_optionKlasifikasi',
        //     'Edit_optionKlasifikasi',
        //     'required',
        //     [
        //         'required' => 'Klasifikas harus dipilih!',
        //     ]
        // );

        // keterangan
        $this->form_validation->set_rules(
            'edit_keterangan',
            'Edit_Keterangan',
            'required',
            [
                'required' => 'Keterangan harus diisi!',
            ]
        );

        if ($this->form_validation->run() === false) {
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/log/index', $data);
            $this->load->view('admin/template/footer', $data);
        } else {

            // update ke data base
            // $klasifikasi = $this->input->post('edit_klasifikasi');
            $user = $data['user']['id'];
            $this->log_laporan->update_log($id_log, $user);


            $this->db->select('*');
            $this->db->from('log'); // Ganti 'nama_tabel' dengan nama tabel yang sesuai
            $this->db->order_by('date_created', 'DESC');
            $this->db->limit(1);
            $query = $this->db->get();
            $data['data_status'] = $query->row_array();

            $status = $data['data_status']['status'];

            // tambah kolom status di tabel lapor_siswa
            $this->db->set('status', $status);
            $this->db->where('id_laporan', $id);
            $this->db->update('lapor_siswa');


            // //  flash data
            $this->session->set_flashdata('flash', 'diperbarui!');


            // redirect
            redirect('admin/log/' . $id);
        }
    }

    // hapus log laporan
    public function hapus_log($id, $id_log)
    {
        sleep(2);

        // delete data log laporan siswa
        $this->log_laporan->delete_log($id_log);



        $this->db->select('*');
        $this->db->from('log'); // Ganti 'nama_tabel' dengan nama tabel yang sesuai
        $this->db->order_by('date_created', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $data['data_status'] = $query->row_array();

        $status = $data['data_status']['status'];

        // tambah kolom status di tabel lapor_siswa
        $this->db->set('status', $status);
        $this->db->where('id_laporan', $id);
        $this->db->update('lapor_siswa');


        if($status === null){
        // update table lapor siswa bagian kolom status menjadi -
        $this->db->set('status', '4');
        $this->db->where('id_laporan', $id);
        $this->db->update('lapor_siswa');
        }


        //redirect
        redirect('admin/log/'. $id);
    }

    // my profile 
    public function profile(){
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/profile/index', $data);
        $this->load->view('admin/template/footer', $data);
    }

    // update profile
    public function update_profile($username){
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // data username
        // $this->form_validation->set_rules(
        //     'username',
        //     'Username',
        //     'required',
        //     [
        //         'required' => 'Username harus diisi!',
        //     ]
        // );

        // nama
        $this->form_validation->set_rules(
            'nama',
            'Nama',
            'required',
            [
                'required' => 'Nama harus diisi!',
            ]
        );

        // email
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email',
            [
                'required' => 'Email harus diisi!',
                'valid_email' => 'Email tidak valid!'
            ]
        );


        // password
        $this->form_validation->set_rules(
            'password',
            'Password',
            'trim|min_length[8]',
            [
                'min_length' => 'Password minimal 8 karakter!'
            ]
        );

        if($this->form_validation->run() === false){
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/profile/index', $data);
            $this->load->view('admin/template/footer', $data);
        }else{
            // upload gambar
            // cek jika ada gambar di upload atau tidak dari variable $_FILES
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                // file format yang boleh diupload
                $config['allowed_types'] = 'gif|jpg|png|jpeg|heic';

                // ukuran file yang boleh diupload lebh dari 5mb
                $config['max_size'] = '5120';

                // lokasi penyimpanan file
                $config['upload_path'] = './assets/img/admin/profile/';

                // resolusi gambar yang diupload
                // $config['max_width'] = '1024';
                // $config['max_height'] = '768';

                // load library upload  
                $this->load->library('upload', $config);

                // cek apakah file berhasil diupload
                if ($this->upload->do_upload('image')) {
                    // add gambar baru 
                    $new_image = $this->upload->data('file_name');

                    // gambar lama selain gambar defaultnya
                    $old_image = $data['user']['foto'];

                    // cek apakah ada gambar atau tidak
                    // cek jika selain nama gambar default maka hapus gambar lama
                    if ($old_image && $old_image != 'default.png' || $old_image != 'default1.png') {
                        // jika ada hapus gambar lama
                        unlink(FCPATH . 'assets/img/admin/profile/' . $old_image);
                    }
                } else {
                    // jika gagal
                    echo $this->upload->display_errors();
                }
            } else {
                // jika tidak ada gambar yang diupload maka gunakan gambar lama dengan variable new_image
                $new_image = $data['user']['foto'];
            }

            // perkondisian ganti password
            if ($this->input->post('password', true) == null) {
                $password_now = $data['user']['password'];
            } else {
                $password = $this->input->post('password', true);
                $password_now = password_hash($password, PASSWORD_DEFAULT);
            }
            // update data akun guru melalui model atau database
            $this->guru->update_profile($username, $new_image, $password_now);

            //  flash data
            $this->session->set_flashdata('flash', 'diperbarui!');

            // redirect
            redirect('admin/profile');
        }


    }
}
?>