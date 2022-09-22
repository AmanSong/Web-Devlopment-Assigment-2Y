<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhmtl1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
    <link rel="stylesheet" href="CSS.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Library</title>
</head>

<body>

<?php
//connection
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
//end of php
?>

<a class = "Return" href = "Logout.php">Log Out?</a>

<a id = 'ViewReserve' href = "Reservation.php">View Reserve</a>

<form id= "search" method="post">

    <div>
        <label for="search"><b>Please search for a book by name/author</b></label>
        <input type="text" name="search" required>
        <br>
    </div>
    <button class="Button" type="submit">Search</button>

</form>

<form id = "search" method = "post">
    <div>
        <select id = 'ChooseGenre' name = 'Genre'>
        <option value="Select">Search by Category</option>
        <?php
            $sql = "SELECT Genre FROM category";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc())
            {
                echo '<option value = "'. $row['Genre']. '">'.$row['Genre'].'</option>'; 
            }
        ?>
        </select>
    </div>
    <button class="Button" type="submit">Search</button>
</form>

<div class = "display">
<?php

if(!isset($_SESSION['validation']))
{
    header("Location: http://localhost/WebD/Assignment/Index.php");
    exit();
}

if( isset($_POST['search']))
{
    $search = $_POST['search'];

    $sql = " SELECT * FROM books WHERE BookTitle LIKE '%$search%' OR Author LIKE '%$search%' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        $reserve;

        // output data of each row
        while($row = $result->fetch_assoc()) 
        {
            echo "<div id = 'result'>";
                echo "ISBN: " . $row["ISBN"]. " - Book Title: " . $row["BookTitle"]. " - Author: " . $row["Author"]. " - Edition: " . $row["Edition"]. " - Year: " . $row["Year"]. " - Category: " . $row["Category"]. " Reserved: " . $row["Reserved"];
                $reserve = $row["ISBN"];
                echo "<form id = 'reserveform' method='post'>";
                echo "<button name = 'Reserve' type = 'submit' id = 'reservebutton' value = '$reserve'>Reserve</button>";
                echo "</form>";
            echo "</div>";
        }
    } 
    else 
    {
        echo "0 results";
    }

    $conn->close();
}

if( isset($_POST['Genre']))
{
    $genre = $_POST['Genre'];
    
    $sql = "SELECT * FROM books JOIN category ON books.Category = category.Category WHERE category.Genre = '$genre'";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc()) 
        {
            echo "<div id = 'result'>";
                echo "ISBN: " . $row["ISBN"]. " - Book Title: " . $row["BookTitle"]. " - Author: " . $row["Author"]. " - Edition: " . $row["Edition"]. " - Year: " . $row["Year"]. " - Category: " . $row["Category"]. " Reserved: " . $row["Reserved"];
                $reserve = $row["ISBN"];
                echo "<form id = 'reserveform' method='post'>";
                echo "<button name = 'Reserve' type = 'submit' id = 'reservebutton' value = '$reserve'>Reserve</button>";
                echo "</form>";
            echo "</div>";
        }
    }

    $conn->close();
}

if( isset($_POST['Reserve']))
{
    $reserve = $_POST['Reserve'];

    //create session
    $_SESSION['ReserveBook'] = $reserve;

    $sql = " SELECT * FROM books WHERE ISBN = '$reserve'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();


    if ($row["Reserved"] == 'Y')
    {
        echo "<script>alert('Book is already reserved!')</script>";
    }
    else
    {
        $Username = $_SESSION['Username'];
        $ISBN = $_SESSION['ReserveBook'];
        $ReservedDate = date('y-m-d');
        
        if(isset($Username) && isset($ISBN) && isset($ReservedDate))
        {
            $sql = " INSERT INTO reservations (ISBN, Username, Date) VALUES ('$ISBN', '$Username', '$ReservedDate')";
        
            if($conn->query($sql) === TRUE)
            {
            }
        }

        $sql = " UPDATE books SET Reserved = 'Y' WHERE ISBN = '$reserve' ";

        if ($conn->query($sql) === TRUE)
        {
            echo "<script>alert('Book has been reserved successfully')</script>";
        }
        else
        {
            echo "ERROR: " . $sql . "<br>" . $conn->error;
        }
    }

}

//end of php section
?>
</div>

<?php
    include('footer.php');
?>

</body>

</html>