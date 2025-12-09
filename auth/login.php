<?php

require_once "../database.php";

class Login
{
	public $mysqli;

	function __construct()
	{
		$this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		session_start();

		$this->check_login();
	}

	function check_login()
	{
		if (isset($_POST['login'])) {
			$email = $_POST['email'];
			$pass = $_POST['password'];

			if (empty($email) || empty($pass)) {
				echo "<script>alert('Username or Password cannot be empty');</script>";
			} else {

				$sql = "SELECT * FROM user where email = '$email'";
				$result = $this->mysqli->query($sql);
				$check_user = $result->num_rows;

				if ($check_user == 1) {
					$row = $result->fetch_row();

					if (password_verify($pass, $row[1])) {
						$_SESSION['email'] = $email;
						header("location:../index.php");
					} else {
						echo "<script>alert('Email or Password is invalid');</script>";
					}
				} else {
					echo "<script>alert('Email tidak terdaftar');</script>";
				}	
			}
		} 
	}
}
