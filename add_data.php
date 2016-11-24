<?php 
require_once("lib/Libraries.php");
if(isset($_POST['add_subscription'])){
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
}if(isset($_POST['add_deposit'])){
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
		$data['person_number'] = $person_id;
		$member_id = $member->addMember($data);
		if($member_id){
			$data['account_number'] = substr(number_format(time() * rand(),0,'',''),0,10);
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
		$data['person_number'] = $person_id;
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
}elseif(isset($_POST['add_loan'])){
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
		echo "Please fill in all fields including guarantors";
		return;
	}
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
}

?>