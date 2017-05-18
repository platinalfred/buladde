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
$expense = new Expenses();
$dashboard = new Dashboard();

$start_date = isset($_POST['start_date'])?$_POST['start_date']:date('Y-m-d',strtotime("-30 day"));
$end_date = isset($_POST['end_date'])?$_POST['end_date']:date('Y-m-d');
$where_person = "";
if(isset($_POST['person_number'])){
	$where_person = "AND person_id = {$_POST['person_number']}";
}

//Total amount of paid subscriptions
$figures['subscriptions'] = $dashboard->getSumOfSubscriptions("(`date_paid` BETWEEN '".$start_date."' AND '".$end_date."') $where_person");

//sum of shares bought
$figures['shares'] = $dashboard->getSumOfShares("(`date_paid` BETWEEN '".$start_date."' AND '".$end_date."') $where_person");

//sum of deposits
//$figures['depositss'] = $dashboard->getSumOfDeposits("transaction_type = 1 AND (`transaction_date` BETWEEN '".$start_date."' AND '".$end_date."') $where_person");

//sum of withdraws
//$figures['withdraws'] = $dashboard->getSumOfDeposits("transaction_type = 2 AND (`transaction_date` BETWEEN '".$start_date."' AND '".$end_date."') $where_person");

//sum of expected payback
$expected_payback = $loan->findExpectedPayBackAmount("(`loan_date` <= '".$end_date."') $where_person");

//sum of paid amount
$amount_paid = $loan->findAmountPaid("(`transaction_date` BETWEEN '".$start_date."' AND '".$end_date."') $where_person");

//income from loan
//$loan_income = $amount_paid - $expected_payback;
$figures['loan_income'] = ($amount_paid - $expected_payback);

$figures['total_revenue'] = $figures['loan_income'] + $figures['shares'] +  $figures['subscriptions'];



//Expenses"
$figures['expenses'] = $expense->findSumOfExpenses("`date_of_expense` BETWEEN '".$start_date."' AND '".$end_date."'");
$figures['total_expenses'] = $figures['expenses'];

$expected_payback_bdl = $loan->findExpectedPayBackAmount("(`active` = 0 AND `loan_date` <= '".$end_date."') $where_person");
$amount_paid_bdl = $loan->findAmountPaid("(`transaction_date` BETWEEN '".$start_date."' AND '".$end_date."') AND `loan_id` IN (SELECT `id` FROM `loan` WHERE `active` = 0 AND `loan_date` <= '".$end_date."') $where_person");

$figures['bad_loans'] = ($amount_paid_bdl - $expected_payback_bdl);

//net income
$figures['net_income'] = $figures['total_revenue'] - $figures['total_expenses'];

echo json_encode($figures);
		
?>