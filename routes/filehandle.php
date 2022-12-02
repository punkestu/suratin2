<?php
require_once __DIR__ . "/../model/pengajuan_model.php";

if (0 < $_FILES['file']['error']) {
      echo 'Error: ' . $_FILES['file']['error'] . '<br>';
      exit();
} else {
      $id = uniqid();

      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      if (isset($_POST["token"])) {
            $data = new Pengajuan();
            $data->setWhereId($conn, $_COOKIE["token"], $_POST["token"]);
            move_uploaded_file($_FILES['file']['tmp_name'], CONTAINER . $id . ".pdf");
            $res = NULL;
            session_start();
            if($_SESSION["role"] != "MAHASISWA"){
                  $res = $data->addFileHasil($conn, $id);
            }else{
                  $res = $data->revisiFile($conn, $id);
            }
            if (isset($res["msg"])) {
                  echo json_encode(["code" => 400, "msg" => $res["msg"]]);
                  exit();
            }
            echo json_encode(["code" => 200, "msg" => $res["data"]]);
            exit();
      } else {
            if($_POST["judul"] == ""){
                  echo json_encode(["code" => 400, "msg" => "judul harus diisi"]);
                  exit();
            }
            $res = Pengajuan::create($conn, $_POST["judul"], $_COOKIE["token"], $_POST["dosen"], $id, $_POST["kategori"]);
            if ($res["data"] == "") {
                  echo json_encode(["code" => 500, "msg" => $res["msg"]]);
                  exit();
            }
      }
      move_uploaded_file($_FILES['file']['tmp_name'], CONTAINER . $id . ".pdf");
      echo json_encode(["code" => 200, "msg" => $res["data"]]);
      exit();
}
