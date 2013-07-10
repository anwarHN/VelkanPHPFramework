<?php
/**
 * Velkan PHP Framework
 * Adaptador para mySql
 *
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class mysql implements dbAdapterBase{
	var $dbLink;
	
	var $db;
	var $host;
	var $user;
	var $pass;
	
	var $isTrans;
	
	var $currResult;
	
	var $calculatedRows;
	
	protected $error=0;
	protected $error_str="";
	
	function __construct(){
		extract(velkan::$configDB);
		
		$this->db=$database;
		$this->host=$host;
		$this->user=$user;
		$this->pass=$pass;
		
		if($userConn=user::getSelfDataBaseConnection()){
			$this->db=$userConn["database"];
			$this->host=$userConn["host"];
			$this->user=$userConn["user"];
			$this->pass=$userConn["pass"];
		}
	}
	
	function connect(){
		$this->dbLink=mysql_connect($this->host,$this->user,$this->pass);
		mysql_select_db($this->db, $this->dbLink);
		mysql_query("SET time_zone = '".velkan::$configDB["time_zone"]."'",$this->dbLink);
		mysql_query("SET NAMES '".velkan::$configDB["localeTimeCharset"]."'",$this->dbLink);
		mysql_query("SET lc_time_names = '".velkan::$configDB["localeTimeNames"]."'",$this->dbLink);
	}
	
	function formatDateForDisplay($field){
		return "date_format($field,'".velkan::$configDB["dateFormatForDisplay"]."')";
	}

	function formatDateValueForQuery($date){
		return "'$date'";
	}
	
	function formatDateValueForSaving($date){
		return $date;
	}
	
	function formatTimeForDisplay($field){
		return "date_format($field,'".velkan::$configDB["timeFormatForDisplay"]."')";
	}
	
	function formatTimeValueForQuery($time){
		return "'$time'";
	}
	
	function formatTimeValueForSaving($time){
		return $time;
	}
	
	function formatDateTimeForDisplay($field){
		return "date_format($field,'".velkan::$configDB["dateTimeFormatForDisplay"]."')";
	}
	
	function formatDateTimeValueForSaving($dateTime){
		return $dateTime;
	}
	
	function formatDateTimeValueForQuery($dateTime){
		return "'$dateTime'";
	}
	
	function close(){
		mysql_close($this->dbLink);
		$this->isTrans=false;
		$this->dbLink=false;
	}
	
	function begin(){
		$this->isTrans=true;
		$this->dbLink = mysql_connect($this->host,$this->user,$this->pass);
		mysql_query("START TRANSACTION", $this->dbLink);
		return mysql_query("BEGIN",$this->dbLink);
	}
	
	
	function commit(){
		if($this->sn_trans==1){
			return mysql_query("COMMIT", $this->dbLink);
			mysql_close($this->dbLink);
		}

		$this->isTrans=false;
	}

	
	function rollback(){
		return mysql_query("ROLLBACK", $this->dbLink);
		$this->isTrans=false;
		mysql_close($this->dbLink);
	}
	
	function query($sql,$calculateRows=false,$fastHint=false){
		if(!$this->dbLink){
			$this->connect();
		}
		if($calculateRows){
			$sql=str_replace("select","SELECT SQL_CALC_FOUND_ROWS ",$sql);
			$sql=str_replace("SELECT","SELECT SQL_CALC_FOUND_ROWS ",$sql);
		}
		
		if($fastHint){
			$sql=str_replace("select","SELECT /*! HIGH_PRIORITY*/ ",$sql);
			$sql=str_replace("SELECT","SELECT /*! HIGH_PRIORITY*/ ",$sql);
		}
		
		$this->error=0;
		$this->error_str="";

		if(!$this->dbLink){
			$this->error = -1;
			$this->error_str="Couldn't find an active conection";
			
			return false;
		}
		
		//echo $sql;
		
		if(!$rsResp = mysql_query($sql,$this->dbLink)){
			$this->error = -2;
			$this->error_str=mysql_error();
			
			if(!$this->isTrans){
				$this->close();
			}
			
			return false;
		}else{
			$this->calculatedRows=0;
			
			if($calculateRows){
				$sql="SELECT FOUND_ROWS()";
				$rsRespRows = mysql_query($sql,$this->dbLink);
				$calcRows=mysql_fetch_array($rsRespRows);
				$this->calculatedRows=$calcRows[0];
				mysql_free_result($rsRespRows);
				unset($rsRespRows);
			}
			
			if(!$this->isTrans){
				$this->close();
			}
			$this->currResult=$rsResp;
			return true;
		}
	}
	
	function exec($sql){
		if(!$this->dbLink){
			$this->connect();
		}
	
		$this->error=0;
		$this->error_str="";
	
		if(!$this->dbLink){
			$this->error = -1;
			$this->error_str="Couldn't find an active conection";
			
			return false;
		}
	
		if(!$rsResp = mysql_query($sql,$this->dbLink)){
			$this->error = -2;
			$this->error_str=mysql_error();
				
			if(!$this->isTrans){
				$this->close();
			}
				
			return false;
		}else{
			if(!$this->isTrans){
				$this->close();
			}
			$this->currResult=$rsResp;
			return true;
		}
	}
	
	function fetch($type=0){
		switch ($type){
			case 0:
				$type=MYSQL_BOTH;
				break;
			case 1:
				$type=MYSQL_ASSOC;
				break;
			case 2:
				$type=MYSQL_NUM;
				break;
		}
		
		if(!empty($this->currResult)){
			return mysql_fetch_array($this->currResult,$type);
		}
	}
	
	function getArray(){
		$dataArray=array();
		
		while($r = mysql_fetch_assoc($this->currResult)) {
			$dataArray[] = $r; // Agregamos al fila entera al array. [] es una sintaxis similar a usar array_push()
		}
		return $dataArray;
	}
	
	function freeResult(){
		@mysql_free_result($this->currResult);
	}
	
	function checkRealEscapeString($value){
		//Si el valor es NULL, debe ir sin el caracter '
		if($value=="NULL"){
			return "NULL";
		}
		
		if(!$this->dbLink){
			$this->connect();
		}
		
		if (get_magic_quotes_gpc()){
			$value = stripslashes($value);
		}
		
		if (!is_numeric($value)){
			$value = "'" . mysql_real_escape_string($value) . "'";
		}
		return $value;
	}
	
	public function getLastInsertedID(){
		return mysql_insert_id();
	}
	
	function getByID($table,$field,$value){
		$value=$this->checkRealEscapeString($value);
		$sql = "SELECT * FROM $table WHERE $field=$value";
		return $this->query($sql);
	}
	
	function getFields($table, $fields="", $condition="",$order="",$limit="",$calculateRows=false,$fastHint=false){
		$conditions="";
		if(is_array($condition)){
			foreach ($condition as $key=>$value){
				if(is_array($value)){
					$cond="";
					switch($value["type"]){
						case velkan::$DATATYPE_STRING:
							$cond=" $table.$key=".$this->checkRealEscapeString($value["value"]);
							break;
						case velkan::$DATATYPE_NUMBER:
							$cond=" $table.$key=".$value["value"];
							break;
						case velkan::$DATATYPE_DATE:
							$cond=" $table.$key=".$this->formatDateValueForQuery(date_time::convertDateValueForDataBase($value["value"],date_time::$DATETIME_PICKER_TYPE_DATE));
							break;
						case velkan::$DATATYPE_TIME:
							$cond=" $table.$key=".$this->formatTimeValueForQuery(date_time::convertDateValueForDataBase($value["value"],date_time::$DATETIME_PICKER_TYPE_TIME));
							break;
						case velkan::$DATATYPE_DATETIME:
							$cond=" $table.$key=".$this->formatDateTimeValueForQuery(date_time::convertDateValueForDataBase($value["value"],date_time::$DATETIME_PICKER_TYPE_DATETIME));
							break;			
					}
					
					if($conditions==""){
						$conditions=$cond;
					}else{
						$conditions=" AND $cond";
					}
				}else{
					if($conditions==""){
						$conditions=" $table.$key=".$this->checkRealEscapeString($value);
					}else{
						$conditions=" AND $table.$key=".$this->checkRealEscapeString($value);
					}
				}
			}
		}else{
			$conditions=$condition;
		}
		
		$fieldsSelect="";
		
		
		if(is_array($fields)&&!empty($fields)){
			$fieldFormat="";
			
			foreach($fields as $field=>$dataType){
				switch (trim($dataType)){
					case velkan::$DATATYPE_DATE:
						$fieldFormat=$this->formatDateForDisplay($table.".".$field)." $field";
						break;
					case velkan::$DATATYPE_TIME:
						$fieldFormat=$this->formatTimeForDisplay($table.".".$field)." $field";
						break;
					case velkan::$DATATYPE_DATETIME:
						$fieldFormat=$this->formatDateTimeForDisplay($table.".".$field)." $field";
						break;
					default:
						$fieldFormat="$table.$field";
						break;
				}
				
				if($fieldsSelect==""){
					$fieldsSelect=$fieldFormat;
				}else{
					$fieldsSelect.=",".$fieldFormat;
				}
			}
		}else{
			if(empty($fields)){
				$fieldsSelect="";
			}else{
				$fieldsSelect=$fields;
			}
		}
		
		$sql="SELECT "
			.($fieldsSelect==""?"*":$fieldsSelect)
			." FROM $table "
			.($conditions==""?"":"WHERE $conditions")." "
			.($order==""?"":"ORDER BY $order")." "
			.($limit==""?"":"LIMIT $limit");
		
		return $this->query($sql,$calculateRows,$fastHint);
	}
	
	function insert($table,array $data){
		$isArray=false;
		$fields="";
		$values="";
		foreach($data as $dataType){
			if(is_array($dataType)){
				$isArray=true;
			}
		}
		
		if($isArray){
			foreach($data as $field=>$dataType){
				if($fields==""){
					$fields=$field;
				}else{
					$fields.=",".$field;
				}
				
				$value="";
				
				switch ($dataType["dataType"]){
					case velkan::$DATATYPE_DATE:
						$value="'".$this->formatDateValueForSaving(date_time::convertDateValueForDataBase($dataType["value"],date_time::$DATETIME_PICKER_TYPE_DATE))."'";
						break;
					case velkan::$DATATYPE_TIME:
						$value="'".$this->formatTimeValueForSaving(date_time::convertDateValueForDataBase($dataType["value"],date_time::$DATETIME_PICKER_TYPE_TIME))."'";
						break;
					case velkan::$DATATYPE_DATETIME:
						$value="'".$this->formatDateTimeValueForSaving(date_time::convertDateValueForDataBase($dataType["value"],date_time::$DATETIME_PICKER_TYPE_DATETIME))."'";
						break;
					default:
						$value=$this->checkRealEscapeString($dataType["value"]);
						break;
				}
				
				if($values==""){
					$values=$value;
				}else{
					$values.=",$value";
				}
			}
		}else{
			$fields = implode(',', array_keys($data));
			foreach ($data as $key => &$value){
				$value = $this->checkRealEscapeString($value);
			}
			$values = implode(',', array_values($data));
		}
		
		$sql="INSERT INTO $table ($fields) values ($values)";
		
		if(!$this->query($sql)){
			return false;
		}
		
		return true;
	}
	
	function update($table,array $updates,$conditions){
		$set="";
		$data="";
		foreach ($updates as $key=>$update){
			switch ($update["dataType"]){
				case velkan::$DATATYPE_DATE:
					$data=$table.".".$key."='".$this->formatDateValueForSaving(date_time::convertDateValueForDataBase($update["value"], date_time::$DATETIME_PICKER_TYPE_DATE))."'";
					break;
				case velkan::$DATATYPE_TIME:
					$data=$table.".".$key."='".$this->formatTimeValueForSaving(date_time::convertDateValueForDataBase($update["value"], date_time::$DATETIME_PICKER_TYPE_TIME))."'";
					break;
				case velkan::$DATATYPE_DATETIME:
					$data=$table.".".$key."='".$this->formatDateTimeValueForSaving(date_time::convertDateValueForDataBase($update["value"], date_time::$DATETIME_PICKER_TYPE_DATETIME))."'";
					break;
				default:
					$data=$table.".".$key."=".$this->checkRealEscapeString($update["value"]);
			}
			
			if($set==""){
				$set.=$data;
			}else{
				$set.=",$data";
			}
			
		}
		
		$where="";
		
		if(is_array($conditions)){
			foreach ($conditions as $key => &$value){
				$value = $this->checkRealEscapeString($value);
				if($where==""){
					$where.="WHERE $table.$key=$value ";
				}else{
					$where.=" AND $table.$key=$value ";
				}
			}
		}else{
			$where="WHERE $conditions";
		}
		
		$sql = "UPDATE $table SET $set $where";
		
		//print_r($sql);
		
		if(!$this->query($sql)){
			return false;
		}
		return true;
	}
	
	function delete($table, array $conditions){
		$where="";
		$data="";
		foreach ($conditions as $key => &$value){
			if(is_array($value)){
				switch ($value["dataType"]){
					case velkan::$DATATYPE_DATE:
						$data=$table.".".$key."='".$this->formatDateValueForSaving(date_time::convertDateValueForDataBase($value["value"], date_time::$DATETIME_PICKER_TYPE_DATE))."'";
						break;
					case velkan::$DATATYPE_TIME:
						$data=$table.".".$key."='".$this->formatTimeValueForSaving(date_time::convertDateValueForDataBase($value["value"], date_time::$DATETIME_PICKER_TYPE_TIME))."'";
						break;
					case velkan::$DATATYPE_DATETIME:
						$data=$table.".".$key."='".$this->formatDateTimeValueForSaving(date_time::convertDateValueForDataBase($value["value"], date_time::$DATETIME_PICKER_TYPE_DATETIME))."'";
						break;
					default:
						$data=$table.".".$key."=".$this->checkRealEscapeString($value["value"]);
				}
			}else{
				$data = "$key = ".checkRealEscapeString($value);
			}
			
			if($where==""){
				$where="WHERE $data ";
			}else{
				$where.=" AND $data ";
			}
		}
		
		$sql="DELETE FROM $table $where";
		
		//print_r($sql);
		
		if(!$this->query($sql)){
			return false;
		}
		return true;
	}
	
	function setDatabaseConnection($host,$database,$user,$pass){
		$this->db=$database;
		$this->host=$host;
		$this->user=$user;
		$this->pass=$pass;
	}
	
	function getNumCols(){
		return mysql_num_fields($this->currResult);
	}
	
	function getNumRows(){
		return mysql_num_rows($this->currResult);
	}
	
	function getCalculatedRows(){
		return $this->calculatedRows;
	}
	
	function setFetchType($type){
	}
	
	/**
	 * Devuelve el error que haya generado un comando a la base de datos
	 */
	function getError(){
		return $this->error_str;
	}
}
?>