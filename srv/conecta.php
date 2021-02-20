<?php
function conecta(): PDO
{
  return new PDO(
    "mysql:dbname=servicios;host=localhost",
    "ususerv",
    "usupass",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );
}
