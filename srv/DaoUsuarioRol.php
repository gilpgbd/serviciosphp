<?php
class DaoUsuarioRol
{
  public static function buscaRoles(
    \PDO $bd,
    string $usuarioCue
  ): array {
    $stmt = $bd->prepare(
      "SELECT rolId
      FROM UsuarioRol
      WHERE
       usuarioCue = :usuarioCue"
    );
    $stmt->execute([
      ":usuarioCue" => $usuarioCue
    ]);
    return $stmt->fetchAll(
      PDO::FETCH_COLUMN,
      0
    );
  }
  public static function agrega(
    \PDO $bd,
    string $usuarioCue,
    array $rolIds
  ) {
    if (count($rolIds) > 0) {
      $stmt = $bd->prepare(
        "INSERT INTO
           UsuarioRol
         (usuarioCue,rolId)
         VALUES
          (:usuarioCue,:rolId)"
      );
      foreach ($rolIds as $rolId) {
        $stmt->execute(
          [
            ":usuarioCue" =>
            $usuarioCue,
            ":rolId" => $rolId
          ]
        );
      }
    }
  }
  public static function elimina(
    \PDO $bd,
    string $usuarioCue
  ) {
    $stmt = $bd->prepare(
      "DELETE FROM UsuarioRol
      WHERE
        usuarioCue = :usuarioCue"
    );
    $stmt->execute([
      ":usuarioCue" => $usuarioCue
    ]);
  }
}
