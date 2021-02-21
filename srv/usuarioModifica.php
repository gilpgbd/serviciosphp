<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./seguridad.php";
require_once "./DaoUsuario.php";
session_start();
try {
  $bd = conecta();
  $bd->beginTransaction();
  if (tieneRol(
    $bd,
    ["Administrador"]
  )) {
    $cue = leeValor("objId");
    $mtch = leeValor("mtch");
    $mtch2 = leeValor("mtch2");
    $bytes = leeBytes("avatar");
    $nombre = leeCampo("nombre");
    $pasatiempoId =
      leeForánea("pasatiempoId");
    $rolIds = leeArray("rolIds");
    valida(
      !$mtch ||
        preg_match(
          "/^\\w{5,25}$/",
          $mtch
        ),
      "La mtch debe tener 5 a " .
        "25 letras o dígitos."
    );
    valida(
      $mtch === $mtch2,
      "Las Mtch no coinciden."
    );
    valida(
      $nombre,
      "Falta el nombre."
    );
    DaoUsuario::modifica(
      $bd,
      $bytes,
      $cue,
      $mtch,
      $nombre,
      $pasatiempoId,
      $rolIds
    );
    $bd->commit();
  }
} catch (\Throwable $th) {
  aborta($th);
}
