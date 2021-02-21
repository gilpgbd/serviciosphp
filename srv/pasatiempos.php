<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./seguridad.php";
require_once
  "./DaoPasatiempo.php";
try {
  session_start();
  $bd = conecta();
  if (tieneRol(
    $bd,
    ["Administrador", "Cliente"]
  )) {
    $listado =
      DaoPasatiempo::consulta(
        $bd
      );
    echo json_encode($listado);
  }
} catch (\Throwable $th) {
  aborta($th);
}
