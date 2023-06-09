<?php
require 'app/Page.php';
require_once 'app/alerts.php';
require 'app/models/oceny2.php';

Page::displayHeader("e-Dziennik Ocenianie", "teacher.css");
Page::displayNavigation();
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                     <select name="kategoria" id="aktualnakategoria">
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
                                     <div class="btn showHide">Pokaż pola komentarzy</div>
                                    <div class="btn comment">Uzupełnij dla wszystkich</div></td>
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
                            <th rowspan="2" class="commentth">Komentarz</th>
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
                    $przewidywana_srodroczna = $Model->showPrzewidywanaSrodroczna($item->usersId, $link);
                    $sredniasem1 = $Model->SredniaSem1($link, $item->usersId);
                    $sredniasem2 = $Model->SredniaSem2($link, $item->usersId);
                    if ($sredniasem1->srednia != NULL) $sredniasemestr = $sredniasem1->srednia;
                    else {
                        $sredniasemestr = "-";
                    };
                    echo <<< END
                                </td>
                                <td class="Sr1">$sredniasemestr</td>
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

                    if ($sredniasem1->srednia == NULL) {
                        if ($sredniasem2->srednia != NULL) {
                            $srednia_roczna = $sredniasem2->srednia;
                        } else {
                            $srednia_roczna = '-';
                        }
                    }
                    if ($sredniasem1->srednia != NULL) {
                        if ($sredniasem2->srednia == NULL) {
                            $srednia_roczna = $sredniasem1->srednia;
                        } else {
                            $avg = ($sredniasem1->srednia + $sredniasem2->srednia) / 2;
                            $avg = number_format((float)$avg, 2, '.', '');
                            $srednia_roczna = $avg;
                        }
                    }
                    echo <<< END
                                <td class="SrR">$srednia_roczna</td>
                                <td class="grade"><input type="text" class="ocenaValue" name="ocenaValue[]" id="$item->usersId"></td>
                                <td class="tdcomment"><textarea name="ocenaComment[]" class="ocenaComment" rows="4"></textarea>
                                <input type="hidden" name="user[]" value="$item->usersId"></td>
                                <div class="systemGrades">
                    END;

                    $systemGrades = $Model->getSystemGradesByStudent($item->usersId, $link);
                    if ($systemGrades) {
                        foreach ($systemGrades as $systemOcena) {
                            $systemNames = array("przewidywana śródroczna", "śródroczna", "przewidywana roczna", "roczna");
                            if (in_array($systemOcena->name, $systemNames)) {
                                if($systemOcena->name == "przewidywana śródroczna") {
                                    $systemOcena->name = "przewidywana_srodroczna";
                                }
                                if($systemOcena->name == "śródroczna") {
                                    $systemOcena->name = "srodroczna";
                                }
                                if($systemOcena-> name == "przewidywana roczna") {
                                    $systemOcena->name = "przewidywana_roczna";
                                }
                                echo <<< END
                                    <input type="hidden" class="$systemOcena->name" name="$systemOcena->name" value="$systemOcena->value" id="$systemOcena->name-$item->usersId">
                                END; }}}

                    echo <<< END
                                </div>
                                </tr>
                    END;
                }
                ?>
                </tbody>
                </table>
                <div class="btn">
                    <input type="submit" value="OK">
                    <a href="/oceny/lista" style="background: #f1f1f1">Anuluj</a>
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
            let commentBtn = document.querySelector('.btn.comment')

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
                var select = document.getElementById('aktualnakategoria');
                var systemCategoryName = select.options[select.selectedIndex].text;
                var ALERT = 0
                oceny.forEach((ocena) => {
                    if(systemCategoryName == "przewidywana śródroczna" || systemCategoryName == "śródroczna" || systemCategoryName == "przewidywana roczna" || systemCategoryName == "roczna") {
                        if(systemCategoryName == "przewidywana śródroczna") {
                            temporary = "przewidywana_srodroczna"
                        }
                        if(systemCategoryName == "śródroczna") {
                            temporary = "srodroczna"
                        }
                        if(systemCategoryName == "przewidywana roczna") {
                            temporary = "przewidywana_roczna"
                        }
                        if(systemCategoryName == "roczna") {
                            temporary = "roczna"
                        }

                        let user = ocena.getAttribute("id")
                        let url = 'input#'+temporary+'-'+user
                        let Inputurl = document.querySelector(url)
                        if(Inputurl != null && ocena.value != "") {
                            ocena.classList.add('border2')
                            e.preventDefault()
                            ALERT = 1
                        } else {
                            ocena.classList.remove('border2')
                        }
                    }
                    const values = ["np", "-", "+","1", "2", "3", "4", "5", "6", "", "bz"];
                    if (!values.includes(ocena.value)) {
                        ocena.classList.add('border')
                        e.preventDefault()
                    } else {
                        ocena.classList.remove('border')
                    }
                })
                if(ALERT == 1) {
                    Swal.fire(
                        'Powielone oceny końcowe!',
                        'Usuń oceny podświetlone na niebiesko.',
                        'error'
                    )
                }
            })

            let showHideBtn = document.querySelector('.btn.showHide')
            showHideBtn.addEventListener("click", () => {
                let ocenaComment = document.querySelectorAll('.ocenaComment')
                ocenaComment.forEach((box) => {
                    if(box.style.display == "none") {
                        let tdcomments = document.querySelectorAll('.tdcomment')
                        tdcomments.forEach((tdcommenT) => {
                            tdcommenT.style.display = "table-cell"
                        })
                        document.querySelector('.commentth').style.display = "table-cell"
                        box.style.display = "block"
                    }
                    else {
                        box.style.display = "none"
                        document.querySelector('.commentth').style.display = "none"
                        let tdcomments = document.querySelectorAll('.tdcomment')
                        tdcomments.forEach((tdcommenT) => {
                            tdcommenT.style.display = "none"
                        })
                    }
                })
            })

            start = () => {
                let tdcomments = document.querySelectorAll('.tdcomment')
                tdcomments.forEach((tdcommenT) => {
                    tdcommenT.style.display = "none"
                })
            }

            start()
        </script>
    </main>
<?php
Page::displayFooter();