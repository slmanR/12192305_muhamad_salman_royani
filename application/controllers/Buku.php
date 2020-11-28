<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //cek login
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url() . 'welcome?pesan=belumlogin');
        }
    }

    function index()
    {
        $data['anggota'] = $this->M_perpus->get_data('anggota')->result();
        $data['buku'] = $this->M_perpus->get_data('buku')->result();

        $data['header'] = "Katalog Buku";
    }

    public function katalog_detail()
    {
        $id = $this->uri->segment(3);
        $buku = $this->db->query('SELECT * FROM buku b, kategori k WHERE b.id_kategori=k.id_id_kategori AND b.id_buku=' . $id)->result();

        foreach ($buku as $fields) {
            $data['judul'] = $fields->judul_buku;
            $data['pengarang'] = $fields->pengarang;
            $data['penerbit'] = $fields->penerbit;
            $data['kategori'] = $fields->nama_kategori;
            $data['tahun'] = $fields->thn_terbit;
            $data['isbn'] = $fields->isbn;
            $data['gambar'] = $fields->gambar;
            $data['id'] = $id;
        }

        $this->load->view('desain');
        $this->load->view('toplayout');
        $this->load->view('detail_buku', $data);
    }
}
