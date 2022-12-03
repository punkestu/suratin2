<?php
require_once __DIR__ . "/../controller/notifikasi_controller.php";

readNotification($_GET["notifikasi"]);
header("Location: " . ROOT . "/view/listpengajuan.php?code=".$_GET['pengajuan']);