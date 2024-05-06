<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "islem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id       = $_POST["id"];
$name     = $_POST["name"];
$price    = $_POST["price"];
$quantity = $_POST["quantity"]; 

$sql= "UPDATE boutique SET name='$name' , price=$price , quantity=$quantity where id=$id ";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";

} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>