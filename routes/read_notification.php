<?php
require_once __DIR__ . "/../controller/notifikasi_controller.php";

readNotification($_GET["notifikasi"]);
header("Location: " . ROOT . "/pengajuan/".$_GET['pengajuan']);