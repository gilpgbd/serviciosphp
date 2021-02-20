<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./DaoUsuarioRol.php";
try {
  session_start();
  mb_internal_encoding("UTF-8");
  if (isset($_SESSION["cue"])) {
    $bd = conecta();
    $roles = DaoUsuarioRol::buscaRoles(
      $bd,
      $_SESSION["cue"]
    );
    echo json_encode($roles);
  } else {
    echo "[]";
  }
} catch (\Throwable $th) {
  aborta($th);
}
