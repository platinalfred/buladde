<?php 
require_once("lib/Person.php");
require_once("lib/SimpleImage.php");
$person = new Person();
$images = new SimpleImage();
$msg = "";
if(isset($_POST['photo_upload'])){
	if ($_FILES['photograph']['error'] > 0) {
		if($_FILES['photograph']['error'] = UPLOAD_ERR_INI_SIZE){
			echo 'The uploaded file exceeds the upload_max_filesize directive by the server.';
		}
		$msg =  "Error: " . $_FILES['photograph']['error'] . "<br />";
	} else {
		$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "PNG", "GIF");
		$extension = end(explode(".", $_FILES["photograph"]["name"]));
		if((($_FILES["photograph"]["type"] = "image/gif") || ($_FILES["photograph"]["type"] == "image/jpeg") || ($_FILES["photograph"]["type"] == "image/jpg") || ($_FILES["photograph"]["type"] == "image/pjpeg") || ($_FILES["photograph"]["type"] == "image/x-png") || ($_FILES["photograph"]["type"] == "image/png"))	&& ($_FILES["photograph"]["size"] < 200000000) && in_array($extension, $allowedExts)){ 							
			if($_FILES["photograph"]["error"] > 0){
				$msg =  "Return Code: " . $_FILES["photograph"]["error"] . "<br>";
			}else{
				$normal = 'img/profiles/'.$_FILES['photograph']['name'];
				if(file_exists($normal)){
					$msg =  $_FILES["photograph"]["name"] . " already exists. ";
				}else{		
					$data['photograph'] = $normal;
					$data['id'] = $_POST['person_number'];
					$images->load($_FILES['photograph']['tmp_name']);
					$images->resize(131, 120); 
					$images->output($_FILES["photograph"]["type"]);
					$images->save('img/profiles/'.$_FILES['photograph']['name']);
					//if(move_uploaded_file($_FILES['photograph']['tmp_name'], 'img/profiles/'.$_FILES['photograph']['name'])){
						if($person->updateImage($data)){					
							 $msg =  'success';
						}else{
							$msg =  "Oooooops!! there was an error! ";
						}
					/* }else{
						$msg = "File can not be uploaded.";
					} */
					
				}
			}
		} 
		
	}
}
echo $msg;
?>