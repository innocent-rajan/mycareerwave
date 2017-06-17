<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<style type="text/css">
	.required{
		color: red;
		display: inline-block;
	}
	</style>
	<script type="text/javascript">
	function pass_check(){
		var pass= document.register.password.value;
		var con_pass= document.register.confirm_password.value;
		if(pass.length != 6){
			document.getElementById("password").style="visibility:visible;display: inline-block;color: red;";
			document.getElementById("password").innerHTML="Length of password must be greater than 6."
			document.register.password.focus();
			return false;
		}
		if(pass != con_pass){
			document.getElementById("password").style="visibility:visible;display: inline-block;color: red;";
			document.getElementById("password").innerHTML="Pasword didn't match."
			document.register.password.focus();
			return false;	
		}
	}

	function display(){
		document.getElementById("password").style="visibility: hidden;display: inline-block;color: red;";
	}

</script>
</head>
<body>
<h1>Register</h1>
<div class="required">*</div> Required Field<br><br>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="register" onsubmit="return pass_check()">
		First Name: <input type="text" name="first_name" required><div class="required">*</div><br><br>
		Last Name: <input type="text" name="last_name" required><div class="required">*</div><br><br>
		Username: <input type="text" name="username" required><div class="required">*</div><br><br>
		Gender: <input type="radio" name="gender" value="Male">Male
		<input type="radio" name="gender" value="Female">Female<br><br>
		Email: <input type="email" name="email" required><div class="required">*</div><br><br>
		Password: <input type="password" name="password" required onclick="display()"><div class="required">*</div><div style="display: inline-block;color: red;visibility: hidden;" id="password"> </div><br><br>
		Confirm Password: <input type="password" name="confirm_password" required><div class="required"> *</div><br><br>
		<button>Submit</button>
	</form>

<?php

include 'constants.php';
	
	$flag=1;
	$nameErr = $emailErr = $genderErr = $websiteErr = "";
	$first_name = $last_name = $username = $email = $password = $confirm_password =$gender = "";

	$first_name = test_input($_POST["first_name"]);
	$last_name = test_input($_POST["last_name"]);
	$username = test_input($_POST["username"]);
	$email = test_input($_POST["email"]);
	$password = test_input($_POST["password"]);
	$confirm_password = test_input($_POST["confirm_password"]);
	$gender = test_input($_POST["gender"]);

	if(!empty($first_name)){
		$sql="SELECT * FROM login WHERE username = '$username'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    echo "Username already taken. Please choose some other username."."<br>";
		    $flag=1;
		} else {
		    $flag=0;
		}
	}

	if($flag==0){
		$password=md5($password);
		$sql="INSERT INTO login (first_name, last_name, username, gender, password, email) VALUES ('$first_name', '$last_name', '$username', '$gender', '$password', '$email')";
		if ($conn->query($sql) === TRUE) {
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$sql="INSERT INTO profile (username) VALUES ('$username')";
		if ($conn->query($sql) === TRUE) {
		    header("Location: success.php");
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}	

	$db->close();

	function test_input($data){
		$data=trim($data);
		$data=stripcslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
?>
</body>
</html>