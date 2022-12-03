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
      <script>
            const toggle = () => {
                  $("#password").attr("type", $("#password").attr("type") === "password" ? "text" : "password");
            }
      </script>
</head>

<body>
      <h1 class="text-center my-2">Masuk</h1>
      <form method="post" class="container w-25 d-flex flex-column">
            <div class="mb-1">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username">
                  <p id="username-error" class="form-text text-danger"></p>
            </div>
            <div class="mb-1">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password">
                  <p id="password-error" class="form-text text-danger"></p>
            </div>
            <div class="d-flex justify-content-between">
                  <div>
                        <input id="togglepassword" type="checkbox" onchange="toggle()">
                        <label for="togglepassword">show password</label>
                  </div>
                  <a href="<?= ROOT ?>/view/forgetpassword.php">forget password?</a>
            </div>
            <button type="submit" class="btn btn-primary flex-fill mt-2">Masuk</button>
            <a href="<?= ROOT ?>/view/register.php" class="btn btn-outline-primary flex-fill mt-2">Daftar</a>
      </form>
      <script>
            const login = e => {
                  e.preventDefault();
                  $.post("<?= ROOT ?>/routes/login.php", {
                        username: $("#username").val(),
                        password: $("#password").val()
                  }).then((data, status, jqXHR) => {
                        window.location.replace("<?= ROOT ?>/view/home.php");
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