<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TujuanModel extends CI_Model
{

    public function datatable()
    {
        @$draw = $_POST['draw'];
        @$length = $_POST['length'];
        @$start = $_POST['start'];
        @$search = $_POST['search'];

        $output = array();
        $output['draw'] = $draw;
        $output['data'] = array();
        $sql = "SELECT * FROM tb_simpul WHERE simpulType = 'tujuan' ";
        if ($search != '') {
            $sql .= "AND (tb_simpul.simpulNama LIKE '%" . $search . "%')";
        }
        $sql .= " ORDER BY tb_simpul.simpulID DESC ";
        $sql1 = $sql . "LIMIT $start,$length";
        $query1 = $this->db->query($sql1);
        $query2 = $this->db->query($sql);
        $output['recordsTotal'] = $output['recordsFiltered'] = $query2->num_rows();
        $nomor_urut = $start + 1;
        foreach ($query1->result() as $row) {

            $output['data'][] = array(
                "$row->simpulNama",
                "",
                '<div class="btn-group btn-rounded" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-danger btn-del" data-id="' . $row->simpulID . '"><i class="dripicons-document-delete"></i></button>
                  <button type="button" class="btn btn-success btn-edit" data-id="' . $row->simpulID . '"><i class="dripicons-document-edit"></i></button>
                </div>'
            );
            $nomor_urut++;
        }
        echo json_encode($output);
    }
    public function datatable2()
    {
        @$draw = $_POST['draw'];
        @$length = $_POST['length'];
        @$start = $_POST['start'];
        @$search = $_POST['search'];

        $output = array();
        $output['draw'] = $draw;
        $output['data'] = array();
        $sql = "SELECT * FROM tb_simpul LEFT JOIN tb_wisata ON tb_wisata.id_wisata=tb_simpul.simpulID WHERE simpulType = 'wisata' ";
        if ($search != '') {
            $sql .= "AND (tb_simpul.simpulNama LIKE '%" . $search . "%'";
            $sql .= " OR tb_wisata.alamat LIKE '%" . $search . "%')";
        }
        $sql .= " ORDER BY tb_simpul.simpulID DESC ";
        $sql1 = $sql . "LIMIT $start,$length";
        $query1 = $this->db->query($sql1);
        $query2 = $this->db->query($sql);
        $output['recordsTotal'] = $output['recordsFiltered'] = $query2->num_rows();
        $nomor_urut = $start + 1;
        foreach ($query1->result() as $row) {

            $output['data'][] = array(
                "<img src='" . site_url('upload/') . $row->img . "' class='rounded' style='width:100px;background-size:cover;'>",
                $row->simpulNama,
                $row->alamat,
                '<div class="btn-group btn-rounded" role="group" aria-label="Basic example">
                    <a class="btn btn-primary" href="' . site_url('Beranda/detail/' . $row->simpulID) . '" >Lihat</a>
                    </div>'
            );
            $nomor_urut++;
        }
        echo json_encode($output);
    }
    public function insert($simpulID, $simpulNama, $simpulType, $simpulLat, $simpulLng)
    {
        $sql = "
            INSERT INTO `tb_simpul`(`simpulID`, `simpulNama`, `simpulType`, `simpulLat`, `simpulLng`)
            VALUES ('{$simpulID}','{$simpulNama}','{$simpulType}','{$simpulLat}','{$simpulLng}')
            ON DUPLICATE KEY UPDATE 
                simpulNama = VALUES(simpulNama),
                simpulType = VALUES(simpulType),
                simpulLat = VALUES(simpulLat),
                simpulLng = VALUES(simpulLng)";
        $this->db->query($sql);
        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        }
        return FALSE;
    }
    public function insertTujuan($simpulID, $simpulNama)
    {
        $sql = "
            INSERT INTO `tb_tujuan`(`id_tujuan`,`nama_tujuan`)
            VALUES ('{$simpulID}','{$simpulNama}')
            ON DUPLICATE KEY UPDATE 
                nama_tujuan = VALUES(nama_tujuan)";
        $this->db->query($sql);
        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        }
        return FALSE;
    }
}
