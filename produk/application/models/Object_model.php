<?php
class Object_model extends CI_Model{
	public $last_query;
	public $dbConf;
	public $dbNm;
	public function get_data($config){
		if($this->dbConf != ''){
			$this->db = $this->load->database($this->dbConf, true);			
		}else{
			$this->db = $this->load->database('default', true);
		}
		
		if(isset($config['select']) && $config['select'] != "")
			$this->db->select($config['select']);
		if(isset($config['where']) &&  $config['where'] != "")
			$this->db->where($config['where']);
		if(isset($config['or_where']) &&  $config['or_where'] != "")
			$this->db->or_where($config['or_where']);
		if(isset($config['where_in']) &&  $config['where_in'] != "")
			$this->db->where_in($config['where_in'][0], $config['where_in'][1]);
		if(isset($config['where_not_in']) &&  $config['where_not_in'] != "")
			$this->db->where_not_in($config['where_not_in'][0], $config['where_not_in'][1]);
		if(isset($config['from']) && $config['from'] != "")
			$this->db->from($config['from']); 
		if(isset($config['join']) && is_array($config['join'])){
			foreach($config['join'] as $key => $val){
				if(isset($config['join_type']) && $config['join_type'] != '')
					$this->db->join($key, $val, $config['join_type']);
				else
					$this->db->join($key, $val);
			}	
		}
		if(isset($config['group']) && $config['group'] != "")
			$this->db->group_by($config['group']);
		if(isset($config['order']) && $config['order'] != ""){
			foreach($config['order'] as $key => $val){
				$this->db->order_by($key, $val);
			}
		}	
		if(isset($config['limit']) && $config['limit'] != "")
			$this->db->limit($config['limit']);
		if(isset($config['query']) && $config['query'] != "")
			$query = $this->db->query($config['query']);
		else	
			$query = $this->db->get();	
		$result = (isset($config['result']) && $config['result'] != '' ? $config['result'] : "row");
        // echo $this->db->last_query();
		switch ($result) {
			case 'array':
				return $query->result_array();
			case 'object':
				return $query->result();	
			case 'query':
				return $this->db->last_query();
			case 'count':
				return $query->num_rows();	
			default:
				return $query->row();
		}
	}

	public function updatedata($table, $where, $data, $return = '')
    {
		if($this->dbConf != ''){
			$this->db = $this->load->database($this->dbConf, true);			
		}else{
			$this->db = $this->load->database('default', true);
		}
		if($return != '' && $return == 'affected'){
			$this->db->where($where)->update($table, $data);
			return $this->db->affected_rows();
		}else if($return != '' && $return == 'query'){
			$this->db->where($where)->update($table, $data);
			return $this->db->last_query();
		}else{
			return $this->db->where($where)->update($table, $data);
		}
    }
	
	public function updatedatabacth($table, $data, $where, $return = '')
    {
		if($this->dbConf != ''){
			$this->db = $this->load->database($this->dbConf, true);			
		}else{
			$this->db = $this->load->database('default', true);
		}


		if($return != '' && $return == 'affected'){
			$this->db->update_batch($table, $data, $where); 
			return $this->db->affected_rows();
		}else if($return != '' && $return == 'query'){
			$this->db->update_batch($table, $data, $where); 
			return $this->db->last_query();
		}else{
			return $this->db->update_batch($table, $data, $where); ;
		}
    }
	
	public function insertdata($table, $data, $return = '')
    {
		if($this->dbConf != ''){
			$this->db = $this->load->database($this->dbConf, true);			
		}else{
			$this->db = $this->load->database('default', true);
		}
		
		$result = $this->db->insert($table, $data);
		if(isset($return)){
			if($return == 'getid'){
				$result = $this->db->insert_id();
			}else{
				$result = $this->db->last_query();
			}
		}

		return $result;
    }
	
	public function insertdatabatch($table, $data)
    {
		if($this->dbConf != ''){
			$this->db = $this->load->database($this->dbConf, true);			
		}else{
			$this->db = $this->load->database('default', true);
		}
		$result = $this->db->insert_batch($table, $data);
		
		return $result;
    }
	
	public function insertdatabatchignore($table, $data)
    {
		if($this->dbConf != ''){
			$this->db = $this->load->database($this->dbConf, true);			
		}else{
			$this->db = $this->load->database('default', true);
		}
		$result = $this->db->insert_batch_ignore($table, $data);
		
		return $result;
    }
	
	public function deletedata($table, $where, $return='')
    {
		if($this->dbConf != ''){
			$this->db = $this->load->database($this->dbConf, true);			
		}else{
			$this->db = $this->load->database('default', true);
		}
		if($return != ''){
			$this->db->delete($table, $where);
			return $this->db->last_query();
		}else{
			return $this->db->delete($table, $where);	
		}        
    }
	
	
	private function get_count_all_rows($table){
		if($this->dbConf != ''){
			$this->db = $this->load->database($this->dbConf, true);			
		}else{
			$this->db = $this->load->database('default', true);
		}
		//where/like
        $sSearch = $this->input->get_post('search[value]', true);
        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($table['table_column']); $i++)
            {
                $bSearchable = $this->input->get_post('columns['.$i.'][searchable]', true);
                
                // Individual column filtering
                if(isset($bSearchable) && $bSearchable == 'true')
                {
					$whr = $table['table_column'][$i];
					if (preg_match("/as/i", $whr)) {
						$expwhr = explode(" as ", $whr);
						$whr = $expwhr[0];
					}
					$tableexplode = explode(" ", $whr);
					$tableex = (count($tableexplode) > 3 ? $whr : $tableexplode[0]);
					if($tableex != 'key'){
						if(isset($table['table_where']) && $table['table_where'] != ''){						
							$array = array('LOWER('.$tableex.')' => strtolower($sSearch));
							$this->db->or_like($array, true);
							$this->db->where($table['table_where']);
						}else if(isset($table['table_where_in']) && $table['table_where_in'] != ''){
							$array = array('LOWER('.$tableex.')' => strtolower($sSearch));
							$this->db->or_like($array, true);
							$this->db->where_in($table['table_where_in'][0], $table['table_where_in'][1]);
						}else if(isset($table['table_where_not_in']) && $table['table_where_not_in'] != ''){
							$array = array('LOWER('.$tableex.')' => strtolower($sSearch));
							$this->db->or_like($array, true);
							$this->db->where_not_in($table['table_where_not_in'][0], $table['table_where_not_in'][1]);
						}else{
							$this->db->or_like('LOWER('.$tableex.')', strtolower($sSearch), true);
						}
					}
                }
            }
        }else{
			if(isset($table['table_where']) && $table['table_where'] != '')
				$this->db->where($table['table_where']);
			if(is_array($table['table_where_in']) && $table['table_where_in'] != '')
				$this->db->where_in($table['table_where_in'][0], $table['table_where_in'][1]);
			if(is_array($table['table_where_not_in']) && $table['table_where_not_in'] != '')
				$this->db->where_not_in($table['table_where_not_in'][0], $table['table_where_not_in'][1]);
		}
        if(isset($table['table_distinct']) && $table['table_distinct'] == TRUE){
			$this->db->distinct();
		}
        // Select Data
		if(isset($table['table_column']) && $table['table_column'] != '')
			$this->db->select($table['table_column']);
		// from Data
		if(isset($table['table_parent']) && $table['table_parent'] != '')
			$this->db->from($table['table_parent']);
		// join table Data
		if(isset($table['table_join']) && is_array($table['table_join'])){
			foreach($table['table_join'] as $key => $val){
				if(isset($table['table_join_type']) && $table['table_join_type'] != '')
					$this->db->join($key, $val, $table['table_join_type']);
				else
					$this->db->join($key, $val);		
			}	
		}	
		if(isset($table['table_group']) && $table['table_group'] != "")
			$this->db->group_by($table['table_group']);
		//get data
		if(isset($table['table_query']) && $table['table_query'] != "")
			$rResult = $this->db->query($table['table_query']);	
		else
			$rResult = $this->db->get();
		$iTotal = @$rResult->num_rows();
		return $iTotal;
	}
	
	public function getTable($table)
    {
		
		if($this->dbConf != ''){
			$this->db = $this->load->database($this->dbConf, true);			
		}else{
			$this->db = $this->load->database('default', true);
		}
		
		if(!isset($table['table_column']) && isset($table['table_parent']) ){
			$fields = $this->db->list_fields($table['table_parent']);
			$table['table_column'] = $fields;
		}
        //limit
		$iDisplayStart = $this->input->get_post('start', true);
        $iDisplayLength = $this->input->get_post('length', true);
		//order by
		$sortcolumn = $this->input->get_post('order[0][column]', true);
		$sort = $this->input->get_post('order[0][dir]', true);
		//where/like
        $sSearch = $this->input->get_post('search[value]', true);
		
        $draw = $this->input->get_post('draw', true);
		// Paging
		if((isset($iDisplayStart) && $iDisplayLength != '-1'))
        {
			if(!isset($table['table_limit']))
				$this->db->limit($iDisplayLength, $iDisplayStart);
        }
        
        // Ordering
        if(isset($sortcolumn) && $sortcolumn > 0)
        {
			for($i=0; $i<count($this->input->get_post('order')); $i++){
				if($this->input->get_post('columns['.$this->input->get_post('order['.$i.'][column]').'][orderable]') == 'true')
				{
					$odr = $table['table_column'][intval($this->input->get_post('order['.$i.'][column]'))];				
					//if (preg_match("/as/i", $odr)) {
					if (count(explode(" ", $odr)) > 1) {
						$expodr = explode(" ", $odr);
						$odr = $expodr[count($expodr-1)];
					} 					
					$tableexplode = explode(" ", $odr);
					$keyex = (count($tableexplode) > 3 ? $odr : $tableexplode[0]);	
					
					$this->db->order_by($keyex, $this->input->get_post('order['.$i.'][dir]'));
				}
			}	
        }else{
			if(isset($table['table_order']) && is_array($table['table_order'])){
				foreach($table['table_order'] as $key => $val){
					$tableexplode = explode(" ", $key);
					$keyex = (count($tableexplode) > 3 ? $key : $tableexplode[0]);					
					$this->db->order_by($keyex, $val);
				}	
			}	
		}
        
        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($table['table_column']); $i++)
            {
                $bSearchable = $this->input->get_post('columns['.$i.'][searchable]', true);
                
                // Individual column filtering
                if(isset($bSearchable) && $bSearchable == 'true')
                {
					$whr = $table['table_column'][$i];
					if (preg_match("/as/i", $whr)) {
						$expwhr = explode(" as ", $whr);
						$whr = $expwhr[0];
					}
					
					$tableexplode = explode(" ", $whr);
					$tableex = (count($tableexplode) > 3 ? $whr : $tableexplode[0]);
					if($tableex != 'key'){	
						if(isset($table['table_where']) && $table['table_where'] != ''){						
							$array = array('LOWER('.$tableex.')' => strtolower($sSearch));
							$this->db->or_like($array, true);
							$this->db->where($table['table_where']);
						}else if(isset($table['table_where_in']) && $table['table_where_in'] != ''){
							$array = array('LOWER('.$tableex.')' => strtolower($sSearch));
							$this->db->or_like($array, true);
							$this->db->where_in($table['table_where_in'][0], $table['table_where_in'][1]);
						}else if(isset($table['table_where_not_in']) && $table['table_where_not_in'] != ''){
							$array = array('LOWER('.$tableex.')' => strtolower($sSearch));
							$this->db->or_like($array, true);
							$this->db->where_not_in($table['table_where_not_in'][0], $table['table_where_not_in'][1]);
						}else{
							$this->db->or_like('LOWER('.$tableex.')', strtolower($sSearch), true);
						}	
					}	
                }
            }
        }else{
			if(isset($table['table_where']) && $table['table_where'] != '')
				$this->db->where($table['table_where']);
			if(isset($table['table_where_in']) && $table['table_where_in'] != '')
				$this->db->where_in($table['table_where_in'][0], $table['table_where_in'][1]);
			if(isset($table['table_where_not_in']) && $table['table_where_not_in'] != '')
				$this->db->where_not_in($table['table_where_not_in'][0], $table['table_where_not_in'][1]);
		}
        if(isset($table['table_distinct']) && $table['table_distinct'] == TRUE){
			$this->db->distinct();
		}
        // Select Data
		if(isset($table['table_column']) && $table['table_column'] != '')
			$this->db->select($table['table_column']);
		// from Data
		if(isset($table['table_parent']) && $table['table_parent'] != '')
			$this->db->from($table['table_parent']);
		// join table Data
		if(isset($table['table_join']) && is_array($table['table_join'])){
			foreach($table['table_join'] as $key => $val){
				if(isset($table['table_join_type']) && $table['table_join_type'] != '')
					$this->db->join($key, $val, $table['table_join_type']);
				else
					$this->db->join($key, $val);		
			}	
		}	
		
		if(isset($table['table_group']) && $table['table_group'] != "")
			$this->db->group_by($table['table_group']);
		//get data
		if(isset($table['table_query']) && $table['table_query'] != ""){
			if(isset($iDisplayStart) && $iDisplayLength != '-1'){
				if(!isset($table['table_limit'])){
					$rResult = $this->db->query($table['table_query']." LIMIT ".$iDisplayLength." OFFSET ".$iDisplayStart);
				}else{
					$rResult = $this->db->query($table['table_query']);	
				}	
			}else{
				$rResult = $this->db->query($table['table_query']);	
			}	
		}else{
			$rResult = $this->db->get();
		}	
		$this->last_query = $this->db->last_query(); //debuging last query
		
        // Data set length after filtering
		//$this->db->select('COUNT(*) OVER() AS found_rows');
		$iTotal = @$rResult->num_rows();
		
		$iFilteredTotal = @$this->get_count_all_rows($table);
		$result = $rResult->result();
		if(isset($table['table_result']) && ($table['table_result'] == 'datatable' || $table['table_result'] == 'data')){
			// Output
			$no = $iDisplayStart;
			$output = array(
				'draw' => intval($draw),
				'recordsTotal' => $iTotal,
				'recordsFiltered' => $iFilteredTotal,
				'query' => $this->last_query,
				'data' => array()
			);
			foreach($result as $aRow ){
				$no++;					
				$row = array();
				$row['no'] = $no;
				foreach($aRow as $key=>$val){
					$row[$key] = nl2br(trim($val));
				}
				$output['data'][] = $row;
			}
		}else if(isset($table['table_result']) && $table['table_result'] == 'array'){
			$output = array(); $no = 0;
			foreach($result as $aRow ){
				$no++;					
				$row = array();
				$row['no'] = $no;
				foreach($aRow as $key=>$val){	
				   $row[$key] = nl2br(trim($val));
				}	
				$output[] = $row;
			}
		}else if(isset($table['table_result']) && $table['table_result'] == 'query'){
			$output[] = $this->last_query;
		}else{
			$output = array();
			foreach($result as $aRow ){
				$k=0;
				foreach($aRow as $val){	
				    if(isset($table['table_rows'])){
						if($k === $table['table_rows'])
							$output[] = nl2br(trim($val));
					}else{   
						$output[] = nl2br(trim($val));
					}	
				$k++;   
				}	
			}
		}	
        //echo $this->db->last_query();die();
		return $output;
    }
}