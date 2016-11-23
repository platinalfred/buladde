<?php
$curdir = dirname(__FILE__);
require_once($curdir.'/Db.php');
class Expenses extends Db {
	protected static $table_name  = "withdraws";
	protected static $db_fields = array("id", "amount","expense_type","expense_by", "date_of_expense", "entered_by");
	
	public function findById($id){
		$result = $this->getrec(self::$table_name, "id=".$id, "");
		return !empty($result) ? $result:false;
	}
	
	public function findExpenseType(){
		$result = $this->getfrec(self::$table_name, "expense_type", "id='$id'", "");
		if($result){
			
		}
		return !empty($result) ? $result['amount']:false;
	}
	public function findAllExpenses(){
		$result_array = $this->getarray(self::$table_name, "","id DESC", "");
		return !empty($result_array) ? $result_array : false;
	}
	
	public function findAmountExpensed($id){
		$result = $this->getfrec(self::$table_name, "amount", "id='$id'", "");
		return !empty($result) ? $result['amount']:false;
	}
	
	
	public function addWithExpense($data){
		$fields = array_slice(1, self::$db_fields);
		if($this->add(self::$table_name, $fields, $this->generateAddFields($fields, $data))){
			return true;
		}
		return false;
	}
	public function updateExpense($data){
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