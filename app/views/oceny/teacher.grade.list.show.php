<?php
require 'app/Page.php';
require_once 'app/alerts.php';

Page::displayHeader("e-Dziennik Ocenianie", "teacher.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px; width: 98%">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-graduation-cap"></i>
                    <span>Ocenianie</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box" style="width: 98%">
            <div class="oceny" style="width: 100%">
                <table style="width: 100%">
                    <tbody>
                    <tr>
                        <th rowspan="2" class="nr" style="padding: 0 10px">Nr</th>
                        <th rowspan="2">Nazwisko i imię</th>
                        <th rowspan="2"></th>
                        <th colspan="4">Okres 1</th>
                        <th colspan="2">Okres 2</th>
                        <th colspan="3">Koniec roku</th>
                    </tr>
                    <tr class="first">
                        <td style="text-align: center">Oceny bieżące</td>
                        <td class="Sr1">
                            <a href="#" title="Średnia ocen z pierwszego okresu">Śr.I</a>
                        </td>
                        <td>
                            <a
                                href="#"
                                title="Przewidywana ocena śródroczna z pierwszego okresu"
                            >(I)</a
                            >
                        </td>
                        <td>
                            <a href="#" title="Ocena śródroczna z pierwszego okresu">I</a>
                        </td>
                        <td>Oceny bieżące</td>
                        <td>
                            <a href="#" title="Średnia ocen z drugiego okresu">Śr.II</a>
                        </td>
                        <td><a href="#" title="Średnia roczna">Śr.R</a></td>
                        <td><a href="#" title="Przewidywana ocena roczna">(R)</a></td>
                        <td><a href="#" title="Ocena roczna">R</a></td>
                    </tr>
                    <?php
                        foreach ($final as $item)
                        {
                            echo <<< END
                                     <tr>
                                <td class="nr">1</td>
                              END;
                            echo '<td class="nazwa">'.$item -> usersSurname.' '.$item->usersName.'</td>';
                            echo <<< END
                                <td class="btn-add">
                                    <a href="#">+</a>
                                </td>
                                <td class="ob">
                                    <a href="#" class="ocena" style="background: cornsilk">5</a>
                                    <a href="#" class="ocena" style="background: crimson">5</a>
                                    <a href="#" class="ocena" style="background: limegreen">4</a>
                                    <a href="#" class="ocena" style="background: limegreen">4</a>
                                    <a href="#" class="ocena" style="background: limegreen">4</a>
                                    <a href="#" class="ocena" style="background: limegreen">4</a>
                                    <a href="#" class="ocena" style="background: limegreen">4</a>
                                    <a href="#" class="ocena" style="background: limegreen">4</a>
                                    <a href="#" class="ocena" style="background: limegreen">4</a>
                                    <a href="#" class="ocena" style="background: limegreen">4</a>
                                    <a href="#" class="ocena" style="background: limegreen">4</a>
                                </td>
                                <td class="Sr1">-</td>
                                <td class="opisowa">-</td>
                                <td class="opisowa">-</td>
                                <td>Brak ocen</td>
                                <td class="Sr2">-</td>
                                <td class="SrR">4.57</td>
                                <td class="opisowa">-</td>
                                <td class="opisowa">-</td>
                            </tr>
                            END;
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php alerts::flashMessages() ?>
    </main>
<?php
Page::displayFooter();