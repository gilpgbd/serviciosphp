<?php
require_once "./DaoImagen.php";
require_once
  "./DaoUsuarioRol.php";
class DaoUsuario
{
  public static function
  consulta(\PDO $bd): array
  {
    $stmt = $bd->query(
      "SELECT
        u.cue AS cue,
        CONCAT(
          'srv/imagen.php?id=',
          u.imagenId)
          AS avatar,
        u.nombre AS nombre,
        IFNULL(p.nombre,
          '-- Sin Pasatiempo --')
          AS pasatiempo,
        GROUP_CONCAT(
          ur.rolId
          ORDER BY ur.rolId
          SEPARATOR ',')
          AS roles
      FROM Usuario u
      LEFT JOIN UsuarioRol ur
      ON u.cue = ur.usuarioCue
      LEFT JOIN Pasatiempo p
      ON u.pasatiempoId = p.id
      GROUP BY u.cue
      ORDER BY u.cue"
    );
    return $stmt->fetchAll(
      PDO::FETCH_OBJ
    );
  }
  public static function busca(
    \PDO $bd,
    string $cue
  ) {
    $stmt = $bd->prepare(
      "SELECT
        cue,
        CONCAT(
          'srv/imagen.php?id=',
          imagenId)
          AS avatar,
        imagenId,
        nombre,
        pasatiempoId
      FROM Usuario
      WHERE cue = :cue"
    );
    $stmt->execute([
      ":cue" => $cue
    ]);
    $stmt->setFetchMode(
      PDO::FETCH_OBJ
    );
    $modelo = $stmt->fetch();
    if ($modelo) {
      $modelo->rolIds =
        DaoUsuarioRol::buscaRoles(
          $bd,
          $cue
        );
    }
    return $modelo;
  }
  public static function valida(
    \PDO $bd,
    string $cue,
    string $mtch
  ) {
    $stmt = $bd->prepare(
      "SELECT
        cue,
        CONCAT(
          'srv/imagen.php?id=',
          imagenId)
          AS avatar,
        nombre
      FROM Usuario
      WHERE cue = :cue AND
        mtch = SHA2(:mtch,256)"
    );
    $stmt->execute([
      ":cue" => $cue,
      ":mtch" => $mtch
    ]);
    $stmt->setFetchMode(
      PDO::FETCH_OBJ
    );
    return $stmt->fetch();
  }
  public static function agrega(
    \PDO $bd,
    string $cue,
    ?string $bytes,
    string $mtch,
    string $nombre,
    ?string $pasatiempoId,
    array $rolIds
  ) {
    $imagenId = DaoImagen::agrega(
      $bd,
      $bytes
    );
    $stmt = $bd->prepare(
      "INSERT INTO Usuario
        (cue, imagenId,
          mtch, nombre,
          pasatiempoId)
      VALUES
        (:cue,:imagenId,
          SHA2(:mtch,256),:nombre,
          :pasatiempoId)"
    );
    $stmt->execute([
      ":cue" => $cue,
      ":imagenId" => $imagenId,
      ":mtch" => $mtch,
      ":nombre" => $nombre,
      ":pasatiempoId" =>
      $pasatiempoId,
    ]);
    DaoUsuarioRol::agrega(
      $bd,
      $cue,
      $rolIds
    );
  }
  public static function modifica(
    \PDO $bd,
    ?string $bytes,
    string $cue,
    string $mtch,
    string $nombre,
    ?string $pasatiempoId,
    array $rolIds
  ) {
    $modelo =
      static::busca($bd, $cue);
    if ($modelo) {
      if ($bytes) {
        if ($modelo->imagenId) {
          DaoImagen::modifica(
            $bd,
            $modelo->imagenId,
            $bytes
          );
        } else {
          $modelo->imagenId =
            DaoImagen::agrega(
              $bd,
              $bytes
            );
        }
      }
      $stmt1 = $bd->prepare(
        "UPDATE Usuario
      SET nombre = :nombre,
        pasatiempoId =
          :pasatiempoId,
        imagenId = :imagenId
      WHERE cue = :cue"
      );
      $stmt1->execute([
        ":nombre" => $nombre,
        ":pasatiempoId" =>
        $pasatiempoId,
        ":imagenId" =>
        $modelo->imagenId,
        ":cue" => $cue
      ]);
      if ($mtch) {
        $stmt2 = $bd->prepare(
          "UPDATE Usuario
          SET
            mtch = SHA2(:mtch,256)
          WHERE cue = :cue"
        );
        $stmt2->execute(
          [
            ":mtch" => $mtch,
            ":cue" => $cue
          ]
        );
      }
      DaoUsuarioRol::elimina(
        $bd,
        $cue
      );
      DaoUsuarioRol::agrega(
        $bd,
        $cue,
        $rolIds
      );
    }
  }
  public static function elimina(
    \PDO $bd,
    string $cue
  ) {
    $modelo =
      static::busca($bd, $cue);
    if ($modelo) {
      DaoUsuarioRol::elimina(
        $bd,
        $cue
      );
      $stmt = $bd->prepare(
        "DELETE FROM Usuario
        WHERE cue = :cue"
      );
      $stmt->execute([
        ":cue" => $cue
      ]);
      DaoImagen::elimina(
        $bd,
        $modelo->imagenId
      );
    }
  }
}
