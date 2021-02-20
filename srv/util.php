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
function valida(
  $condicion,
  string $mensaje
): void {
  if (!$condicion) {
    throw new Exception($mensaje);
  }
}
function aborta(\Throwable $th)
{
  http_response_code(500);
  echo $th->getMessage();
}
function archivoRecibido($nombre): bool
{
  return isset($_FILES[$nombre]) && $_FILES[$nombre]["size"] > 0;
}
function leeBytes(string $archivo): ?string
{
  return archivoRecibido($archivo)
    ? file_get_contents($_FILES[$archivo]["tmp_name"])
    : null;
}
function leeCampo(string $nombreDelCampo): string
{
  return trim($_POST[$nombreDelCampo]);
}
function leeParametro(string $nombreDelCampo): string
{
  return trim($_GET[$nombreDelCampo]);
}
function leeForanea(string $nombreDelCampo): ?string
{
  $valor = $_POST[$nombreDelCampo];
  return $valor ? $valor : null;
}
function leeArray(string $nombreDelCampo): array
{
  $valor = $_POST[$nombreDelCampo];
  return $valor ? $valor : [];
}