<?php
class Komentar
{
      public $id;
      public $name;
      public $komentar;

      public function __construct($id, $name, $komentar)
      {
            $this->id = $id;
            $this->name = $name;
            $this->komentar = $komentar;
      }
      public static function create($conn, $message, $user_id, $pengajuan_id)
      {
            $id = uniqid() . uniqid();
            $query = "INSERT INTO komentar (id, pengajuan_id, user_id, komentar) VALUES ('$id', '$pengajuan_id', '$user_id', '$message');";
            $res = ["msg" => NULL, "data" => ""];
            try {
                  $conn->query($query);
                  $res["data"] = $id;
            } catch (Exception $e) {
                  $res["msg"] = $e->getMessage();
            }
            return $res;
      }
      public static function wherePengajuanId($conn, $pengajuan_id){
            $query = "SELECT k.id as id, name, komentar FROM komentar k JOIN users u ON u.id=k.user_id WHERE pengajuan_id='$pengajuan_id'";
            $res = $conn->query($query);
            if ($res->num_rows > 0) {
                  $buffer = [];

                  while ($row = $res->fetch_assoc()) {
                        array_push($buffer, new Komentar($row["id"], $row["name"], $row["komentar"]));
                  }

                  return $buffer;
            }
            return [];
      }
}
