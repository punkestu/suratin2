<?php
require_once __DIR__ . "/../model/komentar_model.php";
require_once __DIR__ . "/../env.php";

function getComment($pengajuan_id)
{
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $res = Komentar::wherePengajuanId($conn, $pengajuan_id);
      return $res;
}