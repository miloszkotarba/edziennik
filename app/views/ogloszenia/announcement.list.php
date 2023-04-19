<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Ogłoszenia", "ogloszenia.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-scroll"></i>
                    <span>Tablica ogłoszeń</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <div class="content">
                <?php
                if (!$result) {
                    echo <<< END
                <div class="empty-set">
                <i class="las la-bullhorn"></i>
                <span>Brak ogłoszeń</span>
                <span class="description">Nie dodano jeszcze żadnego ogłoszenia.</span>
            END;
                    if($teacher) echo '<a href="/ogloszenia/dodaj">Dodaj ogłoszenie</a>';
                    echo '</div>';
                }else {
                    foreach ($result as $item) {
                        echo <<< END
                        <div class="broadcast">
                    <div class="title">
                        <span>$item->title</span>
                    </div>
                    <div class="person">
                        <img src="/img/no-avatar.png" alt="Profile picture">
                        <div class="name">
                            <span>Dodano przez:</span>
                            <span>$item->usersName $item->usersSurname</span>
                        </div>
                    </div>
                    <div class="date">
                        <span>$item->date</span>
                    </div>
                    <div class="content">
                        <span>$item->content</span>
                    </div>
                </div>
                END;
                    }
                }
                ?>
            </div>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();