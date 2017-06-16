<?php

	require_once '../includes1/DbOperations.php';

	$response = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){

		if(isset($_POST['First_name']) and isset($_POST['Last_name']) and isset($_POST['Email']) and isset($_POST['Username']) and isset($_POST['Password'])){

			$db = new DbOperations();



			$result = $db->createUser($_POST['First_name'], $_POST['Last_name'], $_POST['Email'], $_POST['Username'], $_POST['Password']);

			if($result == 1){
				$response['error']= false;
				$response['message']= "Registered Successfully.";
			}
			elseif($result == 2){			
				$response['error']= true;
				$response['message']= "ERROR : Try Again!";
			}
			elseif($result == 0){
				$response['error']= true;
				$response['message']="ERROR: Username or Email already registered ";
			}
			elseif($result ==3){
				$response['error']= true;
				$response['message']="ERROR: Invalid email format";
			}

			
		}
		else{
			$response['error']= true;
			$response['message']= "Required Fields are missing";
		}
	}
	else{

		$response['error']= true;
		$response['message']= "Invalid Request"; 
	}

	echo json_encode($response);
?>	