<?php
$myfile = fopen("NuevoArchivo.txt", "w") or die("Unable to open file!");
$txt = "PHP Tutorial\n";
fwrite($myfile, $txt);
$txt = "PHP Tutorial\n";
fwrite($myfile, $txt);
fclose($myfile);
?>