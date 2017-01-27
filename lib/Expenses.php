<?php
$curdir = dirname(__FILE__);
require_once($curdir.'/Db.php');
class Expenses extends Db {
	protected static $table_name  = "expense";
	protected static $db_fields = array("id", "amount_used","expense_type","staff", "date_of_expense", "amount_description");
	
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
	public function findAllExpenses($where = 1, $orderby = "id DESC", $limit = ""){
		$result_array = $this->getarray(self::$table_name, $where, $orderby, $limit);
		return !empty($result_array) ? $result_array : false;
	}
	
	public function findAmountExpensed($id){
		$result = $this->getfrec(self::$table_name, "amount_used", "id='$id'", "", "");
		return !empty($result) ? $result['amount']:false;
	}
	
	public function findSumOfExpenses($where = 1){
		$result = $this->getfrec(self::$table_name, "sum(`amount_used`) expenseSum ", $where, "", "");
		return !empty($result) ? (($result['expenseSum']!=NULL)?$result['expenseSum']:0) : 0;
	}
	
	
	public function addExpense($data){
		$fields = array_slice( self::$db_fields,1);
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