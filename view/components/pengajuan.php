<div class="container w-50">
    <hr>
    <h1><?= ucwords($data->judul) ?></h1>
    <h3 class="text-secondary"><?= ucwords($data->kategori) ?></h3>
    <h3 class="<?= $data->status == "diterima" ? "text-success" : ($data->status == "ditolak" ? "text-danger" : "text-dark") ?>">Progres: <?= $data->status ?></h3>

    <hr>
    <?php if (!$data->file_hasil && (str_contains($data->kategori, "tanda tangan") || $_SESSION["role"] == "MAHASISWA")) : ?>
        <form method="post" id="upload">
            <div class="mb-3">
                <label for="file_hasil" class="form-label"><?= $_SESSION["role"] == "MAHASISWA" ? "Revisi surat" : "Upload file tanda tangan" ?></label>
                <input class="form-control" type="file" id="file_hasil" name="file_hasil">
                <p id="surat-error"></p>
                <button type="submit" class="btn btn-outline-primary w-100">Upload</button>
            </div>
        </form>
    <?php endif; ?>

    <div class="mb-3 d-flex gap-3">
        <?php if ($data->file_hasil) : ?>
            <a class="btn btn-primary flex-fill" href="<?= ROOT ?>/container/<?= $data->file_hasil ?>.pdf" target="_blank">Lihat file hasil</a>
        <?php endif; ?>
        <a class="btn btn-primary flex-fill" href="<?= ROOT ?>/container/<?= $data->file ?>.pdf" target="_blank">Lihat surat</a>
    </div>

    <?php if ($_SESSION["role"] != "MAHASISWA" && $data->file_hasil == NULL) : ?>
        <div class="d-flex gap-3">
            <?php if ($data->status != "diterima") : ?>
                <a class="btn btn-success flex-fill" href="<?= ROOT ?>/view/listpengajuan.php?accept=<?= $data->id ?>">Terima</a>
            <?php endif; ?>
            <?php if ($data->status != "ditolak") : ?>
                <a class="btn btn-danger flex-fill" href="<?= ROOT ?>/view/listpengajuan.php?reject=<?= $data->id ?>">Tolak</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <hr>
    <div class="mt-2">
        <h3>Komentar</h3>
        <form id="form-komentar" class="d-flex align-items-center mb-3" method="post">
            <input type="text" class="form-control me-2" name="komentar" id="komentar" placeholder="Komentar">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
        <div class="overflow-auto" style="max-height: 33vh;">
            <?php foreach (getComment($data->id) as $komen) : ?>
                <div class="card mb-2 p-3">
                    <p>From: <?= $komen->name ?></p>
                    <h3><?= $komen->komentar ?></h3>
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
            url: '<?= ROOT ?>/routes/filehandle.php',
            dataType: "text",
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
        $.post("<?= ROOT ?>/routes/post_comment.php", {
            message: $("#komentar").val(),
            pengajuan: "<?= $data->id ?>"
        }).then((data, status, jqXHR) => {
            location.reload();
        });
    }
    $("#upload").submit(upload_filehasil);
    $("#form-komentar").submit(komentar);
</script>