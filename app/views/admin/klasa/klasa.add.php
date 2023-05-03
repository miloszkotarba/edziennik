<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Nowa klasa", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Dodawanie klasy</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form">
            <?php if($result != 0) {
                echo <<< END
                <form action="/oddzial/dodaj" method="post" style="max-width: 40%">
                <label for="name">Nazwa oddziału</label>
                <input type="text" name="name">
                <p>Wychowawca</p>
                <select name="wychowawcaId">
                END;
                        foreach ($result as $item) {
                            echo <<< END
                            <option value="$item->usersId">&nbsp;$item->usersSurname $item->usersName&nbsp;</option>
                            END;
                        }

                ECHO <<< END
                </select>
                <input type="submit" value="Dodaj">
            </form>
            END; }
            else {
                echo <<< END
                <div class="empty-set">
                <i class="las la-user-minus"></i>
                <span>Za mało nauczycieli</span>
                <span class="description">Brak wolnych nauczycieli, którym można przypisać wychowawstwo.</span>
                <a href="/teacher">Dodaj nauczyciela</a>
                END;
            }
            ?>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();
