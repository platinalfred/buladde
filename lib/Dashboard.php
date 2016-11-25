<?php
$curdir = dirname(__FILE__);
require_once($curdir.'/Db.php');
class Dashboard extends Db {
	public function findTotalSumOfSubscriptions(){
		$result = $this->getfrec("subscription", "SUM(amount) as sub", "", "", "");
		return !empty($result) ? $result['sub'] : false;
	}
	public function findTotalSumOfShares(){
		$result = $this->getfrec("shares", "SUM(amount) as shares", "", "", "");
		return !empty($result) ? $result['shares'] : false;
	}
	public function totalActiveLoans(){
		return $this->count("loan", "active=1");
	}
}
?>