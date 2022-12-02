<?php
require_once __DIR__ . "/../model/user_model.php";
function getDosen()
{
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
    $data = User::whereNotMahasiswa($conn);
    return $data;
}
