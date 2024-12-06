<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
   
  $cars = array (
  array("Volvo",22,18),
  array("BMW",15,13),
  array("Saab",5,2),
  array("Land Rover",17,15)
);

$totalF = count($cars);
echo "El total de filas en el arreglo es: " . $totalF . "<br>";

$totalE = count($cars, COUNT_RECURSIVE) - $totalF;
echo "El total de elementos en el arreglo es: " . $totalE;

for ($row = 0; $row < $totalF; $row++) {
  echo "<p><b>Row number $row</b></p>";
  echo "<ul>";
  for ($col = 0; $col < count($cars[$row]); $col++) {
    echo "<li>".$cars[$row][$col]."</li>";
  }
  echo "</ul>";
}

echo $cars[0][0].": En stock: ".$cars[0][1].", vendidos: ".$cars[0][2].".<br>";
echo $cars[1][0].": En stock: ".$cars[1][1].", vendidos: ".$cars[1][2].".<br>";
echo $cars[2][0].": En stock: ".$cars[2][1].", vendidos: ".$cars[2][2].".<br>";
echo $cars[3][0].": En stock: ".$cars[3][1].", vendidos: ".$cars[3][2].".<br>";

?>

</body>
</html>
