<?php
require_once __DIR__ . "/../controller/user_controller.php";
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
      <?php if (youAreAdmin()) : ?>
            <?php include_once __DIR__ . "/components/navbar.php"; ?>
            <form class="container w-25 d-flex flex-column">
                  <div class="mb-1">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        <p class="email-error form-text text-danger"></p>
                  </div>
                  <div class="mb-1">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                        <p class="email-error form-text text-danger"></p>
                  </div>
                  <div class="mb-1">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" aria-describedby="emailHelp">
                        <p id="password-error" class="form-text text-danger"></p>
                  </div>
                  <button type="submit" class="btn btn-primary">Ubah</button>
            </form>
            <script>
                  const ubah = e => {
                        e.preventDefault();
                        $.post("<?= ROOT ?>/routes/ubahpassword.php", {
                              email: $("#email").val(),
                              username: $("#username").val(),
                              password: $("#password").val()
                        }, (data, status, jqXHR) => {
                              window.location.replace("<?= ROOT ?>/view/home.php");
                        }).catch(err => {
                              err = JSON.parse(err.responseText);
                              $(".email-error").html(err["email"] || "");
                              $("#password-error").html(err["password"] || "");
                        });
                  };
                  $("form").submit(ubah);
            </script>
      <?php else : ?>
            <div class="d-flex flex-column align-items-center">
                  <h1>Silahkan hubungi Admin untuk merubah password</h1>
                  <a href="<?= ROOT ?>/view/login.php" class="btn btn-primary">&laquo;Kembali ke halaman login</a>
            </div>
      <?php endif; ?>
</body>

</html>