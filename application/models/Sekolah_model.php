<?php 

class Sekolah_model extends CI_Model{


    // table kabupaten
    public function get_kabupaten(){
        $this->db->select('*');
        $this->db->from('kabupaten');
        // asc agar data berurutan dari a - z
        $this->db->order_by('kabupaten', 'ASC');
        return $this->db->get()->result_array();
    }

    // table kecamatan 
    public function get_kecamatan(){
        $this->db->select('*');
        $this->db->from('kecamatan');
        $this->db->order_by('kecamatan', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getKecamatan($id){
        return $this->db->get_where('kecamatan', ['id_kabupaten' => $id])->result_array();
    }

    // table kota
    public function get_kota(){
        $this->db->select('*');
        $this->db->from('kota');
        $this->db->order_by('kota', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getKota($id)
    {
        return $this->db->get_where('kota', ['id_kabupaten' => $id])->result_array();
    }


    // get all data sekolah
    public function get_data_sekolah(){
        // return $this->db->get('sekolah')->result_array();

        $this->db->select('sekolah.id as id , nama_sekolah, alamat, no_telepon, kecamatan.kecamatan as kecamatan, kabupaten.kabupaten as kabupaten, kota.kota as kota, gambar, date');
        $this->db->from('sekolah');
        $this->db->join('kecamatan', ' = kecamatan.id = sekolah.kecamatan');
        $this->db->join('kabupaten', ' = kabupaten.id = sekolah.kabupaten');
        $this->db->join('kota', ' = kota.id = sekolah.kota');
        return $this->db->get('')->result_array();
    }


    // kode unik untuk kode sekolah
    public function kodeSekolah()
    {
        // Ambil data pasien dengan kode paling besar
        $query = $this->db->query("SELECT MAX(id) AS max_kode FROM sekolah");
        $result = $query->row_array();
        $max_kode = $result['max_kode'];


        // Jika data kosong, maka kode akan dimulai dari 000001
        if (!$max_kode) {
            $kode = '0001';
        } else {
            // Jika data tidak kosong, ambil angka terakhir dari kode sebelumnya
            // dan tambahkan 1 untuk kode selanjutnya
            $last_number = intval(substr($max_kode, -4));
            $kode = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
        }

        return  $kode; 
    }


    // insert sekolah
    public function insert_sekolah($new_image){


        $kode = 'SK'  . $this->kodeSekolah();

        // var_dump($kode);
        // die;

        date_default_timezone_set("Asia/Singapore");
        $data = [
            'id' => $kode,
            'nama_sekolah' => $this->input->post('name', true),
            'alamat' => $this->input->post('alamat', true),
            'no_telepon' => $this->input->post('no_telepon', true),
            'kabupaten'=> $this->input->post('kabupaten', true),
            'kecamatan' => $this->input->post('kecamatan', true),
            'kota' => $this->input->post('kota', true),
            'gambar' => $new_image,
            "date" =>  date('Y/m/d H:i:s')
        ];

        $this->db->insert('sekolah', $data);
    }

    // get sekolah by id
    public function get_data_sekolah_by_id($id){

        $this->db->select('sekolah.id as id, nama_sekolah, alamat, no_telepon, gambar, date, kecamatan.kecamatan as nama_kecamatan, kabupaten.kabupaten as nama_kabupaten, kota.kota as nama_kota, kecamatan.id as kecamatan, kabupaten.id as kabupaten, kota.id as kota');
        $this->db->from('sekolah');
        $this->db->join('kecamatan', 'kecamatan.id = sekolah.kecamatan');
        $this->db->join('kabupaten', 'kabupaten.id = sekolah.kabupaten');
        $this->db->join('kota', 'kota.id = sekolah.kota');
        $this->db->where('sekolah.id', $id);
        return $this->db->get()->row_array();
    }

    // menghitung semua data sekolah
    public function count_all_sekolah(){
        return $this->db->get('sekolah')->num_rows();
    }

    // delete sekolah
    public function delete_sekolah($id){
        $this->db->delete('sekolah', ['id'=> $id]);
    }


    // update sekolah
    public function update_sekolah($id, $new_image){

        $data = [
            'nama_sekolah' => $this->input->post('name', true),
            'alamat' => $this->input->post('alamat', true),
            'no_telepon' => $this->input->post('no_telepon', true),
            'kabupaten' => $this->input->post('kabupaten', true),
            'kecamatan' => $this->input->post('kecamatan', true),
            'kota' => $this->input->post('kota', true),
            'gambar' => $new_image,
            "date" =>  date('Y/m/d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('sekolah', $data);
    }


    // search data sekolah
    public function search_data_sekolah(){
        $keyword = $this->input->post('keyword_sekolah', true);
        $this->db->like('nama_sekolah', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('no_telepon', $keyword);
        $this->db->or_like('kabupaten', $keyword);
        $this->db->or_like('kecamatan', $keyword);
        $this->db->or_like('kota', $keyword);
        return $this->db->get('sekolah')->result_array();
    }

    // pagination searching data sekolah    
    public function get_all_sekolah_pagination($limit, $start, $keyword = null)
    {
        $this->db->select('sekolah.id as id, nama_sekolah, alamat, no_telepon, kecamatan.kecamatan as kecamatan, kabupaten.kabupaten as kabupaten, kota.kota as kota, gambar, date');
        $this->db->join('kecamatan', 'kecamatan.id = sekolah.kecamatan');
        $this->db->join('kabupaten', 'kabupaten.id = sekolah.kabupaten');
        $this->db->join('kota', 'kota.id = sekolah.kota');


        if ($keyword != null) {
            $this->db->like('nama_sekolah', $keyword);
            // $this->db->or_like('deskripsi', $keyword);
        }
        return $this->db->get('sekolah', $limit, $start)->result_array();
    }


    // count all data sekolah
    public function countAllSekolah()
    {
        return $this->db->get('sekolah')->num_rows();
    }

    


}
