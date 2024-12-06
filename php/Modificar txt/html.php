<?php
$myfile = fopen("NuevoArchivo.txt", "w") or die("Unable to open file!");
$txt = "HTML Tutorial\n";
fwrite($myfile, $txt);
$txt = "HTML Tutorial\n";
fwrite($myfile, $txt);
fclose($myfile);
?>