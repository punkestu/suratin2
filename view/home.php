<?php
require_once __DIR__ . "/../tools.php";
require_once __DIR__ . "/../env.php";
require_once __DIR__ . "/../controller/pengajuan_controller.php";

session_start();
loginIfnotAuth();
?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
      <script>
            const logout = () => {
                  document.cookie = "token=; path=/"
                  window.location.replace("<?= ROOT ?>/view/login.php");
            }
      </script>
</head>

<body>
      <?php include_once __DIR__ . "/components/navbar.php"; ?>

      <h1 class="text-center">WELCOME</h1>
      <div class="d-flex flex-column">
            <div class="card py-4 d-flex flex-column align-items-center w-50 mx-auto">
                  <?php
                  $pengajuan = getYours();
                  ?>
                  <div class="card text-center p-2 w-75 mb-2">
                        <h4>Surat yang kamu ajukan</h4>
                        <h4><?= getCount()["data"] ?></h4>
                  </div>
                  <div class="card text-center p-2 w-75 mb-2 bg-success">
                        <h4 class="text-light">Surat yang diterima</h4>
                        <h4 class="text-light"><?= getCountSuccess()["data"] ?></h4>
                  </div>
                  <div class="card text-center p-2 w-75 mb-2 bg-danger">
                        <h4 class="text-light">Surat yang ditolak</h4>
                        <h4 class="text-light"><?= getCountFailed()["data"] ?></h4>
                  </div>
                  <a class="btn btn-lg btn-primary w-75" href="<?= ROOT ?>/view/listpengajuan.php?code=">Buka list pengajuan &raquo;</a>
            </div>
            <?php if ($_SESSION["role"] == "MAHASISWA") : ?>
                  <a class="btn btn-lg btn-primary mt-2 mx-auto w-50" href="<?= ROOT ?>/view/buatpengajuan.php">&plus; Ajukan surat</a>
            <?php endif; ?>
      </div>
</body>

</html>