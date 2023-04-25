<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Lista nauczycieli", "teacher.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Zarządzanie nauczycielami</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <div class="box">
                <a href="teacher/add" style="color: #fff; text-decoration: none">
                    <div class="btn">
                        <div>
                            <i class="las la-plus"></i>
                            <span>Dodaj nauczyciela</span>
                        </div>
                </a>
            </div
            </a>
        </div>
        <?php
        if ($result) {
            echo <<< END
                    <table>
                <thead>
                <tr>
                    <th><span class="user">Użytkownik</span></th>
                    <th><span>Utworzono</span></th>
                    <th><span>Status</span></th>
                    <th><span>Email</span></th>
                    <th><span></span></th>
                </tr>
                </thead>
                <tbody>
                END;
            foreach ($result as $item) {
                echo <<< END
            <tr>
            <td>
                <img src="img/no-avatar.png" alt="Avatar">
                <div>
                    <a href="#">$item->usersSurname $item->usersName
                    </a>
                    <span>Nauczyciel</span>
                </div>
            </td>
            <td>$item->createDate</td>
            <td><span class="status">Aktywny</span></td>
            <td><a href="#" class="mail">$item->usersEmail</a></td>
            <td>
                <a href="#" title="Modyfikuj użytkownika"><i class="las la-edit"></i></a>
                <a href="teacher/delete/$item->usersId" title="Usuń użytkownika"><i class="las la-trash"></i></a>
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