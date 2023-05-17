<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Przypisywanie zajęć", "teacher.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Przypisywanie zajęć</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <div class="box">
                <a href="/zajecia/add/<?=$currentOddzial?>" style="color: #fff; text-decoration: none">
                    <div class="btn">
                        <div>
                            <i class="las la-plus"></i>
                            <span>Dodaj zajęcia</span>
                        </div>
                </a>
            </div>
            </a>
        </div>
        <div style="padding-top: 25px"></div>
        <?php
        echo "<h1 style='font-weight: 500'>Klasa: ".$className."</h1>";
            if ($result) {
                echo <<< END
                    <table>
                <thead>
                <tr>
                    <th><span class="user">Przedmiot</span></th>
                    <th><span></span></th>
                </tr>
                </thead>
                <tbody>
                END;
                foreach ($result as $item) {
                    echo <<< END
            <tr>
            <td>
                <i style="font-size: 1.5rem; margin-left: 20px" class="las la-tags"></i>
                <div style="text-align: left">
                    <a href="#">$item->subjectName
                    </a>
                    <span>Nauczyciel: $item->usersSurname  $item->usersName</span>
                </div>
            </td>
            <td>
                <a href="/zajecia/remove/$item->zajeciaId" title="Usuń zajęcia"><i class="las la-trash"></i></a>
            </td>
            </tr>
            END;
                }
                echo <<< END
            </tbody>
            </table>
            END;
            } ?>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();