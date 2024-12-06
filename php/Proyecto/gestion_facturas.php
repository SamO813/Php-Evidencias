<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
function leerFacturas($pdo) {
    try {
        $sql = "SELECT * FROM factura";
        $stmt = $pdo->query($sql);

        if (!$stmt) {
            echo "Error en la consulta SQL.<br>";
            return;
        }

        $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($facturas) {
            echo "Facturas encontradas: " . count($facturas) . "<br><br>";
            foreach ($facturas as $factura) {
                $valorFormateado = number_format($factura['FacValor'], 0, '', '.');
                echo "Código: " . $factura['FacCodigo'] . "<br>";
                echo "Nombre de la Factura: " . $factura['FacNombreDeFactura'] . "<br>";
                echo "Código del Cliente: " . $factura['CliCodigo'] . "<br>";
                echo "Código del Producto: " . $factura['ProCodigo'] . "<br>";
                echo "Nombre del Cliente: " . $factura['FacNombreDeCLiente'] . "<br>";
                echo "Nombre del Producto: " . $factura['FacNombreDeProducto'] . "<br>";
                echo "Cantidad: " . $factura['FacCantidad'] . "<br>";
                echo "Valor: $ " . $valorFormateado . "<br><br>";
            }
            mostrarMensaje('Facturas mostradas exitosamente.');
        } else {
            echo "No se encontraron facturas.<br>";
            mostrarMensaje('No se encontraron facturas.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al buscar facturas: ' . $e->getMessage(), 'error');
    }
}

function crearFactura($pdo, $nombreFactura, $cliCodigo, $proCodigo, $cantidad) {
    try {
        // Obtener nombre del cliente y del producto
        $stmtCliente = $pdo->prepare("SELECT CliNombre, CliApellido FROM cliente WHERE CliCodigo = :cliCodigo");
        $stmtCliente->bindParam(':cliCodigo', $cliCodigo);
        $stmtCliente->execute();
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        $stmtProducto = $pdo->prepare("SELECT ProNombre, ProValor FROM productos WHERE ProCodigo = :proCodigo");
        $stmtProducto->bindParam(':proCodigo', $proCodigo);
        $stmtProducto->execute();
        $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

        if ($cliente && $producto) {
            $nombreCliente = $cliente['CliNombre'] . ' ' . $cliente['CliApellido'];
            $nombreProducto = $producto['ProNombre'];
            $valor = $producto['ProValor'] * $cantidad;

            $sql = "INSERT INTO factura (FacNombreDeFactura, CliCodigo, ProCodigo, FacNombreDeCLiente, FacNombreDeProducto, FacCantidad, FacValor) VALUES (:nombreFactura, :cliCodigo, :proCodigo, :nombreCliente, :nombreProducto, :cantidad, :valor)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nombreFactura', $nombreFactura);
            $stmt->bindParam(':cliCodigo', $cliCodigo);
            $stmt->bindParam(':proCodigo', $proCodigo);
            $stmt->bindParam(':nombreCliente', $nombreCliente);
            $stmt->bindParam(':nombreProducto', $nombreProducto);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->bindParam(':valor', $valor);
            $stmt->execute();
            mostrarMensaje('Factura creada exitosamente.');
        } else {
            mostrarMensaje('Error: Cliente o Producto no encontrado.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al crear factura: ' . $e->getMessage(), 'error');
    }
}

function actualizarFactura($pdo, $facCodigo, $nombreFactura, $cliCodigo, $proCodigo, $cantidad) {
    try {
        // Obtener nombre del cliente y del producto
        $stmtCliente = $pdo->prepare("SELECT CliNombre, CliApellido FROM cliente WHERE CliCodigo = :cliCodigo");
        $stmtCliente->bindParam(':cliCodigo', $cliCodigo);
        $stmtCliente->execute();
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        $stmtProducto = $pdo->prepare("SELECT ProNombre, ProValor FROM productos WHERE ProCodigo = :proCodigo");
        $stmtProducto->bindParam(':proCodigo', $proCodigo);
        $stmtProducto->execute();
        $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

        if ($cliente && $producto) {
            $nombreCliente = $cliente['CliNombre'] . ' ' . $cliente['CliApellido'];
            $nombreProducto = $producto['ProNombre'];
            $valor = $producto['ProValor'] * $cantidad;

            $sql = "UPDATE factura SET FacNombreDeFactura = :nombreFactura, CliCodigo = :cliCodigo, ProCodigo = :proCodigo, FacNombreDeCLiente = :nombreCliente, FacNombreDeProducto = :nombreProducto, FacCantidad = :cantidad, FacValor = :valor WHERE FacCodigo = :facCodigo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':facCodigo', $facCodigo);
            $stmt->bindParam(':nombreFactura', $nombreFactura);
            $stmt->bindParam(':cliCodigo', $cliCodigo);
            $stmt->bindParam(':proCodigo', $proCodigo);
            $stmt->bindParam(':nombreCliente', $nombreCliente);
            $stmt->bindParam(':nombreProducto', $nombreProducto);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->bindParam(':valor', $valor);

            if ($stmt->execute()) {
                mostrarMensaje('Factura actualizada exitosamente.');
            } else {
                mostrarMensaje('Error al actualizar factura.', 'error');
            }
        } else {
            mostrarMensaje('Error: Cliente o Producto no encontrado.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al actualizar factura: ' . $e->getMessage(), 'error');
    }
}

function eliminarFactura($pdo, $facCodigo) {
    try {
        $sql = "DELETE FROM factura WHERE FacCodigo = :facCodigo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':facCodigo', $facCodigo);

        if ($stmt->execute()) {
            mostrarMensaje('Factura eliminada exitosamente.');
        } else {
            mostrarMensaje('Error al eliminar factura.', 'error');
        }
    } catch (PDOException $e) {
        mostrarMensaje('Error al eliminar factura: ' . $e->getMessage(), 'error');
    }
}

// Manejo de datos del formulario
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Gestión de Facturas</title><link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'></head><body class='bg-gray-100'><div class='container mx-auto p-6'>";
    
    $facCodigo = htmlspecialchars(trim($_REQUEST['facCodigo'] ?? ''));
    $nombreFactura = htmlspecialchars(trim($_REQUEST['nombreFactura'] ?? ''));
    $cliCodigo = htmlspecialchars(trim($_REQUEST['cliCodigo'] ?? ''));
    $proCodigo = htmlspecialchars(trim($_REQUEST['proCodigo'] ?? ''));
    $cantidad = htmlspecialchars(trim($_REQUEST['cantidad'] ?? ''));

    switch ($accion) {
        case 'create':
            if ($nombreFactura && $cliCodigo && $proCodigo && $cantidad) {
                crearFactura($pdo, $nombreFactura, $cliCodigo, $proCodigo, $cantidad);
            } else {
                mostrarMensaje("Error: todos los campos son obligatorios para crear una factura.", 'error');
            }
            break;

        case 'read':
            leerFacturas($pdo);
            break;

        case 'update':
            if ($facCodigo && $nombreFactura && $cliCodigo && $proCodigo && $cantidad) {
                actualizarFactura($pdo, $facCodigo, $nombreFactura, $cliCodigo, $proCodigo, $cantidad);
            } else {
                mostrarMensaje("Error: todos los campos son obligatorios para actualizar una factura.", 'error');
            }
            break;

        case 'delete':
            if ($facCodigo) {
                eliminarFactura($pdo, $facCodigo);
            } else {
                mostrarMensaje("Error: el código de factura es obligatorio para eliminar.", 'error');
            }
            break;

        default:
            echo "Acción no reconocida.<br>";
            mostrarMensaje("Acción no reconocida.", 'error');
    }

    echo "</div></body></html>";
}

