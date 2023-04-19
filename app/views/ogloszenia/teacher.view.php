<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Ogłoszenia", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-scroll"></i>
                    <span>Zarządzanie ogłoszeniami</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <div class="header">
                <h2>Ogłoszenia</h2>
            </div>
            <div class="content">
                <ul>
                    <li><a href="#">Dodawanie i modyfikacja ogłoszeń</a></li>
                    <li><a href="/ogloszenia/lista">Przeglądanie ogłoszeń</a></li>
                </ul>
            </div>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();