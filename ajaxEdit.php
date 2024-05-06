<?php
// Supposons que vous récupériez les données de l'élément depuis votre base de données
$id = $_GET['id'];

// Code pour récupérer les données de l'élément avec l'ID spécifié (vous devez implémenter cette partie)
// Par exemple, supposons que vous avez récupéré les données de l'élément dans un tableau associatif
$data = array(
    'name' => 'echo ". $row["name"]. "',
    'price' => '" . $row["price"]. "',
    'quantity'=>'" . $row["quantity"]. "'
);

// Renvoyer les données au format JSON
echo json_encode($data);
?>
