<?php
$myfile = fopen("NuevoArchivo.txt", "w") or die("Unable to open file!");
$txt = "JavaScript Tutorial\n";
fwrite($myfile, $txt);
$txt = "JavaScript Tutorial\n";
fwrite($myfile, $txt);
fclose($myfile);
?>