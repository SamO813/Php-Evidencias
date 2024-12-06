<html>
<body>
<?php
/* echo "Tu E-mail es: " . $_POST["email"] . "<br>";
//echo "Tienes " . $_POST["edad"] . " años<br>";
echo "Tu grupo es: " . $_POST["grupo"] . "<br>";
echo "Tu ficha es: " . $_POST["ficha"] . "<br>";
echo "Naciste el: " . $_POST["nacimiento"] . "<br>";
echo "La suma de los dos numeros que introduciste es: " . ($num1 + $num2)  . "<br>";
echo "La resta de los dos numeros que introduciste es: " . ($num1 - $num2)  . "<br>";
echo "La multiplicacion de los dos numeros que introduciste es: " . ($num1 * $num2)  . "<br>";
echo "La division de los dos numeros que introduciste es: " . ($num1 / $num2) . "<br>";

echo "Suma " . ($_POST["n1"] + $_POST["n2"]);
*/
//$num1 = $_POST["n1"];
//$num2 = $_POST["n2"];

echo "Bienvenido " . $_POST["nombre"] . " " . $_POST["apellido"] . "<br>"; 
echo "Tu numero de telefono es: +57 " . $_POST["telefono"] . "<br>";
?>


<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$dbname = 'php';
$usuario = 'root';
$contraseña = '';

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $contraseña);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("¡Error en la conexión a la base de datos!: " . $e->getMessage());
}

// Función para insertar datos en la base de datos
function insertarUsuario($pdo, $nombre, $apellido, $telefono) {
    try {
        $sql = "INSERT INTO aprendiz (nombre, apellido, telefono) VALUES (:nombre, :apellido, :telefono)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);

        if ($stmt->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error al registrar los datos.";
        }
    } catch (PDOException $e) {
        echo "Error en la inserción de datos: " . $e->getMessage();
    }
}

// Bloque de recepción de datos del formulario
$nombre = $apellido = $telefono = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['telefono'])) {
        // Asignar y limpiar variables
        $nombre = htmlspecialchars(trim($_POST['nombre']));
        $apellido = htmlspecialchars(trim($_POST['apellido']));
        $telefono = htmlspecialchars(trim($_POST['telefono']));

        // Llamada a la función de inserción
        insertarUsuario($pdo, $nombre, $apellido, $telefono);
    } else {
        echo "Error: faltan datos obligatorios. Asegúrate de completar todos los campos.";
    }
}
?>



</body>
</html>