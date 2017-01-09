<?php 
$show_table_js = false;
require_once("lib/Loans.php");
require_once("lib/Expenses.php");
require_once("lib/Shares.php");
require_once("lib/Income.php");
require_once("lib/Dashboard.php");
$loan = new Loans();
$expense = new Expenses();
$share = new Shares();
$income = new Income();

$start_date = isset($_POST['start_date'])?$_POST['start_date']:date('Y-m-d',strtotime("-7 day"));
$end_date = isset($_POST['end_date'])?$_POST['end_date']:date('Y-m-d');
	
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
	
	echo json_encode($graph_data);
}
	if(isset($_POST['element'])&&strlen($_POST['element'])>0){
		switch($_POST['element']){
			case "barChart":
			case "lineChart":
				getGraphData($start_date, $end_date);
			break;
			case "pieChart":
				$dashboard = new Dashboard();
				$pieChartData[] = $dashboard->getSumOfLoans("`loan_end_date` >= '".$start_date."' AND id NOT IN (SELECT loan_id FROM `loan_repayment` WHERE DATEDIFF('".$end_date."',`transaction_date`)<61)");
				$pieChartData[] = $dashboard->getSumOfLoans("`loan_end_date` >= '".$start_date."' AND id IN (SELECT loan_id FROM `loan_repayment` WHERE DATEDIFF('".$end_date."',`transaction_date`)<61)");
				echo json_encode($pieChartData);
			break;
			//List of non performing loans
			case "nploans":
				$loans = $loan->findAll("`loan_end_date` >= '".$start_date."' AND id NOT IN (SELECT loan_id FROM `loan_repayment` WHERE DATEDIFF('".$end_date."',`transaction_date`)<61)", "expected_payback DESC", "10");
				draw_loans_table($loans);
			break;
			//List of all the active loans
			case "actvloans":
				$loans = $loan->findAll("`loan_end_date` <= '".$start_date."' AND `expected_payback` > COALESCE((SELECT SUM(amount) paid_amount FROM `loan_repayment` WHERE `transaction_date`<'".$end_date."' AND `loan_id` = `loan`.`id`),0)", "expected_payback DESC", "10");
				if($loans){
					draw_loans_table($loans);
				}
			break;
			//list of all the performing loans
			case "ploans":
				$loans = $loan->findAll("`loan_end_date` >= '".$start_date."' AND id IN (SELECT loan_id FROM `loan_repayment` WHERE DATEDIFF('".$end_date."',`transaction_date`)<61)", "expected_payback DESC", "10");
				draw_loans_table($loans);
			break;
			case "income":
				$income = $income->findAll("`date_added` BETWEEN '".$start_date."' AND '".$end_date."'", "amount DESC", "10");?>
                      <thead>
                        <tr>
						<?php 
						$header_keys = array("#", "Income type", "Amount");
						foreach($header_keys as $key){ ?>
							<th><?php echo $key; ?></th>
						<?php } ?>
                        </tr>
                      </thead>
                      <tbody>
						<?php
						$total = 0;
						if($income){
							foreach($income as $single){ ?>
							<tr>
							  <td><a href="#<?php echo $single['id']; ?>"><?php echo $single['id']; ?></A></td>
							  <td><?php echo substr($single['name'],0,20); ?></td>
							  <td><?php echo number_format($single['amount']); $total += $single['amount'];?></td>
							</tr>
							<?php }?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th scope="row">Total</th>
                          <th>&nbsp;</th>
                          <th><?php echo number_format($total); ?></th>
                        </tr>
                      </tfoot>
							<?php }else{?>
						<tr><td colspan="3">No income records found</td></tr>
                      </tbody>
						<?php }?>
			<?php	break;
			case "expenses":
				$expenses = $expense->findAllExpenses("`date_of_expense` BETWEEN ".$start_date." AND ".$end_date, "amount_used DESC", "10");?>
                      <thead>
                        <tr>
						<?php 
						$header_keys = array("#", "Description", "Amount");
						foreach($header_keys as $key){ ?>
							<th><?php echo $key; ?></th>
						<?php } ?>
                        </tr>
                      </thead>
                      <tbody>
						<?php
						$total = 0;
						if($expenses){
							foreach($expenses as $single){ ?>
							<tr>
							  <td><a href="#<?php echo $single['id']; ?>"><?php echo $single['id']; ?></A></td>
							  <td><?php echo $single['amount_description']; ?></td>
							  <td><?php echo number_format($single['amount_used']); $total += $single['amount_used']; ?></td>
							</tr>
							<?php }?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th scope="row">Total</th>
                          <th>&nbsp;</th>
                          <th><?php echo number_format($total); ?></th>
                        </tr>
                      </tfoot>
						<?php }else{?>
						<tr><td colspan="3">No expense records found</td></tr>
                      </tbody>
					<?php }?>
			<?php	break;
			default:
				;//$shares = $share->findAll("`date_paid` BETWEEN '".$start_date."' AND '".$end_date."'");
		}
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