<?php
class DaoPasatiempo
{
  public static function
  consulta(\PDO $bd)
  {
    $stmt = $bd->query(
      "SELECT id, nombre
      FROM Pasatiempo
      ORDER BY nombre"
    );
    return $stmt->fetchAll(
      PDO::FETCH_OBJ
    );
  }
  public static function busca(
    \PDO $bd,
    string $id
  ) {
    $stmt = $bd->prepare(
      "SELECT *
      FROM Pasatiempo
      WHERE id = :id"
    );
    $stmt->execute([
      ":id" => $id
    ]);
    $stmt->setFetchMode(
      PDO::FETCH_OBJ
    );
    return $stmt->fetch();
  }
  public static function agrega(
    \PDO $bd,
    string $nombre
  ) {
    $stmt = $bd->prepare(
      "INSERT INTO Pasatiempo
        (nombre)
      VALUES
        (:nombre)"
    );
    $stmt->execute([
      ":nombre" => $nombre
    ]);
  }
  public static function modifica(
    \PDO $bd,
    string $id,
    string $nombre
  ) {
    $stmt = $bd->prepare(
      "UPDATE Pasatiempo
      SET nombre = :nombre
      WHERE id = :id"
    );
    $stmt->execute([
      ":id" => $id,
      ":nombre" => $nombre
    ]);
  }
  public static function elimina(
    \PDO $bd,
    string $id
  ) {
    $stmt = $bd->prepare(
      "DELETE FROM Pasatiempo
      WHERE id = :id"
    );
    $stmt->execute([
      ":id" => $id
    ]);
  }
}
