<?php
require_once __DIR__ . "/../tools.php";
require_once __DIR__ . "/../env.php";
require_once __DIR__ . "/../controller/user_controller.php";

session_start();
homeIfnotMahasiswa();
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
                  window.location.replace("<?= ROOT ?>/login/");
            }
      </script>
</head>

<body>
      <?php include_once __DIR__ . "/components/navbar.php"; ?>

      <h1 class="text-center">BUAT PENGAJUAN BARU</h1>
      <form method="post" class="container card w-25 p-3">
            <hr>
            <div class="mb-2">
                  <label for="judul" class="form-label">Judul</label>
                  <input type="text" class="form-control m-0" name="judul" id="judul" placeholder="Judul">
                  <p class="form-text text-danger" id="judul-error"></p>
            </div>
            <div class="mb-2">
                  <label for="dosen" class="form-label">Tujuan</label>
                  <select name="dosen" id="dosen" class="form-select">
                        <?php foreach (getDosen() as $d) : ?>
                              <option value="<?= $d["id"] ?>"> <?= $d["name"] ?></option>
                        <?php endforeach; ?>
                  </select>
                  <p class="form-text text-danger" id="dosen-error"></p>
            </div>
            <div class="mb-2">
                  <label for="kategori" class="form-label">Kategori surat</label>
                  <select name="kategori" id="kategori" class="form-select">
                        <option value="1">peminjaman tempat</option>
                        <option value="2">peminjaman alat</option>
                        <option value="3">tanda tangan proposal</option>
                        <option value="4">tandan tangan lpj</option>
                        <option value="5">tugas</option>
                        <option value="6">ijin</option>
                        <option value="7">dispensasi</option>
                        <option value="8">beasiswa</option>
                  </select>
                  <p class="form-text text-danger" id="kategori-error"></p>
            </div>
            <div class="mb-2">
                  <label for="surat" class="form-label">Upload surat</label>
                  <input class="form-control" type="file" id="surat" name="surat">
                  <p id="surat-error" class="form-text text-danger"></p>
            </div>
            <button id="upload" class="btn btn-primary">Ajukan</button>
      </form>
      <script>
            const ajukan = e => {
                  e.preventDefault();

                  $("#surat-error").html("");
                  $("#judul-error").html("");
                  error = false;

                  if ($("#surat")[0].files.length == 0) {
                        $("#surat-error").html("file harus diisi");
                        error = true;
                  }

                  if ($("#judul").val() == "") {
                        $("#judul-error").html("judul harus diisi");
                        error = true;
                  }
                  if (error) {
                        return;
                  }

                  if ($("#surat")[0].files[0].size > 20 * 1000 * 1024) {
                        error = true;
                        $("#surat-error").append("ukuran file terlalu besar <br>");
                  }
                  if ($("#surat")[0].files[0].type != "application/pdf") {
                        error = true;
                        $("#surat-error").append("hanya bisa mengirim file pdf <br>");
                  }
                  if (error) {
                        return;
                  }
                  var file_data = $('#surat').prop('files')[0];
                  var form_data = new FormData();
                  form_data.append("file", file_data);
                  form_data.append("kategori", $("#kategori").val());
                  form_data.append("judul", $("#judul").val());
                  form_data.append("dosen", $("#dosen").val());
                  $.ajax({
                        url: '<?= ROOT ?>/routes/filehandle.php',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                  }).then((data, status, jqXHR) => {
                        data = JSON.parse(data);
                        if (data["code"] == 200) {
                              $("#surat-error").html("success");
                              window.location.replace("<?= ROOT ?>/view/home.php");
                        } else if (data["code"] == 500) {
                              $("#surat-error").html("error: " + data["msg"]);
                        }
                  });
            }
            $("form").submit(ajukan);
      </script>
</body>

</html>