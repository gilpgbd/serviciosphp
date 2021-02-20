<?php
mb_internal_encoding("UTF-8");
require_once "./conecta.php";
require_once "./util.php";
require_once "./DaoUsuario.php";
try {
  session_start();
  if (!isset($_SESSION["cue"])) {
    $cue = trim($_POST["cue"]);
    $mtch = $_POST["mtch"];
    valida($cue, "Falta Cue.");
    valida($mtch, "Falta Mtch.");
    $bd = conecta();
    $ok = DaoUsuario::valida(
      $bd,
      $cue,
      $mtch
    );
    if ($ok) {
      $_SESSION["cue"] = $cue;
    } else {
      throw new Exception(
        "Combinación cue/mtch " .
          "incorrecta"
      );
    }
  }
} catch (\Throwable $th) {
  aborta($th);
}
