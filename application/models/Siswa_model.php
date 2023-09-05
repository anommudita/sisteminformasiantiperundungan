<?php 


class Siswa_model Extends CI_Model{

    // ambil data kelas
    public function get_data_kelas(){
        return $this->db->get('kelas')->result_array();
    }


    // ambil data siswa by id sekolah
    public function get_data_siswa_by_id_sekolah($id_sekolah){
        return $this->db->get_where('siswa', ['sekolah' => $id_sekolah]) ->result_array();
    }


    // ambil data siswa sesuai NISN
    public function get_data_siswa_by_nisn($nisn)
    {
        $this->db->select(
            'siswa.id as id_siswa, nisn, nama, tanggal_lahir, umur, jenis_kelamin, sekolah, foto, date_created, sekolah.nama_sekolah as nama_sekolah, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa , kelas.kelas as kelas, kelas.id as id_kelas'
        );
        $this->db->from('siswa');
        $this->db->join('sekolah', 'sekolah.id = siswa.sekolah');
        $this->db->join('kelas',
            'kelas.id = siswa.kelas'
        );
        $this->db->where('siswa.nisn', $nisn);
        $query = $this->db->get()->row_array();
        return $query;
    }


    // ambil data siswa sesuai NISN
    public function get_data_nisn_by_guru($nisn, $sekolah)
    {
        $this->db->select('siswa.id as id_siswa, nisn, nama, tanggal_lahir, umur, jenis_kelamin, sekolah, foto, date_created, sekolah.nama_sekolah as nama_sekolah, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa, kelas.kelas as nama_kelas, kelas.id as id_kelas');
        $this->db->from('siswa');
        $this->db->join('sekolah', 'sekolah.id = siswa.sekolah', 'left');
        $this->db->join('kelas', 'kelas.id = siswa.kelas', 'left');
        $this->db->where('siswa.nisn', $nisn);
        $this->db->where('siswa.sekolah', $sekolah);
        $query = $this->db->get()->row_array();
        return $query;
    }

    // ambil data siswa sesuai ID 
    public function get_data_siswa_by_id($id)
    {
        $this->db->select(
            'siswa.id as id_siswa, nisn, siswa.nama as nama, tanggal_lahir, umur, jenis_kelamin, siswa.sekolah as sekolah, siswa.foto as foto, siswa.date_created as date_created, sekolah.nama_sekolah as nama_sekolah, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa , kelas.kelas as kelas, kelas.id as id_kelas , users.id as guru, users.nama as nama_guru, users.sekolah as sekolah_guru'
        );
        $this->db->from('siswa');
        $this->db->join('sekolah', 'sekolah.id = siswa.sekolah', 'left');
        $this->db->join('users', 'users.id = siswa.guru', 'left');
        $this->db->join('kelas', 'kelas.id = siswa.kelas');
        $this->db->where('siswa.id', $id);
        $query = $this->db->get()->row_array();
        return $query;
    }


    // ambil data semua siswa
    public function get_data_siswa(){

        $this->db->select('siswa.id as id_siswa, nisn, siswa.nama as nama, tanggal_lahir, umur, jenis_kelamin, siswa.sekolah as sekolah, siswa.foto as foto, siswa.date_created as date_created, sekolah.nama_sekolah as nama_sekolah, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa, kelas.kelas as kelas, total_rundungan, users.nama as nama_guru'
        );
        $this->db->from('siswa');
        $this->db->join('sekolah', 'sekolah.id = siswa.sekolah');
        $this->db->join('kelas', 'kelas.id = siswa.kelas');
        $this->db->join('users', 'users.id = siswa.guru', 'left');
        $this->db->order_by('siswa.id', 'ASC');
        $query = $this->db->get()->result_array();
        return $query;
    }

    // insert siswa
    public function insert_siswa($new_image){

        // default waktu
        date_default_timezone_set("Asia/Singapore");

        $data = [
            "nisn" => $this->input->post('nisn', true),
            "nama" => $this->input->post('name', true),
            "kelas" => $this->input->post('kelas', true),
            "tanggal_lahir" => $this->input->post('tanggal_lahir', true),
            "umur" => $this->input->post('umur', true),
            "jenis_kelamin" => $this->input->post('jenis_kelamin', true),
            "alamat" => $this->input->post('alamat', true),
            "sekolah" => $this->input->post('sekolah', true),
            "guru" => $this->input->post('guru', true),
            "no_telepon" => $this->input->post('no_telepon', true),
            "foto" => $new_image,
            "total_rundungan" => 0,
            "date_created" => date('Y/m/d H:i:s')
        ];

        $this->db->insert('siswa', $data);

    }


    // edit siswa
    public function edit_siswa($id, $new_image)
    {

        // default waktu
        date_default_timezone_set("Asia/Singapore");

        $data = [
            "nisn" => $this->input->post('nisn', true),
            "nama" => $this->input->post('name', true),
            "kelas" => $this->input->post('kelas', true),
            "tanggal_lahir" => $this->input->post('tanggal_lahir', true),
            "umur" => $this->input->post('umur', true),
            "jenis_kelamin" => $this->input->post('jenis_kelamin', true),
            "alamat" => $this->input->post('alamat', true),
            "sekolah" => $this->input->post('sekolah', true),
            "guru" => $this->input->post('guru', true),
            "no_telepon" => $this->input->post('no_telepon', true),
            "foto" => $new_image,
            "date_created" => date('Y/m/d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('siswa', $data);
        
    }
    // delete siswa
    public function delete_siswa($id){
        $this->db->delete('siswa', ['id'=> $id]);
    }



    // get siswa by guru
    public function get_data_siswa_by_guru($sekolah){
        $this->db->select(
            'siswa.id as id_siswa, nisn, nama, tanggal_lahir, umur, jenis_kelamin, sekolah, foto, date_created, sekolah.nama_sekolah as nama_sekolah, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa, kelas.kelas as kelas, total_rundungan'
        );
        $this->db->from('siswa');
        $this->db->join('sekolah', 'sekolah.id = siswa.sekolah', 'left');
        $this->db->join('kelas', 'kelas.id = siswa.kelas');
        $this->db->order_by('siswa.id', 'ASC');
        $this->db->where('siswa.sekolah', $sekolah);
        $query = $this->db->get()->result_array();
        return $query;
    }



    // download data siswa by guru
    // get siswa by guru
    public function get_data_siswa_by_guru_download($sekolah)
    {
        $this->db->select(
            'siswa.id as id_siswa, nisn, nama, tanggal_lahir, umur, jenis_kelamin, sekolah, foto, date_created, sekolah.nama_sekolah as nama_sekolah, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa, kelas.kelas as kelas, total_rundungan, kelas.id as id_kelas'
        );
        $this->db->from('siswa');
        $this->db->join('sekolah', 'sekolah.id = siswa.sekolah', 'left');
        $this->db->join('kelas',
            'kelas.id = siswa.kelas'
        );
        $this->db->order_by('siswa.id', 'ASC');
        $this->db->where('siswa.sekolah', $sekolah);
        $query = $this->db->get()->result_array();
        return $query;
    }

    // insert siswa dari akun guru
    public function insert_siswa_by_guru($new_image, $guru, $sekolah){

        // default waktu
        date_default_timezone_set("Asia/Singapore");

        $data = [
            "guru" => $guru,
            "nisn" => $this->input->post('nisn', true),
            "nama" => $this->input->post('name', true),
            "kelas" => $this->input->post('kelas', true),
            "tanggal_lahir" => $this->input->post('tanggal_lahir', true),
            "umur" => $this->input->post('umur', true),
            "jenis_kelamin" => $this->input->post('jenis_kelamin', true),
            "alamat" => $this->input->post('alamat', true),
            "sekolah" => $sekolah,
            "no_telepon" => $this->input->post('no_telepon', true),
            "foto" => $new_image,
            "total_rundungan" => 0,
            "date_created" => date('Y/m/d H:i:s')
        ];

        $this->db->insert('siswa', $data);

    }


    // insert siswa dari akun guru
    public function edit_siswa_by_guru($id, $new_image, $guru, $sekolah)
    {

        // default waktu
        date_default_timezone_set("Asia/Singapore");

        $data = [
            "guru" => $guru,
            "nisn" => $this->input->post('nisn', true),
            "nama" => $this->input->post('name', true),
            "kelas" => $this->input->post('kelas', true),
            "tanggal_lahir" => $this->input->post('tanggal_lahir', true),
            "umur" => $this->input->post('umur', true),
            "jenis_kelamin" => $this->input->post('jenis_kelamin', true),
            "alamat" => $this->input->post('alamat', true),
            "sekolah" => $sekolah,
            "no_telepon" => $this->input->post('no_telepon', true),
            "foto" => $new_image,
            "total_rundungan" => 0,
            "date_created" => date('Y/m/d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('siswa', $data);
    }



    // insert siswa by excel 
    public function insert_siswa_by_excel($data){
        $this->db->insert_batch('siswa', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    // count all data siswa
    public function countAllSiswa()
    {
        return $this->db->get('siswa')->num_rows();
    }


    // count all data siswa
    public function countAllSiswaByGuru($guru)
    {
        $this->db->where('guru', $guru);
        return $this->db->get('siswa')->num_rows();
    }


    // coult all data by sekolah
    public function countAllSiswaBySekolah($sekolah)
    {
        $this->db->where('sekolah', $sekolah);
        return $this->db->get('siswa')->num_rows();
    }
    

}
