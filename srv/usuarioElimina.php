<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./seguridad.php";
require_once "./DaoUsuario.php";
session_start();
try {
  $bd = conecta();
  if (tieneRol($bd, ["Administrador"])) {
    $id = trim($_GET["id"]);
    valida($id, "Falta id");
    $bd->beginTransaction();
    DaoUsuario::elimina(
      $bd,
      $id
    );
    $bd->commit();
  }
} catch (\Throwable $th) {
  aborta($th);
}
