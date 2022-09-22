<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhmtl1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
    <link rel="stylesheet" href="CSS.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

<?php
//start of php section
include('header.php');
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

if(isset($_POST['username']) && isset($_POST['password']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    //create sessions
    $_SESSION['Username'] = $username;

    $sql1 = "SELECT username FROM user WHERE username = '$username'";
    $login1 = $conn->query($sql1);

    $sql2 = "SELECT password FROM user WHERE password = '$password'";
    $login2 = $conn->query($sql2);

    if(mysqli_num_rows($login1) > 0 && mysqli_num_rows($login2) > 0)
    {
        echo "<script>alert('Login Successful!')</script>";

        $_SESSION['validation'] = TRUE;

        //redirect to library page
        header("Location: http://localhost/WebD/Assignment/BookLibrary.php");
        exit();
    }
    else
    {
        echo "<script>alert('Username or Password is incorrect')</script>";
    }
}

//end of php section
?> 

<h2> Login </h2>

<form method="post" class = "formlogin">
    <a href = "Register.php">Register</a>
    <a id = "adminbutton" href = "AdminLogin.php">Admin Login</a>

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

</body>

<?php
    include('footer.php');
?>

</html>