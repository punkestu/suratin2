<?php
require_once __DIR__ . "/../model/user_model.php";
function getDosen()
{
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
    $data = User::whereNotMahasiswa($conn);
    return $data;
}
function youAreAdmin(){
    if($_COOKIE["token"] != "" && isset($_COOKIE["token"])){
        $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
        $data = User::isAdmin($conn, $_COOKIE["token"]);
        return $data;
    }
    return false;
}