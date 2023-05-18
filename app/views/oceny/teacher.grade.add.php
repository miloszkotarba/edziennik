<!doctype html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dodawanie oceny</title>
    <link rel="stylesheet" href="/css/popup.css">
</head>
<body>
<form action="/oceny/add" method="post">
    <table>
        <thead>
        <tr>
            <th colspan="2">Dodawanie oceny</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Nazwisko i imię</td>
            <td><?=$nazwisko?> <?=$imie?></td>
        </tr>
        <tr>
            <td>Przedmiot</td>
            <td><?=$przedmiot?></td>
        </tr>
        <tr>
            <td>Kategoria</td>
            <td>
                <select name="kategoria">
                    <?php
                    foreach ($kategorie as $kategoria) {
                        echo $kategoria->categoryId;
                        echo <<< END
                        <option value="$kategoria->categoryId">$kategoria->name</option>
                        END;
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Ocena</td>
            <td>
                <select name="ocena">
                    <option value="np">np</option>
                    <option value="nk">nk</option>
                    <option value="bz">bz</option>
                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="6">6</option>
                    <option value="5" selected>5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                </select>

            </td>
        </tr>
        <tr>
            <td>Data</td>
            <td><input type="date" id="theDate" name="date"></td>
        </tr>
        <tr>
            <td>Komentarz</td>
            <td><textarea rows="5" cols="60" name="komentarz"/></textarea></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="btn">
                    <input type="submit" placeholder="OK">
                    <a href="javascript:window.close()">Anuluj</a>
                </div>
            </td>
        </tr>
        </tbody>
        <input type="hidden" name="zajeciaId" value="<?=$zajeciaId?>">
        <input type="hidden" name="studentId" value="<?=$studentId?>">
    </table>
</form>
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
</body>
</html>
