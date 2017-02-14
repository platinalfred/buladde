<?php 
require_once("lib/Libraries.php");
require_once("lib/DatatablesJSON.php");

// Create instance of DataTable class
$data_table = new DataTable();
$primary_key = $columns = $table = $where = $group_by = "";
if ( isset($_POST['page']) && $_POST['page'] == "view_members" ) {
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where = "(`member`.`date_added` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}
	if(isset($_SESSION['access_level']) &&!in_array($_SESSION['access_level'],array(1,2))){
		if(strlen($where)>0){
			$where .= " AND active=1 AND added_by = ".$_SESSION['user_id'];
		}else{
			$where = " added_by = ".$_SESSION['user_id']." AND active=1";
		}
	}
	
	$table = "`member` JOIN `person` ON `member`.`person_number` = `person`.`id` LEFT JOIN (SELECT SUM(`balance`) savings, `person_number` FROM `accounts` GROUP BY `person_number`) `client_savings` ON `member`.`person_number` = `client_savings`.`person_number` LEFT JOIN (SELECT SUM(`amount`) `shares`, `person_number` FROM `shares` GROUP BY `person_number`) `client_shares` ON `member`.`person_number` = `client_shares`.`person_number` LEFT JOIN (SELECT COUNT(`id`) `loans`, `person_number` FROM `loan` GROUP BY `person_number`) `client_loans` ON `member`.`person_number` = `client_loans`.`person_number`";

	$primary_key = "`member`.`id`";

	$columns = array( "`person`.`person_number`", "`firstname`", "`lastname`", "`othername`", "`phone`", "`date_added`", "`member_type`", "`member`.`id` `member_id`", "`loans`", ", `shares`", "`savings`", "`dateofbirth`", "`gender`", "`email`", "`postal_address`", "`physical_address`", "`branch_number`" );
}
//list of all the expenses
if ( isset($_POST['page']) && $_POST['page'] == "view_expenses" ) {
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where = "(`date_of_expense` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}	
	$table = "`expense` JOIN `person` ON `expense`.`staff` = `person`.`id` JOIN `expensetypes` ON `expense_type` = `expensetypes`.`id`";

	$primary_key = "`expense`.`id`";

	$columns = array( "`person`.`person_number`", "`firstname`", "`lastname`", "`othername`", "`expense`.`id`", "`amount_used`","`expense_type`","`amount_description`", "`date_of_expense`", "`name`", "`description`" );
}
//list of loans
if ( isset($_POST['page']) && $_POST['page'] == "view_loans" ) {
	if(isset($_POST['type']) && $_POST['type'] == 1){ //performing loans
		
		if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
			
			$where = "(`loan_date` <= '".$_POST['end_date']."') AND ((`expected_payback`/TIMESTAMPDIFF(MONTH,loan_date,loan_end_date))*TIMESTAMPDIFF(MONTH,loan_date,'".$_POST['end_date']."'))  <= COALESCE((SELECT SUM(`amount`) `paid_amount` FROM `loan_repayment` WHERE `loan_id` = `loan`.`id` AND `transaction_date` <= '".$_POST['end_date']."'),0)";
		}else{
			$where = "(`loan_date` <= CURDATE()) AND ((`expected_payback`/TIMESTAMPDIFF(MONTH,loan_date,loan_end_date))*TIMESTAMPDIFF(MONTH,loan_date,CURDATE()))  <= COALESCE((SELECT SUM(`amount`) `paid_amount` FROM `loan_repayment` WHERE `loan_id` = `loan`.`id` AND `transaction_date` <= CURDATE()),0)";
		}
	}
	if(isset($_POST['type']) && $_POST['type'] == 2){ //non-performing loans
		
		if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
			
			$where = "(`loan_date` <= '".$_POST['end_date']."') AND ((`expected_payback`/TIMESTAMPDIFF(MONTH,loan_date,loan_end_date))*TIMESTAMPDIFF(MONTH,loan_date,'".$_POST['end_date']."')) > COALESCE((SELECT SUM(`amount`) FROM `loan_repayment` WHERE `loan_id` = `loan`.`id` AND `transaction_date` <= '".$_POST['end_date']."'),0)";
		}else{
			$where = "(`loan_date` <= CURDATE()) AND ((`expected_payback`/TIMESTAMPDIFF(MONTH,loan_date,loan_end_date))*TIMESTAMPDIFF(MONTH,loan_date,CURDATE())) > COALESCE((SELECT SUM(`amount`) `paid_amount` FROM `loan_repayment` WHERE `loan_id` = `loan`.`id` AND `transaction_date` <= CURDATE()),0)";
		}
	}
	if(isset($_POST['type']) && $_POST['type'] == 3){ //active loans
		if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
			
			$where = "(`loan_date` <= '".$_POST['end_date']."') AND `expected_payback` > COALESCE((SELECT SUM(amount) `paid_amount` FROM `loan_repayment` WHERE (`transaction_date` < '".$_POST['end_date']."') AND `loan_id` = `loan`.`id`),0)";
		}else{
			$where = "`expected_payback` > COALESCE((SELECT SUM(amount) paid_amount FROM `loan_repayment` WHERE `loan_id` = `loan`.`id`),0)";
		}
		
	}
	if(isset($_POST['type']) && $_POST['type'] == 4){ //due loans
		if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
			//(`transaction_date` BETWEEN DATE_ADD(loan_date, INTERVAL  TIMESTAMPDIFF(MONTH,loan_date,'".$_POST['end_date']."') MONTH) AND DATE_ADD(loan_date, INTERVAL  TIMESTAMPDIFF(MONTH,loan_date,'".$_POST['end_date']."')+1 MONTH)) AND 
			$where = "`loan`.`id` NOT IN (SELECT loan_id FROM `loan_repayment` WHERE (SELECT COALESCE(SUM(`amount`),0) FROM `loan_repayment` WHERE `transaction_date`<='".$_POST['end_date']."')> ((loan.expected_payback/TIMESTAMPDIFF(MONTH,loan.loan_date,loan.loan_end_date))*(TIMESTAMPDIFF(MONTH,loan_date,'".$_POST['end_date']."')+1)))";
		}
		else{
			//(`transaction_date` BETWEEN DATE_ADD(loan_date, INTERVAL  TIMESTAMPDIFF(MONTH,loan_date,CURDATE()) MONTH) AND DATE_ADD(loan_date, INTERVAL  TIMESTAMPDIFF(MONTH,loan_date,CURDATE())+1 MONTH)) AND 
			$where = "`loan`.`id` NOT IN (SELECT loan_id FROM `loan_repayment` WHERE (SELECT COALESCE(SUM(`amount`),0) FROM `loan_repayment` WHERE `transaction_date`<=CURDATE())> ((loan.expected_payback/TIMESTAMPDIFF(MONTH,loan.loan_date,loan.loan_end_date))*(TIMESTAMPDIFF(MONTH,loan_date,CURDATE())+1)))";
		}
	}

	$table = "`loan` JOIN (SELECT `person`.`person_number`, `person`.`id` `person_id`, `firstname`, `lastname`, `othername`, `member`.`id` `member_id` FROM `member` JOIN `person` ON `member`.`person_number` = `person`.`id` WHERE active = 1)`person` ON `loan`.`person_number` = `person`.`person_id` JOIN `loan_type` ON `loan`.`loan_type` = `loan_type`.`id` LEFT JOIN (SELECT SUM(amount) `amount_paid`, `loan_id` FROM `loan_repayment` GROUP BY `loan_id`)`payment` ON `loan`.`id` = `payment`.`loan_id`";
	
	$primary_key = "`loan`.`id`";
	$columns = array( "`loan`.`id`", "`loan`.`loan_number`", "`firstname`", "`loan_type`.`name`", "`lastname`", "`othername`", "`loan_amount`",/* "`loan_amount`*(`interest_rate`/100) interest", */"`expected_payback`", "COALESCE(`amount_paid`,0) `amount_paid`", "`loan_date`", "`member_id`", "`loan_end_date`", "DATEDIFF(`loan_end_date`,`loan_date`) `duration`", "`daily_default_amount`" , "default_days(`loan`.`id`, `loan_date`, `loan_end_date`, CURDATE(),`expected_payback`)def_days" );
}
//list of the income transactions
if ( isset($_POST['page']) && $_POST['page'] == "view_income" ) {
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where = "(`date_added` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}
	$table = "`income` JOIN `income_sources` ON `income_type` = `income_sources`.`id`";

	$primary_key = "`income`.`id`";

	$columns = array( "`name`", "`amount`", "`income`.`description`", "`date_added`", "`income`.`id`");
}
//list of all the shares held by the clients
if ( isset($_POST['page']) && $_POST['page'] == "view_shares" ) {
	
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where = "(`date_paid` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}
	
	$table = "`shares` JOIN `person` ON `shares`.`person_number` = `person`.`id`";
	
	$group_by = "`person_number`";

	$primary_key = "`shares`.`id`";

	$columns = array( "`firstname`", "`lastname`", "`othername`", "`shares`.`person_number`", "SUM(`amount`) `share`");
}
//list of all the client subscriptions
if ( isset($_POST['page']) && $_POST['page'] == "view_subcriptns" ) {
	
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where = "(`date_paid` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}
	
	$table = "`subscription` JOIN `person` ON `subscription`.`person_number` = `person`.`id`";
	
	$group_by = "`person_number`";

	$primary_key = "`subscription`.`id`";

	$columns = array( "`firstname`", "`lastname`", "`othername`", "`amount`", "`subscription_year`", "`date_paid`", "`subscription`.`person_number`");
}
//list of all the client loan payments
if ( isset($_POST['page']) && $_POST['page'] == "view_loan_payments" ) {
	
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where = "(`transaction_date` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}
	
	$table = "`loan_repayment` JOIN (SELECT `firstname`, `lastname`, `othername`, `loan`.`id`, `member_id`, `loan_number` FROM `loan` JOIN (SELECT `person`.`person_number`, `person`.`id`, `firstname`, `lastname`, `othername`, `member`.`id` `member_id` FROM `member` JOIN `person` ON `member`.`person_number` = `person`.`id`)`person` ON `loan`.`person_number` = `person`.`id`) `loan` ON `loan_repayment`.`loan_id` = `loan`.`id`";
	
	$primary_key = "`loan_repayment`.`id`";

	$columns = array( "`firstname`", "`lastname`", "`othername`", "`amount`", "`comments`", "`member_id`", "`transaction_date`", "`transaction_id`", "`loan_number`", "`loan_id`");
}
//list of all the member savings
if ( isset($_POST['page']) && $_POST['page'] == "member_savings" ) {
		//$where = "transaction_type IN (1,2)";
	
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where .= " AND (`transaction_date` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}	
	$table = "`transaction` JOIN (SELECT `person`.`person_number`, `person`.`id` `person_id`, `firstname`, `lastname`, `othername`, `member`.`id` `member_id` FROM `member` JOIN `person` ON `member`.`person_number` = `person`.`id`)`person` ON `transaction`.`person_number` = `person`.`person_id` JOIN accounts ON `transaction`.`person_number` = `accounts`.`person_number`";
	
	$primary_key = "`transaction`.`id`";

	$columns = array( "`firstname`", "`lastname`", "`othername`", "`amount`", "`account_number`", "`person`.`person_number`", "`transacted_by`", "`transaction_date`", "`transaction`.`id`", "`member_id`");
}
if ( isset($_POST['page']) && strlen($_POST['page'])>0) {
	// Get the data
	$data_table->get($table, $primary_key, $columns, $where, $group_by);
}
?>