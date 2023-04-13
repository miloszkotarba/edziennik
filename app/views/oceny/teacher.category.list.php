<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Modyfikacja kategorii", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-graduation-cap"></i>
                    <span>Modyfikacja kategorii</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="list-box">
            <?php


            if (!$row) {
                echo <<< END
                <div class="empty-set">
                <i class="las la-folder-open"></i>
                <span>Brak kategorii</span>
                <span class="description">Nie dodano jeszcze żadnej kategorii.</span>
                <a href="/oceny/kategorie/dodaj">Dodaj kategorię</a>
            </div>
            END;
            } else {
                $ilosc = 0;
                foreach ($row as $item) {
                    $ilosc++;
                }

                $licznik = 0;
                $licznik2 = 0;

                foreach ($row as $item) {
                    if ($licznik % 2 == 0) {
                        echo '<div class="row">';
                    }
                    echo '<div class="category-box">';
                    echo '<div class="color" style="background: ' . $item->color . ';"></div>';
                    echo '<span>' . $item->name . '</span>';
                    echo '<div class="buttons">';
                    echo ' <a href="#"><i class="las la-edit"></i>Edytuj</a>';
                    echo ' <a href="#"><i class="las la-trash"></i>Usuń</a>';
                    echo '</div>
        </div>';
                    $licznik2++;
                    $licznik++;
                    if ($licznik2 == 2) {
                        echo '</div>';
                        $licznik2 = 0;
                    }
                    if ($licznik == $ilosc) {
                        echo '</div>';
                    }
                }
            }
            ?>

            <!--
            <div class="row">
                <div class="category-box first">
                    <span>Praca klasowa</span>
                    <div class="buttons">
                        <a href="#"><i class="las la-edit"></i>Edytuj</a>
                        <a href="#"><i class="las la-trash"></i>Usuń</a>
                    </div>
                </div>
                <div class="category-box second">
                    <span>Kartkówka</span>
                    <div class="buttons">
                        <a href="#"><i class="las la-edit"></i>Edytuj</a>
                        <a href="#"><i class="las la-trash"></i>Usuń</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="category-box">
                    <span>Test</span>
                    <div class="buttons">
                        <a href="#"><i class="las la-edit"></i>Edytuj</a>
                        <a href="#"><i class="las la-trash"></i>Usuń</a>
                    </div>
                </div>
                <div class="category-box">
                    <span>Olimpiada językowa</span>
                    <div class="buttons">
                        <a href="#"><i class="las la-edit"></i>Edytuj</a>
                        <a href="#"><i class="las la-trash"></i>Usuń</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="category-box">
                    <span>Zadanie maturalne</span>
                    <div class="buttons">
                        <a href="#"><i class="las la-edit"></i>Edytuj</a>
                        <a href="#"><i class="las la-trash"></i>Usuń</a>
                    </div>
                </div>
                <div class="category-box">
                    <span>Brak pracy domowej</span>
                    <div class="buttons">
                        <a href="#"><i class="las la-edit"></i>Edytuj</a>
                        <a href="#"><i class="las la-trash"></i>Usuń</a>
                    </div>
                </div>
            </div> -->
            <div style="margin-bottom: 1.5rem"></div>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();