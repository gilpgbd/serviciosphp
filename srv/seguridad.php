<?php
require_once "./DaoUsuarioRol.php";
function tieneRol(\PDO $bd, array $roles): bool
{
  if (!isset($_SESSION["cue"])) {
    return false;
  }
  $rolIds = DaoUsuarioRol::buscaRoles($bd, $_SESSION["cue"]);
  foreach ($roles as $rol) {
    if (array_search($rol, $rolIds) !== FALSE) {
      return true;
    }
  }
  return false;
}
