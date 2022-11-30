<?php
require_once __DIR__ . "/../model/komentar_model.php";
require_once __DIR__ . "/../env.php";

function postComment()
{
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $res = Komentar::create($conn, $_POST["message"], $_COOKIE["token"], $_POST["pengajuan"]);
      echo json_encode($res);
}
function getComment($pengajuan_id)
{
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $res = Komentar::wherePengajuanId($conn, $pengajuan_id);
      return $res;
}

if (isset($_POST["want"]) && $_POST["want"] == "post_comment") {
      postComment();
}
