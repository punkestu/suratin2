<?php
require_once __DIR__."/../env.php";
require_once __DIR__."/../model/user_model.php";

$msg = [];
if($_POST["email"] == "" && $_POST["username"] == ""){
      $msg["email"] = "email atau username tidak boleh kosong";
}
if($_POST["password"] == ""){
      $msg["password"] = "masukan password yang baru";
}

if(count($msg) > 0){
      http_response_code(400);
      echo json_encode($msg);
      exit();
}

$conn = new mysqli(HOST,USERNAME,PASSWORD,DB);
$res = User::changePassword($conn, $_POST["username"], $_POST["email"], $_POST["password"]);