<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
<h1>Login</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="login" method="POST">
	<input type="username" name="username">
	<input type="password" name="password">
	<button>Submit</button>
</form>

<?php

include 'constants.php';
	
	$username = $password = "";
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$username = test_input($_POST['username']);
		$password = test_input($_POST['password']);

		$password=md5($password);

		$sql="SELECT * FROM login WHERE username = '$username' and password = '$password'";	
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
		        echo "Reg_no: " . $row["reg_no"]. " - Username: " . $row["username"]. " Email: " . $row["email"]. "<br>";
		    }
		} else {
		    echo "0 results";
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