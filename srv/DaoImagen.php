<?php
class DaoImagen
{
  public static function busca(\PDO $bd, int $id)
  {
    $stmt = $bd->prepare(
      "SELECT id, bytes
       FROM Imagen
       WHERE id = :id"
    );
    $stmt->execute([":id" => $id]);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    return $stmt->fetch();
  }
  public static function agrega(
    \PDO $bd,
    $bytes
  ): string {
    $stmt = $bd->prepare(
      "INSERT INTO
        Imagen (bytes)
       VALUES (:bytes)"
    );
    $stmt->execute([
      ":bytes" => $bytes
    ]);
    return $bd->lastInsertId();
  }
  public static function modifica(
    \PDO $bd,
    $id,
    $bytes
  ) {
    $stmt = $bd->prepare(
      "UPDATE
        Imagen
      SET bytes = :bytes
      WHERE id = :id"
    );
    $stmt->execute([
      ":id" => $id,
      ":bytes" => $bytes
    ]);
  }
  public static function elimina(
    \PDO $bd,
    string $imagenId
  ) {
    $stmt = $bd->prepare(
      "DELETE FROM Imagen
      WHERE id = :imagenId"
    );
    $stmt->execute([
      ":imagenId" => $imagenId
    ]);
  }
}
