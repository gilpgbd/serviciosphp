<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./DaoPasatiempo.php";
try {
  session_start();
  $bd = conecta();
  if (tieneRol($bd, ["Cliente"])) {
    $id = $_POST["objId"];
    $nombre = leeCampo("nombre");
    valida($id, "Falta el id");
    valida($nombre, "Falta el nombre");
    DaoPasatiempo::modifica(
      $bd,
      $id,
      $nombre
    );
  }
} catch (\Throwable $th) {
  aborta($th);
}
