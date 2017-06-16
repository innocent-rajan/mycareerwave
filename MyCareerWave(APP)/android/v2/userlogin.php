<?php
require_once '../includes1/DbOperations.php';

	$response = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if (isset($_POST['Username']) and isset($_POST['Password'])){
			$db= new DbOperations();
			if($db->userLogin($_POST['Username'], $_POST['Password'])){
				$user = $db->getUserByUsername($_POST['Username']);
				$response['error']= false;
				$response['id']= $user['id']; 
				$response['Email']= $user['Email'];
				$response['Username']= $user['Username'];
				$response['First_name']= $user['First_name'];
				$response['Last_name']= $user['Last_name'];
			}
			else{
				$response['error']= true;
				$response['message']= "ERROR : Invalid Username Or Password";
				echo json_encode($response);
			}
		}
		else{
			$response['error']= true;
			$response['message']= "ERROR : Required Fields Are Missing!"; 	
		}
	}
	echo json_encode($response);
?>