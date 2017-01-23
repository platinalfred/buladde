<?php 
require_once("lib/Db.php");
$db = new Db();
if(isset($_POST)){
	$data = array();
	if($db->getLogin($_POST['username'], $_POST['password'])){
		$data['message'] = "success";
		$data['access_level'] = $_SESSION['access_level'];
	}else{
		$data['message'] = "Incorrect Username/Password.";
	}
	echo json_encode($data);
}
?>