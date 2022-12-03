<?php

class Notifikasi
{
    public $id;
    public $who;
    public $pengajuan;
    public $judul_pengajuan;
    public $message;
    public $read;

    public function __construct($id, $pengajuan, $who, $message, $judul)
    {
        $this->id = $id;
        $this->pengajuan = $pengajuan;
        $this->who = $who;
        $this->message = $message;
        $this->judul_pengajuan = $judul;
    }

    public static function push($conn, $pengajuan_id, $user_id, $msg)
    {
        $id = uniqid() . uniqid();
        $now = time();
        $query = "INSERT INTO notifikasi (id, pengajuan_id, who, msg, created_at) VALUES ('$id', '$pengajuan_id', '$user_id', '$msg', $now);";
        try {
            $conn->query($query);
            return ["code" => 200, "data" => "OK"];
        } catch (Exception $e) {
            return ["code" => 400, "data" => $e->getMessage()];
        }
    }

    public static function isFor($conn, $user_id)
    {
        $query = "SELECT n.id as id, n.pengajuan_id as pengajuan, p.judul, msg, u.name FROM notifikasi n JOIN pengajuan p ON n.pengajuan_id = p.id JOIN users u ON u.id = who WHERE who <> '$user_id' AND (p.created_by = '$user_id' OR p.forwarded_to = '$user_id') ORDER BY n.created_at DESC;";
        try {
            $res = $conn->query($query);
            if ($res->num_rows > 0) {
                $buffer = [];

                while ($row = $res->fetch_assoc()) {
                    array_push($buffer, new Notifikasi($row["id"], $row["pengajuan"], $row["name"], $row["msg"], $row["judul"]));
                }
                return ["code" => 200, "data" => $buffer];
            }
            return ["code" => 200, "data" => []];
        } catch (Exception $e) {
            return ["code" => 400, "data" => $e->getMessage()];
        }
    }
    public static function notificationReadCount($conn, $user_id){
        $query = "SELECT count(n.id) FROM notifikasi n JOIN notifikasi_read nr ON nr.notifikasi_id = n.id WHERE nr.user_id = '$user_id';";
        $res = $conn->query($query);
        return $res->fetch_assoc();
    }
    public function isReadBy($conn, $user_id)
    {
        $query = "SELECT * FROM notifikasi_read WHERE notifikasi_id = '$this->id' AND user_id = '$user_id';";
        $res = $conn->query($query);
        if ($res->num_rows > 0) {
            return true;
        }
        return false;
    }

    public static function readBy($conn, $notifikasi_id, $user_id)
    {
        $query = "INSERT INTO notifikasi_read (notifikasi_id, user_id) VALUES ('$notifikasi_id', '$user_id');";
        try {
            $conn->query($query);
            return ["code" => 200, "data" => "OK"];
        } catch (Exception $e) {
            return ["code" => 400, "data" => $e->getMessage()];
        }
    }
}
