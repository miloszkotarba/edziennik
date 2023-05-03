<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Modyfikacja przedmiotu", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Modyfikacja przedmiotu</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form">
            <form action="/subject/edytuj" method="post" style="max-width: 40%">
                <label for="name">Nazwa</label>
                <input type="text" name="name" value="<?= $result->subjectName ?>">
                <input type="hidden" value="<?= $result->subjectId ?>" name="id">
                <input type="submit" value="Zmień">
            </form>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();
