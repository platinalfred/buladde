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
	if(strlen($where)>0){
		$where .= " AND active = 1";
	}else{
		$where = " active = 1";
	}
	$table = "`member` JOIN `person` ON `member`.`person_number` = `person`.`id` LEFT JOIN (SELECT SUM(`balance`) savings, `person_number` FROM `accounts` GROUP BY `person_number`) `client_savings` ON `member`.`person_number` = `client_savings`.`person_number` LEFT JOIN (SELECT SUM(`amount`) `shares`, `person_number` FROM `shares` GROUP BY `person_number`) `client_shares` ON `member`.`person_number` = `client_shares`.`person_number` LEFT JOIN (SELECT COUNT(`id`) `loans`, `person_number` FROM `loan` GROUP BY `person_number`) `client_loans` ON `member`.`person_number` = `client_loans`.`person_number`";

	$primary_key = "`member`.`id`";

	$columns = array( "`person`.`person_number`", "`firstname`", "`lastname`", "`othername`", "`phone`", "`date_added`", "`member_type`", ", `shares`", "`savings`", "`member`.`id` as `member_id`", "`loans`", "`dateofbirth`", "`gender`", "`email`", "`postal_address`", "`physical_address`", "`branch_number`" );
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
			
			$where = "`loan`.`id` IN (SELECT `loan_id` FROM `loan_repayment` WHERE DATEDIFF('".$_POST['end_date']."',`transaction_date`)<61)";
		}else{
			$where = "`loan`.`id` IN (SELECT `loan_id` FROM `loan_repayment` WHERE DATEDIFF(`transaction_date`,CURDATE())<61)";
		}
	}
	if(isset($_POST['type']) && $_POST['type'] == 2){ //non-performing loans
		
		if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
			
			$where = "(`loan_date` <= '".$_POST['end_date']."') AND `expected_payback` > COALESCE((SELECT SUM(`amount`) `paid_amount` FROM `loan_repayment` WHERE `loan_id` = `loan`.`id`),0) AND `id` NOT IN (SELECT `loan_id` FROM `loan_repayment` WHERE DATEDIFF('".$_POST['end_date']."',`transaction_date`)<61)";
		}else{
			$where = "`loan`.`id` NOT IN (SELECT `loan_id` FROM `loan_repayment` WHERE DATEDIFF(`transaction_date`,CURDATE())<61)";
		}
	}
	if(isset($_POST['type']) && $_POST['type'] == 3){ //active loans
		if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
			
			$where = "(`loan_date` <= '".$_POST['end_date']."') AND `expected_payback` > COALESCE((SELECT SUM(amount) paid_amount FROM `loan_repayment` WHERE (`transaction_date` < '".$_POST['end_date']."') AND `loan_id` = `loan`.`id`),0)";
		}else{
			$where = "`expected_payback` > COALESCE((SELECT SUM(amount) paid_amount FROM `loan_repayment` WHERE `loan_id` = `loan`.`id`),0)";
		}
		
	}
	if(isset($_POST['type']) && $_POST['type'] == 4){ //due loans
		if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
			$where = "(`loan_date` <= '".$_POST['end_date']."') AND (DAY('".$_POST['end_date']."') >= DAY(`loan_date`)) AND `loan`.`id` NOT IN (SELECT loan_id FROM `loan_repayment` WHERE DAY(`transaction_date`) BETWEEN DAY(`loan_date`) AND DAY('".$_POST['end_date']."'))";
		}
		else{
			$where = "(DAY(CURDATE()) >= DAY(`loan_date`)) AND `loan`.`id` NOT IN (SELECT loan_id FROM `loan_repayment` WHERE DAY(`transaction_date`) BETWEEN DAY(`loan_date`) AND DAY(CURDATE()))";
		}
	}

	$table = "`loan` JOIN (SELECT `person`.`person_number`, `person`.`id` `person_id`, `firstname`, `lastname`, `othername`, `member`.`id` `member_id` FROM `member` JOIN `person` ON `member`.`person_number` = `person`.`id` WHERE active = 1)`person` ON `loan`.`person_number` = `person`.`person_id` JOIN `loan_type` ON `loan`.`loan_type` = `loan_type`.`id`";
	
	$primary_key = "`loan`.`id`";
	$columns = array( "`loan`.`id`", "`loan`.`loan_number`", "`firstname`", "`loan_type`.`name`", "`lastname`", "`othername`", "`loan_amount`","`interest_rate`","`expected_payback`", "`loan_date`", "`member_id`", "`loan_end_date`", "TIMESTAMPDIFF(day, `loan_date`,`loan_end_date`) `duration`" );
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
	
	$table = "`loan_repayment` JOIN (SELECT `firstname`, `lastname`, `othername`, `loan`.`id`, `loan_number` FROM `loan` JOIN `person` ON `loan`.`person_number` = `person`.`id`) `loan` ON `loan_repayment`.`loan_id` = `loan`.`id`";
	
	$primary_key = "`loan_repayment`.`id`";

	$columns = array( "`firstname`", "`lastname`", "`othername`", "`amount`", "`comments`", "`transaction_date`", "`transaction_id`", "`loan_number`", "`loan_id`");
}
//list of all the member savings
if ( isset($_POST['page']) && $_POST['page'] == "member_savings" ) {
		$where = "transaction_type=1";
	
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where .= " AND (`transaction_date` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}	
	$table = "`transaction` JOIN `person` ON `transaction`.`person_number` = `person`.`id`";
	
	$primary_key = "`transaction`.`id`";

	$columns = array( "`firstname`", "`lastname`", "`othername`", "`amount`", "`amount_description`", "`transacted_by`", "`transaction_date`", "`transaction`.`id`");
}
//list of the deposits
if ( isset($_POST['page']) && $_POST['page'] == "deposits" ) {
		$where = "transaction_type=2";
	
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where .= " AND (`transaction_date` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}	
	$table = "`transaction` JOIN (SELECT `person`.`person_number`, `person`.`id` `person_id`, `firstname`, `lastname`, `othername`, `member`.`id` `member_id` FROM `member` JOIN `person` ON `member`.`person_number` = `person`.`id`)`person` ON `transaction`.`person_number` = `person`.`person_id` JOIN accounts ON `transaction`.`person_number` = `accounts`.`person_number`";
	
	$primary_key = "`transaction`.`id`";

	$columns = array( "`firstname`", "`lastname`", "`othername`", "`amount`", "`account_number`", "`person`.`person_number`", "`transacted_by`", "`transaction_date`", "`transaction`.`id`", "`member_id`");
}
//list of the withdraws
if ( isset($_POST['page']) && $_POST['page'] == "withdraws" ) {
		$where = "transaction_type=1";
	
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where .= " AND (`transaction_date` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}	
	$table = "`transaction` JOIN (SELECT `person`.`person_number`, `person`.`id` `person_id`, `firstname`, `lastname`, `othername`, `member`.`id` `member_id` FROM `member` JOIN `person` ON `member`.`person_number` = `person`.`id`)`person` ON `transaction`.`person_number` = `person`.`person_id` JOIN accounts ON `transaction`.`person_number` = `accounts`.`person_number`";
	
	$primary_key = "`transaction`.`id`";

	$columns = array( "`firstname`", "`lastname`", "`othername`", "`amount`", "`account_number`", "`person`.`person_number`", "`transacted_by`", "`transaction_date`", "`transaction`.`id`", "`member_id`");
}
//list of all client transactions
if ( isset($_POST['page']) && $_POST['page'] == "client_transactions" ) {
	
	if((isset($_POST['start_date'])&& strlen($_POST['start_date'])>1) && (isset($_POST['end_date'])&& strlen($_POST['end_date'])>1)){
		$where = " (`transaction_date` BETWEEN '".$_POST['start_date']."' AND '".$_POST['end_date']."')";
	}
	$inner_where = "";
	if((isset($_POST['member_id'])&& strlen($_POST['member_id'])>1)){
		$inner_where = "WHERE (`member`.`id` = ".$_POST['member_id'].")";
	}	
	$table = "`transaction` JOIN (SELECT `person`.`person_number`, `person`.`id` `person_id` FROM `member` JOIN `person` ON `member`.`person_number` = `person`.`id` $inner_where)`person` ON `transaction`.`person_number` = `person`.`person_id` JOIN accounts ON `transaction`.`person_number` = `accounts`.`person_number`";
	
	$primary_key = "`transaction`.`id`";

	$columns = array( "`amount`", "`account_number`", "`person`.`person_number`", "`transacted_by`", "`transaction_date`", "`transaction_type`", "`transaction`.`id`");
}
if ( isset($_POST['page']) && strlen($_POST['page'])>0) {
	// Get the data
	$data_table->get($table, $primary_key, $columns, $where, $group_by);
}
?>