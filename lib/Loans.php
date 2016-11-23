<?php
$curdir = dirname(__FILE__);
require_once($curdir.'/Db.php');
class Loans extends Db {
	protected static $table_name  = "loan";
	protected static $db_fields = array("id", "person_number", "loan_number","branch_number", "loan_type", "loan_date","loan_amount", "loan_amount_word", "interest_rate", "default_amount", "approved_by", "repayment_duration", "comments"," loan_agreement_path");
	
	public function findById($id){
		$result = $this->getRecord(self::$table_name, "id=".$id, "");
		return !empty($result) ? $result:false;
	}
	public function findMemberLoans($pno){
		 $results  = $this->getarray(self::$table_name, "person_number=".$pno, "", "");
		 return !empty($results) ? $results : false;
	}
	public function findAll(){
		$result_array = $this->getarray(self::$table_name, "", "loan_date DESC", "");
		return !empty($result_array) ? $result_array : false;
	}
	public function findLoanType($type){
		 $results  = $this->getfrec("loantype", "name", "id=".$type, "", "");
		 return !empty($results) ? $results['name'] : false;
	}
	public function findLoanPaymentDuration($duratn){
		 $results  = $this->getfrec("repaymentduration", "name", "id=".$duratn, "", "");
		 return !empty($results) ? $results['name'] : false;
	}
	public function updateImage($data){
		if($this->update(self::$table_name, array('photo'), array('photo'=>$data['photo']), "id=".$data['id'])){
			return true;
		}else{
			return false;
		}
	}
	
	public function clearLoan($id, $status = ""){
		if($this->update(self::$table_name, array($field), array($field=>$value), 'id = \''.$id.'\'')){
			return true;
		}else{
			return false;
		}
	}
	

	public function addLoan($data){
		
		if($this->add(self::$table_name, array("title", "bike_hire", "hire_amount", "photo","organizer", "organizer_email", "website" ,"location", "event_date", "end_date", "description","terms_and_conditions","cat_id"), array("title"=>$data['title'], "organizer"=>$data['organizer'], "organizer_email"=>$data['organizer_email'], "website"=>$data['website'],"sport_type"=>$data['sport_type'],"event_map"=>$data['event_map'], "photo"=>$data['photo'], "location"=>$data['location'],"description"=>$data['content'],"terms_and_conditions"=>$data['terms_and_conditions'], "event_date"=>$event_date, "end_date"=>$end_date, "bike_hire"=>$data['bike_hire'], "hire_amount"=>$data['hire_amount'],"cat_id"=>$data['cat_id']))){
			return true;
		}else{
			return false;
		}
	}
	
	
	
}
?>