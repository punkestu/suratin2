<?php
require_once __DIR__ . "/../model/pengajuan_model.php";
require_once __DIR__ . "/../env.php";

$conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
$res = Pengajuan::deleteWhereId($conn, $_GET["code"], $_COOKIE["token"]);
Notifikasi::push($conn, $_GET["code"], $_COOKIE["token"], "menghapus pengajuan");
session_start();
$_SESSION["error"] = "pass";

header("Location: " . ROOT . "/pengajuan/", true, 301);
