<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhmtl1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
    <link rel="stylesheet" href="CSS.css">
    <script type="text/javascript" src="JavaScript.JS"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>

<body>

<a class = "Return" href = "Index.php">Return To Login Page</a>

<?php
//start of php section
include('header.php');
session_start();

if(!isset($_SESSION['admin_validation']))
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

if ( isset($_POST['ISBN']) && isset($_POST['booktitle']) && isset($_POST['author']) && isset($_POST['edition']) && isset($_POST['year']) && isset($_POST['category']))
{
    $ISBN = $_POST['ISBN'];
    $booktitle = $_POST['booktitle'];
    $author = $_POST['author'];
    $edition = $_POST['year'];
    $year = $_POST['year'];
    $category = $_POST['category'];
    $reserve = 'N';

    $sql = " INSERT INTO books (ISBN, BookTitle, Author, Edition, Year, Category, Reserved) VALUES ('$ISBN', '$booktitle', '$author', '$edition', '$year', '$category', '$reserve')";

    if ($conn->query($sql) === TRUE)
    {
        echo "<script>alert('Book has been added successfully')</script>";
        header("Location: http://localhost/WebD/Assignment/Admin.php");
    }
    else
    {
        echo "ERROR: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

if( isset($_POST['genre']))
{
    $genre = $_POST['genre'];

    $sql = "INSERT INTO category (Genre) VALUES ('$genre')";

    if ($conn->query($sql) === TRUE)
    {
        echo "<script>alert('Category has been added successfully')</script>";
        header("Location: http://localhost/WebD/Assignment/Admin.php");
    }
    else
    {
        echo "ERROR: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

//end of php section
?>

<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'AddBook')">Add Book</button>
    <button class="tablinks" onclick="openTab(event, 'AddCategory')">Add Category</button>
    <button class="tablinks" onclick="openTab(event, 'ViewAllBooks')">View All Books</button>
    <button class="tablinks" onclick="openTab(event, 'ViewAllCategory')">View All Catagories</button>
    <button class="tablinks" onclick="openTab(event, 'ViewAllUser')">View All Users</button>
</div>


<div id="AddBook" class="tabcontent">
    <h3>Add Book</h3>

    <form method="post">
    <div>
        <label for="ISBN"><b>ISBN</b></label>
        <input type="text" placeholder="Enter ISBN" name="ISBN" required>
        <br>
        <label for="booktitle"><b>Book Title</b></label>
        <input type="text" placeholder="Enter Book" name="booktitle" required>
        <br>
        <label for="author"><b>Author</b></label>
        <input type="text" placeholder="Enter Author" name="author" required>
        <br>
        <label for="edition"><b>Edition</b></label>
        <input type="text" maxlength="1" placeholder="Enter Edition" name="edition" required>
        <br>
        <label for="year"><b>Year</b></label>
        <input type="text" maxlength="4" placeholder="Enter Year" name="year" required>
        <br>
        <label for="category"><b>Category</b></label>
        <input type="text" maxlength="3" placeholder="Enter Category" name="category" required>
        <br>
        <button class="Button" type="submit">Add</button>
    </div>
    </form>

</div>

<div id="AddCategory" class="tabcontent">
    <h3>Add Category</h3>

    <form method="post">
    <div>
        <label for=""><b>Category/Genre</b></label>
        <input type="text" placeholder="Enter Category/Genre" name="genre" required>
        <br>
        <button class="Button" type="submit">Add</button>
    </div>
    </form>

</div>

<div id="ViewAllBooks" class="tabcontent">
    <h3>View All Books</h3>

    <?php

    if (isset($_GET["page"])) 
    {    
        $page_number  = $_GET["page"];    
    }    
    else
    {    
        $page_number=1;    
    }

    $limit = 5;
    $initial_page = ($page_number-1)*$limit;

    $sql = "SELECT * FROM books";  

    // get the result
    $result = mysqli_query($conn,$sql);  
   
    $total_rows = mysqli_num_rows($result); 
   
    // get the required number of pages
    $total_pages = ceil ($total_rows / $limit);

    if (!isset ($_GET['page']) ) 
    {  
        $page_number = 1;  

    } 
    else 
    {  
        $page_number = $_GET['page'];  
    } 

    $sql = "SELECT * FROM books LIMIT " . $initial_page . ',' . $limit;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        // output data of each row
        while($row = $result->fetch_assoc()) 
        {
            echo "<div id = 'result'>";
                echo "ISBN: " . $row["ISBN"]. " - Book Title: " . $row["BookTitle"]. " - Author: " . $row["Author"]. " - Edition: " . $row["Edition"]. " - Year: " . $row["Year"]. " - Category: " . $row["Category"]. " Reserved: " . $row["Reserved"];
                echo "<form id = 'reserveform' method='post'>";
            echo "</div>";
        }
        for($page_number = 1; $page_number<= $total_pages; $page_number++) 
        {  
            echo '<a href = "Admin.php?page=' . $page_number . '">' . $page_number . ' </a>';  
        } 
    } 
    else 
    {
        echo "0 results";
    }
    ?>

</div>

<div id="ViewAllCategory" class="tabcontent">
    <h3>View All Categories</h3>

    <?php
    $sql = " SELECT * FROM category ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        // output data of each row
        while($row = $result->fetch_assoc()) 
        {
            echo "<div id = 'result'>";
                echo "Category ID: " . $row["Category"]. " - Genre: " . $row["Genre"];
                echo "<form id = 'reserveform' method='post'>";
            echo "</div>";
        }
    } 
    else 
    {
        echo "0 results";
    }
    ?>

</div>

<div id="ViewAllUser" class="tabcontent">
    <h3>View All Users</h3>

    <?php
    $sql = " SELECT * FROM user ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        // output data of each row
        while($row = $result->fetch_assoc()) 
        {
            echo "<div id = 'result'>";
                echo "Username: " . $row["username"]. " - First Name: " . $row["firstname"]. " - Last Name: " . $row["firstname"];
                echo "<form id = 'reserveform' method='post'>";
            echo "</div>";
        }
    } 
    else 
    {
        echo "0 results";
    }
    ?>

</div>

<?php
    include('footer.php');
?>

</body>

</html>