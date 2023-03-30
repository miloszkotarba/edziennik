<?php
    require_once 'app/alerts.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>e-Dziennik Logowanie</title>
    <link rel="stylesheet" href="/css/login.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<main>
    <div class="login-box">
        <div class="left">
            <i class="fa fa-graduation-cap"></i>
            <div
                    style="
              color: white;
              font-size: 2rem;
              margin-left: 1rem;
              white-space: nowrap;
            "
            >
                e-Dziennik
            </div>
            <br/>
        </div>
        <div class="right">
            <div class="photo"><img src="/img/login-avatar.png" alt="Avatar"/></div>
            <h1>Logowanie</h1>
            <form method="POST" action="/login/check">
                <input type="hidden" name="type" value="login">
                <input type="text" name="user" placeholder="Login" required/>
                <input type="password" name="password" placeholder="Hasło" required/>
                <div class="link">
                    <a href="#">Przypomnij hasło</a>
                </div>
                <input type="submit" value="Zaloguj"/>
            </form>
        </div>
    </div>
    <?php alerts::flashMessages() ?>
</main>
</body>
</html>
