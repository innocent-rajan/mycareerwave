<?php
	
include 'constants.php';

$username = $password = $gender = $first_name = $last_name = $school = $address = $phone = $email = $dob="";
	//if($_SERVER["REQUEST_METHOD"]=="POST"){
		
		$username="rajangirsa";
		$sql="SELECT * FROM login WHERE username = '$username' ";
				$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
		    	$username = $row["username"];
		    	$password = $row["password"];
		    	$first_name = $row["first_name"];
		    	$last_name = $row["last_name"];
		    	$email = $row["email"];
		    	$gender = $row["gender"];
		    }
		}
		$sql="SELECT * FROM profile WHERE username = '$username' ";
				$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
		    	$gender = $row["gender"];
		    	$dob= $row["dob"];
		    	$school = $row["$school"];
		    	$address = $row["address"];
		    	$phone = $row["phone"];
		   	}
		} else {
		    echo "Details not found.";
		}
	
		echo $username." ".$password." ".$first_name." ".$last_name." ".$email." ".$gender." ".$dob." ".$school." ".$address." ".$phone."<br>";

	$db->close();

?>