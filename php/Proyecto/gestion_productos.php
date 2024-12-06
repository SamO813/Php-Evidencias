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
function crearProducto($pdo, $nombre, $lote, $valor) {
    try {
        $sql = "INSERT INTO productos (ProNombre, ProLote, Provalor) VALUES (:nombre, :lote, :valor)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':lote', $lote);
        $stmt->bindParam(':valor', $valor);
        $stmt->execute();
        mostrarMensaje('Producto creado exitosamente.');
    } catch (PDOException $e) {
        mostrarMensaje('Error al crear Producto: ' . $e->getMessage(), 'error');
    }
}

function leerProductos($pdo) {
    try {
        $sql = "SELECT * FROM Productos";
        $stmt = $pdo->query($sql);
        $Productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($Productos) {
            foreach ($Productos as $Producto) {
                echo "Código: " . $Producto['ProCodigo'] . "<br>";
                echo "Nombre: " . $Producto['ProNombre'] . "<br>";
                echo "lote: " . $Producto['ProLote'] . "<br>";
                echo "Número de Documento: " . $Producto['Provalor'] . "<br><br>";
            }
            mostrarMensaje('Productos mostrados exitosamente.');
        } else {
            mostrarMensaje('No se encontraron Productos.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al buscar Productos: ' . $e->getMessage(), 'error');
    }
}

function actualizarProducto($pdo, $codigo, $nombre, $lote, $valor) {
    try {
        $sql = "UPDATE productos SET ProNombre = :nombre, ProLote = :lote, Provalor = :valor WHERE ProCodigo = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':lote', $lote);
        $stmt->bindParam(':valor', $valor);


        if ($stmt->execute()) {
            mostrarMensaje('Producto actualizado exitosamente.');
        } else {
            mostrarMensaje('Error al actualizar Producto.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al actualizar Producto: ' . $e->getMessage(), 'error');
    }
}

function eliminarProducto($pdo, $codigo) {
    try {
        $sql = "DELETE FROM Productos WHERE ProCodigo = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);

        if ($stmt->execute()) {
            mostrarMensaje('Producto eliminado exitosamente.');
        } else {
            mostrarMensaje('Error al eliminar Producto.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al eliminar Producto: ' . $e->getMessage(), 'error');
    }
}

// Manejo de datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Gestión de Productos</title><link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'></head><body class='bg-gray-100'><div class='container mx-auto p-6'>";
    
    $accion = $_POST['accion'] ?? '';
    $codigo = htmlspecialchars(trim($_POST['codigo'] ?? ''));
    $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''));
    $lote = htmlspecialchars(trim($_POST['lote'] ?? ''));
    $valor = htmlspecialchars(trim($_POST['valor'] ?? ''));


    switch ($accion) {
        case 'create':
            if ($nombre && $lote && $valor) {
                crearProducto($pdo, $nombre, $lote,$valor);
            } else {
                mostrarMensaje("Error: todos los campos son obligatorios para crear un Producto.", 'error');
            }
            break;

        case 'read':
            leerProductos($pdo);
            break;

        case 'update':
            if ($codigo && $nombre && $lote && $valor) {
                actualizarProducto($pdo, $codigo, $nombre, $lote, $valor,);
            } else {
                mostrarMensaje("Error: todos los campos son obligatorios para actualizar.", 'error');
            }
            break;

        case 'delete':
            if ($codigo) {
                eliminarProducto($pdo, $codigo);
            } else {
                mostrarMensaje("Error: el código del Producto es obligatorio para eliminar.", 'error');
            }
            break;

        default:
            mostrarMensaje("Error: acción no reconocida.", 'error');
            break;
    }

    echo "</div></body></html>";
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['accion']) && $_GET['accion'] == 'read') {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Gestión de Productos</title><link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'></head><body class='bg-gray-100'><div class='container mx-auto p-6'>";
    
    leerProductos($pdo);
    
    echo "</div></body></html>";
}
?>
