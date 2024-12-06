<html>
<body>

Bienvenido <?php echo $_POST["nombre"]; ?><br>
Tu apellido es <?php echo $_POST["apellido"]; ?> <br>
Tu telefono es: <?php echo $_POST["telefono"]; ?> <br>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname= "php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexion Exitosa, con PDO Orientada a Objetos, extencion de PHP </br> :";
}catch(PDOException $e) {
    echo "Conexion Fallida, con PDO Orientada a Objetos, extencion de PHP </br> " . $e->getMessage();
}
?>

</body>
</html>