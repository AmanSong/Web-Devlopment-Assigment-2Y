<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhmtl1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
    <link rel="stylesheet" href="CSS.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>

<a class = "Return" href = "Index.php">Return To Login Page</a>

<?php
    include('header.php');
?>

<h2> Register </h2>

<form method="post">

    <div class="container">
        <label for="username"><b>Username</b></label>
        <input type="text" name="username" required>
        <br>
        <label for="firstname"><b>Firstname</b></label>
        <input type="text" name="firstname" required>
        <br>
        <label for="surname"><b>Surname</b></label>
        <input type="text" name="surname" required>
        <br>
        <label for="addressline1"><b>Address Line 1</b></label>
        <input type="text" name="addressline1" required>
        <br>
        <label for="addressline2"><b>Address Line 2</b></label>
        <input type="text" name="addressline2" required>
        <br>
        <label for="city"><b>City</b></label>
        <input type="text" name="city" required>
        <br>
        <label for="mobile"><b>Mobile</b></label>
        <input type="text" pattern="[0-9]{9}" maxlength="9" name="mobile" required>
        <br>
        <label for="password"><b>Password</b></label>
        <input type="password" name="password" required>
        <br>
        <label for="checkpassword"><b>Re-Enter Password</b></label>
        <input type="password" name="checkpassword" required>
        <br>
        <button class="Button" type="submit">Register</button>
    </div>

</form>

</body>

<?php
//start of php
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

if ( isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['surname']) && isset($_POST['addressline1']) && isset($_POST['addressline2']) && isset($_POST['city']) && isset($_POST['mobile']) && isset($_POST['password']) && isset($_POST['checkpassword']))
{
    $username = $_POST['username'];

    $firstname = $_POST['firstname'];
    //Make it so names with special characters like ' is allowed
    $firstname_escape = mysqli_real_escape_string($conn, $firstname);

    $surname = $_POST['surname'];
    //Make it so names with special characters like ' is allowed
    $surname_escape = mysqli_real_escape_string($conn, $surname);

    $addressline1 = $_POST['addressline1'];
    $addressline2 = $_POST['addressline2'];
    $city = $_POST['city'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    //get passwords length
    $password_length = strlen($password);
    $checkpassword = $_POST['checkpassword'];

    $sql = " SELECT username FROM user WHERE username = '$username'";
    $check = $conn->query($sql);

    if(mysqli_num_rows($check) > 0)
    {
        $unique = 'No';
    }
    else
    {
        $unique = 'Yes';
    }

    if ($password == $checkpassword && $unique == 'Yes' && $password_length >= 6)
    {
        $sql = "INSERT INTO user VALUES ('$username', '$firstname_escape', '$surname_escape', '$addressline1', '$addressline2', '$city', '$mobile', '$password')";

        if ($conn->query($sql) === TRUE)
        {
            header("Location: http://localhost/WebD/Assignment/Index.php");
            exit();
        }
        else
        {
            echo "ERROR: " . $sql . "<br>" . $conn->error;
        }
    }
    else
    {
        echo "<script type='text/javascript'>alert('Username has been taken, Passwords do not match or Password too short!');</script>";
    }

    $conn->close();
}

//end of php
?>

<?php
    include('footer.php');
?>

</html>