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
				$this->clientLoans();
			break;
			case '';
				$this->defaultDisplay();
			break;
			case '';
				$this->defaultDisplay();
			break;
			case '';
				$this->defaultDisplay();
			break;
			case '';
				$this->defaultDisplay();
			break;
			case '';
				$this->defaultDisplay();
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
	public function viewClientLoans(){ 
		print_r($_GET);
		?>
		<p>This is a test report</p>
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
	public function clientLoans(){
		$member = new Member();
		$accounts = new Accounts();
		$loans = new Loans();
		$member_data = $member->findById($_GET['member_id']);
		$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
		$member_loans = $loans->findAll();//findMemberLoans($member_data['person_number']); 
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
							  <table class="table table-striped jambo_table bulk_action">
								<thead>
								  <tr class="headings">
									<th>
									  <input type="checkbox" id="check-all" class="flat">
									</th>
									<?php 
									$header_keys = array("Loan Number", "Loan Type", "Principal", "Interest", "Total PayBack","Repayment Duration" );
									foreach($header_keys as $key){ ?>
										<th><?php echo $key; ?></th>
										<?php
									}
									?>
									<th class="column-title no-link last"><span class="nobr">Action</span>
									</th>
									<th class="bulk-actions" colspan="7">
									  <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
									</th>
								  </tr>
								</thead>

								<tbody>
									<?php 
									foreach($member_loans as $single){ 
										$interest = 0;
										if($single['interest_rate'] > 0){
											$interest = ($single['loan_amount'] * ($single['interest_rate']/100));
										}
										?>
										<tr class="even pointer">
											<td class="a-center ">
												<input type="checkbox" value="<?php echo $single['id']; ?>" class="flat" name="table_records">
											</td>
											<td class=" "><?php echo $single['loan_number']; ?></td>
											<td class=" "><?php echo $loans->findLoanType($single['loan_type']); ?> </td>
											<td class=" "><?php echo $single['loan_amount']; ?> </td>
											<td class=" "><?php  echo $interest; ?></td>
											<td class=" "><?php echo $single['loan_amount'] + $interest; ?></td>
											<td class="a-right a-right "><?php echo $loans->findLoanPaymentDuration($single['repayment_duration']); ?></td>
											<td class=" last"><a href="#" class="btn btn-primary">View</a></td>
										</tr>
										<?php
									}
									?>
								</tbody>
							  </table>
							</div>
						<?php 
						}
						?>
                  </div>
                </div>
              </div>
           
		<?php
	}
}