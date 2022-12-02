<?php
require __DIR__ . "/../env.php";

function translateRole($conn, $role)
{
      $res = $conn->query("SELECT kode FROM role_user WHERE role_name='$role'");
      if ($res->num_rows > 0) {
            $res = $res->fetch_assoc();
            $res = $res["kode"];
      } else {
            $res = NULL;
      }
      return $res;
}

class User
{
      public $id;
      public $username;
      public $name;
      public $role;
      public $password;

      private function set($row)
      {
            $this->id = $row["id"];
            $this->username = $row["username"];
            $this->password = $row["password"];
            $this->name = $row["name"];
            $this->role = $row["role"];
      }
      public function setWhereId($conn, $userid){
            $query = "SELECT id, username, password, name, role_name as role FROM users u JOIN role_user ru ON ru.kode = u.kode_role WHERE id = '$userid'";
            $res = $conn->query($query);
            if ($res->num_rows > 0) {
                  $row = $res->fetch_assoc();
                  $this->set($row);
                  return 'OK';
            }
            return NULL;
      }
      public function setWhereUsername($conn, $username, $index = 0)
      {
            $query = "SELECT id, username, password, name, role_name as role FROM users u JOIN role_user ru ON ru.kode = u.kode_role WHERE username = '$username'";
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
      public static function idExists($conn, $id)
      {
            $query = "SELECT id FROM users WHERE id = '$id'";
            $res = $conn->query($query);
            if ($res->num_rows > 0) {
                  return true;
            }
            return false;
      }
      public static function roleWhereId($conn, $id)
      {
            $query = "SELECT role_name FROM users u JOIN role_user ru ON u.kode_role=ru.kode WHERE u.id='$id';";
            $res = $conn->query($query);
            if ($res->num_rows > 0) {
                  return $res->fetch_assoc();
            }
            return NULL;
      }
      public static function whereNotMahasiswa($conn)
      {
            $query = "SELECT id, name FROM users WHERE kode_role <> 3;";
            $res = $conn->query($query);
            if ($res->num_rows > 0) {
                  $buffer = [];

                  while ($row = $res->fetch_assoc()) {
                        array_push($buffer, $row);
                  }

                  return $buffer;
            }
            return [];
      }
      public static function create($conn, $name, $email, $username, $password, $role)
      {
            $id = uniqid();
            $role = translateRole($conn, $role);
            $res = ["msg" => NULL, "data" => ""];
            try {
                  $conn->query("INSERT INTO users (id, name, email, username, password, kode_role) VALUES ('$id', '$name', '$email', '$username', '$password', $role) ");
                  $res["data"] = $id;
            } catch (Exception $e) {
                  $res["msg"] = $e->getMessage();
            }
            return $res;
      }
}
