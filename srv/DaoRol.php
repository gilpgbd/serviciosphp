<?php
class DaoRol
{
  public static function
  consulta(\PDO $bd): array
  {
    $stmt = $bd->query(
      "SELECT id, descripcion
      FROM Rol
      ORDER BY id"
    );
    return $stmt->fetchAll(
      PDO::FETCH_OBJ
    );
  }
}
