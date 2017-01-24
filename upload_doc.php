<?php 
require_once("lib/Loans.php");
$loans = new Loans();
$msg = "";
if(isset($_POST['add_document'])){
	$allowedExts = array("docx", "doc", "wpd","pdf", "xlsx", "xls", "txt", "csv","gif", "jpeg", "jpg", "png", "JPG", "PNG", "GIF");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if (($_FILES["file"]["size"] < 30000000)
	&& in_array($extension, $allowedExts)){
		$path = "docs/".$_FILES["file"]["name"];
		if (file_exists("docs/" . $_FILES["file"]["name"])){
			$msg =  $_FILES["file"]["name"] . " already exists. ";
		}else{
			if(move_uploaded_file($_FILES['file']['tmp_name'], "docs/".basename($_FILES["file"]["name"]))){
				$_POST['doc_path'] = $path;
				if($loans->addLoanDocument($_POST)){
					$msg =  "success";
					
				}else{
					$msg =  "Failed to add document.";
				} 
			}else{
				$msg = "File failed to upload";
			}
		}

	}else{
		$msg = "File is of a wrong format or its too big to be uploaded.";
	}
} 
echo $msg;
?>