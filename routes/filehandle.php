<?php
require_once __DIR__ . "/../model/pengajuan_model.php";
require_once __DIR__ . "/../model/notifikasi_model.php";

$id = uniqid();

$conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
if (isset($_POST["token"]) && $_POST["token"]!="") {
      $data = new Pengajuan();
      $data->setWhereId($conn, $_COOKIE["token"], $_POST["token"]);
      if (!move_uploaded_file($_FILES['file']['tmp_name'], CONTAINER . $id . ".pdf")) {
            return json_encode(["code" => 400, "msg" => "failed upload"]);
      }
      $res = NULL;
      session_start();
      if ($_SESSION["role"] != "MAHASISWA") {
            $res = $data->addFileHasil($conn, $id);
            Notifikasi::push($conn, $_POST["token"], $_COOKIE["token"], "mengupload file hasil");
      } else {
            $res = $data->revisiFile($conn, $id);
            Notifikasi::push($conn, $_POST["token"], $_COOKIE["token"], "merevisi file pengajuan");
      }
      if (isset($res["msg"])) {
            echo json_encode(["code" => 400, "msg" => $res["msg"]]);
            exit();
      }
      echo json_encode(["code" => 200, "msg" => $res["data"]]);
      exit();
} else {
      if ($_POST["judul"] == "") {
            echo json_encode(["code" => 400, "msg" => "judul harus diisi"]);
            exit();
      }
      $res = Pengajuan::create($conn, $_POST["judul"], $_COOKIE["token"], $_POST["dosen"], $id, $_POST["kategori"]);
      if ($res["data"] == "") {
            echo json_encode(["code" => 500, "msg" => $res["msg"]]);
            exit();
      }
      Notifikasi::push($conn, $res["data"], $_COOKIE["token"], "membuat pengajuan baru");
}

if (!move_uploaded_file($_FILES['file']['tmp_name'], CONTAINER . $id . ".pdf")) {
      echo json_encode(["code" => 400, "msg" => "failed upload"]);
      exit();
}
echo json_encode(["code" => 200, "msg" => $res["data"]]);
exit();
