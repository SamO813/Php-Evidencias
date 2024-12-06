<?php
$myfile = fopen("NuevoArchivo.txt", "w") or die("Unable to open file!");
$txt = "CSS Tutorial\n";
fwrite($myfile, $txt);
$txt = "CSS Tutorial\n";
fwrite($myfile, $txt);
fclose($myfile);
?>