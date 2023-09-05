<?php


class Log_model extends CI_Model
{

    // ambil data log sesuai id laporan versi api
    public function get_data_log_by_id_api($id)
    {
        $this->db->select(
            'log.date_created as date_created, date_time_mulai, date_time_selesai, status.status as status, log.keterangan as keterangan, id_log, lapor_siswa, users.id as id_user, users.nama as nama_user'
        );
        $this->db->from('log');
        $this->db->join('lapor_siswa', 'lapor_siswa.id_laporan = log.lapor_siswa');
        $this->db->join('status', 'status.id = log.status');
        // $this->db->join('klasifikasi', 'klasifikasi.id = log.klasifikasi', 'left');
        $this->db->join('users', 'users.id = log.user', 'left');
        $this->db->where('log.id_log', $id);
        return $this->db->get()->result();
    }


    // ambil data log sesuai id laporan
    public function get_data_log_by_id_laporan($id_lapor){

        $this->db->select(
            'lapor_siswa.id_laporan as id_laporan, date_time_mulai, date_time_selesai, status.status as status, log.keterangan as keterangan, id_log, users.id as id_user, users.nama as nama_user'
        );
        $this->db->order_by('id_log', 'ASC');
        $this->db->from('log');
        $this->db->join('lapor_siswa', 'lapor_siswa.id_laporan = log.lapor_siswa');
        $this->db->join('status', 'status.id = log.status');
        $this->db->join('users', 'users.id = log.user', 'left');
        $this->db->where('lapor_siswa.id_laporan', $id_lapor);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get_data_log_by_id($id){
        return $this->db->get_where('id_log', ['id' => $id])->row_array();
    }


    // insert laporan
    public function insert_log($id_lapor_siswa, $user)
    {

        // default waktu
        date_default_timezone_set("Asia/Singapore");

        $data = [
            "lapor_siswa" => $id_lapor_siswa,
            "user" => $user,
            "date_time_mulai" => $this->input->post('date_mulai', true),
            "date_time_selesai" => $this->input->post('date_selesai', true),
            "status" => $this->input->post('optionStatus', true),
            "keterangan" => $this->input->post('keterangan', true),
            "date_created" => date('y-m-d H:i:s')
        ];

        $this->db->insert('log', $data);
    }

    public function update_log($id, $user){
        // default waktu
        date_default_timezone_set("Asia/Singapore");

        $data = [
            "date_time_mulai" => $this->input->post('edit_date_mulai', true),
            "date_time_selesai" => $this->input->post('edit_date_selesai', true),
            "status" => $this->input->post('edit_optionStatus', true),
            "keterangan" => $this->input->post('edit_keterangan', true),
            "user" => $user,
            "date_created" => date('y-m-d H:i:s')
        ];
        $this->db->where('id_log', $id);
        $this->db->update('log', $data);
    }

    public function delete_log($id){
        $this->db->where('id_log', $id);
        $this->db->delete('log');
    }


    // menampilkan data status
    public function get_status(){
        $this->db->where('id !=', 4);
        return $this->db->get('status')->result_array();
    }

}
