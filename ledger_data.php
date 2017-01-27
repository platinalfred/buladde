<?php 
$show_table_js = false;
require_once("lib/Loans.php");
require_once("lib/Expenses.php");
require_once("lib/Shares.php");
require_once("lib/Income.php");
require_once("lib/Dashboard.php");
require_once("lib/Member.php");
$member = new Member();
$loan = new Loans();
//$expense = new Expenses();
$dashboard = new Dashboard();

$start_date = isset($_POST['start_date'])?$_POST['start_date']:date('Y-m-d',strtotime("-30 day"));
$end_date = isset($_POST['end_date'])?$_POST['end_date']:date('Y-m-d');
if(isset($_POST['person_number'])){
	$person_number = $_POST['person_number'];
}

//Total amount of paid subscriptions
$figures['subscriptions'] = $dashboard->getSumOfSubscriptions("(`date_paid` BETWEEN '".$start_date."' AND '".$end_date."') AND person_number = $person_number");

//sum of shares bought
$figures['shares'] = $dashboard->getAmountOfShares("transaction_type = 4 AND (`transaction_date` BETWEEN '".$start_date."' AND '".$end_date."') AND person_number = $person_number");

//sum of deposits
$figures['deposits'] = $dashboard->getSumOfDeposits("transaction_type = 1 AND (`transaction_date` BETWEEN '".$start_date."' AND '".$end_date."') AND person_number = $person_number");

//sum of withdraws
$figures['withdraws'] = $dashboard->getSumOfDeposits("transaction_type = 2 AND (`transaction_date` BETWEEN '".$start_date."' AND '".$end_date."') AND person_number = $person_number");

//sum of expected payback
$figures['expected_payback'] = $loan->findExpectedPayBackAmount("(`loan_date` BETWEEN '".$start_date."'AND '".$end_date."') AND person_number = $person_number");

//sum of paid amount
$figures['amount_paid'] = $loan->findAmountPaid("loan_id IN  (SELECT id FROM `loan` WHERE `loan_date` BETWEEN '".$start_date."'AND '".$end_date."') (`transaction_date` BETWEEN '".$start_date."' AND '".$end_date."') AND person_number = $person_number");

//Expenses"
//$figures['sum_expenses'] = $expense->findSumOfExpenses("`date_of_expense` BETWEEN '".$start_date."' AND '".$end_date."'");

echo json_encode($figures);
		
?>