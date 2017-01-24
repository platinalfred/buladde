<?php
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
	if($staff->deleteMember($_GET['id'])){
		echo "success";
	}else{
		echo "fail";
	}
}
?>