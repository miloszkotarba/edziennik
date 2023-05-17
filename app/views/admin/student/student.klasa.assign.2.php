<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Przypisywanie uczniów", "teacher.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-tools"></i>
                    <span>Przypisywanie uczniów</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box">
            <?php
            if ($result) {
                echo "<h1 style='font-weight: 500'>Klasa: ".$className."</h1>";
                echo <<< END
                    <table>
                <thead>
                <tr>
                    <th><span class="user">Użytkownik</span></th>
                    <th><span></span></th>
                </tr>
                </thead>
                <tbody>
                END;
                foreach ($result as $item) {
                    echo <<< END
                    <tr>
                    <td>
                        <img src="/img/no-avatar.png" alt="Avatar">
                        <div>
                            <a href="#">$item->usersSurname $item->usersName
                            </a>
                    END;
                    if($item->klasaId) echo '<span style="font-weight: 300">Klasa '.$item->klasaName.'</span>';
                    else echo '<span style="font-weight: 300; color: crimson">Nieprzypisany uczeń</span>';
                    echo <<< END
                        </div>
                    </td>
                    <td style="text-align: right">
                    END;
                        if($item -> klasaName == $className) {
                            echo ' <a style="position: relative; text-decoration: none; color: #fff; background-color: rgb(220, 20, 60,0.9); padding: 8px 12px; border-radius: 6px" href="/student/remove/'.$item -> usersId.'/'.$link.'" title="Usuń ucznia z klasy"><i style="color: white; margin-right: 5px; position: absolute; top: 50%; transform: translateY(-50%)" class="las la-user-minus"></i><span style="margin-left: 35px"></span>Usuń</a>';
                        } else if($item -> klasaId == NULL){
                            echo '<a style="position: relative; text-decoration: none; color: #fff; background-color: rgba(19, 122, 19,0.9); padding: 8px 12px; border-radius: 6px" href="/student/add/'.$item -> usersId.'/'.$link.'" title="Dodaj ucznia do klasy"><i style="color: white; margin-right: 5px; position: absolute; top: 50%; transform: translateY(-50%)" class="las la-user-plus"></i><span style="margin-left: 35px"></span>Dodaj</a>';
                        };
                    ?>
                    <span style="margin-right: 20px"></span>
                    <?php echo <<< END
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
                <i class="las la-user-times"></i>
                <span>Brak uczniów</span>
                <span class="description">Nie dodano jeszcze żadnego ucznia.</span>
                <a href="/student">Dodaj ucznia</a>
            </div>
            END;
            }
            ?>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();