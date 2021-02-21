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
    ["Cliente"]
  )) {
    $id = leeParámetro("id");
    valida($id, "Falta id.");
    DaoPasatiempo::elimina(
      $bd,
      $id
    );
  }
} catch (\Throwable $th) {
  aborta($th);
}
