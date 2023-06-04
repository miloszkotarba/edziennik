<!doctype html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Szczegóły oceny</title>
    <link rel="stylesheet" href="/css/popup.css">
    <link rel="icon" type="image/svg+xml"
          href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22256%22 height=%22256%22 viewBox=%220 0 100 100%22><text x=%2250%%22 y=%2250%%22 dominant-baseline=%22central%22 text-anchor=%22middle%22 font-size=%22104%22>🎓</text></svg>"/>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
<table style="max-width: 800px">
    <thead>
    <tr>
        <th colspan="2">Szczegóły oceny</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Ocena</td>
        <td><?= $final->value ?></td>
    </tr>
    <tr>
        <td>Przedmiot</td>
        <td><?= $final->subjectName ?></td>
    </tr>
    <tr>
        <td>Kategoria</td>
        <td>
            <?= $final->category ?>
        </td>
    </tr>

    <?php if ($final->averageCount == 0) {
        echo <<< END
           <tr>
                <td>Licz do średniej</td>
                <td><i class="las la-times" style="color: crimson; font-size: 1.1rem; -webkit-text-stroke: 1.5px crimson"></i></td> 
           </tr>
        END;
    } else {
        echo <<< END
            <tr>
                <td>Licz do średniej</td>
                <td><i class="las la-check" style="color: green; font-size: 1.1rem; -webkit-text-stroke: 1.5px green"></i></td>
            </tr>
            <tr>
                <td>Waga</td>
                <td>$final->weight</td>
            </tr>   
        END;
    } ?>
    <tr>
        <td>Data</td>
        <td>
            <?= $final->date ?>
        </td>
    </tr>
    <tr>

    </tr>

    <?php if ($final->comment) {
        echo <<< END
         <tr>
        <td>Komentarz</td>
        <td><span>$final->comment</span></td>
        </tr>
        END;
    } ?>
    <tr>
        <td>Nauczyciel</td>
        <td><?= $final->usersSurname ?> <?= $final->usersName ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <div class="btn">
                <a href="/oceny">Powrót</a>
            </div>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>

