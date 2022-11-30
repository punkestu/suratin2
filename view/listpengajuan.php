<?php
require_once __DIR__ . "/../controller/pengajuan_controller.php";
require_once __DIR__ . "/../controller/komentar_controller.php";
require_once __DIR__ . "/../tools.php";

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
                        <a href="<?= ROOT ?>/view/listpengajuan.php" class="fw-bold text-light me-5 text-decoration-none">Suratmu</a>
                  </li>
                  <li class="list-unstyled">
                        <a href="<?= ROOT ?>/view/buatpengajuan.php" class="text-light me-5 text-decoration-none">Ajukan</a>
                  </li>
                  <li class="list-unstyled">
                        <a href="<?= ROOT ?>/view/profile.php" class="text-light me-5 text-decoration-none">Profile</a>
                  </li>
                  <li class="list-unstyled">
                        <button onclick="logout()" class="btn btn-danger">Keluar</button>
                  </li>
            </ul>
      </nav>
      <?php if (!isset($_GET["code"])) : ?>
            <div id="list" class="container">
                  <?php
                  session_start();
                  $data = [];
                  if ($_SESSION["role"] == "MAHASISWA") {
                        $data = getYours();
                  } else {
                        $data = getForYou();
                  }
                  if (count($data["data"]) == 0) : ?>
                        <h1>Tidak ada pengajuan surat</h1>
                  <?php endif;
                  foreach ($data["data"] as $d) : ?>
                        <div class="card mb-2 p-4">
                              <h1 class="card-title"><?= $d["judul"] ?></h1>
                              <h4 class="text-secondary"><?= $d["kategori"] ?></h4>
                              <div class="card-body">
                                    <p>Diajukan pada: <?= $d["created_at"] ?></p>
                                    <p>Ditujukan untuk: <?= $d["forward"] ?></p>
                                    <h3 class="<?= $d["status"] == "diterima" ? "text-success" : ($d["status"] == "ditolak" ? "text-danger" : "text-secondary") ?>">Progres: <?= $d["status"] ?></h3>
                              </div>
                              <a href="<?= ROOT ?>/view/listpengajuan.php?code=<?= $d['id'] ?>" class="btn btn-primary">Detail</a>
                        </div>
                  <?php endforeach; ?>
            </div>
      <?php else : ?>
            <?php
            session_start();
            $data = getById($_GET["code"]);
            if ($data == NULL) : ?>
                  <h1>404 data not found</h1>
            <?php else : ?>
                  <div class="container">
                        <h1><?= $data->judul ?></h1>
                        <h3 class="text-secondary"><?= $data->kategori ?></h3>
                        <h3 class="<?= $data->status == "diterima" ? "text-success" : ($data->status == "ditolak" ? "text-danger" : "text-dark") ?>">Progres: <?= $data->status ?></h3>
                        <?php if (!$data->file_hasil && (str_contains($data->kategori, "tanda tangan") || $_SESSION["role"] == "MAHASISWA")) : ?>
                              <br>
                              <hr>
                              <form method="post" id="upload">
                                    <div class="mb-3">
                                          <label for="file_hasil" class="form-label"><?= $_SESSION["role"] == "MAHASISWA" ? "Revisi surat" : "Upload file tanda tangan" ?></label>
                                          <input class="form-control" type="file" id="file_hasil" name="file_hasil">
                                          <p id="surat-error"></p>
                                          <button type="submit" class="btn btn-outline-primary w-100">Upload</button>
                                    </div>
                              </form>
                        <?php endif; ?>
                        <?php if ($data->file_hasil) : ?>
                              <a class="btn btn-primary" href="<?= ROOT ?>/container/<?= $data->file_hasil ?>.pdf" target="_blank">Lihat file hasil</a>
                        <?php endif; ?>
                        <a class="btn btn-primary" href="<?= ROOT ?>/container/<?= $data->file ?>.pdf" target="_blank">Lihat surat</a>
                        <br>
                        <br>
                        <?php if ($_SESSION["role"] != "MAHASISWA" && $data->file_hasil == NULL) : ?>
                              <?php if ($data->status != "diterima") : ?>
                                    <a class="btn btn-success" href="<?= ROOT ?>/view/listpengajuan.php?accept=<?= $data->id ?>">Terima</a>
                              <?php endif; ?>
                              <?php if ($data->status != "ditolak") : ?>
                                    <a class="btn btn-danger" href="<?= ROOT ?>/view/listpengajuan.php?reject=<?= $data->id ?>">Tolak</a>
                              <?php endif; ?>
                        <?php endif; ?>
                        <hr>
                        <div>
                              <h3>Komentar</h3>
                              <form id="form-komentar" class="d-flex align-items-center mb-3" method="post">
                                    <input type="text" class="form-control me-2" name="komentar" id="komentar" placeholder="Komentar">
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                              </form>
                              <div>
                                    <?php foreach (getComment($data->id) as $komen) : ?>
                                          <div class="card mb-2 p-3">
                                                <p>From: <?= $komen["name"] ?></p>
                                                <h3><?= $komen["komentar"] ?></h3>
                                          </div>
                                    <?php endforeach; ?>
                              </div>
                        </div>
                  </div>
                  </div>
                  <script>
                        const upload_filehasil = e => {
                              e.preventDefault();

                              $("#surat-error").html("");
                              error = false;
                              if ($("#file_hasil")[0].files[0].size > 20 * 1000 * 1024) {
                                    error = true;
                                    $("#surat-error").append("ukuran file terlalu besar <br>");
                              }
                              if ($("#file_hasil")[0].files[0].type != "application/pdf") {
                                    error = true;
                                    $("#surat-error").append("hanya bisa mengirim file pdf <br>");
                              }
                              if (error) {
                                    return;
                              }
                              var file_data = $("#file_hasil").prop('files')[0];
                              var form_data = new FormData();
                              form_data.append("file", file_data);
                              form_data.append("token", "<?= $data->id ?>");
                              $.ajax({
                                    url: '<?= ROOT ?>/controller/file_controller.php',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: form_data,
                                    type: 'post',
                              }).then((data, status, jqXHR) => {
                                    data = JSON.parse(data);
                                    if (data["code"] == 200) {
                                          $("#surat-error").html("success");
                                          location.reload();
                                    } else if (data["code"] == 400) {
                                          $("#surat-error").html("error: " + data["msg"]);
                                    }
                              });
                        }
                        const komentar = (e) => {
                              e.preventDefault();
                              $.post("<?= ROOT ?>/controller/komentar_controller.php", {
                                    message: $("#komentar").val(),
                                    pengajuan: "<?= $data->id ?>",
                                    want: "post_comment"
                              }).then((data, status, jqXHR) => {
                                    location.reload();
                              });
                        }
                        $("#upload").submit(upload_filehasil);
                        $("#form-komentar").submit(komentar);
                  </script>
            <?php endif; ?>
      <?php endif; ?>
</body>

</html>