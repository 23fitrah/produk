<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public $db;
	function __construct()
	{
		parent::__construct();
		$this->_ci=&get_instance();
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->connect();
	}
	
	public function cetak(){
		$input="1.225.441";
		$input= str_replace(".","",$input);
		
		echo "<br/>";
		for($i=0; $i < strlen($input); $i++){
			echo $input[$i]. $this->cetak_nol(5).'<br/>';
		}
		echo $input[1];

	

	}
	

	private function connect(){
		$this->load->model("Object_model");
	}

	public function index()
	{	 
		$this->load->view('inventory/index');
	}
 
 
	public function search(){
	
		$result = $this->data("datatable");
		echo json_encode($result);
	}

	 
	private function data($format){		
		$query['table_parent'] = 'tbl_produk';
		$query['table_column'] =  array ("Id", "Nama_barang", "Kode_barang", "Jumlah_barang", "Tanggal");
		$query['table_result'] = $format;
		$result = $this->Object_model->getTable($query);
		return $result;
	}

	public function add(){		
		$data 	= 'failed store data';
		$store= array(
			'Id'			=> $this->input->post("Id"),
			'Nama_barang' 	=> $this->input->post("Nama_barang"),
			'Kode_barang' 	=> $this->input->post("Kode_barang"),
			'Jumlah_barang' => $this->input->post("Jumlah_barang"),
			'Tanggal' 		=> $this->input->post("Tanggal")
		);	

		//validasi form disini
        $this->form_validation->set_rules('Nama_barang', 'Nama Barang', 'trim|required|xss_clean');
        $this->form_validation->set_rules('Kode_barang', 'Kode Barang', 'trim|required|xss_clean');
        $this->form_validation->set_rules('Jumlah_barang', 'Jumlah Barang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Tanggal', 'Tanggal', 'trim|required|xss_clean');

		if($this->form_validation->run($this) == FALSE){
			$replace = array("<p>","</p>");
			$data = str_replace($replace,"",validation_errors());	
			$data = $data;
            $html = json_encode(array("status" => "failedval",
									     "message" => $data));
        }else{ 

			$process = $this->Object_model->insertdata("tbl_produk", $store);
			$result = (bool)$process;	 
			 
			if($result === TRUE){
				$html = json_encode(array("status" => "success",
									      "message" => "Success Save To Database"));
			}else{
				$html = json_encode(array("status" => "failed",
									      "message" => $data));
            }
        }
		echo $html;
	}

	public function update(){		
		$data 	= 'failed store data';
		$store= array(
			'Id'			=> $this->input->post("Id"),
			'Nama_barang' 	=> $this->input->post("Nama_barang"),
			'Kode_barang' 	=> $this->input->post("Kode_barang"),
			'Jumlah_barang' => $this->input->post("Jumlah_barang"),
			'Tanggal' 		=> $this->input->post("Tanggal")
		);	

		//validasi form disini
        $this->form_validation->set_rules('Nama_barang', 'Nama Barang', 'trim|required|xss_clean');
        $this->form_validation->set_rules('Kode_barang', 'Kode Barang', 'trim|required|xss_clean');
        $this->form_validation->set_rules('Jumlah_barang', 'Jumlah Barang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Tanggal', 'Tanggal', 'trim|required|xss_clean');

		if($this->form_validation->run($this) == FALSE){
			$replace = array("<p>","</p>");
			$data = str_replace($replace,"",validation_errors());	
			$data = $data;
               $html = json_encode(array("status" => "failedval",
									     "message" => $data));
        }else{ 

			$where = array("Id" => $store['Id']);
			$process = $this->Object_model->updatedata("tbl_produk", $where, $store, "query");
			$result = (bool)$process;
 
			if($result === TRUE){
				$html = json_encode(array("status" => "success",
									      "message" => "Success Save To Database"));
			}else{
				$html = json_encode(array("status" => "failed",
									      "message" => $data));
            }
        }
		echo $html;
	}

	public function detail($id){		
		
		$query['from'] = 'tbl_produk';
		$query['where'] =  array ("Id" => $id);
		$result = $this->Object_model->get_data($query);
		echo json_encode($result);
	}

	public function delete($id){		
		
		$query['from'] = 'tbl_produk';
		$query['where'] =  array ("Id" => $id);
		$result = $this->Object_model->deletedata($query['from'],$query['where'] );
		$result = (bool)$result;
		
		if($result === TRUE){
			$html = json_encode(array("status" => "success",
									  "message" => "Success Delete"));
		}else{
			$html = json_encode(array("status" => "failed",
									  "message" => $data));
		}

		echo $html;

	}

}
