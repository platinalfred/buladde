<?php
$curdir = dirname(__FILE__);
require_once($curdir.'/Db.php');
class AccountType extends Db {
	protected static $table_name  = "accounttype";
	protected static $db_fields = array("id", "name","minimum_balance", "description");
	
	public function findById($id){
		$result = $this->getrec(self::$table_name, "id=".$id, "");
		return !empty($result) ? $result:false;
	}
	
	public function findAll(){
		$result_array = $this->getarray(self::$table_name, "", "", "");
		return !empty($result_array) ? $result_array : false;
	}
	public function findAccountType($id){
		$result = $this->getfrec(self::$table_name, "name", "id=".$id, "", "");
		return !empty($result) ? $result['name'] : false;
	}
	public function addAccountType($data){
		$fields = self::$db_fields;
		if($this->add(self::$table_name, $fields, $this->generateAddFields($fields, $data))){
			return true;
		}
		return false;
	}
	public function updateAccountType($data){
		$fields = array_slice(1, self::$db_fields);
		$id = $data['id'];
		unset($data['id']);
		if($this->update(self::$table_name, $fields, $this->generateAddFields($fields, $data), "id=".$id)){
			return true;
		}
		return false;
	}
}
?>