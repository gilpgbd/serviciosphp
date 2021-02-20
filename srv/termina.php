<?php
mb_internal_encoding("UTF-8");
require_once "./util.php";
session_start();
try {
  mb_internal_encoding("UTF-8");
  if (isset($_SESSION["cue"])) {
    unset($_SESSION["cue"]);
  }
  session_destroy();
} catch (\Throwable $th) {
  aborta($th);
}
