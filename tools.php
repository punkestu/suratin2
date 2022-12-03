<?php
function isauth()
{
      if (isset($_COOKIE["token"])) {
            require_once __DIR__ . "/model/user_model.php";
            $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
            if (User::idExists($conn, $_COOKIE["token"])) {
                  return true;
            }
      }

      return false;
}
function homeIfnotMahasiswa()
{
      if ($_SESSION["role"] != "MAHASISWA") {
            header("location:" . ROOT . "/view/home.php");
      }
}

function loginIfnotAuth()
{
      if (!isauth()) {
            header("location:" . ROOT . "/view/login.php");
      }
}
