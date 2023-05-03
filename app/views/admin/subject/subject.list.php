<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Lista przedmiotów", "teacher.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Zarządzanie przedmiotami</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <?php if ($result)
                echo <<< END
            <div class="box">
                <a href="/subject" style="color: #fff; text-decoration: none">
                    <div class="btn">
                        <div>
                            <i class="las la-plus"></i>
                            <span>Dodaj przedmiot</span>
                        </div>
                </a>
            </div>
            </a>
        </div>
        END;
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
            <td><i class="las la-tags" style="font-size: 1.9rem; margin-left: 20px; margin-right: 8px"></i><span>$item->subjectName</span></td>
            <td style="text-align: right;">
                <a href="/subject/edit/$item->subjectId" title="Modyfikuj użytkownika"><i class="las la-edit"></i></a>
                <a style=" margin-right: 20px" href="/subject/delete/$item->subjectId" title="Usuń użytkownika"><i class="las la-trash"></i></a>
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
                <i class="las la-tags"></i>
                <span>Brak przedmiotów</span>
                <span class="description">Nie dodano jeszcze żadnego przedmiotu.</span>
                <a href="/subject">Dodaj przedmiot</a>
            </div>
            END;
            }
            ?>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();