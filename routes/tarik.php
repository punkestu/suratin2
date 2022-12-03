<?php
require_once __DIR__ . "/../model/pengajuan_model.php";
require_once __DIR__ . "/../env.php";

$conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
$res = Pengajuan::deleteWhereId($conn, $_GET["code"], $_COOKIE["token"]);
$res = Notifikasi::push($conn, $_GET["code"], $_COOKIE["token"], "menghapus pengajuan");
var_dump($res);

header("Location: " . ROOT . "/view/listpengajuan.php", true, 301);
exit();