<?php
//Authorization- Access Control
//Check wheather the user is loggedin or not
if(!isset($_SESSION['user']))//IF USER session is not set
{
//user is not set
//redirect to login page with message
$_SESSION['no-login-message']="<div class='error text-center'>Please login to access Admin Panel.</div>";
//Redirect to login page
header('location:'.SITEURL.'admin/login.php');
}

?>