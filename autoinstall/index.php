<?php
session_start();
?>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <link href='custom.css' rel='stylesheet' type='text/css'>
    <link rel="icon" href="img/f1.png" type="image/png" sizes="16x16">
    <link rel="icon" href="img/f2.png" type="image/png" sizes="32x32">
    <title>Aktywacja aplikacji</title>
</head>

<body>

<div class="container">

    <div class="row">

        <div class="col-xl-8 offset-xl-2 py-5">

            <h1>Instalacja Aplikacji</h1>

            <p class="lead">Wprowadź poniżej dane, aby poprawnie zainstalować aplikację.</p>


            <form id="contact-form" method="POST" action="activate.php" role="form">

                <div class="messages"></div>

                <div class="controls">

                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="title">Dane administratora</h2>
                            <div class="form-group">
                                <label for="form_name">Imię *</label>
                                <input id="form_name" type="text" name="name" class="form-control" required="required"
                                       data-error="Uzupełnij to pole."
                                       value="<?php if (isset($_SESSION['imie'])) {
                                           echo $_SESSION['imie'];
                                           unset($_SESSION['imie']);
                                       } ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_lastname">Nazwisko *</label>
                                <input id="form_lastname" type="text" name="surname" class="form-control"
                                       required="required" data-error="Uzupełnij to pole."
                                       value="<?php if (isset($_SESSION['nazwisko'])) {
                                           echo $_SESSION['nazwisko'];
                                           unset($_SESSION['nazwisko']);
                                       } ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_email">Email *</label>
                                <input id="form_email" type="email" name="email" class="form-control"
                                       required="required" data-error="Uzupełnij to pole."
                                       value="<?php if (isset($_SESSION['email'])) {
                                           echo $_SESSION['email'];
                                           unset($_SESSION['email']);
                                       } ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_password">Hasło *</label>
                                <input id="form_password" type="password" name="password" class="form-control"
                                       required="required" data-error="Uzupełnij to pole.">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_password2">Powtórz hasło *</label>
                                <input id="form_password2" type="password" name="password2" class="form-control"
                                       required="required" data-error="Uzupełnij to pole.">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="title">Ustawienia bazy danych MySql</h2>
                            <div class="form-group">
                                <label for="form_host">Host *</label>
                                <input id="form_host" type="text" name="host" class="form-control" required="required"
                                       data-error="Uzupełnij to pole." placeholder="np. localhost"
                                       value="<?php if (isset($_SESSION['db_host'])) {
                                           echo $_SESSION['db_host'];
                                           unset($_SESSION['db_host']);
                                       } ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_db_name">Nazwa bazy danych *</label>
                                <input id="form_db_name" type="text" name="db_name" class="form-control"
                                       required="required" data-error="Uzupełnij to pole."
                                       value="<?php if (isset($_SESSION['db_name'])) {
                                           echo $_SESSION['db_name'];
                                           unset($_SESSION['db_name']);
                                       } ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_db_user">Użytkownik bazy danych *</label>
                                <input id="form_db_user" type="text" name="db_user" class="form-control"
                                       required="required" data-error="Uzupełnij to pole."
                                       value="<?php if (isset($_SESSION['db_username'])) {
                                           echo $_SESSION['db_username'];
                                           unset($_SESSION['db_username']);
                                       } ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                                <label>Hasło *</label>
                                <input type="password" name="db_password" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-success btn-send" value="Aktywuj aplikację">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted">
                                <strong>*</strong> Pola wymagane.</p>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>

</div>
<?php
if (isset($_SESSION['error'])) {
    echo <<< END
             <div class="warning">
            <div class="icon">
                <span class="material-symbols-outlined">report</span>
            </div>
            <div class="content"><b>Uwaga! </b>
        END;
    echo $_SESSION['error'];
    echo <<< END
            </div>
        </div>
        END;
}
unset($_SESSION['error']);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"
        integrity="sha256-dHf/YjH1A4tewEsKUSmNnV05DDbfGN3g7NMq86xgGh8=" crossorigin="anonymous"></script>
<script src="contact.js"></script>
</body>
</html>