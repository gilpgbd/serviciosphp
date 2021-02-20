<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./DaoUsuario.php";
try {
  session_start();
  mb_internal_encoding("UTF-8");
  if (isset($_SESSION["cue"])) {
    $bd = conecta();
    $usuario = DaoUsuario::busca(
      $bd,
      $_SESSION["cue"]
    );
    echo json_encode($usuario);
  } else {
    echo "{}";
  }
} catch (\Throwable $th) {
  aborta($th);
}
