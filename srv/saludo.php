<?php
mb_internal_encoding("UTF-8");
$nombre = trim($_POST["nombre"]);
if (strlen($nombre) === 0) {
  http_response_code(500);
  echo "Falta el nombre";
} else {
  echo "Hola $nombre.";
}
