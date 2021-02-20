<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./DaoUsuario.php";
try {
  session_start();
  $bd = conecta();
  if (tieneRol($bd, ["Administrador"])) {
    $cue = trim($_GET["id"]);
    valida($cue, "Falta id");
    $modelo = DaoUsuario::busca(
      $bd,
      $cue
    );
    if ($modelo) {
      echo json_encode($modelo);
    } else {
      throw new Exception(
        "Usuario no encontrado."
      );
    }
  }
} catch (\Throwable $th) {
  aborta($th);
}