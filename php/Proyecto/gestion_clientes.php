<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$dbname = 'ips_vacunate_sas';
$usuario = 'root';
$contraseña = '';

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $contraseña);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("¡Error en la conexión a la base de datos!: " . $e->getMessage());
}

// Función para mostrar mensajes
function mostrarMensaje($mensaje, $tipo = 'success') {
    $color = $tipo == 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
    echo "<div class='flex justify-center mt-4'>
            <div class='border-l-4 p-4 max-w-md w-full $color' role='alert'>
                <p class='font-bold'>$mensaje</p>
            </div>
          </div>";
}

// Funciones CRUD
function crearCliente($pdo, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $telefono, $fechaNacimiento) {
    try {
        $sql = "INSERT INTO cliente (CliNombre, CliApellido, CliTipoDeDocumento, CliNumeroDeDocumento, CliTelefono, CliFechaDeNacimiento) VALUES (:nombre, :apellido, :tipoDocumento, :numeroDocumento, :telefono, :fechaNacimiento)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':tipoDocumento', $tipoDocumento);
        $stmt->bindParam(':numeroDocumento', $numeroDocumento);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
        $stmt->execute();
        mostrarMensaje('Cliente creado exitosamente.');
    } catch (PDOException $e) {
        mostrarMensaje('Error al crear cliente: ' . $e->getMessage(), 'error');
    }
}

function leerClientes($pdo) {
    try {
        $sql = "SELECT * FROM cliente";
        $stmt = $pdo->query($sql);
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($clientes) {
            foreach ($clientes as $cliente) {
                echo "Código: " . $cliente['CliCodigo'] . "<br>";
                echo "Nombre: " . $cliente['CliNombre'] . "<br>";
                echo "Apellido: " . $cliente['CliApellido'] . "<br>";
                echo "Tipo de Documento: " . $cliente['CliTipoDeDocumento'] . "<br>";
                echo "Número de Documento: " . $cliente['CliNumeroDeDocumento'] . "<br>";
                echo "Teléfono: " . $cliente['CliTelefono'] . "<br>";
                echo "Fecha de Nacimiento: " . $cliente['CliFechaDeNacimiento'] . "<br><br>";
            }
            mostrarMensaje('Clientes mostrados exitosamente.');
        } else {
            mostrarMensaje('No se encontraron clientes.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al buscar clientes: ' . $e->getMessage(), 'error');
    }
}

function actualizarCliente($pdo, $codigo, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $telefono, $fechaNacimiento) {
    try {
        $sql = "UPDATE cliente SET CliNombre = :nombre, CliApellido = :apellido, CliTipoDeDocumento = :tipoDocumento, CliNumeroDeDocumento = :numeroDocumento, CliTelefono = :telefono, CliFechaDeNacimiento = :fechaNacimiento WHERE CliCodigo = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':tipoDocumento', $tipoDocumento);
        $stmt->bindParam(':numeroDocumento', $numeroDocumento);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);

        if ($stmt->execute()) {
            mostrarMensaje('Cliente actualizado exitosamente.');
        } else {
            mostrarMensaje('Error al actualizar cliente.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al actualizar cliente: ' . $e->getMessage(), 'error');
    }
}

function eliminarCliente($pdo, $codigo) {
    try {
        $sql = "DELETE FROM cliente WHERE CliCodigo = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);

        if ($stmt->execute()) {
            mostrarMensaje('Cliente eliminado exitosamente.');
        } else {
            mostrarMensaje('Error al eliminar cliente.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al eliminar cliente: ' . $e->getMessage(), 'error');
    }
}

// Manejo de datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Gestión de Clientes</title><link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'></head><body class='bg-gray-100'><div class='container mx-auto p-6'>";
    
    $accion = $_POST['accion'] ?? '';
    $codigo = htmlspecialchars(trim($_POST['codigo'] ?? ''));
    $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''));
    $apellido = htmlspecialchars(trim($_POST['apellido'] ?? ''));
    $tipoDocumento = htmlspecialchars(trim($_POST['tipoDocumento'] ?? ''));
    $numeroDocumento = htmlspecialchars(trim($_POST['numeroDocumento'] ?? ''));
    $telefono = htmlspecialchars(trim($_POST['telefono'] ?? ''));
    $fechaNacimiento = htmlspecialchars(trim($_POST['fechaNacimiento'] ?? ''));

    switch ($accion) {
        case 'create':
            if ($nombre && $apellido && $tipoDocumento && $numeroDocumento && $telefono && $fechaNacimiento) {
                crearCliente($pdo, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $telefono, $fechaNacimiento);
            } else {
                mostrarMensaje("Error: todos los campos son obligatorios para crear un cliente.", 'error');
            }
            break;

        case 'read':
            leerClientes($pdo);
            break;

        case 'update':
            if ($codigo && $nombre && $apellido && $tipoDocumento && $numeroDocumento && $telefono && $fechaNacimiento) {
                actualizarCliente($pdo, $codigo, $nombre, $apellido, $tipoDocumento, $numeroDocumento, $telefono, $fechaNacimiento);
            } else {
                mostrarMensaje("Error: todos los campos son obligatorios para actualizar.", 'error');
            }
            break;

        case 'delete':
            if ($codigo) {
                eliminarCliente($pdo, $codigo);
            } else {
                mostrarMensaje("Error: el código del cliente es obligatorio para eliminar.", 'error');
            }
            break;

        default:
            mostrarMensaje("Error: acción no reconocida.", 'error');
            break;
    }

    echo "</div></body></html>";
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['accion']) && $_GET['accion'] == 'read') {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Gestión de Clientes</title><link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'></head><body class='bg-gray-100'><div class='container mx-auto p-6'>";
    
    leerClientes($pdo);
    
    echo "</div></body></html>";
}
?>
