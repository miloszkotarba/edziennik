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
                    <form action="/oceny/valid" method="POST">
                    <div class="ocena-header">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Kategoria</td>
                                    <td>
                                     <select name="kategoria">
                    <option disabled>Kategorie systemowe</option>
                    END;
                    foreach ($systemKategorie as $kategoria) {
                        echo $kategoria->categoryId;
                        echo <<< END
                        <option value="$kategoria->categoryId">$kategoria->name</option>
                        END;
                    }
                    echo '<option disabled>Kategorie użytkownika</option>';
                    foreach ($kategorie as $kategoria) {
                        echo $kategoria->categoryId;
                        echo <<< END
                        <option value="$kategoria->categoryId">$kategoria->name</option>
                        END;
                    }
                    echo <<< END
                            </select>
                            </td>
                                </tr>
                                <tr>
                                    <td>Data</td>
                                    <td><input type="date" id="theDate" name="date">
                                        <input type="hidden" value="$link" name="zajecia">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Komentarz</td>
                                    <td><textarea name="mainComment" rows="6" id="mainComment"></textarea>
                                    <div class="btn">Uzupełnij dla wszystkich</div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table style="width: 100%">
                        <tbody>
                        <tr>
                            <th rowspan="2" class="nr" style="padding: 0 10px">Nr</th>
                            <th rowspan="2">Nazwisko i imię</th>
                            <th colspan="3">Okres $semestr</th>
                            <th rowspan="2">Ocena</th>
                            <th rowspan="2">Komentarz</th>
                        </tr>
                        <tr class="first">
                            <td style="text-align: center">Oceny bieżące</td>
                            <td class="Sr1">
                                <a href="#" title="Średnia ocen z pierwszego okresu">Śr.I</a>
                            </td>
                            <td>Śr.R</td>
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
                                <td class="ob">
                                END;
                    if ($result == true || $result == false) {
                        $srednia = 0;
                        $wagi = 0;
                        $result2 = $Model->showGradesForEachStudentSem2($item->usersId, $link);
                        if ($semestr == 2) {
                            if($result2) {
                            foreach ($result2 as $ocena) {
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
                            } } else {
                                echo "Brak ocen";
                            }
                        }
                        if($result) {
                        foreach ($result as $ocena) {
                            if ($semestr == 1) {
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
                            }; }
                            if ($ocena->value != "np" && $ocena->value != "bz" && $ocena->value != "-" && $ocena->value != "+" && $ocena->value != "nk") {
                                $srednia = $srednia + $ocena->value * $ocena->weight;
                                $wagi = $wagi + $ocena->weight;
                            }
                        } else if($semestr != 2){
                            echo "Brak ocen";
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
                    $result = $Model->showGradesForEachStudentSem2($item->usersId, $link);
                    if ($result) {
                        $srednia = 0;
                        $wagi = 0;
                        foreach ($result as $ocena) {
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
                                <td class="SrR">$srednia_roczna</td>
                                <td class="grade"><input type="text" class="ocenaValue" name="ocenaValue[]"></td>
                                <td><textarea name="ocenaComment[]" class="ocenaComment" rows="4"></textarea>
                                <input type="hidden" name="user[]" value="$item->usersId"></td>
                                </tr>
                    END;
                }
                ?>
                </tbody>
                </table>
                <div class="btn">
                    <input type="submit" value="OK">
                    <a href="/oceny/lista">Anuluj</a>
                </div>
                </form>
            </div>
        </div>
        <?php alerts::flashMessages() ?>
        <script type="text/javascript">
            let Oceny = document.querySelectorAll('span.ocena')

            Oceny.forEach((ocena) => {
                ocena.addEventListener("mouseover", () => {
                    let tooltip = ocena.querySelector('.ocenatooltip')
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
        <script>
            dzisiaj();

            function dzisiaj() {
                var date = new Date();

                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();

                if (month < 10) month = "0" + month;
                if (day < 10) day = "0" + day;

                var today = year + "-" + month + "-" + day;
                document.getElementById("theDate").value = today;
            }
        </script>
        <script>
            let commentBtn = document.querySelector('.btn')

            commentBtn.addEventListener("click", () => {
                let mainComment = document.getElementById('mainComment').value
                let ocenaComment = document.querySelectorAll('.ocenaComment')
                ocenaComment.forEach((box) => {
                    box.value = mainComment
                })
            })

            let submitBtn = document.querySelector('input[type="submit"]')

            submitBtn.addEventListener("click", (e) => {

                let oceny = document.querySelectorAll('.ocenaValue')
                oceny.forEach((ocena) => {
                    const values = ["np", "-", "+", "nk", "1", "2", "3", "4", "5", "6", "", "bz"];
                    if (!values.includes(ocena.value)) {
                        ocena.classList.add('border')
                        e.preventDefault()
                    } else {
                        ocena.classList.remove('border')
                    }
                })
            })
        </script>
    </main>
<?php
Page::displayFooter();