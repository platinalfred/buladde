<?php 
require_once("lib/Libraries.php");
require_once("lib/DatatablesJSON.php");

// Create instance of DataTable class
$data_table = new DataTable();
if ( isset($_POST['page']) && $_POST['page'] == "view_members" ) {
	
	$table = "`member` JOIN `person` ON `member`.`person_number` = `person`.`id` LEFT JOIN (SELECT SUM(`amount`) savings, `person_number` FROM `transaction` WHERE `transaction_type`=1 GROUP BY `person_number`) `client_savings` ON `member`.`person_number` = `client_savings`.`person_number` LEFT JOIN (SELECT SUM(`amount`) `shares`, `person_number` FROM `shares` GROUP BY `person_number`) `client_shares` ON `member`.`person_number` = `client_shares`.`person_number` LEFT JOIN (SELECT COUNT(`id`) `loans`, `person_number` FROM `loan` GROUP BY `person_number`) `client_loans` ON `member`.`person_number` = `client_loans`.`person_number`";

	$primary_key = "`member`.`id`";

	$columns = array( "`person`.`person_number`", "`firstname`", "`lastname`", "`othername`", "`phone`", "`date_added`", "`member_type`", ", `shares`", "`savings`", "`member`.`id` as `member_id`", "`loans`", "`dateofbirth`", "`gender`", "`email`", "`postal_address`", "`physical_address`", "`branch_number`" );
	// Get the data
	$data_table->get($table, $primary_key, $columns);
}
if ( isset($_POST['page']) && $_POST['page'] == "view_expenses" ) {
	
	$table = "`expense` JOIN `person` ON `expense`.`staff` = `person`.`id` JOIN `expensetypes` ON `expense_type` = `expensetypes`.`id`";

	$primary_key = "`expense`.`id`";

	$columns = array( "`person`.`person_number`", "`firstname`", "`lastname`", "`othername`", "`expense`.`id`", "`amount_used`","`expense_type`","`amount_description`", "`date_of_expense`", "`name`", "`description`" );
	// Get the data
	$data_table->get($table, $primary_key, $columns);
}
?>