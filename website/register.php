<?php

include 'constants.php';
	
	$nameErr = $emailErr = $genderErr = $websiteErr = "";
	$first_name = $last_name = $username = $email = $password = $confirm_password =$gender = "";

	$first_name = test_input($_POST["first_name"]);
	$last_name = test_input($_POST["last_name"]);
	$username = test_input($_POST["username"]);
	$email = test_input($_POST["email"]);
	$password = test_input($_POST["password"]);
	$confirm_password = test_input($_POST["confirm_password"]);
	$gender = test_input($_POST["gender"]);
	if($flag==0){
		$password=md5($password);
		$sql="INSERT INTO login (first_name, last_name, username, gender, password, email) VALUES ('$first_name', '$last_name', '$username', '$gender', '$password', '$email')";
		if ($conn->query($sql) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	else
		echo "Wrong method";

	function test_input($data){
		$data=trim($data);
		$data=stripcslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
?>