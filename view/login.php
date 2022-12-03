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
      <h1 class="text-center my-2">Masuk</h1>
      <form method="post" class="container w-25">
            <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username">
                  <p id="username-error" class="form-text text-danger"></p>
            </div>
            <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password">
                  <p id="password-error" class="form-text text-danger"></p>
            </div>
            <button type="submit" class="btn btn-primary">Masuk</button>
            <a href="<?= ROOT ?>/view/register.php" class="btn btn-outline-primary">Daftar</a>
      </form>
      <script>
            const login = e => {
                  e.preventDefault();
                  $.post("<?= ROOT ?>/authlogin/", {
                        username: $("#username").val(),
                        password: $("#password").val()
                  }).then((data, status, jqXHR) => {
                        window.location.replace("<?= ROOT ?>/home/");
                  }).catch((err) => {
                        console.log(err);
                        err = JSON.parse(err.responseText);
                        console.log(err["msg"]);
                        $("#username-error").html(err["msg"]["username"] || "");
                        $("#password-error").html(err["msg"]["password"] || "");
                  });
            };
            $("form").submit(login);
      </script>
</body>

</html>