<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./seguridad.php";
require_once "./DaoUsuario.php";
session_start();
try {
  $bd = conecta();
  if (tieneRol(
    $bd,
    ["Administrador"]
  )) {
    $cue = leeCampo("cue");
    $mtch = leeValor("mtch");
    $mtch2 = leeValor("mtch2");
    $bytes = leeBytes("avatar");
    $nombre = leeCampo("nombre");
    $pasatiempoId =
      leeForánea("pasatiempoId");
    $rolIds = leeArray("rolIds");
    valida(
      preg_match(
        "/^\\w{5,16}$/",
        $cue
      ),
      "El cue debe tener 5 a " .
        "16 letras o dígitos."
    );
    valida(
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
    valida(
      $bytes,
      "Falta el ávatar."
    );
    $bd->beginTransaction();
    DaoUsuario::agrega(
      $bd,
      $cue,
      $bytes,
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
