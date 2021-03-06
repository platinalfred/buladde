<?php 
session_start();
require_once("lib/Libraries.php");
//Transaction Types 1-Deposits, 2-Withdraws, 3-Loan Repayment, 4-Shares, 5-Membership subscription
if(isset($_POST['add_loan'])){
	$data = $_POST;
	$loan = new Loans();
	$guarantor = new Guarantor();
	$data['loan_date'] = date("Y-m-d");
	if(isset($data['guarantor'])){
		$loan_id = $loan->addLoan($data);
		if($loan_id){
			$result = false;
			$guarantor_data = array();
			foreach($data['guarantor'] as $person_number){
				$guarantor_data[] = '("'.mysql_real_escape_string($person_number).'", '.$loan_id.')';
			}
			$result = $guarantor->addGuarantors($guarantor_data);
			if($result){
				echo "success";
			}
		}
		else
			echo "Failed adding loan";
		return;
	}
	else{
		echo "Please fill in all fields including guarantors. ";
		return;
	}
}elseif(isset($_POST['repayment_duration'])){
	$data = $_POST;
	$loan_repayment_duration = new LoanRepaymentDuration();
	 if($loan_repayment_duration->addLoanRepaymentDuration($data)){
		echo "success";
		return;
	}  
	return false;
}elseif(isset($_POST['add_income'])){
	$data = $_POST;
	$data['date_added'] = date("Y-m-d");
	$income = new Income();
	 if($income->addIncome($data)){
		echo "success";
		return;
	}  
	return false;
}elseif(isset($_POST['add_expense'])){
	$data = $_POST;
	$data['date_of_expense'] = date("Y-m-d");
	$expenses = new Expenses();
	 if($expenses->addExpense($data)){
		echo "success";
		return;
	}  
	return false;
}elseif(isset($_POST['addnok'])){
	$data = $_POST;
	$nok = new Nok();
	$data['date_added'] = date("Y-m-d");
	 if($nok->addNok($data)){
		echo "success";
		return;
	}  
	return false;
}elseif(isset($_POST['add_share_rate'])){
	$data = $_POST;
	$shares = new Shares();
	$data['date_added'] = date("Y-m-d");
	if($shares->addShareRate($data)){
		echo "success";
		return;
		
	}  
	return false;
}elseif(isset($_POST['add_share'])){
	$data = $_POST;
	$member = new Member();
	$shares = new Shares();
	$income = new Income();
	$data['date_paid'] = date("Y-m-d");
	if($shares->addShares($data)){
		$data['date_added'] = date("Y-m-d");
		$data['added_by'] = $data['received_by'];
		$data['description'] = "Shares bought by ".$member->findMemberNames($data['person_number'])." on ".$data['date_added'];
		if($income->addIncome($data)){
			//Record into the transaction table
			$data['transaction_type']  = 3;
			$data['branch_number']  = $_SESSION['income_type'];
			$data['transacted_by']  = $data['paid_by'];
			$data['transaction_date'] = $data['date_added'];
			$data['approved_by']= $data['received_by'];
			$data['comments'] = $data['description'] ;
			$trans_fields = array("transaction_type", "branch_number", "person_number", "amount", "amount_description", "transacted_by", "transaction_date", "approved_by", "comments");
			$shares->add("transaction", $trans_fields, $shares->generateAddFields($trans_fields, $data));
			echo "success";
			return;
		}
	}  
	return false;
}elseif(isset($_POST['add_subscription'])){
	$data = $_POST;
	$member = new Member();
	$subscription = new Subscription();
	$income = new Income();
	$data['date_paid'] = date("Y-m-d");
	 if($subscription->addSubscription($data)){
		$data['income_type'] = 1;
		$data['date_added'] = date("Y-m-d");
		$data['added_by'] = $data['received_by'];
		
		$data['description'] = "Annual subscription paid by ".$member->findMemberNames($data['person_number'])." for year ".$data['subscription_year'];
		if($income->addIncome($data)){
			echo "success";
			return;
		}
	}  
	return false;
}elseif(isset($_POST['add_deposit'])){
	$data = $_POST;
	$accounts = new Accounts();
	if($accounts->addDeposit($data)){
		echo "success";
		return;
	} 
	
	return false;
}elseif(isset($_POST['withdraw_cash'])){
	$data = $_POST;
	$accounts = new Accounts();
	if($accounts->addWithdraw($data)){
		echo "success";
		return;
	} 
	return false;
}elseif(isset($_POST['add_member'])){
	$data = $_POST;
	$member = new Member();
	$person = new Person();
	$accounts = new Accounts();
	$data['date_registered'] = date("Y-m-d");
	$data['date_added'] = date("Y-m-d");
	$data['photograph'] = "";
	$data['active']=1;
	$person_id = $person->addPerson($data);
	if($person_id){
		$data['person_id'] = $person_id;
		$member_id = $member->addMember($data);
		if($member_id){
			$act= sprintf('%08d', $person_id);
			$data['account_number'] =  $act;
			$data['balance'] = 0.00;
			$data['status'] = 1;
			$data['date_created'] = date("Y-m-d");
			$data['created_by'] = $data['added_by']; 
			if($accounts->addAccount($data)){
				echo $member_id;
				return;
			}
			
		}
	} 
	return "failed"; 
}elseif(isset($_POST['update_member'])){
	$data = $_POST;
	$staff_d = array();
	$member = new Member();
	$person = new Person();
	$accounts = new Accounts();
	$member_d = $data;
	$p['person_id'] = $member->findPersonNumber($data['id']);
	$member_d['person_id'] = $p['person_id']; 
	if($member->updateMember($member_d)){
		$data['id'] = $p['person_id']; 
		$data['dateofbirth'] = $member->formatSlashedDate($data['dateofbirth']);
		$person->updatePerson($data);
		echo "success";
		return;
	
	}

	return; 
}elseif(isset($_POST['add_staff'])){
	$data = $_POST;
	$staff = new Staff();
	$person = new Person();
	$accounts = new Accounts();
	$data['date_registered'] = date("Y-m-d");
	$data['date_added'] = date("Y-m-d");
	$data['photograph'] = "";
	$data['active']=1;
	$data['password'] = md5($data['password']);
	$person_id = $person->addPerson($data);
	if($person_id){
		$data['person_id'] = $person_id;
		if($staff->addStaff($data)){
			$data['account_number'] = substr(number_format(time() * rand(),0,'',''),0,10);
			$data['balance'] = 0.00;
			$data['status'] = 1;
			$data['date_created'] = date("Y-m-d");
			$data['created_added'] = $data['added_by']; 
			if($accounts->addAccount($data)){
				echo "success";
				return;
			}
		}
	}
	return; 
}elseif(isset($_POST['update_staff'])){
	$data = $_POST;
	$staff_d = array();
	$staff = new Staff();
	$person = new Person();
	$accounts = new Accounts();
	if(!$accounts->isValidMd5($data['password'])){
		$data['password'] = md5($data['password']);
	}
	$staff_d = $data;
	$p['person_id'] = $staff->findPersonNumber($data['id']);
	if($staff->updateStaff($staff_d)){
		$data['id'] = $p['person_id']; 
		$data['dateofbirth'] = $staff->formatSlashedDate($data['dateofbirth']);
		$person->updatePerson($data);
		echo "success";
		return;
	
	}

	return; 
}elseif(isset($_POST['add_security_type'])){
	$security_type = new SecurityType();
	if($security_type->addSecurityType($_POST)){
		echo "success";
		return;
	}else{
		echo "failed";
		return;
	}
}elseif(isset($_POST['add_member_type'])){
	$member_type = new MemberType();
	if($member_type->addMemberType($_POST)){
		echo "success";
		return;
	}else{
		echo "failed";
	}
}elseif(isset($_POST['add_branch'])){
	$branch = new Branch();
	if($branch->addBranch($_POST)){
		echo "success";
		return;
	}else{
		echo "failed";
	}
}elseif(isset($_POST['add_loan_type'])){
	$loan_type = new LoanType();
	if($loan_type->addLoanType($_POST)){
		echo "success";
		return;
	}else{
		echo "failed";
	}
}
elseif(isset($_POST['add_access_level'])){
	$access_level = new AccessLevel();
	if($access_level->addAccessLevel($_POST)){
		echo "success";
		return;
	}else{
		echo "failed";
	}
}elseif(isset($_POST['add_expense_type'])){
	$expense_type = new ExpenseTypes();
	if($expense_type->addExpenseType($_POST)){
		echo "success";
		return;
	}else{
		echo "failed";
	}
}elseif(isset($_POST['add_income_source'])){
	$income_source = new IncomeSource();
	if($income_source->addIncomeSource($_POST)){
		echo "success";
		return;
	}else{
		echo "failed";
	}
}elseif(isset($_POST['loan_repayment'])){
	$loans = new Loans();
	if($loans->addLoanRepayment($_POST)){
		echo "success";
		return;
	}else{
		echo "failed";
	}
}

?>