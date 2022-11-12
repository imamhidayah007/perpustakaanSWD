<?php 
 
class Query extends CI_Model{


	public function search($sekolah,$jurusan_sekolah,$prodi,$jalur,$table){
		$this->db->like('sekolah', $sekolah);
		$this->db->or_like('jurusan_sekolah', $jurusan_sekolah);
		$this->db->or_like('prodi', $prodi);
		$this->db->or_like('jalur', $jalur);

		$result = $this->db->get($table);

		return $result;
	}


	function getAllData($table)
    {
		return $this -> db -> get($table);
	}

    function getAllDataOrder($table,$params,$order_type)
    {
        $this -> db -> select('*')
                    -> from($table)
                    -> order_by($params,$order_type);
        return $this -> db -> get();
    }
	
	function inputDataDetail($data,$table){
		$input = $this -> db -> insert($table,$data);
        $error = $this->db->error(); // Has keys 'code' and 'message'
        $return_arr = array('is_query'=>$input,'error'=>$error);
    return $return_arr;
	}

  function inputData($data,$table){

    return $this -> db -> insert($table,$data);

  }




	function inputDataCSV($data,$table){

		return $this -> db -> insert_batch($table,$data);

	}


     function inputDataGetLastID($data,$table){
        $insert = $this -> db -> insert($table,$data);
        $get_id = $this-> db ->query('SELECT LAST_INSERT_ID() AS "last_id" ')->row();
        $id = $get_id -> last_id;
        $error = $this->db->error();
        $ret_array = array('id'=>$id,'is_insert'=>$insert,'error'=>$error);
        return $ret_array;
    }

	function delData($where,$table){
		$this -> db -> where($where);
		$delete = $this -> db -> delete($table);
        return $delete;
	}

	function getData($where,$table){
		return $this -> db -> get_where($table,$where);
	}



	function getDataAdmin($where,$table){
		$otherdb = $this->load->database('otherdb', TRUE);

		return $otherdb -> get_where($table,$where);
	}


	function getDataDistince($field,$table)
	{
		$this->db->select($field);
		$this->db->distinct();
		$query = $this->db->get($table);

		return $query;
	}


	function getDataSpecified($field,$table)
    {
        $this -> db -> select($field)
                    -> from($table);
        return $this -> db -> get();
    }


	function getDataOrder($where,$table,$title,$order)
	{
		 $this -> db -> select('*')
			 		-> from($table)
						 -> where($where)
		 			-> order_by($title,$order);
		return $this -> db -> get();
	}

	function getDataOrderLimit($where,$table,$title,$order,$limit)
	{
		$this -> db -> select('*')
			-> from($table)
			-> where($where)
			-> order_by($title,$order)
			->limit($limit);
		return $this -> db -> get();
	}

    function getDataSpecifiedWhere($field,$where,$table)
    {
        $this -> db -> select($field)
                    -> from($table)
                    -> where($where);
        return $this -> db -> get();
    }

	function updateData($where,$data,$table){
		$update = $this->db->where($where)
		                   ->update($table,$data);
        return $update;
	}	

  function updateDataDetail($where,$data,$table){
    $update = $this->db->where($where)
                       ->update($table,$data);
    $error = $this->db->error(); // Has keys 'code' and 'message'
    $return_arr = array('is_query'=>$update,'error'=>$error);
    return $return_arr;
  } 

    function aktifasiBiaya($where,$data,$table){
        $update = $this->db->where('id_biaya_spp !=',$where)
                           ->update($table,$data);
        return $update;
    }   

	function getDataJoin($table1,$table2,$field1,$field2){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field1.'='.$table2.'.'.$field2);
        // $this->db->where($where);
        return $this->db->get();
    }

    function getDataJoinOrder($table1,$table2,$field,$field2,$title,$order){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field2,'left');
        $this->db->order_by($title,$order);
        // $this->db->where($where);
        return $this->db->get();
    }

    function getDataJoinOrderWhere($table1,$table2,$field,$where){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->where($where);
        $this->db->order_by($order);
        return $this->db->get();
    }

    function getDataTransWait()
    {
        $this->db->select('*')
                 ->from('transaksi')
                 ->join('meja','meja.id_meja = transaksi.id_meja','left')
                 ->where(array('status_trans'=>'wait'))
                 ->order_by("tgl_transaksi DESC");
        return $this -> db -> get();
    }

    function getDataJoinWhere($table1,$table2,$field,$field2,$where){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field2);
        $this->db->where($where);
        return $this->db->get();
    }


	function getDataJoinWhere3($table1,$table2,$table3,$field,$field2,$field4,$field3,$where){
		$this->db->select('*');
		$this->db->from($table1);
		$this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field2,'left');
		$this->db->join($table3, $table1.'.'.$field4.'='.$table3.'.'.$field3,'left');
		$this->db->where($where);
		return $this->db->get();
	}

    function getDataJoinLike($table1,$table2,$field,$like){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->like($like);
        return $this->db->get();
    }


     function getDataJoinWhereDiff($table1,$table2,$field,$field2,$where){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field2);
        $this->db->where($where);
        return $this->db->get();
    }

     function getDataJoinWhereNot($table1,$table2,$field,$where,$wherenot){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->where($where);
        $this->db->where_not_in($wherenot);
        return $this->db->get();
    }

   function getDataBahanFromMenu($where)
   {
        $this->db->select('*')
                 ->from('menu_has_bahan')
                 ->join('bahan','menu_has_bahan.id_bahan = bahan.id_bahan','left')
                 ->join('satuan','bahan.id_satuan = satuan.id_satuan','left')
                 ->where($where);
        return $this -> db -> get();
   }  


   function getDataMenuFromTrans()
   {
        $this->db-> select('*')
                 -> from('transaksi_detail')
                 -> join('menu','transaksi_detail.id_menu = menu.id_menu','left')
                 -> join('transaksi','transaksi_detail.id_transaksi = transaksi.id_transaksi','left')
                 -> order_by('transaksi.tgl_transaksi','desc');
        return $this -> db -> get(); 
   }

  function getDataMenuFromTransWhere($where)
   {
        $this->db-> select('*')
                 -> from('transaksi_detail')
                 -> join('menu','transaksi_detail.id_menu = menu.id_menu','left')
                 -> join('transaksi','transaksi_detail.id_transaksi = transaksi.id_transaksi','left')
                 -> order_by('transaksi.tgl_transaksi','desc')
                 -> where($where);  
        return $this -> db -> get(); 
   }

   function GetDataTransaksiDetail($where)
   {
        $this->db-> select('*')
                 -> from('transaksi_detail')
                 -> join('menu','transaksi_detail.id_menu = menu.id_menu','left')
                 -> join('transaksi','transaksi_detail.id_transaksi = transaksi.id_transaksi','left')
                 -> order_by('transaksi.tgl_transaksi','desc')
                 -> where($where);  
        return $this -> db -> get(); 
   }

   function getDataTransaksiFilter($tgl_mulai,$tgl_selesai)
   {
        $this->db -> select('*')
                  -> from('transaksi')
                  -> join('meja','transaksi.id_meja = meja.id_meja','left')
                  -> order_by('transaksi.tgl_transaksi','desc')
                  -> where('tgl_transaksi BETWEEN "'.$tgl_mulai. '" AND "'.$tgl_selesai.'"');
        return $this -> db -> get(); 
   }

    function sum($where)
    {
        $this->db->select_sum('price');
        $this->db->select('sum(jumlah_beli) as count');
        $this->db->from('pre_transaksi');
        $this->db->where($where);
        return $this->db->get();
    }

    public function orderByLimit($table,$field,$sort,$limit){
        $this->db->select('id_transaksi')
            ->from($table)
            ->order_by($field,$sort)
            ->limit($limit);
        return $this->db->get();
    }


    function getLast($table){
        $data = $this -> db -> select('id_transaksi')
                        ->from($table);
        $get_id = $this-> db ->query('SELECT LAST_INSERT_ID() AS "last_id" ')->row();
        $id = $get_id -> last_id;
        $error = $this->db->error();
        $ret_array = array('id_transaksi'=>$id,'is_insert'=>$data,'error'=>$error);
        return $ret_array;
    }


    function selectMax($table, $where)
    {
        $this -> db -> select_max('id_transaksi')
            -> from($table);
        return $this -> db -> get();
    }


//------------------------------SERVER SIDE INPUT NPM VA--------------------

	var $table = 'v_npm_va'; //nama tabel dari database
	var $column_order = array(null, 'nomor','nama','sekolah', 'no_hp','email','prodi', 'jalur','npm','va_regis'); //field yang ada di table user
	var $column_search = array('nomor','nama','sekolah', 'no_hp','email','prodi', 'jalur','npm','va_regis'); //field yang diizin untuk pencarian
	var $order = array('nomor' => 'desc'); // default order

	private function _get_datatables_query()
	{

		$this->db->from($this->table);

		$i = 0;

		foreach ($this->column_search as $item) // looping awal
		{
			if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
			{

				if($i===0) // looping awal
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}




	//----------------------

	function get_v_npm($postData=null){

		$response = array();

		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value

		// Custom search filter
		$searchJalur = $postData['searchJalur'];
		$searchSekolah = $postData['searchSekolah'];
		$searchProdi = $postData['searchProdi'];

		## Search
		$search_arr = array();
		$searchQuery = "";
		if($searchValue != ''){
			$search_arr[] = " (nomor like '%".$searchValue."%' or nama like '%".$searchValue."%' or jalur like '%".$searchValue."%' or 
       no_hp like '%".$searchValue."%' or  email like '%".$searchValue."%' or  sekolah like '%".$searchValue."%' or 
  	  va_regis like '%".$searchValue."%' or   npm like '%".$searchValue."%' or    prodi like'%".$searchValue."%' ) ";
		}
		if($searchJalur != ''){
			$search_arr[] = " jalur='".$searchJalur."' ";
		}
		if($searchSekolah != ''){
			$search_arr[] = " sekolah='".$searchSekolah."' ";
		}
		if($searchProdi != ''){
			$search_arr[] = " prodi like '%".$searchProdi."%' ";
		}
		if(count($search_arr) > 0){
			$searchQuery = implode(" and ",$search_arr);
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$records = $this->db->get('v_npm_va')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		if($searchQuery != '')
			$this->db->where($searchQuery);
		$records = $this->db->get('v_npm_va')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('*');
		if($searchQuery != '')
			$this->db->where($searchQuery);
		$this->db->order_by('id_reg', 'desc');
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('v_npm_va')->result();

		$data = array();
			$no = 1;
		foreach($records as $record ){
			$no++;
			$data[] = array(

				"nomor"=>$record->nomor,
				"nama"=>$record->nama,
				"sekolah"=>$record->sekolah,
				"no_hp"=>$record->no_hp,
				"email"=>$record->email,
				"prodi"=>$record->prodi,
				"jalur"=>$record->jalur,
				"npm"=>$record->npm,
				"va_regis"=>$record->va_regis,
				"opsi"=>"<div class=\"btn-group mb-3 btn-group-sm\" role=\"group\" aria-label=\"Basic example\">
					<a href=\"#\" class=\"btn btn-primary\"><i class=\"fas fa-pen\"></i></a>
				</div>",

			);
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);

		return $response;
	}

//	function getdatabea(){
//
//		$query = $this->db->query("SELECT *,tb_akademik.tingkat AS tk_akademik,tb_akademik.peringkat AS pk_akademik, tb_nonaka.tingkat AS tk_nonaka, tb_nonaka.peringkat AS pk_nonaka FROM tb_reg INNER JOIN tb_nilai ON tb_nilai.no_daftar= tb_reg.nodaftar INNER JOIN tb_bio ON tb_bio.no_daftar=tb_reg.nodaftar INNER JOIN tb_akademik ON tb_akademik.no_daftar=tb_reg.nodaftar INNER JOIN tb_nonaka ON tb_nonaka.no_daftar=tb_reg.nodaftar ORDER BY tb_reg.id_reg DESC");
//		return $query;
//	}

}
