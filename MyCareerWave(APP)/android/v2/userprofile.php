<?php

	require_once '../includes1/DbOperations.php';

	$response = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){

		if(isset($_POST['Address']) and isset($_POST['Gender']) and isset($_POST['Dob']) and isset($_POST['School']) and isset($_POST['Phone'])){

			$db = new DbOperations();

			$result = $db->update_profile($_POST['Address'], $_POST['Gender'], $_POST['Phone'], $_POST['School'], $_POST['Dob']);

			if($result == 1){
				$response['error']= false;
				$response['message']= "Profile Updated";
			}
			else{
				$response['error']= true;
				$response['message']= "ERROR: FAILED TO UPDATE";
			}
		}
	
		
		else{

			$response['error']= true;
			$response['message']= "Invalid Request"; 
		}

		echo json_encode($response);

	}
?>	
