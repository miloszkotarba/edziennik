<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Nowy przedmiot", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Dodawanie przedmiotu</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form">
            <form action="/subject/dodaj" method="post" style="max-width: 40%">
                <label for="name">Nazwa</label>
                <input type="text" name="name">
                <input type="submit" value="Dodaj">
            </form>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();
