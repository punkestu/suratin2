<?php
require_once __DIR__ . "/../model/user_model.php";
$msg = [];

if (isset($_GET["want"]) && $_GET["want"] == "dosen") {
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $data = User::whereNotMahasiswa($conn);
      echo json_encode($data);
      exit();
}

if ($_POST["to"] == "register" && $_POST["name"] == "") {
      $msg["name"] = "nama tidak boleh kosong";
}
if ($_POST["to"] == "register" && $_POST["email"] == "") {
      $msg["name"] = "email tidak boleh kosong";
}
if ($_POST["username"] == "") {
      $msg["username"] = "username tidak boleh kosong";
}
if ($_POST["password"] == "") {
      $msg["password"] = "password tidak boleh kosong";
}

if (count($msg) > 0) {
      http_response_code(400);
      echo json_encode(["code" => 400, "msg" => $msg]);
      exit();
}

$conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
if ($_POST["to"] == "register") {
      $query = User::create($conn, $_POST["name"], $_POST["email"], $_POST["username"], $_POST["password"], "MAHASISWA");

      if ($query["msg"] != NULL) {
            http_response_code(400);
            echo json_encode(["code" => 400, "msg" => $query["msg"]]);
            exit();
      }
      setcookie("token", $query["data"], 0, "/");
      session_start();
      $_SESSION["role"] = User::roleWhereId($conn, $query["data"])["role_name"];
}
if ($_POST["to"] == "login") {
      $user = new User();
      $res = $user->setWhereUsername($conn, $_POST["username"]);
      if ($res != "OK") {
            $msg["username"] = "username not found";
      } else {
            if ($user->password != $_POST["password"]) {
                  $msg["password"] = "password wrong";
            } else {
                  session_start();
                  $_SESSION["role"] = $user->role;
                  setcookie("token", $user->id, 0, "/");
            }
      }
}

if (count($msg) > 0) {
      http_response_code(400);
      echo json_encode(["code" => 400, "msg" => $msg]);
      exit();
}

http_response_code(200);
exit();
