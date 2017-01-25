<?php 
require_once("lib/Accounts.php");
require_once("lib/Member.php");
$accounts = new Accounts();
$member = new Member();
$member_data = $member->findById($_GET['member_id']);
$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
if(!isset($_GET['start_date'])){
	$client_transactions =  $accounts->findTransactionByPersonNumber($member_data['person_number']);
}else{
	$start_date =  date("Y-m-d", strtotime($_GET['start_date']));
	$end_date = date("Y-m-d", strtotime($_GET['end_date']));
	$client_transactions = $accounts->findTransactionByDateRange($start_date,$end_date,$member_data['person_number']);
}

?>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2><?php echo  $account_names['firstname']." ".$account_names['lastname']; ?> <small> transactions from <?php echo $_GET['start_date']; ?> to <?php echo $_GET['end_date']; ?></small></h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<?php 
			if(!$client_transactions){ ?>
				<h2>There are no trasactions found for this period.</h2>
				<?php
			}else{ ?>
				<div class="table-responsive">
				  <table id="datatable-buttons" class="table table-striped jambo_table bulk_action">
					<thead>
					  <tr class="headings">
						<th>
						  <input type="checkbox" id="check-all" class="flat">
						</th>
						<?php 
						$header_keys = array("Account Number", "Transaction Type", "Amount", "Transaction Date", "Transacted By");
						foreach($header_keys as $key){ ?>
							<th><?php echo $key; ?></th>
							<?php
						}
						?>
					  </tr>
					  <tr>
						<th class="bulk-actions" colspan="6">
						  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
						</th>
					  </tr>
					</thead>
					<tbody>
						<?php
						$c = 1;
						$cur_balance = 0;
						foreach($client_transactions as $single){ ?>
							<tr class="<?php if(($c%2) == 0){  echo "even"; }else{ echo "odd"; } ?> pointer">
								<td class="a-center ">
									<input type="checkbox" value="<?php echo $single['id']; ?>" class="flat" name="table_records">
								</td>
								<td class=" "><?php echo $accounts->findAccountNoByPersonNumber($single['person_number']); ?> </td>
								<td class=" "><?php if($single['transaction_type'] == 1){ echo "Deposit"; }elseif($single['transaction_type'] == 2){ echo "Withdraw"; }elseif($single['transaction_type'] == 3){ echo "Shares"; }elseif($single['transaction_type'] == 4){ echo "Membership"; } ?></td>
								<td class=" "><?php $cur_balance += $single['amount']; if($single['amount'] < 0){ echo "(".($single['amount'] * -1).")"; }else{ echo  $single['amount']; }; ?></td>
								<td><?php echo date("j F, Y", strtotime($single['transaction_date'])); ?> </td>
								<td><?php echo $single['transacted_by']; ?></td>
							</tr>
							<?php
							$c++;
						}
						?>
					</tbody>
					<tfoot>
							<tr>
								<th colspan="2">Total (UGX)</th>
								<th><?php echo number_format($cur_balance,2,".",","); ?></th>
								<th  colspan="3">&nbsp;</th>
							</tr>
					</tfoot>
				  </table>
				</div>
				<?php 
			}
			?>
		</div>
	</div>
</div>
