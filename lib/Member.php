<?php
$curdir = dirname(__FILE__);
require_once($curdir.'/Db.php');
class Member extends Db {
	protected static $table_name  = "member";
	protected static $db_fields = array("id","person_number","branch_id","member_type","comments", "added_by","date_added", "active");
	
	public function findById($id){
		$result = $this->getrec(self::$table_name, "id=".$id, "", "");
		return !empty($result) ? $result:false;
	}
	public function findByPersonIdNo($pno){
		$result = $this->getrec(self::$table_name, "person_number=".$pno, "", "");
		return !empty($result) ? $result:false;
	}
	
	public function findAll(){
		$result_array = $this->getarray(self::$table_name, "","id DESC", "");
		return !empty($result_array) ? $result_array : false;
	}
	public function findNamesByPersonNumber($pno){
		$result = $this->getrec(self::$table_name." st, person p", "p.first_name, p.last_name, p.other_names", "st.person_number='$pno' AND p.person_number = st.person_number", "", "");
		return !empty($result) ? $result['first_name']." ".$result['other_names']." ".$result['last_name'] : false;
	}
	public function findNamesById($id){
		$result = $this->getrec(self::$table_name." st, person p", "p.first_name, p.last_name, p.other_names", "st.id='$id' AND p.person_number = st.person_number", "", "");
		return !empty($result) ? $result['first_name']." ".$result['other_names']." ".$result['last_name'] : false;
	}
	
	public function addMember($data){
		$fields = array("person_number","branch_number","member_type","comment", "added_by","date_added");
		if($this->add(self::$table_name, $fields, $this->generateAddFields($fields, $data))){
			return true;
		}
		return false;
	}
	public function updateMember($data){
		$fields = array_slice(1, self::$db_fields);
		$id = $data['id'];
		unset($data['id']);
		if($this->update(self::$table_name, $fields, $this->generateAddFields($fields, $data), "id=".$id)){
			return true;
		}
		return false;
	}
	public function deActicateMember($data){
		if($this->update_single(self::$table_name, $data['field'], $data['value'], "id=".$data['primary'])){
			return true;
		}
		return false;
	}
	
}
?>