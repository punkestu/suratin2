<?php
require_once __DIR__ . "/../tools.php";
require_once __DIR__ . "/../env.php";

if (isauth()) {
      header("location:" . ROOT . "/view/home.php");
}
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
</head>

<body>
      <h1 class="text-center my-2">Daftar</h1>
      <form method="post" class="container w-25">
            <div class="mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                  <p id="name-error" class="form-text text-danger"></p>
            </div>
            <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                  <p id="email-error" class="form-text text-danger"></p>
            </div>
            <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                  <p id="username-error" class="form-text text-danger"></p>
            </div>
            <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" aria-describedby="emailHelp">
                  <p id="password-error" class="form-text text-danger"></p>
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
            <a href="<?= ROOT ?>/view/login.php" class="btn btn-outline-primary">Masuk</a>
      </form>
      <script>
            const register = e => {
                  e.preventDefault();
                  $.post("<?= ROOT ?>/controller/auth.php", {
                        name: $("#name").val(),
                        email: $("#email").val(),
                        username: $("#username").val(),
                        password: $("#password").val(),
                        to: "register"
                  }, (data, status, jqXHR) => {
                        window.location.replace("<?= ROOT ?>/view/home.php");
                  }).catch(err => {
                        err = JSON.parse(err.responseText);
                        $("#name-error").html(err["msg"]["name"] || "");
                        $("#email-error").html(err["msg"]["email"] || "");
                        $("#username-error").html(err["msg"]["username"] || "");
                        $("#password-error").html(err["msg"]["password"] || "");
                  });
            };
            $("form").submit(register);
      </script>
</body>

</html>