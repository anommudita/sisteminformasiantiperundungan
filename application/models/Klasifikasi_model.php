<?php 


    class Klasifikasi_model extends CI_Model{


    // get data klasifikasi
    public function get_data_klasifikasi(){
        return $this->db->get('klasifikasi')->result_array();
    }


    // ambil data klasifikasi by id versi api
    public function get_data_klasifikasi_by_id_api($id)
    {
        return $this->db->get_where('klasifikasi', ['id' => $id])->result();
    }



    // tambah data klasifikasi 
    public function insert_klasifikasi(){

        $data = [
            'klasifikasi' => $this->input->post('klasifikasi', true),
            'date_created' => date('Y/m/d H:i:s')
        ];

        $this->db->insert('klasifikasi', $data);
    }


    // delete data klasifikasi
    public function delete_klasifikasi($id){
        $this->db->delete('klasifikasi', ['id'=> $id]);
    }



    // update data klasifikasi 
    public function update_klasifikasi($id){
        $data = [
            'klasifikasi' => $this->input->post('edit_klasifikasi', true),
            'date_created' => date('Y/m/d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('klasifikasi', $data);
    }


    // update semua data klasifikasi by id_log
    // public function update_klasifikasi_by_id_log($lapor_siswa){
    //     $this->db->set('klasifikasi', $this->input->post('klasifikasi1', true));
    //     $this->db->where('lapor_siswa', $lapor_siswa);
    //     $this->db->update('log');
    // }


    // update klasifikasi by lapor_siswa
    public function update_klasifikasi_by_id_log($id_laporan, $klasifikasi){
        $this->db->set('klasifikasi', $klasifikasi);
        $this->db->where('id_laporan', $id_laporan);
        $this->db->update('lapor_siswa');
    }

    }

?>