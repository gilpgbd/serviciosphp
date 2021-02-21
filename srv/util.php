<?php
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
function
archivoRecibido($nombre): bool
{
  return
    isset($_FILES[$nombre]) &&
    $_FILES[$nombre]["size"] > 0;
}
function
leeBytes(string $archivo): ?string
{
  return archivoRecibido($archivo)
    ? file_get_contents(
      $_FILES[$archivo]["tmp_name"]
    )
    : null;
}
function leeValor(
  string $nombreDelCampo
): string {
  $valor =
    isset($_POST[$nombreDelCampo])
    ? $_POST[$nombreDelCampo]
    : "";
  return $valor;
}
function leeCampo(
  string $nombreDelCampo
): string {
  $valor =
    leeValor($nombreDelCampo);
  return trim($valor);
}
function leeParámetro(
  string $nombreDelCampo
): string {
  $valor =
    isset($_GET[$nombreDelCampo])
    ? $_GET[$nombreDelCampo]
    : "";
  return trim($valor);
}
function leeForánea(
  string $nombreDelCampo
): ?string {
  $valor =
    isset($_POST[$nombreDelCampo])
    ? $_POST[$nombreDelCampo]
    : null;
  return $valor ? $valor : null;
}
function leeArray(
  string $nombreDelCampo
): array {
  $valor =
    isset($_POST[$nombreDelCampo])
    ? $_POST[$nombreDelCampo]
    : [];
  return $valor;
}
