<html>
    <style>
        input[type=text], select {
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
        }
        
        input[type=submit] {
          width: 100%;
          background-color: #4CAF50;
          color: white;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }
        
        input[type=submit]:hover {
          background-color: #45a049;
        }
        
        div {
          border-radius: 5px;
          background-color: #f2f2f2;
          padding: 20px;
        }
        </style>
<body>
    <h3>update article</h3>
    <div>
    <form action="save.php" method="post">
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

$sql = "SELECT * FROM boutique where id=".$_REQUEST["id"];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  $row = $result->fetch_assoc();
  echo "<label> id</label>";
  echo "<input value='" . $row["id"]. "' type='text' name='id' >";
  echo "<label > Name</label>";
  echo "<input type='text' name='name' value='" . $row["name"]. "'>";
  echo "<label>price</label>";
  echo "<input type='text'  name='price' value='" . $row["price"]."' >";
  echo "<label >quantity</label>";
  echo "<input type='text' name='quantity' value='". $row["quantity"]. "'>";
} else {
  echo "0 results";
}
?>
  <input type="submit" value="Submit">
    </form>
  </div>



</body>
</html>