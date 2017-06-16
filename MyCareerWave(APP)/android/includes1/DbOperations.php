<?php
	
	class DbOperations{
		private $con;
		function __construct(){

			require_once 'DbConnect.php';
			$db = new DbConnect();
			$this->con = $db->connect();
		
		}

		
		public function createUser($First_name, $Last_name, $Email, $Username, $pass){
			
			if($this-> isUserExist($Username, $Email)){

				return 0;
			}
			else{
				$Email=trim($Email);
				$Email=stripcslashes($Email);
				$Email=htmlspecialchars($Email);
				
				if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
				  	$EmailErr = "Invalid email format";
				  	return 3; 
				}
				$Password = md5($pass);
				$x = $this->con->prepare("INSERT INTO `userlogin` (`id`, `First_name`, `Last_name`, `Email`, `Username`, `Password`) VALUES (NULL, ?, ?, ?, ?, ?);");
				$x->bind_param("sssss", $First_name, $Last_name, $Email, $Username, $Password);

				$x = $this->con->prepare("INSERT INTO `profile` (`Username`) VALUES (?);");
				$x->bind_param("s", $Username);
				

				if($x->execute()){

					return 1;
				}
				else{

					return 2;
				}
			}
		}

		function update_profile($Gender, $Address, $Phone, $School, $Dob, $Username){
			$x = $this->con->prepare("UPDATE profile SET Gender='$Gender', Address='$Address', Phone='$Phone', School='$School', Dob='$Dob' WHERE Username='$Username');");
			$x->bind_param("sssss", $Gender, $Address, $Dob, $School, $Phone);

			if($x->execute()){
				return 1;
			}
			else{
				return 0;
			}
		}



		public function userLogin($Username, $pass){

			$Password = md5($pass);
			$z = $this->con->prepare("SELECT id FROM userlogin WHERE Username=? AND Password=?");
			$z->bind_param("ss", $Username, $Password);
			$z->execute();
			$z->store_result();
			return $z->num_rows>0;

		}

		public function getUserByUsername($Username){
			$x=$this->con->prepare("SELECT * FROM userlogin WHERE Username=?");
			$x->bind_param("s", $Username);
			$x->execute();
			return $x->get_result()->fetch_assoc();
		}

		private function isUserExist($Username, $Email){

			$y = $this->con->prepare("SELECT id FROM userlogin WHERE Username=? OR Email=?");
			$y->bind_param ("ss", $Username, $Email);
			$y->execute();
			$y->store_result();
			return $y->num_rows>0;
		}
	}
?>