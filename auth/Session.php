<?php

require_once "config.php";

class Session
{
	public $mysqli;
	public $login_user;

	function __construct()
	{
		session_start();
		$this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$this->check_session();
		$this->logout();
	}

	function check_session()
	{
		$user_check = $_SESSION['email'];

		$ses_sql = "SELECT * FROM users where email='$user_check'";
		$query = $this->mysqli->query($ses_sql);
		$row = $query->fetch_row();

		$this->login_user = $row[2];

		if (!isset($user_check)) {
			header("location: loginForm.php");
		}
	}

	function logout(){
		if (isset($_POST['logout'])) {
			session_destroy();
			header("location:loginForm.php");
		}
	}
}
