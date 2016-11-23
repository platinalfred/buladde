<?php 
require_once("lib/Libraries.php");
Class Forms{
	public function __construct($task){
	   $this->task = $task;
	   $this->displayOption();
	}
	
	public function displayOption(){
		switch($this->task){
			case 'default.add';
				$this->defaultDisplay();
			break;
			case 'loan.add';
				$this->addLoan();
			break;
			case 'security.add';
				$this->addSecurity();
			break;
			case 'repayment.add';
				$this->LoanRepayment();
			break;
			case 'nok.add';
				$this->nextOfKin();
			break;
			case 'deposit.add';
				$this->depositToAccount();
			break;
			case 'withdraw.add';
				$this->withdrawFromAccount();
			break;
			
			case 'security_type.add';
				$this->addSecurityType();
			break;
			case 'member_type.add';
				$this->addMemberType();
			break;
			case 'branch.add';
				$this->addBranch();
			break;
			case 'loan_type.add';
				$this->addLoanType();
			break;
			case 'access_level.add';
				$this->addAccessLevel();
			break;
			
			default:
				$this->defaultDisplay();
			break;
		}
	}
	function defaultDisplay(){
		?>
		<div class="row">
			<form style="margin-left:150px; text-align: center; width:200px;" id="check_out_form" name="purchase" action="http://web-tier-elb-826037097.us-west-2.elb.amazonaws.com/wa/purchase-receipt" method="post">
				<input type="hidden" name="x_fp_sequence" value="179">
				<input type="hidden" name="x_fp_timestamp" value="1479374359">
				<input type="hidden" name="x_fp_hash" value="cdd1868cdef4f2f71f7b86056b0d9e42">
				<input class="products_total_price" type="hidden" name="x_amount" value="119.00">
				<input class="products_total_price" type="hidden" name="price" value="119.00">
				<input type="hidden" name="code" value="">
				<input class="products_total_price" type="hidden" name="total" value="119.00">
				<input type="hidden" name="x_state" value="wa">
				<input type="hidden" name="current_state" value="wa">
				<input type="hidden" name="x_first_name" value="Test1">
				<input type="hidden" name="x_last_name" value="Tester">
				<input type="hidden" name="x_phone" value="342-293-2989">
				<input type="hidden" name="x_cust_id" value="az_tester">
				<input type="hidden" name="x_email" value="dongorman@gmail.com">
				<input type="hidden" name="x_description" value="Real Estate Education">
				<input type="hidden" name="x_login" value="274H6eQmb">
				<input type="hidden" name="x_show_form" value="PAYMENT_FORM">
				<input type="hidden" name="x_relay_response" value="True">
				<input type="hidden" name="x_fp_timestamp" value="1479374359">
				<input type="hidden" name="x_logo_url" value="https://secure.authorize.net/mgraphics/logo_1448809_3.jpg">
				<input type="hidden" name="user_id" value="13181">
				<input type="hidden" name="x_fp_sequence" value="179">
				<input type="hidden" name="x_fp_timestamp" value="1479374359">
				<input type="hidden" name="x_fp_hash" value="62753ec1068fd0ce054b193cfa411ec3">
				<button id="send" type="submit" class="btn btn-success ">Submit</button>
			</form>
			 
		</div>
		<?php
	}	
	function addLoan(){
		$db = new Db();
		$bno = $_SESSION['branch_number'];
		 $branch = $db->getfrec("branch","branch_name", "branch_number='BR00001'","", "");
		 $branch_name = $branch['branch_name'];
		$initials = ($branch['branch_name'] != "")? strtoupper($branch['branch_name']) : strtoupper(substr($branch_name, 0, 3));
         $date = date("ymdis");
         $loan_number =  $initials."-".$date; 
		?>
		
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Add Loan Information <small></small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left" novalidate>
				 <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="loan_number">Loan Number <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input id="loan_number" value="<?php echo $loan_number;?>" class="form-control col-md-7 col-xs-12"  name="loan_number" placeholder="<?php echo $loan_number; ?>"  readonly = "readonly" type="text">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="loan_type">Loan Type <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php
						$db->loadList("Select * from loan_type", "loan_type", "id","name","loan_type");
						?>
					 
					</div>
				  </div>					
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="branch_id">Awarding Branch<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="branch_id" name="branch_id"  readonly = "readonly"  value="<?php echo $_SESSION['branch_number']; ?>" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="loan_amout">Loan Amount <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="number" id="loan_amout" name="loan_amout"  maxlength="128" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="item form-group" >
					<label class="control-label col-md-3 col-sm-3 col-xs-12"  for="loan_amout">Amount In Words</label>
					<div class="col-md-6 col-sm-6 col-xs-12" id="number_words">
					  
					</div>
					<input type="hidden" id="loan_amout" type="hidden" name="loan_amount_word"  class="form-control col-md-7 col-xs-12">
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="interest_rate">Loan Interest Rate(%) <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input  type="number" id="interest_rate"  name="interest_rate" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="item form-group" >
					<label class="control-label col-md-3 col-sm-3 col-xs-12"  for="loan_amout">Expected Payback Amount</label>
					<div class="col-md-6 col-sm-6 col-xs-12" id="expected_payback">
					  
					</div>
					<input  type="hidden" id="interest_rate"  name="expected_payback" required="required" class="form-control col-md-7 col-xs-12">
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Repayment Duration <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <?php
						$db->loadList("Select * from repaymentduration", "repayment_duration", "id","name","repayment_duration");
						?>
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="daily_default">Daily Charge Upon Default 	</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input id="daily_default" type="number" name="daily_default"  class="optional form-control col-md-7 col-xs-12">
					</div>
				  </div>				  
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="comments">Comments 
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="comments" required="required" name="comments" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="	approved_by">Approved By <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php  $d = $db->getfrec("person", "firstname, lastname",  "id = ".$_SESSION['person_number'], "", ""); 
						echo $d['firstname']. " ".$d['lastname']; ; ?>
					  <input type="hidden" id="approved_by" value="<?php echo $_SESSION['id']; ?>" readonly = "readonly" name="approved_by" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="ln_solid"></div>
				  <div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <button type="submit" class="btn btn-primary">Cancel</button>
					  <button id="send" type="submit" class="btn btn-success loginbtn">Submit</button>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
			
		 <div class="clearfix"></div>
		<?php
	}
	function addSecurity(){
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Add Security <small></small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left" novalidate>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Security Type <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <select class="form-control" name="member_type">
						<option value="1" >Development</option>
						<option value="2">Member</option>
					  </select>
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Loan Number <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <select class="form-control" name="member_type">
						<option value="1" >Development</option>
						<option value="2">Member</option>
					  </select>
					</div>
				  </div>					
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Name<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="email" id="email2" name="confirm_email" data-validate-linked="email" required="required" readonly = "readonly"  value="<?php echo $_SESSION['branch_number']; ?>" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="textarea" required="required" name="textarea" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comments <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="textarea" required="required" name="textarea" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Approved By <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="tel" id="telephone" readonly = "readonly" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="ln_solid"></div>
				  <div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <button type="submit" class="btn btn-primary">Cancel</button>
					  <button id="send" type="submit" class="btn btn-success loginbtn">Submit</button>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
			
		 <div class="clearfix"></div>
		<?php
	}
	
	function LoanRepayment(){
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Add new Payement <small></small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left" novalidate>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Loan Being Repaid<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <select class="form-control" name="member_type">
						<option value="1" >Development</option>
						<option value="2">Member</option>
					  </select>
					</div>
				  </div>
				 					
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Amount<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="money"  name="amount" data-validate-linked="email" required="required" readonly = "readonly"  class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Justification <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="textarea" required="required" name="textarea" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Added By <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="tel" id="telephone" readonly = "readonly" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="ln_solid"></div>
				  <div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <button type="submit" class="btn btn-primary">Cancel</button>
					  <button id="send" type="submit" class="btn btn-success loginbtn">Submit</button>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
			
		 <div class="clearfix"></div>
		<?php
	}
	function nextOfKin(){
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Add Next of Kin (NOK) for this Member <small></small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left" novalidate>
				 <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">First Name <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gender">Gender<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <select class="form-control" name="gender">
						<option value="1" >Development</option>
						<option value="2">Member</option>
					  </select>
					</div>
				  </div>					
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Date of Birth<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="email" id="email2" name="confirm_email" data-validate-linked="email" required="required" readonly = "readonly"  value="<?php echo $_SESSION['branch_number']; ?>" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gender">Marital Status<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <select class="form-control" name="gender">
						<option value="1" >Development</option>
						<option value="2">Member</option>
					  </select>
					</div>
				  </div>	
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Telephone<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text"  name="phone" required="required" data-validate-minmax="10,100" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Postal address<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="textarea" required="required" name="textarea" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Physical Address<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="textarea" required="required" name="textarea" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Added By <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="tel" id="telephone" readonly = "readonly" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="ln_solid"></div>
				  <div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <button type="submit" class="btn btn-primary">Cancel</button>
					  <button id="send" type="submit" class="btn btn-success loginbtn">Submit</button>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
			
		 <div class="clearfix"></div>
		<?php
	}
	function depositToAccount(){
		if(!isset($_GET['member_id'])){
			header("view_members.php");
		}
		$accounts = new Accounts();
		$member = new Member();
		$member_data = $member->findById($_GET['member_id']);
		$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Deposit to <small> <b><?php echo $account_names['firstname']." ".$account_names['othername']." ".$account_names['lastname']; ?> a/c</b></small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left"  action="" method="" novalidate>
					<input type="hidden" value="<?php echo $member_data['person_number']; ?>" name="person_number">
					<input type="hidden" value="add_deposit" name="add_deposit">
					<input type="hidden" value="<?php echo $_SESSION['branch_number']; ?>" name="branch_number">
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Account Number
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="number"  name="account_number"  value="<?php echo $accounts->findAccountNoByPersonNumber($member_data['person_number']); ?>" readonly = "readonly"  class="form-control col-md-7 col-xs-12">
					</div>
				  </div>			
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount<span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="number"  id="deposit_amount" name="amount"  required="required" class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount Description<span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12"  id="amount_description">
					  
					</div>
					<input type="hidden"  class="amount_description" name="amount_description"  class="form-control col-md-7 col-xs-12">
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="transacted_by">Deposited By<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text"  name="transacted_by"  required="required"   class="form-control col-md-7 col-xs-12">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comment </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="textarea"  name="comments" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="approved_by">Approved By <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text"  readonly = "readonly" value="<?php $logged_in_as = $accounts->findAccountNamesByPersonNumber($_SESSION['person_number']); echo $logged_in_as['firstname']." ".$logged_in_as['othername']." ".$logged_in_as['lastname']; ?>"  required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
					  <input type="hidden" id="approved_by" name="approved_by" value="<?php echo $_SESSION['id']; ?>">
					</div>
				  </div>
				 <input type="hidden" name="transaction_type" value="deposit">
				  <div class="ln_solid"></div>
				  <div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <button type="button" class="btn btn-primary">Cancel</button>
					  <button id="send" type="button" class="btn btn-success loginbtn save_data">Deposit</button>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
		<div class="clearfix"></div>
		<?php
	}
	function withdrawFromAccount(){
		if(!isset($_GET['member_id'])){
			header("view_members.php");
		}
		$accounts = new Accounts();
		$member = new Member();
		
		$member_data = $member->findById($_GET['member_id']);
		$minimum_amount = $accounts->findMinimumBalance();
		$account_names = $accounts->findAccountNamesByPersonNumber($member_data['person_number']);
		$account_balance = $accounts->findByAccountBalance($member_data['person_number']);
		$max_withdraw = $account_balance - $minimum_amount;
		
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Withdraw From <small> <b><?php echo ucfirst($account_names['firstname'])." ".ucfirst($account_names['othername'])." ".ucfirst($account_names['lastname']); ?> A/C</b></small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<?php 
				if($max_withdraw < 5000){ ?>
					<h4>Your account is insufficient, you can not withdraw less than the minimum balance of <?php echo $accounts->numberFormat($minimum_amount); ?>, your current balance is <?php echo $accounts->numberFormat($account_balance); ?> </h4>
					<?php
				}else{
					?>
					<form class="form-horizontal form-label-left"  action="" method="" novalidate>
						<input type="hidden" value="<?php echo $member_data['person_number']; ?>" name="person_number">
						<input type="hidden" value="2" name="withdraw_cash">
						<input type="hidden" value="<?php echo $_SESSION['branch_number']; ?>" name="branch_number">
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Account Number
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="number"  name="account_number"  value="<?php echo $accounts->findAccountNoByPersonNumber($member_data['person_number']); ?>" readonly = "readonly"  class="form-control col-md-7 col-xs-12">
						</div>
					  </div>
						<div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Maximum Withdraw Amount</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<?php 
								echo $accounts->numberFormat($max_withdraw)." (".$member->numberToWords($max_withdraw).") "; ?>
							</div>
					  </div>					  
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="withdraw_amount">Amount<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="number"  id="withdraw_amount" name="amount"  max="<?php echo (int)$max_withdraw; ?>"  required="required" class="form-control col-md-7 col-xs-12">
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount Description<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12"  id="amount_description">
						  
						</div>
						<input type="hidden"  class="amount_description" name="amount_description"  class="form-control col-md-7 col-xs-12">
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="transacted_by">Withdrawn By<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text"  name="transacted_by"  required="required"   class="form-control col-md-7 col-xs-12">
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Comment </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <textarea id="textarea"  name="comments" class="form-control col-md-7 col-xs-12"></textarea>
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="approved_by">Approved By <span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text"  readonly = "readonly" value="<?php $logged_in_as = $accounts->findAccountNamesByPersonNumber($_SESSION['person_number']); echo $logged_in_as['firstname']." ".$logged_in_as['othername']." ".$logged_in_as['lastname']; ?>"  required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
						  <input type="hidden" id="approved_by" name="approved_by" value="<?php echo $_SESSION['id']; ?>">
						</div>
					  </div>
					 <input type="hidden" name="transaction_type" value="deposit">
					  <div class="ln_solid"></div>
					  <div class="form-group">
						<div class="col-md-6 col-md-offset-3">
						  <button id="send" type="button" class="btn btn-success loginbtn save_data">Withdraw</button>
						</div>
					  </div>
					</form>
					<?php 
				}
				?>
			  </div>
			</div>
		  </div>
		</div>
		<div class="clearfix"></div>
		<?php
	}
	function addSecurityType(){
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Add Security Type <small></small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left"  novalidate>
					<input name="add_security_type" type="hidden" value="add_security_type">
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text"  name="name"  required="required"   class="form-control col-md-7 col-xs-12 required_f">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="description" name="description" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  <div class="ln_solid"></div>
				  <div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <button type="button" class="btn btn-primary">Cancel</button>
					  <button id="send" type="button" class="btn btn-success loginbtn save_data">Submit</button>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
			
		 <div class="clearfix"></div>
		<?php
	}
	function addMemberType(){
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Add Member Type <small></small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left" novalidate>
					<input type="hidden" name="add_member_type" value='member_type'>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text"  name="name"  required="required"   class="form-control col-md-7 col-xs-12 required_f">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="description" name="description" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  <div class="ln_solid"></div>
				  <div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <button type="button" class="btn btn-primary">Cancel</button>
					  <button id="send" type="button" class="btn btn-success loginbtn save_data">Submit</button>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
			
		 <div class="clearfix"></div>
		<?php
	}
	function addBranch(){
		 $this->branch = new Branch();
		 
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Add Branch <small> </small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left" novalidate>
					<input type="hidden" name="add_branch" value="add_branch">
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="branch_number">Branch Number
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text" readonly="readonly" value="<?php echo $this->branch->createNewBranchNumber(); ?>" name="branch_number"   class="form-control col-md-7 col-xs-12">
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="branch_name">Name<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text"  name="branch_name"  required="required"   class="form-control col-md-7 col-xs-12 required_f">
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="office_phone">Office Phone<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text"  name="office_phone" data-inputmask="'mask': '999-999-999'" required="required"   class="form-control col-md-7 col-xs-12 required_f">
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email_address">Email Address
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text"  name="email_address"    class="form-control col-md-7 col-xs-12">
						</div>
					  </div>
					   <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="postal_address">Postal Address
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <textarea id="postal_address" name="postal_address" class="form-control col-md-7 col-xs-12"></textarea>
						</div>
					  </div>
					 <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="physical_address">Physical Address
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <textarea id="physical_address" name="physical_address" class="form-control col-md-7 col-xs-12"></textarea>
						</div>
					  </div>
					  <div class="ln_solid"></div>
					  <div class="form-group">
						<div class="col-md-6 col-md-offset-3">
						  <button type="button" class="btn btn-primary cancel">Cancel</button>
						  <button id="send" type="button" class="btn btn-success loginbtn save_data">Submit</button>
						</div>
					  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
			
		 <div class="clearfix"></div>
		<?php
	}
	function addLoanType(){
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Add Loan Type <small> </small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left" novalidate>
					<input type="hidden" name="add_loan_type" value="loan_type">
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <input type="text"  name="name"  required="required"   class="form-control col-md-7 col-xs-12 required_f">
						</div>
					  </div>
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						  <textarea id="textarea" name="description" class="form-control col-md-7 col-xs-12"></textarea>
						</div>
					  </div>
					  <div class="ln_solid"></div>
					  <div class="form-group">
						<div class="col-md-6 col-md-offset-3">
						  <button type="button" class="btn btn-primary cancel">Cancel</button>
						  <button id="send" type="button" class="btn btn-success loginbtn save_data">Submit</button>
						</div>
					  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
			
		 <div class="clearfix"></div>
		<?php
	}
	function addAccessLevel(){
		?>
		<div class="row">
		  <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
			  <div class="x_title">
				<h2>Add Access Level <small> </small></h2>
				<ul class="nav navbar-right panel_toolbox">
				  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			  </div>
			  <div class="x_content">
				<form class="form-horizontal form-label-left" novalidate>
					<input type="hidden" name="add_access_level" value="access_level">
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text"  name="name"  required="required"   class="form-control col-md-7 col-xs-12 required_f">
					</div>
				  </div>
				  <div class="item form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <textarea id="textarea" name="description" class="form-control col-md-7 col-xs-12"></textarea>
					</div>
				  </div>
				  <div class="ln_solid"></div>
				  <div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <button type="button" class="btn btn-primary cancel">Cancel</button>
					  <button id="send" type="button" class="btn btn-success loginbtn save_data">Submit</button>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
			
		 <div class="clearfix"></div>
		<?php
	}
}