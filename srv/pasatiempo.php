<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./DaoPasatiempo.php";
try {
  session_start();
  $bd = conecta();
  if (tieneRol($bd, ["Cliente"])) {
    $id = trim($_GET["id"]);
    valida($id, "Falta id");
    $modelo = DaoPasatiempo::busca(
      $bd,
      $id
    );
    if ($modelo) {
      echo json_encode($modelo);
    } else {
      throw new Exception(
        "Pasatiempo no encontrado."
      );
    }
  }
} catch (\Throwable $th) {
  aborta($th);
}
