<?php
require 'app/Page.php';
require_once 'app/alerts.php';
require 'app/models/oceny2.php';

Page::displayHeader("e-Dziennik Ocenianie", "teacher.css");
Page::displayNavigation();
?>
    <style>
        .links-box {
            padding: 30px 15px !important;
        }
    </style>
    <main>
        <div class="links-box" style="padding: 30px; width: 100%">
            <div class="header" style="padding: 0 50px">
                <h2 id="page-title">
                    <i class="las la-graduation-cap"></i>
                    <span>Ocenianie</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="links-box" style="width: 100%;">
            <div class="oceny" style="width: 100%">
                <?php
                if ($final) {
                    echo <<< END
                    <table style="min-width: 100%;">
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
                            <a href="#" class="ocena" target="popup" onclick="window.open('/oceny/szczegoly/$ocena->ocenaId/$item->usersId','popup','width=700,height=700'); return false;" style="background: $ocena->color; margin-right: 5px">
                            $ocena->value
                            <input type="hidden" value="$ocena->weight" id="weight">
                            <input type="hidden" value="$ocena->comment" id="comment">
                            <input type="hidden" value="$ocena->date" id="date">
                            <input type="hidden" value="$ocena->usersSurname $ocena->usersName" id="teacher">
                            <input type="hidden" value="$ocena->name" id="category">
                            <input type="hidden" value="$ocena->value" id="value">
                            </a>
                            <div class="ocenatooltip">
                            <span class="category"></span>
                            <span class="date"></span>
                            <span class="average">Licz do średniej: Nie</span>
                            <span class="weight"></span>
                            <span class="teacher"></span>
                            <span class="comment"></span>
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
                    $przewidywana_srodroczna = $Model->showPrzewidywanaSrodroczna($item->usersId, $link);
                    echo <<< END
                                </td>
                                <td class="Sr1">$temp</td>
                    END;
                    if ($przewidywana_srodroczna) {
                        echo <<< END
                                    <td class="opisowa">
                                    <span class="ocena" style="margin-right: -5px">
                                    <a href="#" target="popup" onclick="window.open('/oceny/szczegoly/$przewidywana_srodroczna->ocenaId/$item->usersId','popup','width=700,height=700'); return false;" class="ocena" style="background: $przewidywana_srodroczna->color; margin-right: 5px" target="popup">$przewidywana_srodroczna->value
                                     <input type="hidden" value="$przewidywana_srodroczna->weight" id="weight">
                                    <input type="hidden" value="$przewidywana_srodroczna->comment" id="comment">
                                    <input type="hidden" value="$przewidywana_srodroczna->date" id="date">
                                    <input type="hidden" value="$przewidywana_srodroczna->usersSurname $przewidywana_srodroczna->usersName" id="teacher">
                                    <input type="hidden" value="$przewidywana_srodroczna->name" id="category">
                                    <input type="hidden" value="$przewidywana_srodroczna->value" id="value">
                                    </a>
                                    <div class="ocenatooltip" style="text-align: left">
                                    <span class="category"></span>
                                    <span class="date"></span>
                                    <span class="average">Licz do średniej: Nie</span>
                                    <span class="weight"></span>
                                    <span class="teacher"></span>
                                    <span class="comment"></span>
                                    </div>
                                    </span>
                                END;
                    } else {
                        echo '<td class="opisowa">-';
                    }
                    $srodroczna = $Model->showSrodroczna($item->usersId, $link);
                    echo '</td>   
                          <td class="opisowa">';
                    if ($srodroczna) {
                        echo <<< END
                                    <span class="ocena" style="margin-right: -5px">
                                    <a href="#" target="popup" onclick="window.open('/oceny/szczegoly/$srodroczna->ocenaId/$item->usersId','popup','width=700,height=700'); return false;" class="ocena" style="background: $srodroczna->color; margin-right: 5px" target="popup">$srodroczna->value
                                     <input type="hidden" value="$srodroczna->weight" id="weight">
                                    <input type="hidden" value="$srodroczna->comment" id="comment">
                                    <input type="hidden" value="$srodroczna->date" id="date">
                                    <input type="hidden" value="$srodroczna->usersSurname $srodroczna->usersName" id="teacher">
                                    <input type="hidden" value="$srodroczna->name" id="category">
                                    <input type="hidden" value="$srodroczna->value" id="value">
                                    </a>
                                    <div class="ocenatooltip" style="text-align: left">
                                    <span class="category"></span>
                                    <span class="date"></span>
                                    <span class="average">Licz do średniej: Nie</span>
                                    <span class="weight"></span>
                                    <span class="teacher"></span>
                                    <span class="comment"></span>
                                    </div>
                                    </span>
                                END;
                    } else {
                        echo '-';
                    }
                    echo '</td>';
                    echo '<td class="ob">';
                    $result = $Model->showGradesForEachStudentSem2($item->usersId, $link);
                    if ($result) {
                        $srednia = 0;
                        $wagi = 0;
                        foreach ($result as $ocena) {
                            echo <<< END
                            <span class="ocena" style="margin-right: -5px">
                            <a href="#" target="popup" onclick="window.open('/oceny/szczegoly/$ocena->ocenaId/$item->usersId','popup','width=700,height=700'); return false;" class="ocena" style="background: $ocena->color; margin-right: 5px" target="popup">$ocena->value
                             <input type="hidden" value="$ocena->weight" id="weight">
                            <input type="hidden" value="$ocena->comment" id="comment">
                            <input type="hidden" value="$ocena->date" id="date">
                            <input type="hidden" value="$ocena->usersSurname $ocena->usersName" id="teacher">
                            <input type="hidden" value="$ocena->name" id="category">
                            <input type="hidden" value="$ocena->value" id="value">
                            </a>
                            <div class="ocenatooltip">
                            <span class="category"></span>
                            <span class="date"></span>
                            <span class="average">Licz do średniej: Nie</span>
                            <span class="weight"></span>
                            <span class="teacher"></span>
                            <span class="comment"></span>
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
                    $przewidywana_roczna = $Model->showPrzewidywanaRoczna($item->usersId, $link);
                    echo <<< END
                                </td>
                                <td class="Sr2">$temp</td>
                                <td class="SrR">$srednia_roczna</td>
                    END;
                    echo '
                                <td class="opisowa">';
                    if ($przewidywana_roczna) {
                        echo <<< END
                                    <span class="ocena" style="margin-right: -5px">
                                    <a href="#" target="popup" onclick="window.open('/oceny/szczegoly/$przewidywana_roczna->ocenaId/$item->usersId','popup','width=700,height=700'); return false;" class="ocena" style="background: $przewidywana_roczna->color; margin-right: 5px" target="popup">$przewidywana_roczna->value
                                     <input type="hidden" value="$przewidywana_roczna->weight" id="weight">
                                    <input type="hidden" value="$przewidywana_roczna->comment" id="comment">
                                    <input type="hidden" value="$przewidywana_roczna->date" id="date">
                                    <input type="hidden" value="$przewidywana_roczna->usersSurname $przewidywana_roczna->usersName" id="teacher">
                                    <input type="hidden" value="$przewidywana_roczna->name" id="category">
                                    <input type="hidden" value="$przewidywana_roczna->value" id="value">
                                    </a>
                                    <div class="ocenatooltip right" style="text-align: left">
                                    <span class="category"></span>
                                    <span class="date"></span>
                                    <span class="average">Licz do średniej: Nie</span>
                                    <span class="weight"></span>
                                    <span class="teacher"></span>
                                    <span class="comment"></span>
                                    </div>
                                    </span>
                                END;
                    } else {
                        echo "-";
                    }
                    echo '</td>
                                <td class="opisowa">';
                    $roczna = $Model->showRoczna($item->usersId,$link);
                    if($roczna) {
                        echo <<< END
                                    <span class="ocena" style="margin-right: -5px">
                                    <a href="#" target="popup" onclick="window.open('/oceny/szczegoly/$roczna->ocenaId/$item->usersId','popup','width=700,height=700'); return false;" class="ocena" style="background: $roczna->color; margin-right: 5px" target="popup">$roczna->value
                                     <input type="hidden" value="$roczna->weight" id="weight">
                                    <input type="hidden" value="$roczna->comment" id="comment">
                                    <input type="hidden" value="$roczna->date" id="date">
                                    <input type="hidden" value="$roczna->usersSurname $roczna->usersName" id="teacher">
                                    <input type="hidden" value="$roczna->name" id="category">
                                    <input type="hidden" value="$roczna->value" id="value">
                                    </a>
                                    <div class="ocenatooltip right" style="text-align: left;">
                                    <span class="category"></span>
                                    <span class="date"></span>
                                    <span class="average">Licz do średniej: Nie</span>
                                    <span class="weight"></span>
                                    <span class="teacher"></span>
                                    <span class="comment"></span>
                                    </div>
                                    </span>
                                END;
                    } else {
                        echo '-';
                    }
                    echo '</td>
                     </tr>';
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
                    if(!tooltip.classList.contains('right')) {
                        tooltip.classList.add('left')
                    }
                    tooltip.style.display = "flex"
                    let value = ocena.querySelector('input#value').getAttribute("value")
                    let teacher = ocena.querySelector('input#teacher').getAttribute("value")
                    tooltip.querySelector('span.teacher').innerHTML = "Nauczyciel: " + teacher
                    let date = ocena.querySelector('input#date').getAttribute("value")
                    tooltip.querySelector('span.date').innerHTML = "Data: " + date
                    let category = ocena.querySelector('input#category').getAttribute("value")
                    tooltip.querySelector('span.category').innerHTML = "Kategoria: " + category
                    let weight = ocena.querySelector('input#weight').getAttribute("value")
                    if (weight != 0 && value !== "np" && value !== "bz" && value !== "nk" && value !== "-" && value !== "+") {
                        tooltip.querySelector('span.weight').innerHTML = "Waga: " + weight
                        tooltip.querySelector('span.average').innerHTML = "Licz do sredniej: Tak"
                    }
                    let comment = ocena.querySelector('input#comment').getAttribute("value")
                    if (comment !== "") tooltip.querySelector('span.comment').innerHTML = "Komentarz: " + comment
                })
                ocena.addEventListener("mouseout", () => {
                    ocena.querySelector('.ocenatooltip').style.display = "none"
                })
            })
        </script>
    </main>
<?php
Page::displayFooter();