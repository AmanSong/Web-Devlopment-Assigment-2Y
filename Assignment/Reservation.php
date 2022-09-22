<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhmtl1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
    <link rel="stylesheet" href="CSS.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
</head>

<body>

<a class = "Return" href = "BookLibrary.php">Return</a>

<?php
//start of php section
include('header.php');
session_start();

if(!isset($_SESSION['validation']))
{
    header("Location: http://localhost/WebD/Assignment/Index.php");
    exit();
}

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

//end of php section
?> 

<div class = "display">
<?php

$Username = $_SESSION['Username'];

$sql = " SELECT * FROM reservations JOIN books ON reservations.ISBN = books.ISBN WHERE reservations.Username = '$Username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    // output data of each row
    while($row = $result->fetch_assoc()) 
    {
        echo "ISBN: " . $row["ISBN"]. " - Book Title: " .$row["BookTitle"]. " - User Name: " . $row["Username"]. " - Date: " . $row["Date"]. "<br>";
        $remove = $row["ISBN"];
        echo "<form id = 'remove' method='post'>";
        echo "<button name = 'Remove' type = 'submit' class = 'Button' value = '$remove'>Remove</button>";
        echo "</form>";
    }
} 
else 
{
    echo "0 results";
}

if( isset($_POST['Remove']))
{
    $remove = $_POST['Remove'];
    $sql = " DELETE FROM reservations WHERE ISBN = '$remove'";
    $sql2 = "UPDATE books SET Reserved = 'N' WHERE ISBN = '$remove'";

    if($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE)
    {
        
    }
    else
    {
        echo "<script>Failed to Remove</script>";
    }
}

?>
</div>

<?php
    include('footer.php');
?>

</body>

</html>