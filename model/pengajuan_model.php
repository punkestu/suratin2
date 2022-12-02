<?php
require __DIR__ . "/../env.php";
require __DIR__ . "/user_model.php";

function translateStatus($conn, $status)
{
      $res = $conn->query("SELECT kode FROM status WHERE status='$status'");
      if ($res->num_rows > 0) {
            $res = $res->fetch_assoc();
            $res = $res["kode"];
      } else {
            $res = NULL;
      }
      return $res;
}
function translateKategori($conn, $kategori)
{
      $res = $conn->query("SELECT kode FROM kategori_surat WHERE kategori='$kategori'");
      if ($res->num_rows > 0) {
            $res = $res->fetch_assoc();
            $res = $res["kode"];
      } else {
            $res = NULL;
      }
      return $res;
}

class Pengajuan
{
      public $id;
      public $judul;
      public $created_at;
      public $kategori;
      public $status;
      public $file;
      public $file_hasil;
      public $forward;

      private function set($row)
      {
            $this->id = $row["id"];
            $this->judul = $row["judul"];
            $this->created_at = $row["created_at"];
            $this->kategori = $row["kategori"];
            $this->status = $row["status"];
            $this->file = $row["file"];
            $this->file_hasil = $row["file_hasil"];
            $this->forward = $row["forward"];
      }
      public function setWhereId($conn, $createdBy, $id, $index = 0)
      {
            $query = "SELECT p.id as id, judul, created_at, kategori, s.status as status, file, file_hasil, name as forward FROM pengajuan p JOIN file_surat fs ON fs.id = p.file JOIN kategori_surat ks ON fs.kategori_id = ks.kode JOIN users u ON u.id = p.forwarded_to JOIN status s ON s.kode = p.status WHERE p.id = '$id' AND ( created_by='$createdBy' OR forwarded_to='$createdBy');";
            $res = $conn->query($query);
            if ($res->num_rows > 0) {
                  $row = [];
                  for ($i = 0; $i <= $index; $i++) {
                        $row = $res->fetch_assoc();
                  }
                  $this->set($row);
                  return 'OK';
            }
            return NULL;
      }
      public function updateStatus($conn, $status)
      {
            $res = [];
            try {
                  $status = translateStatus($conn, $status);
                  $query = "UPDATE pengajuan SET status=$status WHERE id='$this->id'";
                  $conn->query($query);
            } catch (Exception $e) {
                  $res["msg"] = $e->getMessage();
            }
            return $res;
      }
      public function addFileHasil($conn, $file)
      {
            try {
                  $conn->query("INSERT INTO file_surat (id, kategori_id) VALUES ('$file', 9);");
                  $query = "UPDATE pengajuan SET file_hasil='$file' WHERE id='$this->id';";
                  $conn->query($query);
            } catch (Exception $e) {
                  $res["msg"] = $e->getMessage();
            }
            return $res;
      }
      public function revisiFile($conn, $file)
      {
            try {
                  $kategori = translateKategori($conn, $this->kategori);
                  $conn->query("INSERT INTO file_surat (id, kategori_id) VALUES ('$file', $kategori);");
                  $query = "UPDATE pengajuan SET file='$file' WHERE id='$this->id';";
                  $conn->query($query);
            } catch (Exception $e) {
                  $res["msg"] = $e->getMessage();
            }
            return $res;
      }
      public static function create($conn, $judul, $created_by, $forwarded_to, $file, $kategori)
      {
            $id = uniqid();
            $res = ["msg" => NULL, "data" => ""];
            try {
                  $conn->query("INSERT INTO file_surat (id, kategori_id) VALUES ('$file',$kategori);");
                  $conn->query("INSERT INTO pengajuan (id, judul, created_by, forwarded_to, created_at, file, status) VALUES('$id', '$judul', '$created_by', '$forwarded_to', UNIX_TIMESTAMP(), '$file', 1);");
                  $res["data"] = $id;
            } catch (Exception $e) {
                  $res["msg"] = $e->getMessage();
            }
            return $res;
      }

      public static function whereCreatedBy($conn, $createdBy)
      {
            try {
                  $query = "SELECT p.id as id, judul, created_at, kategori, s.status as status, file, file_hasil, name as forward FROM pengajuan p JOIN file_surat fs ON fs.id = p.file JOIN kategori_surat ks ON fs.kategori_id = ks.kode JOIN users u ON u.id = p.forwarded_to JOIN status s ON s.kode = p.status WHERE created_by='$createdBy';";
                  $res = $conn->query($query);
                  if ($res->num_rows > 0) {
                        $buffer = [];

                        while ($row = $res->fetch_assoc()) {
                              $row["created_at"] = strftime("%d/%b/%Y %R %Z");
                              array_push($buffer, $row);
                        }
                        return ["code" => 200, "data" => $buffer];
                  }
                  return ["code" => 200, "data" => []];
            } catch (Exception $e) {
                  return ["code" => 400, "data" => $e->getMessage()];
            }
      }
      public static function count($conn, $createdBy){
            try {
                  $query = "SELECT count(id) FROM pengajuan WHERE created_by='$createdBy';";
                  $res = $conn->query($query);
                  if ($res->num_rows > 0) {
                        $row = $res->fetch_assoc();
                        return ["code" => 200, "data" => $row["count(id)"]];
                  }
                  return ["code" => 200, "data" => []];
            } catch (Exception $e) {
                  return ["code" => 400, "data" => $e->getMessage()];
            }
      }
      public static function countStatus($conn, $createdBy, $status){
            try {
                  $query = "SELECT count(id) FROM pengajuan p JOIN status s ON p.status = s.kode WHERE s.status='$status' AND p.created_by='$createdBy';";
                  $res = $conn->query($query);
                  if ($res->num_rows > 0) {
                        $row = $res->fetch_assoc();
                        return ["code" => 200, "data" => $row["count(id)"]];
                  }
                  return ["code" => 200, "data" => []];
            } catch (Exception $e) {
                  return ["code" => 400, "data" => $e->getMessage()];
            }
      }
      public static function whereForwardTo($conn, $forwardTo)
      {
            try {
                  $query = "SELECT p.id as id, judul, created_at, kategori, s.status as status, file, file_hasil, name as forward FROM pengajuan p JOIN file_surat fs ON fs.id = p.file JOIN kategori_surat ks ON fs.kategori_id = ks.kode JOIN users u ON u.id = p.forwarded_to JOIN status s ON s.kode = p.status WHERE forwarded_to='$forwardTo';";
                  $res = $conn->query($query);
                  if ($res->num_rows > 0) {
                        $buffer = [];

                        while ($row = $res->fetch_assoc()) {
                              $row["created_at"] = strftime("%d/%b/%Y %R %Z");
                              array_push($buffer, $row);
                        }
                        return ["code" => 200, "data" => $buffer];
                  }
                  return ["code" => 200, "data" => []];
            } catch (Exception $e) {
                  return ["code" => 400, "data" => $e->getMessage()];
            }
      }

      public static function deleteWhereId($conn, $id, $user_id){
            
      }
}