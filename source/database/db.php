<?php 
if(!defined('IN_PF')) {
	exit('Access Denied');
}
class DB{
	private $mysqli;
	private $like_condition;
	private $where_condition;
	private $orwhere_condition;
	private $limit_num;
	private $insert_feild;
	private $insert_value;
	private $update_value;
	private $table_references;
	private $ORDER_BY = NULL;
	private $query_result = NULL;

	function __construct(){
		$config = $GLOBALS['_DB'];
		$this->mysqli = @new mysqli($config['dbhost'], $config['dbuser'], $config['dbpass'], $config['dbname']);
	}

	//選擇資料表
	public function table($table_references){
		$this->table_references = $table_references;
		return $this;
	}

	public function error(){
		echo $this->mysqli->error;
	}

	
	public function ASC($feild){
		$this->ORDER_BY = ' ORDER BY `'.$feild.'` ASC ';
		return $this;
	}
	public function DESC($feild){
		$this->ORDER_BY = ' ORDER BY `'.$feild.'` DESC ';
		return $this;
	}


	//SELECT 用, 配合底下整群where
	public function limit($num){
		if(is_numeric($num)&&$num>0){
			$this->limit_num = $num;
		}
		return $this;
	}
	public function get(){
		$sql = $this->create_query('select');
		$this->query_result = $this->mysqli->query($sql);
		return $this->query_result;
	}
	public function select(){
		$sql = $this->create_query('select');
		$this->query_result = $this->mysqli->query($sql);
		return $this->query_result->fetch_assoc();
	}
	public function toArray(){
		$return = [];
		foreach($this->get() as $data){
			$return[] = $data;
		}
		return $return;
	}
	public function rows(){
		return $this->get()->num_rows;
	}

	//INSERT INTO 用 
	public function insert($insert_array){
		//如果陣列中是陣列 輸入多行
		if(@is_array($insert_array[0])){
			foreach($insert_array as $array){
				$this->insert_feild_edit($array);
			}
		}
		else{
			$this->insert_feild_edit($insert_array);
		}
		
		$sql = $this->create_query('insert');
		$this->query_result = $this->mysqli->query($sql);
		return $this->query_result;		
	}
	public function insert_GetID($insert_array){
		$this->insert($insert_array);
		return $this->mysqli->insert_id;
	}
	private function insert_feild_edit($array){
		$return_array = [];
		$insert_feild = [];
		if(is_array($this->insert_feild)){
			foreach($this->insert_feild as $feild){
				$return_array[$feild] = "NULL";
				if(@$array[$feild]){
					$return_array[$feild] = $this->insert_update_value_fix($array[$feild]);
				}
			}
			
		}
		else{
			foreach($array as $key => $data){
				$insert_feild[] = $key;
				$return_array[$key] = $this->insert_update_value_fix($data);
			}
			$this->insert_feild = $insert_feild;
		}
		$this->insert_value[] = $return_array;
	}
	private function insert_update_value_fix($value){
		$exarr = ['NULL','CURRENT_DATE','CURRENT_TIME','CURRENT_TIMESTAMP'];
		if(is_numeric($value)){
			return $value;
		}
		elseif(in_array($value, $exarr)){
			return $value;
		}
		elseif(is_null($value)){
			return "NULL";
		}
		else{
			return '\''.$value.'\'';
		}

	}
	private function insert_query_edit(){
		foreach($this->insert_feild as $value){
			$insert_feild[] = '`'.$value.'`';
		}
		$this->insert_feild = implode(', ',$insert_feild);

		foreach($this->insert_value as $value){
			$insert_value[] = '('.implode(', ',$value).')';
		}
		$this->insert_value = implode(', ',$insert_value);
	}

	// UPDATE, 配合底下整群where
	public function update($update_array){
		//如果陣列中是陣列 輸入多行
		if(@is_array($update_array[0])){
			foreach($update_array as $array){
				$this->update_feild_edit($array);
			}
		}
		else{
			$this->update_feild_edit($update_array);
		}
		$this->update_value = implode(', ',$this->update_value);


		$sql = $this->create_query('update');
		$this->query_result = $this->mysqli->query($sql);
		return $this->query_result;	
	}
	private function update_feild_edit($array){
		$update_value = '`'.$array[0].'` = '.$this->insert_update_value_fix($array[1]);
		$this->update_value[] = $update_value;
	}

	// DELECT用, 配合底下整群where
	public function delete(){
		$sql = $this->create_query('delete');
		$this->query_result = $this->mysqli->query($sql);
		return $this->query_result;
	}

	// 整群的where
	public function like($where_feild,$where_condition){
		$this->like_condition = ['feild'=>$where_feild,'value'=>$where_condition];
		return $this;
	}

	public function where($where_feild,$symbol,$where_condition=null){
		if(empty($where_condition)){
			$where_condition = $symbol;
			$symbol = "=";
		}
		if(is_array($this->where_condition)){
			$this->where_condition[] = ['feild'=>$where_feild,'symbol'=>$symbol,'value'=>$where_condition];
		}
		else{
			$this->where_condition = [['feild'=>$where_feild,'symbol'=>$symbol,'value'=>$where_condition]];
		}
		return $this;
	}
	public function orwhere($where_feild,$symbol,$where_condition=null){
		if(empty($where_condition)){
			$where_condition = $symbol;
			$symbol = "=";
		}
		$this->orwhere_condition[] = [['feild'=>$where_feild,'symbol'=>$symbol,'value'=>$where_condition]];
		return $this;
	}
	private function where_query_edit(){
		$where_condition = [];
		if(is_array($this->where_condition)){
			foreach($this->where_condition as $data){
				$where_condition[] = '`'. $data['feild'].'` '. $data['symbol'].' '.$this->insert_update_value_fix($data['value']);
			}
		}
		$this->where_condition = implode(' AND ',$where_condition);
		
		if(is_array($this->orwhere_condition)){
			$where_condition = [];
			foreach($this->orwhere_condition as $data){
				$where_condition[] = '`'. $data['feild'].'` '. $data['symbol'].' '.$this->insert_update_value_fix($data['value']);
			}
			$this->where_condition = ' OR '.implode(' OR ',$where_condition);
		}
		if(empty($this->where_condition)){
			$this->where_condition = '1';
		}


		if(@$this->like_condition){
			$data = $this->like_condition; 
			$this->like_condition = '`' . $data['feild'] . '` LIKE \'' . $data['value'] . '\'';
		}
	}

	//直接使用語法
	public function query($sql){
		return $this->mysqli->query($sql);
	}

	//產生SQL
	private function create_query($type=null){
		switch($type){
			case 'select':	//SELECT * FROM `user` WHERE 1
				$this->where_query_edit();
				if($this->like_condition){
					if($this->limit_num){
						$sql_query = "SELECT * FROM `".$this->table_references."` WHERE ".$this->like_condition.$this->ORDER_BY.' LIMIT '.$this->limit_num;
					}
					else{
						$sql_query = "SELECT * FROM `".$this->table_references."` WHERE ".$this->like_condition.$this->ORDER_BY;
					}
				}
				else{
					if($this->limit_num){
						$sql_query = "SELECT * FROM `".$this->table_references."` WHERE ".$this->where_condition.$this->ORDER_BY.' LIMIT '.$this->limit_num;
					}
					else{
						$sql_query = "SELECT * FROM `".$this->table_references."` WHERE ".$this->where_condition.$this->ORDER_BY;
					}
				}
			break;
			case 'insert':	//INSERT INTO `user`(`uid`, `name`) VALUES ([value-1],[value-2])
				$this->insert_query_edit();
				$sql_query = "INSERT INTO `".$this->table_references."` (".$this->insert_feild.") VALUES ".$this->insert_value;
			break;
			case 'update':	//UPDATE `user` SET `uid`=[value-1],`name`=[value-2] WHERE 1
				$this->where_query_edit();
				$sql_query = "UPDATE  `".$this->table_references."` SET  ".$this->update_value."  WHERE ".$this->where_condition;
			break;
			case 'delete':	//DELETE FROM `user` WHERE 0
				$this->where_query_edit();
				$sql_query = "DELETE  FROM `".$this->table_references."` WHERE ".$this->where_condition;
			break;
		}
		$this->like_condition = NULL;
		$this->where_condition = NULL;
		$this->orwhere_condition = NULL;
		$this->limit_num = NULL;
		$this->insert_feild = NULL;
		$this->insert_value = NULL;
		$this->update_value = NULL;
		$this->table_references = NULL;
		$this->query_result = NULL;
		$this->ORDER_BY = NULL;
		return @$sql_query;
	}
}
