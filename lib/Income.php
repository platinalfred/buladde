<?php
$curdir = dirname(__FILE__);
require_once($curdir.'/Db.php');
class Income extends Db {
	protected static $table_name  = "income";
	protected static $db_fields = array("id", "income_type", "amount", "date_added", "added_by", "description");
	
	public function findById($id){
		$result = $this->getrec(self::$table_name, "id=".$id, "");
		return !empty($result) ? $result:false;
	}
	
	public function findAll($where = 1){
		$result_array = $this->getarray(self::$table_name, $where, "", "");
		return !empty($result_array) ? $result_array : false;
	}
	public function findSubscriptionAmount($id){
		$result = $this->getfrec(self::$table_name, "amount", "id=".$id, "", "");
		return !empty($result) ? $result['amount'] : false;
	}
	public function findSubscriptionAmountForYear($year){
		$result = $this->getfrec(self::$table_name, "amount", "year=".$id, "", "");
		return !empty($result) ? $result['amount'] : false;
	}
	public function isSubscribedForYear($id, $year){
		$result = $this->getfrec(self::$table_name, "year=".$year." AND id=".$id, "", "");
		if($result > 0){
			return true;
		}
		return false;
	}
	public function addIncome($data){
		$fields = array_slice(self::$db_fields, 1);
		if($this->add(self::$table_name, $fields, $this->generateAddFields($fields, $data))){
			return true;
		}
		return false;
	}
	public function updateMemberType($data){
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