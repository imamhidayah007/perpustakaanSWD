<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller{

  public function __construct(){
    parent:: __construct();
    $this->load->model('buku_model');
	  $this->load->model('Query');
	  date_default_timezone_set('Asia/Jakarta');
  }

  public function index(){
    $data['content'] = 'buku/buku';
    $data['title']   = 'Daftar Data Buku';
    $data['buku'] = $this->buku_model->get_data_buku()->result();

    $this->load->view('dashboard', $data);
  }

  public function tambahBuku(){
    $data['content'] = 'buku/tambah_buku';
    $data['title'] = 'Form Tambah Buku';
    $data['id_buku'] = $this->buku_model->id_buku();
    $data['pengarang'] = $this->db->get('pengarang')->result();
    $data['penerbit'] = $this->db->get('penerbit')->result();

    $this->load->view('dashboard', $data);
  }

  public function simpan(){

	  //upload photo
	  $config['allowed_types'] = 'png|jpg|jpeg';
	  $config['remove_spaces'] = TRUE;
	  $config['overwrite'] = TRUE;
	  $config['upload_path'] = 'GambarBuku/';
	  $config['encrypt_name'] = TRUE;

	  $this->load->library('upload');
	  $this->upload->initialize($config);

	  //ambil data image
	  $this->upload->do_upload('gambarbuku');
	  $gambarbuku = $this->upload->data('file_name');

	  $data = array(
      'id_buku'      => $this->input->post('id_buku'),
      'judul_buku'   => $this->input->post('judul_buku'),
      'id_pengarang' => $this->input->post('id_pengarang'),
      'id_penerbit'  => $this->input->post('id_penerbit'),
      'tahun_terbit' => $this->input->post('tahun_terbit'),
      'jumlah'       => $this->input->post('jumlah'),
		'gambarbuku'       => $gambarbuku
    );
    $query = $this->db->insert('buku', $data);

    if($query){
      $this->session->set_flashdata('info', 'Data berhasil disimpan');
      redirect('buku');
    }
  }

  public function edit($id){
    $data['content'] = 'buku/edit_buku';
    $data['title'] = 'Form Edit Buku';
    $data['buku'] = $this->buku_model->edit($id);
    $data['pengarang'] = $this->db->get('pengarang')->result();
    $data['penerbit'] = $this->db->get('penerbit')->result();

    $this->load->view('dashboard', $data);
  }

  public function update(){
    $id_buku = $this->input->post('id_buku');

	  $databuku = $this->Query->getData(array('id_buku' => $id_buku ),'buku')->row();



	  if ($this->input->post('filelawas') != '1') {
		  $gambarbuku = $databuku->gambarbuku;

		  }else{

		  $config['allowed_types'] = 'png|jpg|jpeg';
		  $config['remove_spaces'] = TRUE;
		  $config['overwrite'] = TRUE;
		  $config['upload_path'] = 'GambarBuku/';
		  $config['encrypt_name'] = TRUE;

		  $this->load->library('upload');
		  $this->upload->initialize($config);

		  $this->upload->do_upload('editgambarbuku');
		  $gambarbuku = $this->upload->data('file_name');

		  }

	  echo $databuku->gambarbuku;

	  $data = array(
      'id_pengarang' => $this->input->post('id_pengarang'),
      'id_penerbit'  => $this->input->post('id_penerbit'),
      'judul_buku'   => $this->input->post('judul_buku'),
      'tahun_terbit' => $this->input->post('tahun_terbit'),
      'jumlah'       => $this->input->post('jumlah'),
		  'gambarbuku'       => $gambarbuku

    );

    $query = $this->Query->updateData(array('id_buku' =>  $id_buku), $data,'buku');
    if($query){
      $this->session->set_flashdata('info', 'Data berhasil di-update');
      redirect('buku');
    }else{
		echo 'update failed';
	}
  }

  public function delete($id){
    $query = $this->buku_model->delete($id);

    if($query = true){
      $this->session->set_flashdata('info', 'Data berhasil dihapus');
      redirect('buku');
    }
  }



}
