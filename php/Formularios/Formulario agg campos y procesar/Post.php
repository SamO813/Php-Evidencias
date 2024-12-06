<html>
<body>
<?php
$num1 = $_POST["n1"];
$num2 = $_POST["n2"];

echo "Bienvenido " . $_POST["nombre"] . "<br>"; 
echo "Tienes " . $_POST["edad"] . " años<br>";
echo "Tu numero de telefono es: +57 " . $_POST["cel"] . "<br>";
echo "Tu E-mail es: " . $_POST["email"] . "<br>";
echo "Tu grupo es: " . $_POST["grupo"] . "<br>";
echo "Tu ficha es: " . $_POST["ficha"] . "<br>";
echo "Naciste el: " . $_POST["nacimiento"] . "<br>";
echo "La suma de los dos numeros que introduciste es: " . ($num1 + $num2)  . "<br>";
echo "La resta de los dos numeros que introduciste es: " . ($num1 - $num2)  . "<br>";
echo "La multiplicacion de los dos numeros que introduciste es: " . ($num1 * $num2)  . "<br>";
echo "La division de los dos numeros que introduciste es: " . ($num1 / $num2) . "<br>";

echo "Suma " . ($_POST["n1"] + $_POST["n2"]);
?>
</body>
</html>