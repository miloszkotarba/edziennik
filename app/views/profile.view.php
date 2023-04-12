<?php
require 'app/Page.php';

Page::displayHeader("Ustawienia konta", "profile.css");
Page::displayNavigation();
?>
<main>
    <div class="box">
        <div class="right">
            <div class="circle">
                <img src="/img/zuzannastasiak.jpeg" alt="Avatar" style="height: 200px; width: 200px">
            </div>
            <div class="about-user">
                <h2><?= $_SESSION['usersName']." ". $_SESSION['usersSurname']?></h2>
                <span>USA, Lodz - ul. Józefa Chełmońskiego 3/2</span>
            </div>
            <div class="button">
                <a href="#">Edit account</a>
            </div>
        </div>
    </div>
</main>
<?php
Page::displayFooter();
?>
