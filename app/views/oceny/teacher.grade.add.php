<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Dodawanie ocen", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px; width: 98%">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-graduation-cap"></i>
                    <span>Dodawanie ocen</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form" style="width: 98%;">
            <table id="oceny">
                <thead>
                <tr>
                <th rowspan="2">Nr</th>
                <th rowspan="2" style="">Nazwisko i imię</th>
                <th rowspan="2">Dodawanie</th>
                <th colspan="4">Okres 1</th>
                <th colspan="2">Okres 2</th>
                <th colspan="3">Koniec roku</th>
                </thead>
                </tr>
                <tbody>
                    <tr>
                        <td style="background: #cdcdcd"></td>
                        <td style="background: #cdcdcd"></td>
                        <td style="background: #cdcdcd"></td>
                        <td style="background: rgb(229,229,229)">Okres1</td>
                        <td style="background: rgb(229,229,229)">Okres1</td>
                        <td style="background: rgb(229,229,229)"> Okres1</td>
                        <td style="background: rgb(229,229,229)">Okres1</td>
                        <td style="background: rgb(229,229,229)">Okres2</td>
                        <td style="background: rgb(229,229,229)">Okres2</td>
                        <td style="background: rgb(229,229,229)">Rok</td>
                        <td style="background: rgb(229,229,229)">Rok</td>
                        <td style="background: rgb(229,229,229)">Rok</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Kowalski Piotr</td>
                        <td>+</td>
                        <td>Okres1</td>
                        <td>Okres1</td>
                        <td>Okres1</td>
                        <td>Okres1</td>
                        <td>Okres2</td>
                        <td>Okres2</td>
                        <td>Rok</td>
                        <td>Rok</td>
                        <td>Rok</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Kowalski Piotr</td>
                        <td>+</td>
                        <td>Okres1</td>
                        <td>Okres1</td>
                        <td>Okres1</td>
                        <td>Okres1</td>
                        <td>Okres2</td>
                        <td>Okres2</td>
                        <td>Rok</td>
                        <td>Rok</td>
                        <td>Rok</td>
                    </tr>
                </tbody>
            </table>

            <div class="table">
                <div class="container">
                    <div>h</div>
                    <div>h</div>
                    <div>h</div>
                    <div>h</div>
                    <div>hh</div>
                    <div>h</div>
                </div>
            </div>
        </div>
        <?php alerts::flashMessages() ?>
        <script>
            function ShowHideDiv() {
                var chkYes = document.getElementById("yes");
                var categoryWeight = document.querySelectorAll('.categoryWeight');
                categoryWeight.forEach(element => {
                    element.style.display = chkYes.checked ? "block" : "none";
                })
            }
        </script>
    </main>
<?php
Page::displayFooter();