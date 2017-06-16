<?php

	require_once '../includes/DbOperations.php';

	$response = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){

		if(isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['email_address']) and isset($_POST['username']) and isset($_POST['password'])){

			$db = new DbOperations();
			if($db->createUser($_POST['first_name'], $_POST['last_name'], $_POST['email_address'], $_POST['username'], $_POST['password'])){

				$response['error'] = false;
				$repsonse['message'] = "user registered successfully";
			}
			else{
				
				$response['error']= true;
				$response['message']= "ERROR : Try Again!"; 
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