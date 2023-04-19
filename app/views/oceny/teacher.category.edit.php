<?php
require 'app/Page.php';
require_once 'app/alerts.php';


Page::displayHeader("e-Dziennik Modyfikacja kategorii", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-graduation-cap"></i>
                    <span>Modyfikacja kategorii</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form">
            <form action="/oceny/modyfikuj_kategorie" method="post">
                <label for="categoryName">Nazwa</label>
                <input type="text" name="categoryName" value="<?= $result->name ?>">
                <p>Licz do średniej:</p>
                <label style="display: flex; align-items: center"><input type="radio" name="categoryAverage" value="yes"
                                                                         id="yes" onclick="ShowHideDiv()" <?php
                    if ($result->weight != 0) echo "checked";
                    ?>>&nbsp;Tak <i
                            style="color: green; font-size: 1.3rem; margin-left: 0.2rem; -webkit-text-stroke: 1px green;"
                            class="las la-check"></i></label>
                <label style="display: flex; align-items: center"><input type="radio" name="categoryAverage" value="no"
                                                                         id="no" onclick="ShowHideDiv()" <?php
                    if ($result->weight == 0)
                        echo "checked";
                    ?>>&nbsp;Nie
                    <i style="color: crimson; font-size: 1.3rem; margin-left: 0.2rem; -webkit-text-stroke: 1px crimson;"
                       class="las la-times"></i></label>
                <label style="margin-top: 1rem;" for="categoryWeight" class="categoryWeight">Waga</label>
                <input type="text" name="categoryWeight" class="categoryWeight" value="<?= $result->weight ?>">
                <p style="margin-top: 1rem">Motyw</p>
                <select name="categoryTheme" id="categoryTheme">
                    <option value="F0E68C"
                            style="color: black; background-color: #F0E68C;" <?php if ($result->color == "F0E68C") echo "selected"; ?>>
                        &nbsp;khaki&nbsp;
                    </option>
                    <option value="87CEFA"
                            style="color: black; background-color: #87CEFA;" <?php if ($result->color == "87CEFA") echo "selected"; ?>>
                        &nbsp;lightskyblue&nbsp;
                    </option>
                    <option value="B0C4DE"
                            style="color: black; background-color: #B0C4DE;" <?php if ($result->color == "87CEFA") echo "selected"; ?>>
                        &nbsp;lightsteelblue&nbsp;
                    </option>
                    <option value="F0F8FF"
                            style="color: black; background-color: #F0F8FF;" <?php if ($result->color == "FOF8FF") echo "selected"; ?>>
                        &nbsp;aliceblue&nbsp;
                    </option>
                    <option value="F0FFFF"
                            style="color: black; background-color: #F0FFFF;" <?php if ($result->color == "F0FFFF") echo "selected"; ?>>
                        &nbsp;azure&nbsp;
                    </option>
                    <option value="F5F5DC"
                            style="color: black; background-color: #F5F5DC;" <?php if ($result->color == "F5F5DC") echo "selected"; ?>>
                        &nbsp;beige&nbsp;
                    </option>
                    <option value="FFEBCD"
                            style="color: black; background-color: #FFEBCD;" <?php if ($result->color == "FFEBCD") echo "selected"; ?>>
                        &nbsp;blanchedalmond&nbsp;
                    </option>
                    <option value="FFF8DC"
                            style="color: black; background-color: #FFF8DC;" <?php if ($result->color == "FFF8DC") echo "selected"; ?>>
                        &nbsp;cornsilk&nbsp;
                    </option>
                    <option value="A9A9A9"
                            style="color: black; background-color: #A9A9A9;" <?php if ($result->color == "A9A9A9") echo "selected"; ?>>
                        &nbsp;darkgray&nbsp;
                    </option>
                    <option value="BDB76B"
                            style="color: black; background-color: #BDB76B;" <?php if ($result->color == "BDB76B") echo "selected"; ?>>
                        &nbsp;darkkhaki&nbsp;
                    </option>
                    <option value="8FBC8F"
                            style="color: black; background-color: #8FBC8F;" <?php if ($result->color == "8FBC8F") echo "selected"; ?>>
                        &nbsp;darkseagreen&nbsp;
                    </option>
                    <option value="DCDCDC"
                            style="color: black; background-color: #DCDCDC;" <?php if ($result->color == "DCDCDC") echo "selected"; ?>>
                        &nbsp;gainsboro&nbsp;
                    </option>
                    <option value="DAA520"
                            style="color: black; background-color: #DAA520;" <?php if ($result->color == "DAA520") echo "selected"; ?>>
                        &nbsp;goldenrod&nbsp;
                    </option>
                    <option value="E6E6FA"
                            style="color: black; background-color: #E6E6FA;" <?php if ($result->color == "E6E6FA") echo "selected"; ?>>
                        &nbsp;lavender&nbsp;
                    </option>
                    <option value="FFA07A"
                            style="color: black; background-color: #FFA07A;" <?php if ($result->color == "FFA07A") echo "selected"; ?>>
                        &nbsp;lightsalmon&nbsp;
                    </option>
                    <option value="32CD32"
                            style="color: black; background-color: #32CD32;" <?php if ($result->color == "32CD32") echo "selected"; ?>>
                        &nbsp;limegreen&nbsp;
                    </option>
                    <option value="66CDAA"
                            style="color: black; background-color: #66CDAA;" <?php if ($result->color == "66CDAA") echo "selected"; ?>>
                        &nbsp;mediummaquamarine&nbsp;
                    </option>
                    <option value="C0C0C0"
                            style="color: black; background-color: #C0C0C0;" <?php if ($result->color == "C0C0C0") echo "selected"; ?>>
                        &nbsp;silver&nbsp;
                    </option>
                    <option value="D2B48C"
                            style="color: black; background-color: #D2B48C;" <?php if ($result->color == "D2B48C") echo "selected"; ?>>
                        &nbsp;tan&nbsp;
                    </option>
                    <option value="3333FF"
                            style="color: black; background-color: #3333FF;" <?php if ($result->color == "3333FF") echo "selected"; ?>>
                        &nbsp;blue&nbsp;
                    </option>
                    <option value="7B68EE"
                            style="color: black; background-color: #7B68EE;" <?php if ($result->color == "7B68EE") echo "selected"; ?>>
                        &nbsp;mediumslateblue&nbsp;
                    </option>
                    <option value="7B68EE"
                            style="color: black; background-color: #BA55D3;" <?php if ($result->color == "7B68EE") echo "selected"; ?>>
                        &nbsp;mediumorchid&nbsp;
                    </option>
                    <option value="FFB6C1"
                            style="color: black; background-color: #FFB6C1;" <?php if ($result->color == "FFB6C1") echo "selected"; ?>>
                        &nbsp;lightpink&nbsp;
                    </option>
                    <option value="FF1493"
                            style="color: black; background-color: #FF1493;" <?php if ($result->color == "FF1493") echo "selected"; ?>>
                        &nbsp;deeppink&nbsp;
                    </option>
                    <option value="DC143C"
                            style="color: black; background-color: #DC143C;" <?php if ($result->color == "DC143C") echo "selected"; ?>>
                        &nbsp;crimson&nbsp;
                    </option>
                    <option value="FF0000"
                            style="color: black; background-color: #FF0000;" <?php if ($result->color == "FF0000") echo "selected"; ?>>
                        &nbsp;red&nbsp;
                    </option>
                    <option value="FF8C00"
                            style="color: black; background-color: #FF8C00;" <?php if ($result->color == "FF8C00") echo "selected"; ?>>
                        &nbsp;darkorange&nbsp;
                    </option>
                    <option value="FFD700"
                            style="color: black; background-color: #FFD700;" <?php if ($result->color == "FFD700") echo "selected"; ?>>
                        &nbsp;gold&nbsp;
                    </option>
                    <option value="ADFF2F"
                            style="color: black; background-color: #ADFF2F;" <?php if ($result->color == "ADFF2F") echo "selected"; ?>>
                        &nbsp;greenyellow&nbsp;
                    </option>
                    <option value="7CFC00"
                            style="color: black; background-color: #7CFC00;" <?php if ($result->color == "7CFC00") echo "selected"; ?>>
                        &nbsp;lawngreen&nbsp;
                    </option>
                </select>
                <input type="submit" value="Zmień">
                <input type="hidden" value="<?= $result->categoryId; ?>" name="categoryId">
            </form>
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
        <?php
        if ($result->weight != 0) echo "<script>ShowHideDiv()</script>";
        ?>
    </main>
<?php
Page::displayFooter();