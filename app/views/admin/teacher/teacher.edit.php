<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Edycja nauczyciela", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Modyfikacja nauczyciela</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form">
            <form action="/teacher/edytuj" method="post" style="max-width: 40%">
                <label for="name">Imię</label>
                <input type="text" name="name" value="<?=$final -> usersName?>">
                <label for="surname">Nazwisko</label>
                <input type="text" name="surname" value="<?=$final -> usersSurname?>">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?=$final -> usersEmail?>">
                <label for="login">Login</label>
                <input type="text" name="login" value="<?=$final -> usersLogin?>">
                <label for="password">Hasło</label>
                <input type="password" name="password">
                <input type="hidden" name="usersId" value="<?=$final -> usersId?>">
                <input type="submit" value="Modyfikuj">
            </form>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();
