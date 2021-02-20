<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./DaoUsuario.php";
session_start();
try {
  mb_internal_encoding("UTF-8");
  $bd = conecta();
  if (tieneRol($bd, ["Administrador"])) {
    $listado = DaoUsuario::consulta($bd);
    echo json_encode($listado);
  }
} catch (\Throwable $th) {
  aborta($th);
}
