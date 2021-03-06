<?php
$curdir = dirname(__FILE__);
require_once($curdir.'/Db.php');
class Dashboard extends Db {
	public function totalActiveLoans($where = 1){
		return $this->count("loan", $where);
	}
	public function getCountOfLoans($where = 1){
		$result = $this->getfrec("loan", "count(`id`) loanCount ", $where, "", "");
		return !empty($result) ? (($result['loanCount']!=NULL)?$result['loanCount']:0) : 0;
	}
	public function getSumOfLoans($where = 1){
		$result = $this->getfrec("loan", "sum(`expected_payback`) `loanSum` ", $where, "", "");
		return !empty($result) ? (($result['loanSum']!=NULL)?$result['loanSum']:0) : 0;
	}
	public function getSumOfShares($where = 1){
		$result = $this->getfrec("shares", "sum(`amount`) sharesSum ", $where, "", "");
		return !empty($result) ? (($result['sharesSum']!=NULL)?$result['sharesSum']:0) : 0;
	}
	public function getCountOfShares($where = 1){
		$result = $this->getfrec("shares", "sum(`no_of_shares`) sharesCount ", $where, "", "");
		return !empty($result) ? (($result['sharesCount']!=NULL)?$result['sharesCount']:0) : 0;
	}
	public function getAmountOfShares($where = 1){
		$result = $this->getfrec("transaction", "sum(`amount`) sharesSum ", $where, "", "");
		return !empty($result) ? (($result['sharesSum']!=NULL)?$result['sharesSum']:0) : 0;
	}
	public function getSumOfSubscriptions($where = 1){
		$result = $this->getfrec("subscription", "sum(`amount`) subsSum ", $where, "", "");
		return !empty($result) ? (($result['subsSum']!=NULL)?$result['subsSum']:0) : 0;
	}
	public function getSumOfDeposits($where = 1){
		$result = $this->getfrec("transaction", "sum(`amount`) depositsSum ", $where, "", "");
		return !empty($result) ? (($result['depositsSum']!=NULL)?$result['depositsSum']:0) : 0;
	}
	public function getSumOfWithdraws($where = 1){
		$result = $this->getfrec("transaction", "sum(`amount`) withdrawsSum ", $where, "", "");
		return !empty($result) ? (($result['withdrawsSum']!=NULL)?$result['withdrawsSum']:0) : 0;
	}
	public function getCountOfSubscriptions($where = 1){
		$result = $this->getfrec("subscription", "count(`id`) subsCount ", $where, "", "");
		return !empty($result) ? (($result['subsCount']!=NULL)?$result['subsCount']:0) : 0;
	}
	public function getSumOfLoanRepayments($where = 1){
		$result = $this->getfrec("loan_repayment", "sum(`amount`) loanPayments ", $where, "", "");
		return !empty($result) ? (($result['loanPayments']!=NULL)?$result['loanPayments']:0) : 0;
	}
}
?>