<?php
require_once __DIR__ . "/../model/user_model.php";
$msg = [];

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

if (count($msg) > 0) {
      http_response_code(400);
      echo json_encode(["code" => 400, "msg" => $msg]);
      exit();
}

http_response_code(200);
exit();