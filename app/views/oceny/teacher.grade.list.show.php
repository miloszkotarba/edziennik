<?php
require 'app/Page.php';
require_once 'app/alerts.php';
require 'app/models/oceny2.php';

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
                <?php
                if ($final) {
                    echo <<< END
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
                    END;
                }
                if (!$final) {
                    echo '<h1>Brak studentów</h1>';
                    exit();
                }
                $licznik = 1;
                foreach ($final as $item) {
                    $Model = new Grade();
                    $result = $Model->showGradesForEachStudent($item->usersId, $link);
                    echo <<< END
                                     <tr>
                                <td class="nr">$licznik</td>
                              END;
                    $licznik++;
                    echo '<td class="nazwa">' . $item->usersSurname . ' ' . $item->usersName . '</td>';
                    echo <<< END
                                <td class="btn-add">
                                    <a target="popup" href="#" onclick="window.open(`/oceny/dodaj/$link/$item->usersId`,'popup','width=600,height=700'); return false;">+</a>
                                </td>
                                <td class="ob">
                                END;
                    if ($result) {
                        $srednia = 0;
                        $wagi = 0;
                        foreach ($result as $ocena) {
                            echo <<< END
                            <span class="ocena" style="margin-right: -5px">
                            <a href="#" class="ocena" target="popup" onclick="window.open('/oceny/szczegoly/$ocena->ocenaId','popup','width=700,height=700'); return false;" style="background: $ocena->color; margin-right: 5px">
                            $ocena->value
                            <input type="hidden" value="$ocena->weight" id="weight">
                            <input type="hidden" value="$ocena->comment" id="comment">
                            <input type="hidden" value="$ocena->date" id="date">
                            <input type="hidden" value="$ocena->usersSurname $ocena->usersName" id="teacher">
                            <input type="hidden" value="$ocena->name" id="category">
                            </a>
                            <div class="ocenatooltip">
                            <span class="category">Kategoria: Kartkówka</span>
                            <span class="date">Data: 10-04-2023</span>
                            <span class="average">Licz do średniej: Nie</span>
                            <span class="weight"></span>
                            <span class="teacher">Nauczyciel: Kowalska Alicja</span>
                            </div>
                            </span>
                            END;
                            if ($ocena->value != "np" && $ocena->value != "bz" && $ocena->value != "-" && $ocena->value != "+" && $ocena->value != "nk") {
                                $srednia = $srednia + $ocena->value * $ocena->weight;
                                $wagi = $wagi + $ocena->weight;
                            }
                        }
                        if ($wagi != 0) {
                            $srednia = $srednia / $wagi;
                            $srednia = number_format((float)$srednia, 2, '.', '');
                        }
                        $temp = $srednia;
                        $sem1 = $temp;
                        $srednia = 0;
                        $wagi = 0;
                    } else {
                        $srednia = 0;
                        $wagi = 0;
                        $temp = $srednia;
                        $sem1 = $temp;
                        echo "Brak ocen";
                    }
                    if (!isset($temp) || $temp == 0) $temp = "-";
                    echo <<< END
                                </td>
                                <td class="Sr1">$temp</td>
                                <td class="opisowa">-</td>
                                <td class="opisowa">-</td>
                                <td class="ob">
                                END;
                    $result = $Model->showGradesForEachStudentSem2($item->usersId, $link);
                    if ($result) {
                        $srednia = 0;
                        $wagi = 0;
                        foreach ($result as $ocena) {
                            echo <<< END
                            <span class="ocena" style="margin-right: -5px">
                            <a href="#" target="popup" onclick="window.open('/oceny/szczegoly/$ocena->ocenaId','popup','width=700,height=700'); return false;" class="ocena" style="background: $ocena->color; margin-right: 5px" target="popup">$ocena->value
                             <input type="hidden" value="$ocena->weight" id="weight">
                            <input type="hidden" value="$ocena->comment" id="comment">
                            <input type="hidden" value="$ocena->date" id="date">
                            <input type="hidden" value="$ocena->usersSurname $ocena->usersName" id="teacher">
                            <input type="hidden" value="$ocena->name" id="category">
                            </a>
                            <div class="ocenatooltip">
                            <span class="category">Kategoria: Kartkówka</span>
                            <span class="date">Data: 10-04-2023</span>
                            <span class="average">Licz do średniej: Nie</span>
                            <span class="weight"></span>
                            <span class="teacher">Nauczyciel: Kowalska Alicja</span>
                            </div>
                            </span>
                            END;
                            if ($ocena->value != "np" && $ocena->value != "bz" && $ocena->value != "-" && $ocena->value != "+" && $ocena->value != "nk") {
                                $srednia = $srednia + $ocena->value * $ocena->weight;
                                $wagi = $wagi + $ocena->weight;
                            }
                        }
                        if ($wagi != 0) {
                            $srednia = $srednia / $wagi;
                            $srednia = number_format((float)$srednia, 2, '.', '');
                        }
                        $temp = $srednia;
                        $srednia = 0;
                        $wagi = 0;
                    } else {
                        $srednia = 0;
                        $wagi = 0;
                        $temp = $srednia;
                        echo "Brak ocen";
                    }

                    $srednia_roczna = ($sem1 + $temp) / 2;

                    if ($sem1 == 0) {
                        $srednia_roczna = $temp;
                    } else if ($temp == 0) {
                        $srednia_roczna = $sem1;
                    } else if ($sem1 == 0 && $temp == 0) {
                        $srednia_roczna = 0;
                    }

                    if (!isset($temp) || $temp == 0) $temp = "-";

                    if ($srednia_roczna == 0) $srednia_roczna = "-";
                    else {
                        $srednia_roczna = number_format((float)$srednia_roczna, 2, '.', '');
                    }

                    echo <<< END
                                </td>
                                <td class="Sr2">$temp</td>
                                <td class="SrR">$srednia_roczna</td>
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
        <script type="text/javascript">
            let Oceny = document.querySelectorAll('span.ocena')

            Oceny.forEach((ocena) => {
                ocena.addEventListener("mouseover", () => {
                    let tooltip = ocena.querySelector('.ocenatooltip')
                    tooltip.style.display = "flex"
                    let teacher = ocena.querySelector('input#teacher').getAttribute("value")
                    tooltip.querySelector('span.teacher').innerHTML = "Nauczyciel: " + teacher
                    let date = ocena.querySelector('input#date').getAttribute("value")
                    tooltip.querySelector('span.date').innerHTML = "Data: " + date
                    let category = ocena.querySelector('input#category').getAttribute("value")
                    tooltip.querySelector('span.category').innerHTML = "Kategoria: " + category
                    let weight = ocena.querySelector('input#weight').getAttribute("value")
                    if (weight != 0) {
                        tooltip.querySelector('span.weight').innerHTML = "Waga: " + weight
                        tooltip.querySelector('span.average').innerHTML = "Licz do sredniej: Tak"
                    }
                })
                ocena.addEventListener("mouseout", () => {
                    ocena.querySelector('.ocenatooltip').style.display = "none"
                })
            })
        </script>
    </main>
<?php
Page::displayFooter();