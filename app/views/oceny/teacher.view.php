<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Oceny", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-graduation-cap"></i>
                    <span>Zarządzanie ocenami</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <div class="header">
                <h2>Oceny</h2>
            </div>
            <div class="content">
                <ul>
                    <li><a href="#">Dodawanie i modyfikacja ocen</a></li>
                    <li><a href="#">Przeglądanie ocen</a></li>
                </ul>
            </div>
            <div class="header">
                <h2>Kategorie</h2>
            </div>
            <div class="content">
                <ul>
                    <li><a href="/oceny/kategorie/dodaj">Dodawanie kategorii</a></li>
                    <li><a href="/oceny/kategorie/lista">Modyfikacja kategorii</a></li>
                </ul>
            </div>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();