<!doctype html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edycja oceny</title>
    <link rel="stylesheet" href="/css/popup.css">
    <link rel="icon" type="image/svg+xml"
          href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22256%22 height=%22256%22 viewBox=%220 0 100 100%22><text x=%2250%%22 y=%2250%%22 dominant-baseline=%22central%22 text-anchor=%22middle%22 font-size=%22104%22>🎓</text></svg>"/>
</head>
<body>
<form action="/oceny/edit" method="post">
    <table>
        <thead>
        <tr>
            <th colspan="2">Edycja oceny</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Nazwisko i imię</td>
            <td><?= $nazwisko ?> <?= $imie ?></td>
        </tr>
        <tr>
            <td>Przedmiot</td>
            <td><?= $przedmiot ?></td>
        </tr>
        <tr>
            <td>Kategoria</td>
            <td>
                <select name="kategoria">
                    <option disabled>Kategorie systemowe</option>
                    <?php
                    foreach ($systemKategorie as $kategoria) {
                        if ($category === $kategoria->name) {
                            $previous = $kategoria->name;
                            echo '<option value="' . $kategoria->categoryId . '" selected>' . $kategoria->name . '</option>';
                        } else {
                            echo <<< END
                            <option value="$kategoria->categoryId">$kategoria->name</option>
                            END;
                        }
                    }
                    ?>
                    <option disabled>Kategorie użytkownika</option>
                    <?php
                    foreach ($kategorie as $kategoria) {
                        if ($category === $kategoria->name) {
                            $previous = $kategoria->name;
                            echo '<option value="' . $kategoria->categoryId . '" selected>' . $kategoria->name . '</option>';
                        } else {
                            echo <<< END
                            <option value="$kategoria->categoryId">$kategoria->name</option>
                            END;
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Ocena</td>
            <td>
                <select name="ocena">
                    <option value="+" <?php if ($value == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if ($value == '-') echo 'selected'; ?>>-</option>
                    <option value="bz" <?php if ($value == 'bz') echo 'selected'; ?>>bz</option>
                    <option value="np" <?php if ($value == 'np') echo 'selected'; ?>>np</option>
                    <option value="1" <?php if ($value == '1') echo 'selected'; ?>>1</option>
                    <option value="2" <?php if ($value == '2') echo 'selected'; ?>>2</option>
                    <option value="3" <?php if ($value == '3') echo 'selected'; ?>>3</option>
                    <option value="4" <?php if ($value == '4') echo 'selected'; ?>>4</option>
                    <option value="5" <?php if ($value == '5') echo 'selected'; ?>>5</option>
                    <option value="6" <?php if ($value == '6') echo 'selected'; ?>>6</option>
                </select>

            </td>
        </tr>
        <tr>
            <td>Data</td>
            <td><input type="date" id="theDate" name="date" value="<?=$data?>"></td>
        </tr>
        <tr>
            <td>Komentarz</td>
            <td><textarea rows="5" cols="60" name="komentarz"/><?=$komentarz?></textarea></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="btn">
                    <input type="submit" value="OK">
                    <a href="/oceny/usun/<?= $gradeId ?>">Usuń</a>
                    <a href="javascript:window.close()">Anuluj</a>
                </div>
            </td>
        </tr>
        </tbody>
        <input type="hidden" name="ocenaId" value="<?= $gradeId ?>">
        <input type="hidden" name="zajeciaId" value="<?=$zajeciaId?>">
        <input type="hidden" name="studentId" value="<?=$studentId?>">
        <input type="hidden" name="previousCategory" value="<?=$previous?>">
    </table>
</form>
</body>
</html>

