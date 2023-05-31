<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Lista klas", "teacher.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Zarządzanie klasami</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <?php if($result)
                echo <<< END
            <div class="box">
                <a href="/oddzial" style="color: #fff; text-decoration: none">
                    <div class="btn">
                        <div>
                            <i class="las la-plus"></i>
                            <span>Dodaj klasę</span>
                        </div>
                </a>
            </div>
            </a>
        </div>
        END;
            if ($result) {
                echo <<< END
                    <table style="font-size: 1.2rem">
                <thead>
                <tr>
                    <th><span class="user">Klasa</span></th>
                    <th><span>Wychowawca</span></th>
                    <th><span></span></th>
                </tr>
                </thead>
                <tbody>
                END;
                foreach ($result as $item) {
                    echo <<< END
            <tr>
            <td>
                  <span style="margin-left: 20px">$item->klasaName</span>
            </td>
            <td>$item->usersSurname $item->usersName </td>
            <td style="text-align: right">
                <a  href="/oddzial/edit/$item->klasaId" title="Modyfikuj użytkownika"><i class="las la-edit"></i></a>
                <a style=" margin-right: 20px" href="/oddzial/delete/$item->klasaId" title="Usuń użytkownika"><i class="las la-trash"></i></a>
            </td>
            </tr>
            END;
                }

                echo <<< END
            </tbody>
            </table>
            END;
            } else {
                echo <<< END
                <div class="empty-set">
                <i class="las la-home"></i>
                <span>Brak klas</span>
                <span class="description">Nie dodano jeszcze żadnej klasy.</span>
                <a href="/oddzial">Dodaj klasę</a>
            </div>
            END;
            }
            ?>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();