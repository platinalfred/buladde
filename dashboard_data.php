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
$share = new Shares();
$income = new Income();
$dashboard = new Dashboard();

$start_date = isset($_POST['start_date'])?$_POST['start_date']:date('Y-m-d',strtotime("-30 day"));
$end_date = isset($_POST['end_date'])?$_POST['end_date']:date('Y-m-d');

//set the respective variables to be received from the calling page
$figures = $tables = $percents = array();


//line and barchart
$_result['lineBarChart'] = getGraphData($start_date, $end_date);
//pie chart
$_result['pieChart'][] = $dashboard->getSumOfLoans("`loan_date` <= '".$end_date."' AND id IN (SELECT loan_id FROM `loan_repayment` WHERE DATEDIFF('".$end_date."',`transaction_date`)<61)");
$_result['pieChart'][] = $dashboard->getSumOfLoans("`loan_date` <= '".$end_date."' AND id NOT IN (SELECT loan_id FROM `loan_repayment` WHERE DATEDIFF('".$end_date."',`transaction_date`)<61)");

//Non performing loans
$tables['nploans'] = $loan->findAll("(`loan_date` <= '".$end_date."') AND `expected_payback` > COALESCE((SELECT SUM(`amount`) `paid_amount` FROM `loan_repayment` WHERE `loan_id` = `loan`.`id`),0) AND `id` NOT IN (SELECT loan_id FROM `loan_repayment` WHERE DATEDIFF('".$end_date."',`transaction_date`)<61)", "expected_payback DESC", "10");

//active loans
$tables['actvloans'] = $loan->findAll("((`loan_date` <= '".$end_date."') AND `expected_payback` > COALESCE((SELECT SUM(amount) paid_amount FROM `loan_repayment` WHERE (`transaction_date` <= '".$end_date."') AND `loan_id` = `loan`.`id`),0))", "expected_payback DESC", "10");

//Performing loans
$tables['ploans'] = $loan->findAll("`id` IN (SELECT `loan_id` FROM `loan_repayment` WHERE DATEDIFF('".$end_date."',`transaction_date`)<61)", "expected_payback DESC", "10");

//No of members
//1 in this period
$figures['no_members'] = $member->noOfMembers("(`date_added` BETWEEN '".$start_date."' AND '".$end_date."')");
//before this period
$members_b4 = $member->noOfMembers("(`date_added` < '".$start_date."')");
$percents['members_percent'] = $members_b4>0?round((($members_b4 - $figures['no_members'])/$members_b4)*100,2):0;

//Total amount of paid subscriptions
//1 in this period
$figures['total_scptions'] = $dashboard->getCountOfSubscriptions("(`date_paid` BETWEEN '".$start_date."' AND '".$end_date."')");
//before this period
$total_scptions_b4 = $dashboard->getCountOfSubscriptions("(`date_paid` < '".$start_date."')");
//percentage increase/decrease
$percents['scptions_percent'] = $total_scptions_b4>0?round((($total_scptions_b4 - $figures['total_scptions'])/$total_scptions_b4)*100,2):0;

//Total shares bought
//1 in this period
$figures['total_shares'] = $dashboard->getSumOfShares("(`date_paid` BETWEEN '".$start_date."' AND '".$end_date."')");
//before this period
$total_shares_b4 = $dashboard->getSumOfShares("(`date_paid` < '".$start_date."')");
//percentage increase/decrease
$percents['shares_percent'] = $total_shares_b4>0?round((($total_shares_b4 - $figures['total_shares'])/$total_shares_b4)*100,2):0;

//Total active loans
//1 in this period
$figures['total_actv_loans'] = $dashboard->totalActiveLoans("(`loan_date` <= '".$end_date."') AND `expected_payback` > COALESCE((SELECT SUM(amount) paid_amount FROM `loan_repayment` WHERE (`transaction_date` <= '".$end_date."') AND `loan_id` = `loan`.`id`),0)");
//before this period
$total_actv_loans_b4 = $dashboard->totalActiveLoans("(`loan_date` < '".$start_date."') AND `expected_payback` > COALESCE((SELECT SUM(amount) paid_amount FROM `loan_repayment` WHERE (`transaction_date` < '".$start_date."') AND `loan_id` = `loan`.`id`),0)");
//percentage increase/decrease
$percents['actv_loans_percent'] = $total_actv_loans_b4>0?round((($total_actv_loans_b4 - $figures['total_actv_loans'])/$total_actv_loans_b4)*100,2):0;

//Total loan payments
//1 in this period
$figures['loan_payments'] = $dashboard->getCountOfLoanRepayments("(`transaction_date` BETWEEN '".$start_date."' AND '".$end_date."')");
//before this period
$loan_payments_b4 = $dashboard->getCountOfLoanRepayments("(`transaction_date` < '".$start_date."')");
//percentage increase/decrease
$percents['loan_payments_percent'] = $loan_payments_b4>0?round((($loan_payments_b4 - $figures['loan_payments'])/$loan_payments_b4)*100,2):0;

//Due loans
//1 in this period
$figures['due_loans'] = $dashboard->getCountOfDueLoans("(`loan_date` <= '".$end_date."') AND (DAY('".$end_date."') >= DAY(`loan_date`)) AND `loan`.`id` NOT IN (SELECT loan_id FROM `loan_repayment` WHERE DAY(`transaction_date`) BETWEEN DAY(`loan_date`) AND DAY('".$end_date."'))");
//before this period
$due_loans_b4 = $dashboard->getCountOfDueLoans("(`loan_date` <= '".$start_date."') AND (DAY('".$start_date."') >= DAY(`loan_date`)) AND `loan`.`id` NOT IN (SELECT loan_id FROM `loan_repayment` WHERE DAY(`transaction_date`) BETWEEN DAY(`loan_date`) AND DAY('".$start_date."'))");
//percentage increase/decrease
$percents['due_loans_percent'] = $due_loans_b4>0?round((($due_loans_b4 - $figures['due_loans'])/$due_loans_b4)*100,2):0;

//Income
$tables['income'] = $income->findAll("`date_added` BETWEEN '".$start_date."' AND '".$end_date."'", "amount DESC", "10");

//Expenses"
$tables['expenses'] = $expense->findAllExpenses("`date_of_expense` BETWEEN '".$start_date."' AND '".$end_date."'", "amount_used DESC", "10");

$_result['figures'] = $figures;
$_result['tables'] = $tables;
$_result['percents'] = $percents;

echo json_encode($_result);

function getGraphData($start_date, $end_date){
	$days = round((strtotime($end_date)-strtotime($start_date))/86400);
	$dashboard = new Dashboard();
	//arrays with data for the past i days/months
	$shares_sum_graph_data = $loans_sum_graph_data = $subscriptions_sum_graph_data = $data_points = array();
	$shares_count_graph_data = $loans_count_graph_data = $subscriptions_count_graph_data = array();
	$_end = new DateTime($end_date);
	$period = new DatePeriod( new DateTime($start_date), new DateInterval('P1D'), $_end );
	$period_dates = iterator_to_array($period);
	
	//if days are 7 or less
	if($days == 0 || $days <8){
		$period = new DatePeriod( new DateTime($start_date), new DateInterval('P1D'), $_end->modify( '+1 day' ) );
		foreach($period as $date){
			$loans_sum_graph_data[] = $dashboard->getSumOfLoans("`loan_end_date` >='{$date->format("Y-m-d")}'");
			$shares_sum_graph_data[] = $dashboard->getSumOfShares("`date_paid`='{$date->format("Y-m-d")}' ");
			$subscriptions_sum_graph_data[] = $dashboard->getSumOfSubscriptions("`date_paid`='{$date->format("Y-m-d")}' ");
			$loans_count_graph_data[] = $dashboard->getCountOfLoans("`loan_end_date` >='{$date->format("Y-m-d")}'");
			$shares_count_graph_data[] = $dashboard->getCountOfShares("`date_paid`='{$date->format("Y-m-d")}' ");
			$subscriptions_count_graph_data[] = $dashboard->getCountOfSubscriptions("`date_paid`='{$date->format("Y-m-d")}' ");
			$data_points[] = date('D, j/n', strtotime($date->format("Y-m-d")));
		}
	}
	elseif($days > 7 && $days <31){
		/*split the days into weeks
		*generate an array holding the start and end dates of the given period
		*/
		
		$weeks = array();
		$index = 0;
		$weeks[$index]['start'] = $start_date;
		if(date('N',strtotime($start_date))==7){
			$weeks[$index++]['end'] = $start_date;
		}
		for($i = $index; $i<count($period_dates);$i++){
			$period_date = $period_dates[$i];
			if($period_date->format('N')==1){
				$weeks[$index]['start'] = $period_date->format('Y-m-d');
			}
			if($period_date->format('N')==7){
				$weeks[$index++]['end'] = $period_date->format('Y-m-d');
			}
		}
		$weeks[$index]['end'] = $end_date;
		if(date('N',strtotime($end_date))==1){
			$weeks[$index]['start'] = $end_date;
			$weeks[$index]['end'] = $end_date;
		}
		
		foreach($weeks as $week){
			$between = "BETWEEN '".$week['start']."' AND '".$week['end']."')";
			$loans_sum_graph_data[] = $dashboard->getSumOfLoans("`loan_date` <= '".$week['end']."' AND `active` = 1");
			$shares_sum_graph_data[] = $dashboard->getSumOfShares("(`date_paid` ".$between);
			$subscriptions_sum_graph_data[] = $dashboard->getSumOfSubscriptions("(`date_paid` ".$between);
			$loans_count_graph_data[] = $dashboard->getCountOfLoans("`loan_date` <= '".$week['end']."' AND `active` = 1");
			$shares_count_graph_data[] = $dashboard->getCountOfShares("(`date_paid` ".$between);
			$subscriptions_count_graph_data[] = $dashboard->getCountOfSubscriptions("(`date_paid` ".$between);
			$data_points[] = date('j/M', strtotime($week['start']))."-".date('j/M', strtotime($week['end']));
		}
	}
	elseif($days > 30){
		/*split the days into months
		*generate an array holding the start and end dates of the given period
		*/
		
		$months = array();
		$index = 0;
		$months[$index]['start'] = $start_date;
		if(date('j',strtotime($start_date))==date('t',strtotime($start_date))){
			$months[$index++]['end'] = $start_date;
		}
		for($i = $index; $i<count($period_dates);$i++){
			$period_date = $period_dates[$i];
			if($period_date->format('j')==1){
				$months[$index]['start'] = $period_date->format('Y-m-d');
			}
			if($period_date->format('j')==$period_date->format('t')){
				$months[$index++]['end'] = $period_date->format('Y-m-d');
			}
		}
		$months[$index]['end'] = $end_date;
		if(date('j',strtotime($end_date)) == date('t',strtotime($end_date))){
			$months[$index]['start'] = $end_date;
			$months[$index]['end'] = $end_date;
		}
		foreach($months as $month){
			$between = "BETWEEN '".$month['start']."' AND '".$month['end']."')";
			$loans_sum_graph_data[] = $dashboard->getSumOfLoans("`loan_date` <= '".$month['end']."' AND `active` = 1");
			$shares_sum_graph_data[] = $dashboard->getSumOfShares("(`date_paid` ".$between);
			$subscriptions_sum_graph_data[] = $dashboard->getSumOfSubscriptions("(`date_paid` ".$between);
			$loans_count_graph_data[] = $dashboard->getCountOfLoans("`loan_date` <= '".$month['end']."' AND `active` = 1");
			$shares_count_graph_data[] = $dashboard->getCountOfShares("(`date_paid` ".$between);
			$subscriptions_count_graph_data[] = $dashboard->getCountOfSubscriptions("(`date_paid` ".$between);
			$data_points[] = date('M, Y', strtotime($month['start']));
		}
	}
	$graph_data['loans_sum'] = $loans_sum_graph_data;
	$graph_data['shares_sum'] = $shares_sum_graph_data;
	$graph_data['subscriptions_sum'] = $subscriptions_sum_graph_data;
	$graph_data['loans_count'] = $loans_count_graph_data;
	$graph_data['shares_count'] = $shares_count_graph_data;
	$graph_data['subscriptions_count'] = $subscriptions_count_graph_data;
	$graph_data['data_points'] = $data_points;
	return $graph_data;
}
function draw_loans_table($loans_data){?>
				  <thead>
					<tr>
					<?php 
					$header_keys = array("Loan No", "Amount", "Balance");
					foreach($header_keys as $key){ ?>
						<th><?php echo $key; ?></th>
					<?php } ?>
					</tr>
				  </thead>
				  <tbody>
					<?php
					$amount = $balance = 0;
					if($loans_data){
						foreach($loans_data as $single){ ?>
						<tr>
						  <td><a href="#<?php echo $single['id']; ?>" title="View details"><?php echo $single['loan_number']; ?></a></td>
						  <td><?php echo number_format($single['expected_payback']); $amount += $single['expected_payback']; ?></td>
						  <td><?php echo number_format($single['loan_amount']); $balance += $single['loan_amount']; ?></td>
						</tr>
						<?php }?>
				  </tbody>
				  <tfoot>
					<tr>
					  <th scope="row">Total</th>
					  <th><?php echo number_format($amount); ?></th>
					  <th><?php echo number_format($balance); ?></th>
					</tr>
				  </tfoot>
					<?php }else{?>
						<tr><td colspan="3">No loans data</td></tr>
				  </tbody>
				<?php }?>
		<?php
}			
?>