<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Document</title>
<style>
  a:link, a:visited {
  background-color: #f44336;
  color: white;
  padding: 14px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

a:hover, a:active {
  background-color: red;
}
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
<script>
  function ajaxDelete(id) {
    var xhttp   = new XMLHttpRequest();
    var element = document.getElementById(id);

    xhttp.open("POST", "ajaxDelete.php?id="+id, true);
    xhttp.send();
    
    element.remove();
  }
</script>
<script>
function ajaxInsert() {
// Récupérer les données du formulaire
var name     = document.getElementById('name').value;
var price    = document.getElementById('price').value;
var quantity = document.getElementById('quantity').value;

// Créer un objet XMLHttpRequest
var xhttp = new XMLHttpRequest();

// Définir la fonction de rappel pour gérer la réponse du serveur
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        // Gérer la réponse du serveur
        console.log(this.responseText);
    }
};

// Ouvrir une nouvelle requête POST vers le serveur
xhttp.open("POST", "ajaxInsert.php", true);

// Définir l'en-tête Content-Type pour les données envoyées
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

// Envoyer les données au serveur
xhttp.send("name=" + name + "&price=" + price + "&quantity=" + quantity);
}
</script>
<!--script update-->
<script>
 // Fonction ajaxUpdate pour envoyer une requête XMLHttpRequest GET
function ajaxUpdate(id) {
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Traiter la réponse du serveur
            var data = JSON.parse(this.responseText);
            // Afficher les données dans le modèle modal
            document.getElementById('name').value = data.name;
            document.getElementById('price').value = data.price;
            document.getElementById('quantity').value = data.quantity;
            // Afficher le modèle modal
            $('#UpdateModal').modal('show'); 
        }
    };
    xhttp.open("GET", "ajaxEdit.php?id=" + id, true);
    xhttp.send();
}
function Update(){

// Récupérer les données du formulaire
var name     = document.getElementById('name').value;
var price    = document.getElementById('price').value;
var quantity = document.getElementById('quantity').value;

  // Envoi des données modifiées au serveur via une requête AJAX
  var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Traiter la réponse du serveur si nécessaire
            console.log(this.responseText);
            
            // Fermer le modèle modal après avoir enregistré les modifications
            $('#myModal').modal('hide'); // Assurez-vous d'inclure jQuery et Bootstrap dans votre page
        }
    };
    xhttp.open("POST", "save.php", true); // Assurez-vous d'avoir un script PHP nommé "save_changes.php" pour traiter les modifications
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

// Envoyer les données au serveur
xhttp.send("name=" + name + "&price=" + price + "&quantity=" + quantity);
}



</script>
</head>
<body>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  insert
</button>
<table id="customers">
  <tr>
  <th>id</th>
    <th>name</th>
    <th>price</th>
    <th>quantity</th>
    <th>modifier et suprimer</th>
    <th>supprimer (ajax) </th>
  </tr>
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

$sql = "SELECT * FROM boutique";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo 
    "<tr id=" . $row["id"]. ">
      <td>" . $row["id"]. "</td>
      <td>" . $row["name"]. "</td>
      <td>" . $row["price"]."</td>
      <td>" . $row["quantity"]."</td>
      <td>
        <a href='edit.php?id=". $row["id"]."' style='background-color: blue;'>modifier</a>
        <a href='delete.php?id=". $row["id"]."'>suprimer</a>
      </td>
      <td>
      <button type='button' onclick='ajaxDelete(". $row["id"].")'class='btn btn-success deletebtn'>delete</button>
      <button type='button' onclick='ajaxUpdate(". $row["id"].")'class='btn btn-success updatebtn' data-bs-toggle='modal' data-bs-target='#UpdateModal'>update</button>
      </td>
    </tr>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>
</table>
<!--insert Model-->
<form id="myForm" method="post">
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">insert Article</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <p id="message"></p>
      <div class="modal-body">
      <h3></h3>
  <div>
      <div class="form-group">
    <label for="fname"> Name</label>
      <input type="text" id="name" name="name" placeholder="Your name.." class="form-control"><br>
      </div>
      <div class="form-group">
      <label for="lname">price</label>
      <input type="text" id="price" name="price" class="form-control" ><br>
      </div>
      <div class="form-group">
      <label for="country">quantity</label>
      <input type="text" id="quantity" name="quantity" class="form-control" >
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="ajaxInsert()">Save</button>
      </div>
    </div>
  </div>
</div>
<!--update Model-->
<div>
</form>
<form id="editform" method="post">
<div class="modal fade" id="UpdateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Article</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <p id="message"></p>
      <div class="modal-body">
      <h3></h3>
  <div>
      <div class="form-group">
    <label for="fname"> Name</label>
      <input type="text" id="name" name="name" placeholder="Your name.." class="form-control"><br>
      </div>
      <div class="form-group">
      <label for="lname">price</label>
      <input type="text" id="price" name="price" class="form-control" ><br>
      </div>
      <div class="form-group">
      <label for="country">quantity</label>
      <input type="text" id="quantity" name="quantity" class="form-control" >
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="Update()">Save</button>
      </div>
    </div>
  </div>
</div>
</form>
</div>
</body>

</html>