<?php
	
	class DbOperations{
		private $con;
		function __construct(){

			require_once 'DbConnect.php';
			$db = new DbConnect();
			$this->con = $db->connect();
		}

		public function createUser($first_name, $last_name, $email_address, $username, $pass){

			if(this->isUserExist($username, $email_address)){

				return 0;
			}

			else{	
				$password = md5($pass);
				$x = $this->con->prepare("INSERT INTO `login` (`id`, `first_name`, `last_name`, `email_address`, `username`, `password`) VALUES (NULL, ?, ?, ?, ?, ?);");
				$x->bind_param("sssss", $first_name, $last_name, $email_address, $username, $password);
				if($x->execute()){

					return 1;
				}
				else{

					return 2;
				}
			}
		}

		public function userLogin($username, $pass){

			$password = md5(password);
			$z = $this->con->prepare("SELECT id FROM login WHERE username=? AND password=?");
			$z->bind_param("ss", $username, $password);
			$z->execute();
			$z->store_result();
			return $z->num_rows>0;

		}

		public function getUserByUsername$username){
			$x=$this->con->prepare("SELECT * FROM login WHERE username=?");
			$x->bind_param("s", username);
			$x->execute();
			return $x->get_result()->fetch_assoc();
		}

		private function isUserExist($username, $email_address){

			$y = $this->con->prepare("SELECT id FROM login WHERE username=? OR email_address=?");
			$y->bind_param("ss", $username, $email_address);
			$y->execute();
			$y->store_result();
			return $y->num_rows>0;
		}


	}

?>