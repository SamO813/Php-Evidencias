<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Conexion Fallida: " . $conn->connect_error);
}
echo "Conexion Correcta, con MySQL orientado a Objetos </br>";
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
/* $dbname = "nombre de la base de datos"*/ 
// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
  die("Conexion Fallida: " . mysqli_connect_error());
}
echo "Conexion Exitosa, con MySQL orientado a Procedimientos </br>";
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=php", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Conexion Exitosa, con PDO Orientada a Objetos, extencion de PHP </br> :";
} catch(PDOException $e) {
  echo "Conexion Fallida, con PDO Orientada a Objetos, extencion de PHP </br> " . $e->getMessage();
}
?>