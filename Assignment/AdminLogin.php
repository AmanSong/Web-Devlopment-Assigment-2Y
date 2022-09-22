<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhmtl1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
    <link rel="stylesheet" href="CSS.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>

<body>

<a class = "Return" href = "Index.php">Return To Login Page</a>

<?php
//start of php section
include('header.php');
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labdb";

//create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['username']) && isset($_POST['password']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == "Admin" && $password == "Database")
    {
        echo "<script>alert('Login Successful!')</script>";

        $_SESSION['admin_validation'] = TRUE;

        //redirect library database
        header("Location: http://localhost/WebD/Assignment/Admin.php");
        exit();
    }
    else
    {
        echo "<script>alert('Wrong information entered')</script>";
    }
}

//end of php section
?>

<h2> Admin Login </h2>

<form method="post" class = "formlogin">

    <div>
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required>
        <br>
        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>
        <br>
        <button class="Button" type="submit">Login</button>
    </div>

</form>

<?php
    include('footer.php');
?>

</body>

</html>