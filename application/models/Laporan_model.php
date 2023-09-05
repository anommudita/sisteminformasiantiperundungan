<?php


class Laporan_model extends CI_Model
{

    // ambil data siswa sesuai NISN
    public function get_data_siswa_by_nisn($nisn)
    {
        $this->db->select(
            'siswa.id as id_siswa, nisn, nama, tanggal_lahir, umur, jenis_kelamin, sekolah, foto, date_created, sekolah.nama_sekolah as nama_sekolah, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa , kelas.kelas as kelas, kelas.id as id_kelas'
        );
        $this->db->from('siswa');
        $this->db->join('sekolah', 'sekolah.id = siswa.sekolah');
        $this->db->join(
            'kelas',
            'kelas.id = siswa.kelas'
        );
        $this->db->where('siswa.nisn', $nisn);
        $query = $this->db->get()->row_array();
        return $query;
    }


    // ambil data siswa sesuai ID 
    public function get_data_siswa_by_id($id)
    {
        $this->db->select(
            'siswa.id as id_siswa, nisn, nama, tanggal_lahir, umur, jenis_kelamin, sekolah, foto, date_created, sekolah.nama_sekolah as nama_sekolah, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa , kelas.kelas as kelas, kelas.id as id_kelas'
        );
        $this->db->from('siswa');
        $this->db->join('sekolah', 'sekolah.id = siswa.sekolah');
        $this->db->join('kelas', 'kelas.id = siswa.kelas');
        $this->db->where('siswa.id', $id);
        $query = $this->db->get()->row_array();
        return $query;
    }

    // ambil data laporan sesuai id laporan
    public function get_data_laporan_by_id($id){
        $this->db->select('id_laporan, keterangan, klasifikasi.id as id_klasifikasi, klasifikasi.klasifikasi as klasifikasi');
        $this->db->from('lapor_siswa');

        $this->db->join('klasifikasi', 'klasifikasi.id = lapor_siswa.klasifikasi', 'left');
        $this->db->where('id_laporan', $id);

        $query = $this->db->get()->row_array();
        return $query;

        // return $this->db->get_where('lapor_siswa', ['id_laporan' => $id])->row_array();
    }

    // ambil data laporan sesuai id laporan versi lengkap 
    public function get_data_laporan_siswa_by_id($id){

        $this->db->select(
            'id_laporan, lapor_siswa.date_created as tanggal_pengaduan, pelapor, siswa.nama as nama_siswa, kelas.kelas as kelas, sekolah.nama_sekolah as nama_sekolah, users.nama as nama_guru, siswa.foto as foto, siswa.nama as nama, siswa.nisn as nisn, siswa.kelas as kelas_siswa, siswa.sekolah as sekolah, siswa.id as id_siswa, keterangan'
        );
        $this->db->from('lapor_siswa');
        $this->db->join('siswa', 'siswa.id = lapor_siswa.siswa');
        $this->db->join('sekolah', 'sekolah.id = lapor_siswa.sekolah');
        $this->db->join('kelas', 'kelas.id = lapor_siswa.kelas');
        $this->db->join('users', 'users.id = lapor_siswa.pelapor');
        $this->db->where('lapor_siswa.id_laporan', $id);
        $query = $this->db->get()->row_array();
        return $query;
    }
    
    // ambil data semua siswa
    public function get_data_laporan_siswa()
    {

        $this->db->select(
            'id_laporan, lapor_siswa.date_created as tanggal_pengaduan, pelapor, siswa.nama as nama_siswa, kelas.kelas as kelas, sekolah.nama_sekolah as nama_sekolah, users.nama as nama_guru, siswa.foto as foto, siswa.nama as nama, siswa.nisn as nisn, siswa.umur as umur, siswa.jenis_kelamin as jenis_kelamin, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa, siswa.date_created as tanggal_didaftarkan, siswa.tanggal_lahir as tanggal_lahir, siswa.id as id_siswa, status.status as status'
        );
        $this->db->order_by('lapor_siswa.date_created', 'DESC');
        $this->db->from('lapor_siswa');
        $this->db->join('siswa', 'siswa.id = lapor_siswa.siswa');
        $this->db->join('sekolah', 'sekolah.id = lapor_siswa.sekolah');
        $this->db->join('kelas', 'kelas.id = lapor_siswa.kelas');
        $this->db->join('users', 'users.id = lapor_siswa.pelapor');
        $this->db->join('status', 'status.id = lapor_siswa.status');
        $query = $this->db->get()->result_array();
        return $query;
    }



    // ambil data semua siswa by guru
    public function get_data_laporan_siswa_guru($guru)
    {

        $this->db->select(
            'id_laporan, lapor_siswa.date_created as tanggal_pengaduan, pelapor, siswa.nama as nama_siswa, kelas.kelas as kelas, sekolah.nama_sekolah as nama_sekolah, users.nama as nama_guru, siswa.foto as foto, siswa.nama as nama, siswa.nisn as nisn, siswa.umur as umur, siswa.jenis_kelamin as jenis_kelamin, siswa.alamat as alamat_siswa, siswa.no_telepon as no_telepon_siswa, siswa.date_created as tanggal_didaftarkan, siswa.tanggal_lahir as tanggal_lahir, siswa.id as id_siswa, status.status as status , lapor_siswa.keterangan as keterangan'
        );
        $this->db->order_by('lapor_siswa.date_created', 'DESC');
        $this->db->from('lapor_siswa');
        $this->db->join('siswa', 'siswa.id = lapor_siswa.siswa');
        $this->db->join('sekolah', 'sekolah.id = lapor_siswa.sekolah');
        $this->db->join('kelas', 'kelas.id = lapor_siswa.kelas');
        $this->db->join('users', 'users.id = lapor_siswa.pelapor');
        $this->db->join('status', 'status.id = lapor_siswa.status');
        $this->db->where('lapor_siswa.pelapor', $guru);

        $query = $this->db->get()->result_array();
        return $query;
    }

    // insert laporan
    public function insert_laporan_siswa($id_guru)
    {

        // default waktu
        date_default_timezone_set("Asia/Singapore");

        $data = [
            "pelapor" => $id_guru,
            "siswa" => $this->input->post('id_siswa', true),
            "kelas" => $this->input->post('kelas', true),
            "sekolah" => $this->input->post('sekolah', true),
            "keterangan" => $this->input->post('keterangan', true),
            "status" => 4,
            "date_created" => date('Y-m-d H:i:s')
        ];

        $this->db->insert('lapor_siswa', $data);
    }



    // edit laporan
    public function update_laporan_siswa($id_guru, $id_laporan)
    {
        // default waktu
        date_default_timezone_set("Asia/Singapore");

        $data = [
            "pelapor" => $id_guru,
            "siswa" => $this->input->post('id_siswa', true),
            "kelas" => $this->input->post('kelas', true),
            "sekolah" => $this->input->post('sekolah', true),
            "keterangan" => $this->input->post('keterangan', true),
            "date_created" => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_laporan', $id_laporan);
        $this->db->update('lapor_siswa', $data);
    }


    // delete lapor siswa
    public function delete_laporan_siswa($id)
    {
        $this->db->delete('lapor_siswa', ['id_laporan' => $id]);
    }


    // count all data laporan
    public function countAllLaporan()
    {
        return $this->db->get('lapor_siswa')->num_rows();
    }


    // count all data laporan by sekolah
    public function TotalPerundunganBySekolah($id_sekolah){
        $this->db->where('sekolah', $id_sekolah);
        return $this->db->get('lapor_siswa')->num_rows();
    }


    // count all data laporan by guru
    public function countAllLaporanByGuru($guru)
    {
        $this->db->where('pelapor', $guru);
        return $this->db->get('lapor_siswa')->num_rows();
    }
}
