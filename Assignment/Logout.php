<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhmtl1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
    <title>Log Out</title>
</head>

<body>

<?php
//start of php section
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

//create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}


$Username = $_SESSION['Username'];
$ISBN = $_SESSION['ReserveBook'];
unset($_SESSION['validation']);
unset($_SESSION['admin_validation']);

//wipe username and ISBN book
$Username = NULL;
$ISBN - NULL;

//send user back to Login page
header("Location: http://localhost/WebD/Assignment/Index.php");
exit();

//end of php section
?> 


</body>

</html>