<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Nowy uczeń", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Dodawanie ucznia</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form">
            <form action="/student/dodaj" method="post" style="max-width: 40%">
                <label for="name">Imię</label>
                <input type="text" name="name">
                <label for="surname">Nazwisko</label>
                <input type="text" name="surname">
                <label for="email">Email</label>
                <input type="email" name="email">
                <label for="login">Login</label>
                <input type="text" name="login">
                <label for="password">Hasło</label>
                <input type="password" name="password">
                <input type="submit" value="Dodaj">
            </form>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();
