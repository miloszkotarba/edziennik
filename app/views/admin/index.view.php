<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Administracja", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Panel Administracyjny</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <div class="header">
                <h2>Nauczyciele</h2>
            </div>
            <div class="content">
                <ul>
                    <li><a href="/teacher">Dodawanie i modyfikacja nauczycieli</a></li>
                    <li><a href="#">Przypisywanie przedmiotów</a></li>
                </ul>
            </div>
            <div class="header">
                <h2>Uczniowie</h2>
            </div>
            <div class="content">
                <ul>
                    <li><a href="#">Dodawanie i modyfikacja uczniów</a></li>
                    <li><a href="#">Przypisywanie uczniów do klas</a></li>
                </ul>
            </div>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();