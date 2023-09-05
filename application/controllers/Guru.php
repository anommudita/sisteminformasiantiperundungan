<?php

// depedency phpoffice 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Writer\Csv;
// use PhpOffice\PhpSpreadsheet\Writer\Xls;

// depedency phpmailer
use PharIo\Manifest\Email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require 'vendor/autoload.php';

class Guru extends CI_Controller{


    // constructor
    public function __construct()
    {
        parent::__construct();


        // styel baru mengambil model
        $this->load->model([
            'Sekolah_model' => 'sekolah',
            'Guru_model' => 'guru',
            'Siswa_model' => 'siswa',
            'Laporan_model' => 'laporan',
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
    }


    // API data guru dan siswa
    public function data_api()
    {
        $action = $this->input->get('action');
        $response = array(); // Inisialisasi response
        switch ($action) {
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
        }
        $response = json_encode($response);
        $this->output->set_content_type('application/json')
        ->set_output($response);
    }


    public function index(){
        // hapus session blocktime
        $this->session->unset_userdata('blockEndTime');

        // data guru
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // notif ketika guru belum isi data profile
        if($data['user']['sekolah'] === null || $data['user']['alamat'] === null || $data['user']['no_telp'] === null){
            $data['notif'] = 'notif';
        }else{
            $data['notif'] = '';
        }

        $data['siswa'] =  $this->siswa->countAllSiswaBySekolah($data['user']['sekolah']);

        $data['laporan'] = $this->laporan->countAllLaporanByGuru($data['user']['id']);

        $this->load->view('guru/template/header',$data);
        $this->load->view('guru/template/sidebar',$data);
        $this->load->view('guru/template/topbar',$data);
        $this->load->view('guru/dashboard/index',$data);
        $this->load->view('guru/template/footer',$data);
    }


    // halaman siswa
    public function siswa()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get akun guru
        $data['siswa'] = $this->siswa->get_data_siswa_by_guru($data['user']['sekolah']);
        // var_dump($data['siswa']);

        $this->load->view('guru/template/header', $data);
        $this->load->view('guru/template/sidebar', $data);
        $this->load->view('guru/template/topbar', $data);
        $this->load->view('guru/siswa/index', $data);
        $this->load->view('guru/template/footer', $data);
    }

    // halaman tambah siswa
    public function tambah_siswa()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // var_dump($data['user']['id']);

        //  get data siswa
        $data['siswa'] = $this->siswa->get_data_siswa();

        // get data kelas dari model siswa
        $data['kelas'] = $this->siswa->get_data_kelas();
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
            $this->load->view('guru/template/header', $data);
            $this->load->view('guru/template/sidebar', $data);
            $this->load->view('guru/template/topbar', $data);
            $this->load->view('guru/siswa/tambah_siswa', $data);
            $this->load->view('guru/template/footer', $data);
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

                    redirect('guru/siswa');
                }
            } else {
                // jika tidak ada gambar yang diupload
                $new_image = 'default.png';
            }


            // insert ke database
            $this->siswa->insert_siswa_by_guru($new_image, $data['user']['id'], $data['user']['sekolah']);

            //  flash data
            $this->session->set_flashdata('flash', 'ditambahkan!');

            // redirect
            redirect('guru/siswa');
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
            $this->load->view('guru/template/header', $data);
            $this->load->view('guru/template/sidebar', $data);
            $this->load->view('guru/template/topbar', $data);
            $this->load->view('guru/siswa/edit_siswa', $data);
            $this->load->view('guru/template/footer', $data);
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

                    redirect('guru/siswa');
                }
            } else {
                // jika tidak ada gambar yang diupload maka gunakan gambar lama dengan variable new_image
                $new_image = $data['siswa']['foto'];
            }

            // update ke databse
            $this->siswa->edit_siswa_by_guru($id, $new_image, $data['user']['id'], $data['user']['sekolah']);


            //  flash data
            $this->session->set_flashdata('flash', 'diubah!');

            // redirect
            redirect('guru/siswa');
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
            redirect('guru/siswa');
        }

        if ($old_image != 'default.png') {

            unlink(FCPATH . 'assets/img/siswa/foto/' . $old_image);
            // hapus data siswa melalui model atau database
            $this->siswa->delete_siswa($id);
            //redirect
            redirect('guru/siswa');
        }
    }


    // Report Siswa
    public function lapor_siswa()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get akun guru
        $data['laporan'] = $this->laporan->get_data_laporan_siswa_guru($data['user']['id']);
        // var_dump($data['laporan']);
        // var_dump($data['siswa']);

        $this->load->view('guru/template/header', $data);
        $this->load->view('guru/template/sidebar', $data);
        $this->load->view('guru/template/topbar', $data);
        $this->load->view('guru/lapor_siswa/index', $data);
        $this->load->view('guru/template/footer', $data);
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

        if ($this->form_validation->run() == false) {
            $this->load->view('guru/template/header', $data);
            $this->load->view('guru/template/sidebar', $data);
            $this->load->view('guru/template/topbar', $data);
            $this->load->view('guru/lapor_siswa/edit_lapor_siswa', $data);
            $this->load->view('guru/template/footer', $data);
        } else {
            // insert ke database
            $this->laporan->update_laporan_siswa($data['user']['id'], $id);

            //  flash data
            $this->session->set_flashdata('flash', 'diperbarui!');

            // redirect
            redirect('guru/lapor_siswa');
        }
    }


    public function tambah_lapor_siswa()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // var_dump($data['user']['nama_sekolah']);

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
            $this->load->view('guru/template/header', $data);
            $this->load->view('guru/template/sidebar', $data);
            $this->load->view('guru/template/topbar', $data);
            $this->load->view('guru/lapor_siswa/tambah_lapor_siswa', $data);
            $this->load->view('guru/template/footer', $data);
        } else {



            // insert ke database
            $this->laporan->insert_laporan_siswa($data['user']['id']);

            // tambah kolom total_perundungan di tabel siswa
            $this->db->set('total_rundungan', 'total_rundungan + 1', FALSE);
            $this->db->where('id', $this->input->post('id_siswa'));
            $this->db->update('siswa');


            // update data total_perundungan di table users(guru)
            $this->db->set('total_lapor_perundungan', 'total_lapor_perundungan + 1', FALSE);
            $this->db->where('id', $data['user']['id']);
            $this->db->update('users');

            // send email ke role admin 
            $this->_sendEmailAdmin($data['user']['nama'], $data['user']['nama_sekolah']);

            //  flash data
            $this->session->set_flashdata('flash', 'ditambahkan!');

            // redirect
            redirect('guru/lapor_siswa');
        }
    }

    

    // function kriim email ke admin 
    private function _sendEmailAdmin($namaGuru, $sekolah){
        // email admin
        $emailAdmin = 'otweditor007@gmail.com';

        $subject =  'Notifikasi Laporan Perundungan';
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
            $mail->addAddress($emailAdmin);
            $mail->Subject = ($subject);
            // $mail->Body = $message;

            // hari ini 
            $date = date('Y-m-d H:i:s');

            // file html 
            $htmlContent = file_get_contents('application/views/guru/message_email/notifEmailAdmin.php');
            $htmlContent = str_replace('{{SEKOLAH}}', $sekolah, $htmlContent);
            $htmlContent = str_replace('{{GURU}}', $namaGuru, $htmlContent);
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
        redirect('guru/lapor_siswa');
    }


    // get data nisn untuk ajax
    public function get_data_nisn()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // sekolah
        $sekolah = $data['user']['sekolah'];

        $nisn = $this->input->post('nisn');
        $data_nisn = $this->siswa->get_data_nisn_by_guru($nisn, $sekolah);


        if ($data_nisn) {
            echo json_encode(array('success' => true, 'data' => $data_nisn));
        } else {
            echo json_encode(array('success' => false));
        }
    }




    public function profile()
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get data sekolah
        $data['sekolah'] = $this->sekolah->get_data_sekolah();
        // var_dump($data['user']);

        $this->load->view('guru/template/header', $data);
        $this->load->view('guru/template/sidebar', $data);
        $this->load->view('guru/template/topbar', $data);
        $this->load->view('guru/profile/index', $data);
        $this->load->view('guru/template/footer', $data);
    }

    // update profile
    public function update_profile($username)
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));


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


        if($data['user']['sekolah'] == null){
            // sekolah
            $this->form_validation->set_rules(
                'sekolah',
                'Sekolah',
                'required',
                [
                    'required' => 'Sekolah harus dipilih!',
                ]
            );
        }

        // alamat
        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
            'required',
            [
                'required' => 'Alamat harus diisi!',
            ]
        );


        // nomor_telepon
        $this->form_validation->set_rules(
            'nomor_telepon',
            'Nomor_telepon',
            'required',
            [
                'required' => 'Nomor Telepon harus diisi!',
            ]
        );


        if ($this->form_validation->run() === false) {

            $this->load->view('guru/template/header', $data);
            $this->load->view('guru/template/sidebar', $data);
            $this->load->view('guru/template/topbar', $data);
            $this->load->view('guru/profile/index', $data);
            $this->load->view('guru/template/footer', $data);
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

                    // gambar lama selain gambar defaultnya
                    $old_image = $data['user']['foto'];

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

                    redirect('guru/profile');
                }
            } else {
                // jika tidak ada gambar yang diupload maka gunakan gambar lama dengan variable new_image
                $new_image = $data['user']['foto'];
            }


            $sekolah = $this->input->post('sekolah');

            if($sekolah == null){
                $sekolah = $data['user']['sekolah'];
            }
            // var_dump($sekolah);
            // die;


            // update data akun guru melalui model atau database
            $this->guru->update_profile_guru($username, $data['user']['id'], $new_image, $sekolah) ;

            //  flash data
            $this->session->set_flashdata('flash', 'diperbarui!');

            // redirect
            redirect('guru/profile');
        }
    }



    public function gantiKataSandi($id_guru)
    {
        // data admin
        $data['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get data sekolah
        $data['sekolah'] = $this->sekolah->get_data_sekolah();


        $this->form_validation->set_rules(
            'passwordcurrent',
            'PasswordCurrent',
            'required|trim',
            [
                'required' => 'Password tidak boleh kosong!'
            ]
        );

        // password baru 
        $this->form_validation->set_rules(
            'passwordnew',
            'PasswordNew',
            'required|trim|min_length[8]|matches[passwordconfirm]',
            [
                'matches' => "Password tidak sama!",
                'min_length' => "Password terlalu pendek!",
                'required' => 'Password baru tidak boleh kosong!'
            ]
        );

        // password konfirmasi baru
        $this->form_validation->set_rules(
            'passwordconfirm',
            'PasswordConfirm',
            'required|trim|min_length[8]|matches[passwordnew]',
            [
                'required' => 'Konfirmasi password tidak boleh kosong!',
                'matches' => "Password tidak sama!",
            ]
        );

        if($this->form_validation->run() === false){
            $this->load->view('guru/template/header', $data);
            $this->load->view('guru/template/sidebar', $data);
            $this->load->view('guru/template/topbar', $data);
            $this->load->view('guru/profile/gantiKataSandi', $data);
            $this->load->view('guru/template/footer', $data);

        }else{
            // cek input password lama dan password baru
            $currentpassword =  $this->input->post('passwordcurrent');
            $newpassword = $this->input->post('passwordnew');

            // perkondisian pasword lama dan password baru
            // password diterjemahkan dengan password_verify
            if (!password_verify($currentpassword, $data['user']['password'])) {
                // flash data
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password lama salah!</div>');
                redirect('guru/gantiKataSandi/'.$id_guru);
            } else {
                // jika password lama dan password baru sama 
                if ($currentpassword == $newpassword) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password lama!</div>');
                    redirect('guru/gantiKataSandi/' . $id_guru);
                } else {
                    // jika password benar
                    // password di enkripsi
                    $password_hash = password_hash($newpassword, PASSWORD_DEFAULT);

                    // update password 
                    $this->guru->updatePasswordByGuru($password_hash, $id_guru);
                    // flashdata
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success" role="alert">Password berhasil dirubah. Silahkan login ulang</div>'
                    );
                    // redirect
                    redirect('guru/gantiKataSandi/' . $id_guru);
                }
            }
        }
    }


    public function uploadFileExcel(){


        // data guru
        $user['guru'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        $guru = $user['guru']['id'];
        $sekolah = $user['guru']['sekolah'];


            $upload_file = $_FILES['uploadFile']['name'];
            
            // cek extension file
            $extension = pathinfo($upload_file, PATHINFO_EXTENSION);


            // default clock indonesia
            date_default_timezone_set("Asia/Singapore");

            if($extension === 'csv'){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            }else if($extension === 'xls'){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }else if($extension === 'xlsx'){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }else{
                $this->session->set_flashdata('flash_import_excel', 'Format file tidak sesuai!');
                redirect('guru/siswa');
            }

            // echo $extension;

            // load file lembar kerja excel
            $spreadsheet = $reader->load($_FILES['uploadFile']['tmp_name']);
            // ambil data menjadi data array
            $heetdata = $spreadsheet->getActiveSheet()->toArray();

            // mengecek data array rapi
            // echo '<pre>';
            // print_r($heetdata);
            $sheetcount = count($heetdata);

            // jumlah row dari excel
            // var_dump($sheetcount);


            // Data Siswa yang sudah ada
            $data_siswa['siswa'] = $this->siswa->get_data_siswa_by_guru($user['guru']['id']);
            $nisn_siswa = array();
            foreach ($data_siswa['siswa'] as $siswa) {
                $nisn_siswa[] = $siswa['nisn'];
            }

            // var_dump($nisn_siswa);
            // die;

            if($sheetcount > 1){
                for($i = 1; $i < $sheetcount; $i++ ){
                    // echo $productname = $heetdata[$i]['0'];
                    $nisn = $heetdata[$i]['0'];


                // cek nisn siswa yang sudah ada didatabase 
                // Periksa apakah NISN sudah ada di sistem
                if (in_array($nisn, $nisn_siswa)) {
                    // NISN sudah ada, berikan tindakan gagal
                    $this->session->set_flashdata('flash_import_excel', 'Data dengan NISN '. $nisn .' sudah ada di sistem.');
                    redirect('guru/siswa');
                }
                    $nama = $heetdata[$i]['1'];
                    $kelas = $heetdata[$i]['2'];
                    $tanggal_lahir = $heetdata[$i]['3'];
                    $umur = $heetdata[$i]['4'];
                    $jenis_kelamin = $heetdata[$i]['5'];
                    $alamat = $heetdata[$i]['6'];
                    $no_telepon = $heetdata[$i]['7'];

                    
                    $dateObj = DateTime::createFromFormat('d/m/Y', $tanggal_lahir);
                    if($dateObj === false){
                        $this->session->set_flashdata('flash_import_excel', 'Format tanggal lahir salah!');
                        redirect('guru/siswa');
                    }
                    $tanggal_lahir_db = $dateObj->format('Y-m-d');

                    // masuk ke dalam array
                    $data[] = array(
                        'guru' => $guru,
                        'nisn' => $nisn,
                        'nama' => $nama,
                        'kelas' => $kelas,
                        'tanggal_lahir' => $tanggal_lahir_db,
                        'umur' => $umur,
                        'jenis_kelamin' => $jenis_kelamin,
                        'alamat' => $alamat,
                        'no_telepon' => $no_telepon,
                        'sekolah' => $sekolah,
                        'foto' => 'default.png',
                        'date_created' => date('Y/m/d H:i:s'),
                    );
                }
    
                    // var_dump($data);
                    // die;
                    // insert data ke database 
                    $insertdata = $this->siswa->insert_siswa_by_excel($data);
                    if($insertdata){

                    //  flash data
                    $this->session->set_flashdata('flash', 'ditambahkan!');
                    redirect('guru/siswa');
        
                    }else{
                    $this->session->set_flashdata('flash_import_excel', 'Data gagal diimport!');
                    redirect('guru/siswa');
                    }
        
            }
    
    }

    // download file siswa
    public function downloadFileExcel(){

        $guru['user'] = $this->guru->get_data_by_username($this->session->userdata('username'));

        // get data siswa by guru(fetch data)
        $sekolah = $guru['user']['sekolah'];
        $seluruh_siswa = $this->siswa->get_data_siswa_by_guru_download($sekolah);

        if($seluruh_siswa == null){
            $this->session->set_flashdata('flash_import_excel', 'Data siswa kosong!');
            redirect('guru/siswa');
        }

            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment; filename="siswa.xlsx"');

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // nisn
            $sheet->setCellValue('A1', 'NISN');
            // nama siswa
            $sheet->setCellValue('B1', 'Nama Siswa');
            // kelas
            $sheet->setCellValue('C1', 'Kelas');
            // tanggal lahir
            $sheet->setCellValue('D1', 'Tanggal Lahir');
            // umur
            $sheet->setCellValue('E1', 'Umur');
            // jenis kelamin
            $sheet->setCellValue('F1', 'Jenis Kelamin');
            // alamat 
            $sheet->setCellValue('G1', 'Alamat');
            // no telepon
            $sheet->setCellValue('H1', 'No Telepon');

            $sn = 2;
            foreach ($seluruh_siswa as $siswa) {
                // echo  $siswa['nisn'] . "<br>";
                // die;
                $sheet->setCellValue('A' . $sn, $siswa['nisn']);
                $sheet->setCellValue('B' . $sn, $siswa['nama']);
                $sheet->setCellValue('C' . $sn, $siswa['id_kelas']);
                $sheet->setCellValue('D' . $sn, $siswa['tanggal_lahir']);
                $sheet->setCellValue('E' . $sn, $siswa['umur']);
                $sheet->setCellValue('F' . $sn, $siswa['jenis_kelamin']);
                $sheet->setCellValue('G' . $sn, $siswa['alamat_siswa']);
                $sheet->setCellValue('H' . $sn, $siswa['no_telepon_siswa']);
                $sn++;
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            // redirect('guru/siswa');
    }

    // get waktu untuk date selesai
    public function get_date()
    {
        $id_status = $this->input->post('id_status');

        // var_dump($id_status);

        if ($id_status && $id_status != '1') {
            $data['dateSelesai'] = date('Y-m-d H:i:s');
            echo json_encode(array('success' => true, 'data' => $data));
        } else {
            $data['dateSelesai'] = null;
            echo json_encode(array('success' => false));
        }
    }


    // halaman log by lapor_perundungan
    public function log($id)
    {
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

        $this->load->view('guru/template/header', $data);
        $this->load->view('guru/template/sidebar', $data);
        $this->load->view('guru/template/topbar', $data);
        $this->load->view('guru/log/index', $data);
        $this->load->view('guru/template/footer', $data);
    }

    // tambah log laporan 
    public function tambah_log($id)
    {

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



        if ($data['lapor']['id_klasifikasi'] == null || $data['lapor']['klasifikasi'] == null) {
            $this->session->set_flashdata('flash_failed', 'Klasifikasi harus dipilih!');
            redirect('guru/log/' . $id);
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

        // keterangan
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan',
            'required',
            [
                'required' => 'Keterangan harus diisi!',
            ]
        );


        if ($this->form_validation->run() === false) {
            $this->load->view('guru/template/header', $data);
            $this->load->view('guru/template/sidebar', $data);
            $this->load->view('guru/template/topbar', $data);
            $this->load->view('guru/log/index', $data);
            $this->load->view('guru/template/footer', $data);
        } else {


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
            redirect('guru/log/' . $id);
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
            $this->load->view('guru/template/header', $data);
            $this->load->view('guru/template/sidebar', $data);
            $this->load->view('guru/template/topbar', $data);
            $this->load->view('guru/log/index', $data);
            $this->load->view('guru/template/footer', $data);
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
            redirect('guru/log/' . $id);
        }
    }
}



?>