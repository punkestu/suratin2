<?php
require_once __DIR__ . "/../env.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
                  <li class="list-unstyled">
                        <a href="<?= ROOT ?>/view/buatpengajuan.php" class="text-light me-5 text-decoration-none">Ajukan</a>
                  </li>
                  <li class="list-unstyled">
                        <a href="<?= ROOT ?>/view/profile.php" class="fw-bold text-light me-5 text-decoration-none">Profile</a>
                  </li>
                  <li class="list-unstyled">
                        <button onclick="logout()" class="btn btn-danger">Keluar</button>
                  </li>
            </ul>
      </nav>
</body>

</html>