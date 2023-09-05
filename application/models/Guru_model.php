<?php 


class Guru_model Extends CI_Model{

    public function get_data_by_username($username)
    {
        $this->db->select('users.id as id, nama, username, users.alamat as alamat, users.no_telp as no_telp, email, users.foto as foto, users.date_created as date_created, role, is_active, status_login, sekolah.nama_sekolah as nama_sekolah, users.sekolah as sekolah, users.password as password');
        $this->db->from('users');
        $this->db->join('sekolah', 'sekolah.id = users.sekolah', 'left');
        $this->db->where('username', $username);
        return $this->db->get()->row_array();
        // return $this->db->get_where('users', ['username' => $username])->row_array();
    }


    // get data guru by sekolah
    public function get_guru_by_sekolah($sekolah){
        $this->db->select('id, nama')
        ->from('users')
        ->where('sekolah', $sekolah)
        ->where('is_active', 1)
        ->where('role', 2);
        return $this->db->get()->result_array();
    }

    public function get_data_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }


    // api
    public function get_data_by_id_api($id)
    {
        return $this->db->get_where('users', ['id' => $id])->result();
    }


    // ambil data semua guru
    public function get_data_akun_guru(){
        // return $this->db->get('guru')->result();
        $this->db->order_by('id', 'ASC');
        $this->db->select('nama, username, email, foto, users.id as id, is_active, role, date_created, status_login, users.alamat as alamat, users.no_telp as no_telp, sekolah.nama_sekolah as sekolah, users.total_lapor_perundungan as total_lapor_perundungan');
        $this->db->join('sekolah', 'sekolah.id = users.sekolah', 'left');
        return $this->db->order_by('id', 'ASC')->get_where('users', ['role' => 2])->result_array();
    }


    // kode unik untuk akun guru
    public function kodeAkunGuru()
    {
        // Ambil data pasien dengan kode paling besar
        $query = $this->db->query("SELECT MAX(id) AS max_kode FROM users");
        $result = $query->row_array();
        $max_kode = $result['max_kode'];


        // Jika data kosong, maka kode akan dimulai dari 000001
        if (!$max_kode) {
            $kode = '000001';
        } else {
            // Jika data tidak kosong, ambil angka terakhir dari kode sebelumnya
            // dan tambahkan 1 untuk kode selanjutnya
            $last_number = intval(substr($max_kode, -6));
            $kode = str_pad($last_number + 1, 6, '0', STR_PAD_LEFT);
        }

        return  $kode;
    }

    // insert akun_guru
    public function insert_akun_guru($new_image){

        $kode = 'ID'.$this->kodeAkunGuru();

        // default waktu
        date_default_timezone_set("Asia/Singapore");

        $data = [
            "id" =>$kode,
            "role" => 2,
            "is_active" => 0,
            "nama" => $this->input->post('name'),
            "username" => $this->input->post('username'),
            "email" => $this->input->post('email'),
            "password" => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            "foto" => $new_image,
            "status_login" => 0,
            'date_created' => date('Y/m/d H:i:s')
        ];


        $this->db->insert('users', $data);

    }


    // delete akun guru
    public function delete_guru($username){
        $this->db->delete('users', ['username'=> $username]);
    }
    

    // update akun guru
    public function update_akun_guru($id, $new_image, $password_now){

        date_default_timezone_set("Asia/Singapore");
        $data = [
            "nama" => $this->input->post('edit_name', true),
            "email" => $this->input->post('edit_email', true),
            "username" => $this->input->post('edit_username', true),
            "password" => $password_now,
            "foto" => $new_image,
            "date_created" => date('Y/m/d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }


    // active akun guru
    public function active_akun_guru($username){
        $this->db->set('is_active', 1);
        $this->db->where('username', $username);
        $this->db->update('users');
    }


    // delete token
    public function delete_token($email){
        $this->db->delete('user_token', ['email'=> $email]);
    }

    // delete akun guru
    public function delete_akun_guru($email){
        $this->db->delete('users', ['email'=> $email]);
    }


    // update akun admin
    public function
    update_profile($username, $new_image, $password_now){

        date_default_timezone_set("Asia/Singapore");
        $data = [
            "nama" => $this->input->post('nama', true),
            "email" => $this->input->post('email', true),
            "username" => $this->input->post('username', true),
            "password" => $password_now,
            "foto" => $new_image,
            "date_created" => date('Y/m/d H:i:s')
        ];

        $this->db->where('username', $username);
        $this->db->update('users', $data);
    }

    // count all data akun guru
    public function countAllAkunGuru()
    {
        return $this->db->get_where('users', ['role' => 2])->num_rows();
    }



    // update akun guru
    public function
    update_profile_guru($username, $guru_id, $new_image, $sekolah)
    {

        date_default_timezone_set("Asia/Singapore");
        $data = [
            "nama" => $this->input->post('nama', true),
            "email" => $this->input->post('email', true),
            "alamat" => $this->input->post('alamat', true),
            "username" => $username,
            "sekolah" => intval($sekolah),
            "no_telp" => $this->input->post('nomor_telepon', true),
            "foto" => $new_image,
            "date_created" => date('Y/m/d H:i:s')
        ];

        $this->db->where('id', $guru_id);
        $this->db->update('users', $data);
    }


    



    // record ip address
    public function record_attempts($ip_address)
    {
        date_default_timezone_set("Asia/Singapore");
        $data = [
            "ip_address" => $ip_address,
            "timestamp" => date('Y/m/d H:i:s')
        ];

        $this->db->insert('failed_login_attempts', $data);
    }

    // clear ip address
    public function clear_attempts($ip_address)
    {
        $this->db->delete('failed_login_attempts', ['ip_address' => $ip_address]);
    }

    // get ip address 
    public function get_attempts($ip_address)
    {
        $this->db->where('ip_address', $ip_address);
        $this->db->from('failed_login_attempts');
        return $this->db->count_all_results();
    }


    public function clear_old_attempts($ip_address)
    {
        $oneDayAgo = strtotime('-1 day'); // Timestamp 1 hari yang lalu
        $this->db->where('ip_address', $ip_address);
        $this->db->where('timestamp <', $oneDayAgo);
        $this->db->delete('failed_login_attempts');
    }


    // menghapus token ketika sudah 24 jam 
    public function delete_token_expired()
    {
        $oneDayAgo = strtotime('-1 day'); // Timestamp 1 hari yang lalu
        $this->db->where('date_created <', $oneDayAgo);
        $this->db->delete('user_token');
    }


    public function updatePasswordByGuru($password, $guru){
        $this->db->set('password', $password);
        $this->db->where('id', $guru);
        $this->db->update('users');
    }

}
