<?php
require_once __DIR__ . "/../controller/pengajuan_controller.php";
require_once __DIR__ . "/../controller/komentar_controller.php";
require_once __DIR__ . "/../tools.php";

session_start();
loginIfnotAuth();
updateStatusPengajuan();
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
                  window.location.replace("<?= ROOT ?>/login/");
            }
      </script>
</head>

<body>
      <?php include_once __DIR__ . "/components/navbar.php"; ?>

      <h1 class="text-center">LIST PENGAJUAN SURAT</h1>
      <?php if ($_GET["code"] == "") : ?>
            <div id="list" class="container d-flex flex-column align-items-center">
                  <hr>
                  <?php
                  $data = [];
                  if ($_SESSION["role"] == "MAHASISWA") {
                        $data = getYours();
                  } else {
                        $data = getForYou();
                  }
                  if (count($data["data"]) == 0) : ?>
                        <h1 class="text-center">Tidak ada pengajuan surat</h1>
                  <?php endif;
                  foreach ($data["data"] as $d) : ?>
                        <div class="card w-50 mb-2 p-4">
                              <h1 class="card-title"><?= ucwords($d["judul"]) ?></h1>
                              <h4 class="text-secondary"><?= ucwords($d["kategori"]) ?></h4>
                              <hr>
                              <div class="card-body">
                                    <p>Diajukan pada: <?= $d["created_at"] ?></p>
                                    <p>Ditujukan untuk: <?= $d["forward"] ?></p>
                                    <h3 class="<?= $d["status"] == "diterima" ? "text-success" : ($d["status"] == "ditolak" ? "text-danger" : "text-secondary") ?>">Progres: <?= $d["status"] ?></h3>
                              </div>
                              <a href="<?= ROOT ?>/pengajuan/<?= $d['id'] ?>" class="btn btn-primary mb-2">Detail</a>
                              <a href="<?= ROOT ?>/tarik/<?= $d['id'] ?>" class="btn btn-danger">Tarik</a>
                        </div>
                  <?php endforeach; ?>
            </div>
      <?php else : ?>
            <?php
            $data = getById($_GET["code"]);
            if ($data == NULL) : ?>
                  <h1 class="text-center">404 data not found</h1>
            <?php else : ?>
                  <?php include_once __DIR__ . "/components/pengajuan.php"; ?>
            <?php endif; ?>
      <?php endif; ?>
</body>

</html>