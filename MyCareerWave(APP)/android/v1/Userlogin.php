<?php
require_once '../includes/DbOperations.php';

	$response = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if (isset($_POST['username']) AND isset($_POST['password'])){

			if($db->userLogin($_POST['username'], $_POST['password'])){

				$user = $db->getUserByUsername($_POST['username']);
				$response['error']= false;
				$response['id']= $user['id']; 
				$response['email_address'= $user['email_address'];
				$response['username']= $user['username'];
			}
			else{
				$response['error']= true;
				$response['message']= "ERROR : Invalid Username Or Password"; 	
			}
		}
		else{
			$response['error']= true;
			$response['message']= "ERROR : Required Fields Are Missing!"; 	
		}
	}
	echo json_encode($response);
?>