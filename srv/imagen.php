<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./seguridad.php";
require_once "./DaoImagen.php";
try {
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  session_start();
  $bd = conecta();
  if (tieneRol(
    $bd,
    ["Administrador", "Cliente"]
  )) {
    $id = $_GET["id"];
    $bd = conecta();
    if ($id) {
      $imagen = DaoImagen::busca(
        $bd,
        $id
      );
      if (!$imagen) {
        throw new Exception(
          "Registro no " .
            "encontrado."
        );
      }
      echo $imagen->bytes;
    }
  }
} catch (Exception $e) {
  aborta($e);
}
