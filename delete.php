<?php
require_once("lib/Db.php");
$db = new Db();
if($_GET['tbl'] == "staff"){
	require_once("lib/Staff.php");
	$staff = new Staff();
	if($staff->deleteStaff($_GET['id'])){
		echo "success";
	}else{
		echo "fail";
	}
}elseif($_GET['tbl'] == "member"){ 
	require_once("lib/Member.php");
	$member = new Member();
	if($member->deleteMember($_GET['id'])){
		echo "success";
	}else{
		echo "fail";
	}
}elseif($_GET['tbl'] == "member_types"){ 
	if($db->del("membertype", "id=".$_GET['id'])){
		echo "success";
	}else{
		echo "fail";
	}
}elseif($_GET['tbl'] == "expensetypes"){ 
	if($db->del("expensetypes", "id=".$_GET['id'])){
		echo "success";
	}else{
		echo "fail";
	}
}elseif($_GET['tbl'] == "securitytypes"){ 
	if($db->del("securitytype", "id=".$_GET['id'])){
		echo "success";
	}else{
		echo "fail";
	}
}elseif($_GET['tbl'] == "branches"){ 
	if($db->del("branch", "id=".$_GET['id'])){
		echo "success";
	}else{
		echo "fail";
	}
}elseif($_GET['tbl'] == "incomesources"){ 
	if($db->del("income_sources", "id=".$_GET['id'])){
		echo "success";
	}else{
		echo "fail";
	}
}elseif($_GET['tbl'] == "loantypes"){ 
	if($db->del("loan_type", "id=".$_GET['id'])){
		echo "success";
	}else{
		echo "fail";
	}
}
?>