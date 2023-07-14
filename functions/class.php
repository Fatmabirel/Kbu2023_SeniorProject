
<?php

$dbh = NULL;
$dbh_time = 0;

class Obj {

	public function __construct($obj=NULL){
		if(!is_null($obj)&&(is_object($obj)||is_array($obj))){
			foreach ($obj as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	public function getDBH(){
		global $dbh;
		global $dbh_time;

		if(is_null($dbh) || time()-$dbh_time>100){
			try{
				$dbh = new PDO(
					"mysql:host=localhost;dbname=bitirme;charset=utf8mb4", 
					"root", 
					""
				);
				$dbh_time = time();
			}catch(PDOException $e) {
				die("FATAL! Database connection error!");
			}
		}
		return $dbh;
	}


	public function execute($query, $array=NULL){
		$dbh = $this->getDBH();

		$stmt = $dbh->prepare($query);
		if(!is_null($array)){
			foreach ($array as $key => $value) {
				$stmt->bindValue($key, $value);	
			}
		}
		$stmt->execute();

		if($stmt -> rowCount() >= 0){
			return true;
		}else{
			$this->error = "No rows changed.";
			return false;
		}
	}

	public function load($query, $array=NULL, $cache=[]){
		$dbh = $this->getDBH();

		if($cache["caching"]??false){
			$temp_file_name = $cache["name"]??hash('sha512',$query.json_encode($array));
			$cache_file = $_ENV["CACHE_DIR"].$temp_file_name;

			if(file_exists($cache_file)&&filemtime($cache_file)>strtotime("-".($cache["time"]??CACHE_TIME))){
				$temp = json_decode(file_get_contents($cache_file));
				foreach ($temp as $key => $value) {
					$this->{$key}=$value;
				}
				return isset($this->error)?false:true;
			}
		}

		$stmt = $dbh->prepare($query);
		if(!is_null($array)){
			foreach ($array as $key => $value) {
				$stmt->bindValue($key, $value);	
			}
		}
		$stmt->execute();

		if($stmt -> rowCount() == 1){
			$res = $stmt->fetch(PDO::FETCH_OBJ);
			foreach ($res as $key => $value) {
				$this->$key = $value;
			}
			$result=true;
		}else{
			$this->error = $stmt->errorInfo();
			$result=false;
		}

		if($cache["caching"]??false){
			file_put_contents($cache_file, json_encode($this));
		}
		return $result;
	}

	public function list($query, $array=NULL, $cache=[]){
		$dbh = $this->getDBH();

		if($cache["caching"]??false){
			$temp_file_name = $cache["name"]??hash('sha512',$query.json_encode($array));
			$cache_file = $_ENV["CACHE_DIR"].$temp_file_name;

			if(file_exists($cache_file)&&filemtime($cache_file)>strtotime("-".($cache["time"]??CACHE_TIME))){
				$temp = json_decode(file_get_contents($cache_file));
				foreach ($temp as $key => $value) {
					$this->{$key}=$value;
				}
				return isset($this->list)?true:false;
			}
		}

		$stmt = $dbh->prepare($query);
		if(!is_null($array)){
			foreach ($array as $key => $value) {
				$stmt->bindValue($key, $value);	
			}
		}
		$stmt->execute();

		if($stmt -> rowCount() > 0){
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);
			$this->count = $stmt -> rowCount();
			$this->list = $result;

			$res = true;
		}else{
			$this->error = $stmt->errorInfo();
			$res = false;
		}

		if($cache["caching"]??false){
			file_put_contents($cache_file, json_encode($this));
		}
		return $res;
	}
	
	public function update($database){
		if(isset($this->id)){
			$dbh = $this->getDBH();
			$set="";
			$edited=$this->info();
			
			foreach ($edited as $key => $value) {
				$set.="$key = :$key, ";
			}
			$set = substr($set, 0, -2);

			$stmt = $dbh->prepare(sprintf("UPDATE %s SET %s WHERE id = :id",$database,$set));	
			foreach ($edited as $key => $value) {
				$stmt->bindValue(":$key", $value);	
			}
			$stmt->execute();
			
			if($stmt -> rowCount() == 1){
				return true;
			}else{
				$this->error = $stmt->errorInfo();
				return false;
			}
		}else{

			echo $this->error = "Object ID not found.";
			return false;
		}		
	}

	public function create($database){
		$dbh = $this->getDBH();
		$set="";
		$info=$this->info();
		
		foreach ($info as $key => $value) {
			$set.="$key = :$key, ";	
		}
		$set = substr($set, 0, -2);

		$stmt = $dbh->prepare(sprintf("INSERT INTO %s SET %s",$database,$set));	
		foreach ($info as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}
		$stmt->execute();

		if($stmt -> rowCount() == 1){
			$this->id = $dbh->lastInsertId();
			return true;
		}else{
			
			$this->error = $stmt->errorInfo();
			return false;
		}
	}

	public function createOnce($database,$options){	
		$dbh = $this->getDBH();

		$columns = array();
		$values = array();
		$on_duplicate = array();

		$info=$this->info();
		foreach ($info as $key => $value) {
			$columns[]="{$key} = :{$key}";
			$values[$key]=$value;
			if(isset($options["exclude_columns"]) && !in_array($key, $options["exclude_columns"])){
				$on_duplicate[]="{$key}=VALUES({$key})";
			}else if(isset($options["include_columns"]) && in_array($key, $options["include_columns"])){
				$on_duplicate[]="{$key}=VALUES({$key})";
			}
		}

		$stmt = $dbh->prepare(sprintf("INSERT INTO %s SET %s ON DUPLICATE KEY UPDATE %s", 
			$database,
			implode(",",$columns),
			implode(",",$on_duplicate),
		));	
		$stmt->execute($values);

		$error = $stmt->errorInfo();
		if(($error[0]??"-1")!="00000"){
			$this->error = $error;
			return false;
		}else{
			return true;
		}
	}

	public function multicreate($options){	
		$dbh = $this->getDBH();
		$chunked_objects = array_chunk($options["objects"], $options["count"]??500, true);

		$errors=array();
		foreach ($chunked_objects as $chunked_object) {			
			$columns=array();
			$query=array();
			$vals=array();
			foreach ($chunked_object as $object) {
				$temp_query=array();
				foreach ($object as $key => $value) {
					if(is_array($value)||is_object($value)){
						$value="-";
					}
					$temp_query[] = ":val".count($vals);
					$vals[":val".count($vals)]=$value;
					if(!in_array($key, $columns)){
						$columns[]=$key;
					}
				}
				$query[]=sprintf("(%s)",implode(",",$temp_query));
			}

			$stmt = $dbh->prepare(sprintf(
				"INSERT INTO %s (%s) VALUES %s %s",
				$options["table"],
				implode(",",$columns),
				implode(",",$query),
				isset($options["on_duplicate"])?"ON DUPLICATE KEY UPDATE {$options["on_duplicate"]}":""
			));
			$stmt->execute($vals);

			$error = $stmt->errorInfo();
			if(($error[0]??"-1")!="00000"){
				$errors[]=$error;
			}
		}

		if(empty($errors)){
			return true;
		}else{
			$this->error = $errors;
			return false;
		}
	}

	public function info(){
		return get_object_vars($this);
	}

}