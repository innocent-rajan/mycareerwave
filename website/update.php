<!DOCTYPE html>
<html>
<head>
	<title>Update Profile</title>
</head>
<body>

<button onclick="show_edit()">Edit Profile</button><br><br>

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
	
		echo "First Name: ".$first_name."<br>Last Name: ".$last_name."<br>Username: ".$username."<br>Gender: ".$gender."<br>Email: ".$email."<br>Date of Birth: ".$dob."<br>School: ".$school."<br>Address: ".$address."<br>Phone number: ".$phone;

	$db->close();
?>

<script type="text/javascript">
	function show_edit(){
		
	}
</script>
</body>
</html>