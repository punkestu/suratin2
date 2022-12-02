<?php
require_once __DIR__ . "/../model/komentar_model.php";
require_once __DIR__ . "/../env.php";

$conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
$res = Komentar::create($conn, $_POST["message"], $_COOKIE["token"], $_POST["pengajuan"]);
echo json_encode($res);
exit();