<?php
require 'app/Page.php';

Page::displayHeader("e-Dziennik Nowa kategoria", "oceny.css");
Page::displayNavigation();
?>
    <main>
        <div class="links-box" style="padding: 30px">
            <div class="header">
                <h2 id="page-title">
                    <i class="las la-graduation-cap"></i>
                    <span>Dodawanie kategorii</span>
                </h2>
            </div>
        </div>
        <div style="margin-bottom: 1rem"></div>
        <div class="category-form">
            <form action="/oceny/dodaj_kategorie" method="post">
                <label for="categoryName">Nazwa</label>
                <input type="text" name="categoryName">
                <label for="categoryWeight">Waga</label>
                <input type="text" name="categoryWeight">
                <p>Licz do średniej:</p>
                <label style="display: flex; align-items: center"><input type="radio" name="categoryAverage" value="yes" checked>&nbsp;Tak <i style="color: green; font-size: 1.3rem; margin-left: 0.2rem; -webkit-text-stroke: 1px green;" class="las la-check"></i></label>
                <label style="display: flex; align-items: center"><input type="radio" name="categoryAverage" value="no">&nbsp;Nie <i style="color: crimson; font-size: 1.3rem; margin-left: 0.2rem; -webkit-text-stroke: 1px crimson;" class="las la-times"></i></label>
                <p style="margin-top: 1rem">Motyw</p>
                <select name="categoryTheme">
                    <option value="F0E68C" style="color: black; background-color: #F0E68C;">&nbsp;khaki&nbsp;</option>
                    <option value="87CEFA" style="color: black; background-color: #87CEFA;">&nbsp;lightskyblue&nbsp;
                    </option>
                    <option value="B0C4DE" style="color: black; background-color: #B0C4DE;">&nbsp;lightsteelblue&nbsp;
                    </option>
                    <option value="F0F8FF" style="color: black; background-color: #F0F8FF;">&nbsp;aliceblue&nbsp;
                    </option>
                    <option value="F0FFFF" style="color: black; background-color: #F0FFFF;">&nbsp;azure&nbsp;</option>
                    <option value="F5F5DC" style="color: black; background-color: #F5F5DC;">&nbsp;beige&nbsp;</option>
                    <option value="FFEBCD" style="color: black; background-color: #FFEBCD;">&nbsp;blanchedalmond&nbsp;
                    </option>
                    <option value="FFF8DC" style="color: black; background-color: #FFF8DC;">&nbsp;cornsilk&nbsp;
                    </option>
                    <option value="A9A9A9" style="color: black; background-color: #A9A9A9;">&nbsp;darkgray&nbsp;
                    </option>
                    <option value="BDB76B" style="color: black; background-color: #BDB76B;">&nbsp;darkkhaki&nbsp;
                    </option>
                    <option value="8FBC8F" style="color: black; background-color: #8FBC8F;">&nbsp;darkseagreen&nbsp;
                    </option>
                    <option value="DCDCDC" style="color: black; background-color: #DCDCDC;">&nbsp;gainsboro&nbsp;
                    </option>
                    <option value="DAA520" style="color: black; background-color: #DAA520;">&nbsp;goldenrod&nbsp;
                    </option>
                    <option value="E6E6FA" style="color: black; background-color: #E6E6FA;">&nbsp;lavender&nbsp;
                    </option>
                    <option value="FFA07A" style="color: black; background-color: #FFA07A;">&nbsp;lightsalmon&nbsp;
                    </option>
                    <option value="32CD32" style="color: black; background-color: #32CD32;">&nbsp;limegreen&nbsp;
                    </option>
                    <option value="66CDAA" style="color: black; background-color: #66CDAA;">&nbsp;mediummaquamarine&nbsp;</option>
                    <option value="C0C0C0" style="color: black; background-color: #C0C0C0;">&nbsp;silver&nbsp;</option>
                    <option value="D2B48C" style="color: black; background-color: #D2B48C;">&nbsp;tan&nbsp;</option>
                    <option value="3333FF" style="color: black; background-color: #3333FF;">&nbsp;blue&nbsp;</option>
                    <option value="7B68EE" style="color: black; background-color: #7B68EE;">
                        &nbsp;mediumslateblue&nbsp;
                    </option>
                    <option value="BA55D3" style="color: black; background-color: #BA55D3;">&nbsp;mediumorchid&nbsp;
                    </option>
                    <option value="FFB6C1" style="color: black; background-color: #FFB6C1;">&nbsp;lightpink&nbsp;
                    </option>
                    <option value="FF1493" style="color: black; background-color: #FF1493;">&nbsp;deeppink&nbsp;
                    </option>
                    <option value="DC143C" style="color: black; background-color: #DC143C;">&nbsp;crimson&nbsp;</option>
                    <option value="FF0000" style="color: black; background-color: #FF0000;">&nbsp;red&nbsp;</option>
                    <option value="FF8C00" style="color: black; background-color: #FF8C00;">&nbsp;darkorange&nbsp;
                    </option>
                    <option value="FFD700" style="color: black; background-color: #FFD700;">&nbsp;gold&nbsp;</option>
                    <option value="ADFF2F" style="color: black; background-color: #ADFF2F;">&nbsp;greenyellow&nbsp;
                    </option>
                    <option value="7CFC00" style="color: black; background-color: #7CFC00;">&nbsp;lawngreen&nbsp;
                    </option>
                </select>
                <input type="submit" value="Dodaj">
            </form>
        </div>
    </main>
<?php
Page::displayFooter();