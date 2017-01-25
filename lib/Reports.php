<?php 
require_once("lib/Libraries.php");
Class Reports{
	public function __construct($task){
	   $this->task = $task;
	  
	   $this->displayOption();
	   
	}
	public function displayOption(){
		switch($this->task){
			case 'client_trasaction_history';
				$this->clientTransactionHistory();
			break;
			case 'client_loans';
				$this->memberLoans();
			break;
			case 'mysubscriptions';
				$this->subScriptions();
			break;
			case 'myshares';
				$this->viewMemberShares();
			break;
			case 'nok';
				$this->viewNok();
			break;
			case 'mysavings';
				$this->viewMemberSaving();
			break;
			case 'client_loan';
				$this->ClientLoan();
			break;
			case '';
				$this->defaultDisplay();
			break;
			case '';
				$this->defaultDisplay();
			break;
			default:
				$this->defaultDisplay();
			break;
		}
	}
	public function defaultDisplay(){ 
		
		?>
		<p>This is a test report</p>
		<?php	
	}
	public function clientLoan(){
		$member = new Member();
		$accounts = new Accounts();
		$loans = new Loans();
		$member_data = $member->findById($_GET['member_id']);
		$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
		$loan_data = $loans->findById($_GET['lid']); 
		$interest = 0;
		if($loan_data['interest_rate'] > 0){
			$interest = ($loan_data['loan_amount'] * ($loan_data['interest_rate']/100));
		}
		?>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Loan <small> <?php echo $loan_data['loan_number']; ?>  details</small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="col-md-2 col-sm-12 col-xs-12 form-group">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add_document"><i class="fa fa-plus"></i> Attach  Loan Documents</button> 
						<br/>
						<div class="col-md-12 col-sm-12 col-xs-12 details">
							
							<?php 
							$loan_documents = $loans->findLoanDocuments($_GET['lid']);
							if($loan_documents){ ?>
								<h2 class="x_title">Loan Documents</h2>
								<?php
								foreach($loan_documents as $single){
									?>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<a href="<?php $single['doc_path']; ?>"><i class="fa fa-file"></i> <?php echo $single['name']; ?></a>
									</div>
									<?php 
								}
							}
							?>
						</div>
						<div class="modal fade add_document" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-sm">
							  <div class="modal-content">
									<form method="post" action="doc_upload.php" id="document">
										<div class="modal-header">
										  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
										  </button>
										  <h4 class="modal-title" id="myModalLabel2">Attach document</h4>
										</div>
										<div class="modal-body">
											<input type="hidden" name="add_document" >
											  <input type="hidden" name="loan_id" value="<?php echo $_GET['lid']; ?>">
											  <div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="comments">Name 
												</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
												  <input type="text" name="name">
												</div>
											  </div>
											  <div style="clear:both;"></div>
											  <div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="comments">Comment 
												</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
												  <textarea id="comments" required="required" name="description" class="form-control col-md-12 col-xs-12"></textarea>
												</div>
											  </div>
											  <div style="clear:both;"></div>
											  <br/>
											  <div class="item form-group">
												<input id="myFileInput" type="file" name="file" accept="image/*;capture=camera">
											   </div>
											  <div style="clear:both;"></div>
										</div>
										
										<div class="modal-footer">
										  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										  <button type="submit" class="btn btn-primary upload_document">Upload</button>
										</div>
									</form>
									
							  </div>
							</div>
						</div>
					</div>
					<div class="col-md-10 col-sm-12 col-xs-12 form-group">
						<div class="col-md-12 col-sm-12 col-xs-12 details">
							<div class="col-md-3 col-sm-12 col-xs-12 form-group " >
								<p class="lead" style="">Loan Date</p>
								<p class="p"><?php echo date("j F, Y", strtotime($loan_data['loan_date'])); ?></p>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group " >
								<p class="lead">Loan Amount</p>
								<p class="p"><?php echo number_format($loan_data["loan_amount"],2,".",","); ?></p>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
								<p class="lead" >Interest</p>
								<p class="p"><?php echo number_format($interest,2,".",","); ?></p>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<p class="lead" >Total PayBack</p>
								<p class="p"><?php echo number_format(($loan_data['loan_amount'] + $interest),2,".",","); ?></p>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 details">
							<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
								<p class="lead">Loan Duration</p>
								<p class="p"><?php $months = round((($loan_data['loan_duration']>0)?($loan_data['loan_duration']/30):0),1); echo $months; ?> month<?php echo $months==1?"":"s"; ?></p>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
								<p class="lead" >PayBack Date</p>
								<p class="p"><?php echo date("F j, Y", strtotime($loan_data['loan_end_date'])); ?></p>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group ">
								<p class="lead">Daily Default</p>
								<p class="p"><?php echo number_format($loan_data["daily_default_amount"],3,".",","); ?></p>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<p class="lead" >Loan Type</p>
								<p class="p"><?php echo $loans->findLoanType($loan_data['loan_type']); ?> </p>
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 form-group">
								<p class="lead" >Comments</p>
								<p class="p"><?php  echo $loan_data["comments"]; ?></p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	public function clientTransactionHistory(){ 
		$accounts  = new Accounts();
		?>
		<div class="page-title" >
		  <div class="title_left" style="width:35%;">
			<h3>Transactions <small>your transactions</small></h3> 
		  </div>
		  <div class="title_right" style="width:55%;">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
				  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
				  <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
				</div>
				<span style="margin-top: 40px; margin-left:10px;">Select a transaction period</span>
			</div>
		  </div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_content">
				<div id="report_data" class="col-md-12 co">
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<?php
	}
	public function memberLoans(){
		$member = new Member();
		$accounts = new Accounts();
		$loans = new Loans();
		$member_data = $member->findById($_GET['member_id']);
		$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
		$member_loans = $loans->findMemberLoans($member_data['person_number']); //->findAll();//
		?>
		 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $account_names['firstname']." ".$account_names['lastname']; ?> <small> loans details</small></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
						<?php 
						if($member_loans){  ?>
							<div class="table-responsive">
							  <table id="datatable-buttons" class="table table-striped jambo_table bulk_action">
								<thead>
								  <tr class="headings">
									<th>
									  <input type="checkbox" id="check-all" class="flat">
									</th>
									<?php 
									$header_keys = array("Loan Number", "Loan Type", "Principal", "Interest", "Total PayBack","Loan Date","Duration", "Expected PayBack Date");
									foreach($header_keys as $key){ ?>
										<th><?php echo $key; ?></th>
										<?php
									}
									?>
									</th>
								  </tr>
								  <tr>
									<th class="bulk-actions" colspan="9">
									  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
									</th>
								  </tr>
								</thead>

								<tbody>
									<?php
									$loan_sum = $expected_payback_sum = $interest_sum = 0;
									foreach($member_loans as $single){ 
										
										$interest = 0;
										if($single['interest_rate'] > 0){
											$interest = ($single['loan_amount'] * ($single['interest_rate']/100));
										}
										?>
										<tr class="even pointer <?php if($loans->isLoanAboutToExpire($single['id'], $single['repayment_duration'])){ echo "danger"; } ?>" >
											<td class="a-center ">
												<input type="checkbox" value="<?php echo $single['id']; ?>" class="flat" name="table_records">
											</td>
											<td class=""><a href="?member_id=<?php echo $_GET['member_id'];?>&view=client_loan&lid=<?php echo $single['id'];?>"><?php echo $single['loan_number']; ?></a></td>
											<td class=""><?php echo $loans->findLoanType($single['loan_type']); ?> </td>
											<td class=""><?php $loan_sum += $single['loan_amount']; echo number_format($single['loan_amount'],2,".",","); ?> </td>
											<td class=""><?php $interest_sum += $interest; echo number_format($interest,2,".",","); ?></td>
											<td class=" "><?php $expected_payback_sum += $single['loan_amount'] + $interest; echo number_format($single['loan_amount'] + $interest,2,".",","); ?></td>
											<td class="a-right a-right"><?php echo date("j F, Y", strtotime($single['loan_date'])); ?></td>
											<td class="a-right a-right"><?php $months = round((($single['loan_duration']>0)?($single['loan_duration']/30):0),1); echo $months; ?> month<?php echo $months==1?"":"s"; ?></td>
											<td class="a-right a-right"><?php echo date("F j, Y", strtotime($single['loan_end_date'])); ?></td>
										</tr>
										<?php
									}
									?>
								</tbody>
								<tfoot>
										<tr>
											<th colspan="3">Total (UGX)</th>
											<th><?php echo number_format($loan_sum,2,".",","); ?> </th>
											<th><?php echo number_format($interest_sum,2,".",","); ?></th>
											<th><?php echo number_format($expected_payback_sum,2,".",","); ?></th>
											<th  colspan="3">&nbsp;</th>
										</tr>
								</tfoot>
							  </table>
							</div>
						<?php 
						}else{
							echo "<p>There currently no loans subscribed by this member.</p>";
						}
						?>
                  </div>
                </div>
              </div>
           
		<?php
	}
	public function subScriptions(){
		$member = new Member();
		$accounts = new Accounts();
		$subscription = new Subscription();
		$member_data = $member->findById($_GET['member_id']);
		$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
		$all_client_subscriptions = $subscription->findMemberSubscriptions($member_data['person_number']); 
		?>
		 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $account_names['firstname']." ".$account_names['lastname']; ?> <small> Subscriptions </small></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
						<?php 
						if($all_client_subscriptions){  ?>
							<div class="table-responsive">
							  <table class="table table-striped jambo_table bulk_action">
								<thead>
								  <tr class="headings">
									<th>
									  <input type="checkbox" id="check-all" class="flat">
									</th>
									<?php 
									$header_keys = array("Date Subscribed", "Year", "Amount");
									foreach($header_keys as $key){ ?>
										<th><?php echo $key; ?></th>
										<?php
									}
									?>
								  </tr>
								  <tr>
									<th class="bulk-actions" colspan="4">
									  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
									</th>
								  </tr>
								</thead>

								<tbody>
									<?php
									$subscription_sum = 0;
									foreach($all_client_subscriptions as $single){ 
										?>
										<tr class="even pointer " >
											<td class="a-center ">
												<input type="checkbox" value="<?php echo $single['id']; ?>" class="flat" name="table_records">
											</td>
											<td class="a-right a-right "><?php echo date("j F, Y", strtotime($single['date_paid'])); ?></td>
											<td class=" "><?php echo $single['subscription_year']; ?> </td>
											<td class=" "><?php $subscription_sum += $single['amount']; echo number_format($single['amount'],2,".",","); ?></td>
										</tr>
										<?php
									}
									?>
								</tbody>
								<tfoot>
									<tr class="headings">
										<th colspan="3">Total</th>
										<th class=" "><?php echo number_format($subscription_sum,2,".",","); ?></th>
									</tr>
								</tfoot>
							  </table>
							</div>
						<?php 
						}else{
							echo "This member has not yet subscribed, please add subscription.";
						}
						?>
                  </div>
                </div>
              </div>
           
		<?php
	}
	public function viewMemberShares(){
		$member = new Member();
		$accounts = new Accounts();
		$shares = new Shares();
		$member_data = $member->findById($_GET['member_id']);
		$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
		$all_client_shares = $shares->findMemberShares($member_data['person_number']); 
		?>
		 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $account_names['firstname']." ".$account_names['lastname']; ?> <small> Shares </small></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
						<?php 
						if($all_client_shares){  ?>
							<div class="table-responsive">
							  <table class="table table-striped jambo_table bulk_action">
								<thead>
								  <tr class="headings">
									<th>
									  <input type="checkbox" id="check-all" class="flat">
									</th>									
									<?php 
									$header_keys = array("Purchase Date", "Amount");
									foreach($header_keys as $key){ ?>
										<th><?php echo $key; ?></th>
										<?php
									}
									?>
									<th class="bulk-actions">
									  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
									</th>
								  </tr>
								  <tr>
									<th class="bulk-actions" colspan="3">
									  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
									</th>
								  </tr>
								</thead>
								<tbody>
									<?php
									$shares_sum = 0;
									foreach($all_client_shares as $single){ 
										?>
										<tr class="even pointer " >
											<td class="a-center ">
												<input type="checkbox" value="<?php echo $single['id']; ?>" class="flat" name="table_records"/>
											</td>
											<td class="a-right a-right"><?php echo date("j F, Y", strtotime($single['date_paid'])); ?></td>
											<td colspan="2"><?php $shares_sum += $single['amount']; echo number_format($single['amount'],0,".",","); ?></td>
										</tr>
										<?php
									}
									?>
								</tbody>
								</tfoot>
									<tr>
										<th colspan="2">Total</th>
										<th class="a-right a-right " colspan="2"><?php echo number_format($shares_sum,0,".",","); ?></th>
									</tr>
								</tfoot>
							  </table>
							</div>
						<?php 
						}else{
							echo "This member has not yet bought shares, please add shares.";
						}
						?>
                  </div>
                </div>
              </div>
           
		<?php
	}
	public function viewNok(){
		$member = new Member();
		$accounts = new Accounts();
		$nok = new Nok();
		$member_data = $member->findById($_GET['member_id']);
		$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
		$noks = $nok->findMemberNextOfKin($member_data['person_number']); 
		?>
		 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $account_names['firstname']." ".$account_names['lastname']; ?> <small> Next of Kin </small></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
						<?php 
						if($noks){  ?>
							<div class="table-responsive">
							  <table class="table table-striped jambo_table bulk_action">
								<thead>
								  <tr class="headings">
									<th>
									  <input type="checkbox" id="check-all" class="flat">
									</th>
									<?php 
									$header_keys = array("Name", "Gender", "Relationship", "Status", "Phone","Address","Edit");
									foreach($header_keys as $key){ ?>
										<th><?php echo $key; ?></th>
										<?php
									}
									?>
									<th class="column-title no-link last"><span class="nobr">Action</span>
									</th>
								  </tr>
								  <tr>
									<th class="bulk-actions" colspan="8">
									  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
									</th>
								  </tr>
								</thead>

								<tbody>
									<?php 
									foreach($noks as $single){ 
										?>
										<tr class="even pointer " >
											<td class="a-center ">
												<input type="checkbox" value="<?php echo $single['id']; ?>" class="flat" name="table_records">
											</td>
											<td class=" "><?php echo $single['name']; ?></td>
											<td class=" "><?php echo $single['gender']; ?> </td>
											<td class=" "><?php  echo $single['relationship']; ?></td>
											<td class=" "><?php echo $single['marital_status']; ?></td>
											<td class="a-right a-right "><?php echo $single['phone']; ?></td>
											<td class="a-right a-right "><?php  echo $single['physical_address']; ?></td>
											<td class=" last"><a href="?member_id=<?php echo $_GET['member_id']; ?>&edit=nok&nok_id=<?php echo $single['id']; ?>" class="btn btn-success">Edit</a></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							  </table>
							</div>
						<?php 
						}else{
							echo "<p>There is currently no Next of Kin added to this member.</p>";
						}
						?>
                  </div>
                </div>
              </div>
           
		<?php
	}
	public function viewMemberSaving(){
		$member = new Member();
		$accounts = new Accounts();
		$member_data = $member->findById($_GET['member_id']);
		$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
		$all_member_deposits = $accounts->findMemberDeposits($member_data['person_number']); 
		?>
		 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $account_names['firstname']." ".$account_names['lastname']; ?> <small> My savings</small></h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
						<?php 
						if($all_member_deposits){  ?>
							<div class="table-responsive">
							  <table class="table table-striped jambo_table bulk_action">
								<thead>
								  <tr class="headings">
									<th>
									  <input type="checkbox" id="check-all" class="flat">
									</th>
									<?php 
									$header_keys = array("Deposited By","Date Deposited", "Amount", "Amount in Words");
									foreach($header_keys as $key){ ?>
										<th><?php echo $key; ?></th>
										<?php
									}
									?>
								  </tr>
								  <tr>
									<th class="bulk-actions" colspan="8">
									  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
									</th>
								  </tr>
								</thead>

								<tbody>
									<?php
									$savings_sum = 0;
									foreach($all_member_deposits as $single){ 
										
										?>
										<tr class="even pointer " >
											<td class="a-center ">
												<input type="checkbox" value="<?php echo $single['id']; ?>" class="flat" name="table_records">
											</td>
											<td class=" "><?php echo $single['transacted_by']; ?></td>
											<td class="a-right a-right "><?php echo date("j F, Y", strtotime($single['transaction_date'])); ?></td>
											<td class=" "><?php $savings_sum += $single['amount']; echo $single['amount']; ?></td>
											<td class=" "><?php echo $single['amount_description']; ?> </td>
										</tr>
										<?php
									}
									?>
								</tbody>
								</tfoot>
									<tr>
										<th colspan="3">Total (UGX)</th>
										<th><?php echo $savings_sum; ?></th>
										<th>&nbsp;</th>
									</tr>
								</tfoot>
							  </table>
							</div>
						<?php 
						}else{
							echo "There are currently no deposits.";
						}
						?>
                  </div>
                </div>
              </div>
           
		<?php
	}
}