<?php
require_once __DIR__ . "/../env.php";
require_once __DIR__ . "/../tools.php";
require_once __DIR__ . "/../model/user_model.php";

session_start();
loginIfnotAuth();
$user = new User();
$conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
$user->setWhereId($conn, $_COOKIE["token"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
      <script>
            const logout = () => {
                  document.cookie = "token=; path=/"
                  window.location.replace("<?= ROOT ?>/view/login.php");
            }
      </script>
</head>

<body>
      <nav class="navbar navbar-expand-lg py-0 pt-3 px-3 d-flex justify-content-between bg-primary navbar-dark mb-3">
            <a class="navbar-brand" href="<?= ROOT ?>/view/home.php">Surat.in</a>
            <ul class="d-flex align-items-center">
                  <li class="list-unstyled">
                        <a href="<?= ROOT ?>/view/home.php" class="text-light me-5 text-decoration-none">Home</a>
                  </li>
                  <li class="list-unstyled">
                        <a href="<?= ROOT ?>/view/listpengajuan.php" class="text-light me-5 text-decoration-none">Suratmu</a>
                  </li>
                  <?php if ($_SESSION["role"] == "MAHASISWA") : ?>
                        <li class="list-unstyled">
                              <a href="<?= ROOT ?>/view/buatpengajuan.php" class="text-light me-5 text-decoration-none">Ajukan</a>
                        </li>
                  <?php endif; ?>
                  <li class="list-unstyled">
                        <a href="<?= ROOT ?>/view/profile.php" class="fw-bold text-light me-5 text-decoration-none">Profile</a>
                  </li>
                  <li class="list-unstyled">
                        <button onclick="logout()" class="btn btn-danger">Keluar</button>
                  </li>
            </ul>
      </nav>
      <h1 class="text-center">PROFILE</h1>
      <div class="card w-25 text-center mx-auto p-3">
            <h1><?= $user->name ?></h1>
            <h3 class="text-secondary"><?= $user->role ?></h2>
            <button onclick="logout()" class="mt-5 btn btn-lg btn-danger">Keluar</button>
      </div>
</body>

</html>