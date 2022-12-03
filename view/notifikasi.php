<?php
require_once __DIR__ . "/../tools.php";
require_once __DIR__ . "/../env.php";
require_once __DIR__ . "/../controller/notifikasi_controller.php";
require_once __DIR__ . "/../controller/user_controller.php";

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
    <h1 class="text-center">NOTIFIKASI</h1>
    <div class="d-flex flex-column align-items-center overflow-auto" style="height:75vh;">
        <?php foreach (getMyNotification() as $notification) : ?>
            <div class="card w-50 mb-2 p-2 <?= !notificationIsReadBy($notification, $_COOKIE["token"]) ? "bg-success p-2 text-white bg-opacity-75" : "" ?>">
                <p><?= $notification->who . " " . $notification->message . " pada pengajuan \"" . $notification->judul_pengajuan . "\"" ?></p>
                <a href="<?= ROOT ?>/routes/read_notification.php?notifikasi=<?= $notification->id ?>&pengajuan=<?= $notification->pengajuan ?>" class="btn btn-primary">Lihat</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>