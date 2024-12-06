<?php
$target_dir = "uploads/";

// Subir imágenes
if (isset($_FILES["fileToUpload"])) {
    foreach ($_FILES["fileToUpload"]["name"] as $key => $fileName) {
        $target_file = $target_dir . basename($fileName);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$key]);
        if ($check !== false) {
            echo "Archivo " . $fileName . " es una imagen - " . $check["mime"] . ".<br>";
        } else {
            echo "Archivo " . $fileName . " no es una imagen.<br>";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $target_file)) {
                echo "El archivo " . $fileName . " se ha subido correctamente.<br>";
            } else {
                echo "Hubo un error al subir el archivo " . $fileName . ".<br>";
            }
        }
    }
}

if (isset($_FILES["fileToUploadDos"])) {
    $target_file = $target_dir . basename($_FILES["fileToUploadDos"]["name"]);
    $uploadOk = 1;
    $wordFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($wordFileType == "doc" || $wordFileType == "docx") {
        echo "Archivo de Word " . $_FILES["fileToUploadDos"]["name"] . " es válido.<br>";
        if (move_uploaded_file($_FILES["fileToUploadDos"]["tmp_name"], $target_file)) {
            echo "El archivo de Word se ha subido correctamente.<br>";
        } else {
            echo "Hubo un error al subir el archivo de Word.<br>";
        }
    } else {
        echo "El archivo no es un archivo de Word válido.<br>";
    }
}
?>