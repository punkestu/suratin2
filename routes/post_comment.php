<?php
require_once __DIR__ . "/../env.php";
require_once __DIR__ . "/../model/komentar_model.php";
require_once __DIR__ . "/../model/notifikasi_model.php";

$conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
$res = Komentar::create($conn, $_POST["message"], $_COOKIE["token"], $_POST["pengajuan"]);
Notifikasi::push($conn, $_POST["pengajuan"], $_COOKIE["token"], "memberi komentar");
echo json_encode([$res, $_POST["pengajuan"], $_COOKIE["token"]]);
exit();
