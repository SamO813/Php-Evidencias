<?php
$myfile = fopen("NuevoArchivo.txt", "w") or die("Unable to open file!");
$txt = "TPS2-123\n2999151\n";
fwrite($myfile, $txt);
$txt = "TPS2-123\n2999151\n";
fwrite($myfile, $txt);
fclose($myfile);
?>