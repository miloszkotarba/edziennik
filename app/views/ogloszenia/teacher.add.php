<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Nowe ogłoszenie", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-scroll"></i>
                    <span>Dodawanie ogłoszenia</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form">
            <form action="/ogloszenia/add" method="post" style="max-width: 100%">
                <label for="Title">Tytuł</label>
                <input type="text" name="Title">
                <label for="Content">Treść ogłoszenia</label>
                <textarea name="Content" cols="30" rows="10" style="resize: none; border-radius: 6px; margin-top: 0.3rem; font-size: 1.2rem; padding: 0.4rem"></textarea>
                <input type="submit" value="Dodaj">
            </form>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();
