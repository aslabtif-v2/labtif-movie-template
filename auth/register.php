<?php

require_once "config.php";

class Register{
    public $mysqli;

    function __construct(){
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    function register(){
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];

        if(empty($user) || empty($pass) || empty($email)){
            echo "<script>alert('Input tidak boleh kosong');</script>";
        }else{
            $get_user = "SELECT * FROM users WHERE email = '$email'";
            $result = $this->mysqli->query($get_user);
            $check_user = $result->num_rows;

            if($check_user == 1){
                echo "<script>alert('Email sudah tersedia');</script>";
            }else{
                $pass = password_hash($pass, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, password,email) VALUES ('" .$user."','". $pass."','".$email."')";
                $query = $this->mysqli->prepare($sql) or die($this->mysqli->error);
                $query->execute();

                if($query){
                    header("location:loginForm.php");
                }else{
                    echo "<script>alert('Register gagal');</script>";
                }
    
            }
        }
    }
}
