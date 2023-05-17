<?php
require 'app/Page.php';

Page::displayHeader("Ustawienia konta", "profile.css");
Page::displayNavigation();
?>
<main>
    <div class="box">
        <div class="right">
            <div class="circle">
                <img src="/img/no-avatar.png" alt="Avatar">
                <div class="overlay">
                    <i class="las la-camera"></i>
                    <input type="file">
                </div>
            </div>
            <div class="about-user">
                <h2><?= $_SESSION['usersName']." ". $_SESSION['usersSurname']?></h2>
                <span>USA, Lodz - ul. Józefa Chełmońskiego 3/2</span>
            </div>
            <div class="button">
                <a href="/profile/photo">Edit account</a>
            </div>
        </div>
    </div>
</main>
<?php
Page::displayFooter();
?>
