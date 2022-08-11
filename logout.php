<?php 

session_start();

if(!$_SESSION['cedu']) {
	header('location: index.php');	
} 

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 

header('location: https://localhost/template/login.php');

?>