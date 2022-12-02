<?php
require_once __DIR__ . "/../model/pengajuan_model.php";
require_once __DIR__ . "/../env.php";

$conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
$res = Pengajuan::deleteWhereId($conn, $_GET["code"], $_COOKIE["token"]);
if ($res["code"] == 400) {
}
session_start();
$_SESSION["error"] = "pass";

header("Location: " . ROOT . "/pengajuan/", true, 301);
