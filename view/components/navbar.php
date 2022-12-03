<?php
require_once __DIR__ . "/../../controller/notifikasi_controller.php";
?>

<nav class="navbar navbar-expand-lg py-0 px-3 d-flex align-items-center justify-content-between bg-primary navbar-dark mb-3">
    <a class="navbar-brand" href="<?= ROOT ?>/view/home.php">Surat.in</a>
    <ul class="my-3 d-flex align-items-center">
        <li class="list-unstyled">
            <a href="<?= ROOT ?>/view/home.php" class="text-light me-5 text-decoration-none">Home</a>
        </li>
        <li class="list-unstyled">
            <a href="<?= ROOT ?>/view/listpengajuan.php?code=" class="text-light me-5 text-decoration-none">Suratmu</a>
        </li>
        <?php if ($_SESSION["role"] == "MAHASISWA") : ?>
            <li class="list-unstyled">
                <a href="<?= ROOT ?>/view/buatpengajuan.php" class="text-light me-5 text-decoration-none">Ajukan</a>
            </li>
        <?php endif; ?>
        <li class="list-unstyled">
            <a href="<?= ROOT ?>/view/notifikasi.php" class="<?= getNotificationCount() > 0 ? "bg-warning text-dark" : "text-light" ?> p-2 rounded me-5 text-decoration-none">Notifikasi</a>
        </li>
        <li class="list-unstyled">
            <a href="<?= ROOT ?>/view/profile.php" class="text-light me-5 text-decoration-none">Profile</a>
        </li>
        <li class="list-unstyled">
            <button onclick="logout()" class="btn btn-danger">Keluar</button>
        </li>
    </ul>
</nav>