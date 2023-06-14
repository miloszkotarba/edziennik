<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Terminarz", "teacher.css");
Page::displayNavigation();
?>
<main>
    <div class="links-box" style="padding: 30px">
        <div class="header">
            <h2 id="page-title">
                <i class="las la-calendar"></i>
                <span>Terminarz</span>
            </h2>
        </div>
    </div>
    <div style="margin-bottom: 1rem"></div>
    <div class="links-box">
        <div class="empty-set">
            <i class="las la-hammer"></i>
            <span>Strona w budowie</span>
            <span class="description">Ten moduł będzie udostępniał terminarz z wydarzeniami.</span>
        </div>
    </div>
</main>