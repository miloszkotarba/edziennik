<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Ocenianie", "teacher.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-graduation-cap"></i>
                    <span>Ocenianie</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <?php
            if ($result) {
                echo <<< END
                    <table style="font-size: 1.2rem">
                <thead>
                <tr>
                    <th><span class="user">Zajęcia</span></th>
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
                  <span style="margin-left: 20px"> <span style="font-weight: 500"> $item->klasaName - $item->subjectName</span></span>
            </td>
            <td>$item->usersSurname $item->usersName </td>
            <td style="text-align: right">
               <a style="position: relative; text-decoration: none; color: #fff; background-color: rgba(19, 122, 19,0.9); padding: 8px 12px; border-radius: 6px; margin-right: 20px" href="/oceny/pokaz/$item->zajeciaId"><i style="color: white; margin-right: 5px; position: absolute; top: 50%; transform: translateY(-50%)" class="las la-plus-circle"></i><span style="margin-left: 35px"></span>Oceny</a>
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
                <i class="las la-graduation-cap"></i>
                <span>Brak przypisanych przedmiotów</span>
                <span class="description">W razie pomyłki - zgłoś to administratorowi.</span>
            </div>
            END;
            }
            ?>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();