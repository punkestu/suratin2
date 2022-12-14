<?php
require_once __DIR__ . "/../model/pengajuan_model.php";

function getYours()
{
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $data = Pengajuan::whereCreatedBy($conn, $_COOKIE["token"]);
      return $data;
}
function getForYou()
{
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $data = Pengajuan::whereForwardTo($conn, $_COOKIE["token"]);
      return $data;
}
function getCount()
{
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $data = Pengajuan::count($conn, $_COOKIE["token"]);
      return $data;
}
function getCountSuccess()
{
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $data = Pengajuan::countStatus($conn, $_COOKIE["token"], "diterima");
      return $data;
}
function getCountFailed()
{
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $data = Pengajuan::countStatus($conn, $_COOKIE["token"], "ditolak");
      return $data;
}
function getById($id)
{
      $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
      $data = new Pengajuan();
      $res = $data->setWhereId($conn, $_COOKIE["token"], $id);
      return $res == NULL ? NULL : $data;
}
function updateStatusPengajuan()
{
      if (isset($_GET["accept"])) {
            $data = getById($_GET["accept"]);
            $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
            $data->updateStatus($conn, "diterima");
      }
      if (isset($_GET["reject"])) {
            $data = getById($_GET["reject"]);
            $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
            $data->updateStatus($conn, "ditolak");
      }
}
